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
    // Nếu có session 'buy_now' (khách bấm "Mua ngay") -> chỉ thanh toán riêng sản phẩm đó, KHÔNG đụng tới giỏ hàng
    public function checkout(Request $request)
    {
        // Nếu khách vào từ trang Giỏ hàng (bấm "Tiến hành thanh toán") -> luôn ưu tiên giỏ hàng,
        // xóa session buy_now còn sót lại (nếu trước đó có bấm Mua ngay nhưng bỏ dở giữa chừng)
        if ($request->query('from_cart')) {
            session()->forget('buy_now');
        }

        $buyNow = session()->get('buy_now');
        $cart = $buyNow ? [$buyNow] : session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng đang trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('orders.checkout', compact('cart', 'total'));
    }

    // 2. Lưu đơn hàng vào DB
    public function store(Request $request)
    {
        $isBuyNow = session()->has('buy_now');
        $cart = $isBuyNow ? [session()->get('buy_now')] : session()->get('cart', []);

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

            // Lưu từng món trong đơn hàng (không còn trừ tồn kho vì đã bỏ tính năng quản lý kho)
            foreach ($cart as $key => $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['name'],
                    'size'         => $item['size'] ?? null,
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                ]);
            }

            DB::commit();

            // Nếu là "Mua ngay" -> chỉ xóa session buy_now, GIỮ NGUYÊN giỏ hàng chính
            // Nếu thanh toán từ giỏ hàng bình thường -> xóa sạch giỏ hàng như cũ
            if ($isBuyNow) {
                session()->forget('buy_now');
            } else {
                session()->forget('cart');
            }

            return redirect()->route('order.success', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng, vui lòng thử lại!');
        }
    }
	// Xem lịch sử đơn hàng của khách đang đăng nhập
    public function history()
    {
        $orders = Order::with('items.product')
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
