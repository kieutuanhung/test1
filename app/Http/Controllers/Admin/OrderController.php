<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Danh sách tất cả đơn hàng (đơn đã thanh toán hoặc đã hoàn tiền)
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->whereIn('payment_status', ['paid', 'refunded'])
            ->when($request->filled('order_id'), function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->order_id . '%');
            })
            ->when($request->filled('customer'), function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->customer . '%');
            })
            ->when($request->filled('product'), function ($q) use ($request) {
                $q->whereHas('items', function ($q2) use ($request) {
                    $q2->where('product_name', 'like', '%' . $request->product . '%');
                });
            })
            ->when($request->filled('phone'), function ($q) use ($request) {
                $q->where('customer_phone', 'like', '%' . $request->phone . '%');
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    // Xem chi tiết một đơn hàng
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng (Chờ duyệt -> Đang giao -> Hoàn thành)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        // Đơn chưa thanh toán chỉ được hủy, không được duyệt/giao
        if ($order->payment_status !== 'paid' && $request->status !== 'cancelled') {
            return back()->with('error', 'Đơn hàng này chưa thanh toán hoặc đã hoàn tiền, không thể xử lý.');
        }

        $oldStatus = $order->status;

        $order->update(['status' => $request->status]);

        // Audit: chỉ ghi khi trạng thái thực sự thay đổi
        if ($oldStatus !== $order->status) {
            AuditLog::record(
                'order.status_changed',
                $order,
                ['status' => $oldStatus],
                ['status' => $order->status]
            );
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }

    // Ghi nhận đã hoàn tiền cho khách (đơn đã hủy + đã thanh toán)
    public function refund(Request $request, $id)
    {
        $request->validate([
            'refund_note' => 'required|string|max:255',
        ], [
            'refund_note.required' => 'Vui lòng nhập mã giao dịch hoặc ghi chú hoàn tiền.',
        ]);

        $order = Order::findOrFail($id);

        if ($order->status !== 'cancelled' || $order->payment_status !== 'paid') {
            return back()->with('error', 'Chỉ hoàn tiền cho đơn đã hủy và đã thanh toán.');
        }

        $oldPaymentStatus = $order->payment_status;

        $order->update([
            'payment_status' => 'refunded',
            'refunded_at'    => now(),
            'refund_note'    => $request->refund_note,
        ]);

        // Audit: hoàn tiền là thao tác nhạy cảm về tài chính
        AuditLog::record(
            'order.refunded',
            $order,
            ['payment_status' => $oldPaymentStatus],
            [
                'payment_status' => 'refunded',
                'refund_note'    => $request->refund_note,
                'total_price'    => $order->total_price,
            ]
        );

        return back()->with('success', 'Đã ghi nhận hoàn tiền cho đơn #' . $order->id);
    }

    // Danh sách tổng hợp hàng khách đặt cần nhập về
    public function pickList()
    {
        $itemsToPick = \App\Models\OrderItem::select('product_name', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending')
                      ->where('payment_status', 'paid');
            })
            ->whereHas('activeProduct') // bỏ qua sản phẩm đã ngừng bán (xóa mềm)
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->get();

        return view('admin.orders.picklist', compact('itemsToPick'));
    }
}
