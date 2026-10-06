<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Danh sách tất cả đơn hàng (chỉ đơn đã thanh toán)
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->where('payment_status', 'paid')   // THÊM
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

        // THÊM: đơn chưa thanh toán chỉ được hủy, không được duyệt/giao
        if ($order->payment_status !== 'paid' && $request->status !== 'cancelled') {
            return back()->with('error', 'Đơn hàng này chưa thanh toán, không thể xử lý.');
        }

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }

    // Danh sách tổng hợp hàng khách đặt cần nhập về
    public function pickList()
    {
        $itemsToPick = \App\Models\OrderItem::select('product_name', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending')
                      ->where('payment_status', 'paid');   // THÊM
            })
            ->whereHas('activeProduct') // bỏ qua sản phẩm đã ngừng bán (xóa mềm)
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->get();

        return view('admin.orders.picklist', compact('itemsToPick'));
    }
}
