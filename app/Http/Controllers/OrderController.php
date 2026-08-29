<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. Mở trang điền form Checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng đang trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('orders.checkout', compact('cart', 'total'));
    }

    // 2. Lưu đơn hàng vào DB & Trừ tồn kho
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng đang trống!');
        }

        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'customer_email'   => 'nullable|email|max:255',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
// Lưu thông tin đơn hàng
            $order = Order::create([
                'user_id'          => Auth::id(),
                'customer_name'    => $request->customer_name,
                'customer_email'   => $request->customer_email,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'note'             => $request->note,
                'total_price'      => $total,
                'status'           => 'pending',
            ]);

            // Lưu từng món trong đơn hàng (Không trừ kho)
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $id,
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                ]);
            }

            DB::commit();

            // Xóa sạch giỏ hàng trong Session
            session()->forget('cart');

            return redirect()->route('order.success', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng, vui lòng thử lại!');
        }
    }
	// Xem lịch sử đơn hàng của khách đang đăng nhập
    public function history()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    // 3. Hiển thị trang cảm ơn / thông báo thành công
    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('orders.success', compact('order'));
    }
}
