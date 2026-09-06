<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Danh sách tất cả đơn hàng
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(10);
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
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }
    // Danh sách tổng hợp hàng khách đặt cần nhập về
    public function pickList()
    {
        $itemsToPick = \App\Models\OrderItem::select('product_name', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending');
            })
            ->whereHas('activeProduct') // bỏ qua sản phẩm đã ngừng bán (xóa mềm)
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->get();

        return view('admin.orders.picklist', compact('itemsToPick'));
    }
}
