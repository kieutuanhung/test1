<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Lấy các dòng giỏ hàng khách đã tick để thanh toán (lưu trong session 'checkout_items')
    private function selectedCart(): array
    {
        $all  = session()->get('cart', []);
        $keys = session()->get('checkout_items');

        if (!is_array($keys)) {
            return $all; // chưa có lựa chọn nào -> như cũ: toàn bộ giỏ
        }

        $keys = array_map('strval', $keys);

        return array_filter(
            $all,
            fn ($item, $key) => in_array((string) $key, $keys, true),
            ARRAY_FILTER_USE_BOTH
        );
    }

    // Trả về tên các sản phẩm CÓ size nhưng khách chưa chọn size
    private function itemsMissingSize(array $items): array
    {
        $ids = collect($items)->pluck('product_id')->filter()->unique()->all();
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');

        $missing = [];
        foreach ($items as $item) {
            $product = $products->get($item['product_id'] ?? 0);
            if ($product && count((array) $product->sizeList) > 0 && empty($item['size'])) {
                $missing[] = $item['name'];
            }
        }

        return $missing;
    }

    // 1. Mở trang điền form Checkout
    public function checkout(Request $request)
    {
        // Đi từ giỏ hàng: chỉ lấy các dòng đã tick (items[])
        if ($request->query('from_cart')) {
            session()->forget('buy_now');

            $selected = array_map('strval', (array) $request->query('items', []));
            $picked = array_filter(
                session()->get('cart', []),
                fn ($item, $key) => in_array((string) $key, $selected, true),
                ARRAY_FILTER_USE_BOTH
            );

            if (empty($picked)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
            }

            session()->put('checkout_items', array_keys($picked));
        }

        $buyNow = session()->get('buy_now');
        $cart = $buyNow ? [$buyNow] : $this->selectedCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
        }

        // Sản phẩm có size mà chưa chọn size thì không cho thanh toán
        $missing = $this->itemsMissingSize($cart);
        if ($missing) {
            $back = $buyNow ? route('shop.show', $buyNow['slug']) : route('cart.index');
            return redirect($back)->with('error', 'Vui lòng chọn size cho: ' . implode(', ', $missing));
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
        $cart = $isBuyNow ? [session()->get('buy_now')] : $this->selectedCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
        }

        // Kiểm tra lại phía server: thiếu size thì không được đặt hàng
        $missing = $this->itemsMissingSize($cart);
        if ($missing) {
            $back = $isBuyNow ? route('shop.show', $cart[0]['slug']) : route('cart.index');
            return redirect($back)->with('error', 'Vui lòng chọn size cho: ' . implode(', ', $missing));
        }

        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'customer_email'   => 'nullable|email|max:255',
            'otp_code'         => 'required|string|size:6',
        ]);

        // ===== Kiểm tra mã OTP xác minh số điện thoại =====
        $otp = session('phone_otp');

        if (
            !$otp ||
            $otp['phone'] !== $request->customer_phone ||
            $otp['code'] !== $request->otp_code ||
            now()->greaterThan($otp['expires_at'])
        ) {
            return back()
                ->withErrors(['otp_code' => 'Mã xác minh không đúng hoặc đã hết hạn. Vui lòng gửi lại mã.'])
                ->withInput();
        }

        session()->forget('phone_otp');
        // ===== Kết thúc kiểm tra OTP =====

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

            if ($isBuyNow) {
                session()->forget('buy_now');
            } else {
                // Chỉ xóa các dòng đã thanh toán, giữ lại các dòng không tick
                $remaining = session()->get('cart', []);
                foreach (array_keys($cart) as $key) {
                    unset($remaining[$key]);
                }
                session()->put('cart', $remaining);
                session()->forget('checkout_items');

                // Đồng bộ bản lưu giỏ hàng của user (để đăng nhập lại không hiện lại hàng đã mua)
                if (Auth::check()) {
                    Cache::forever('cart_user_' . Auth::id(), $remaining);
                }
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

        if ($order->user_id !== auth()->id() && !in_array(auth()->user()->role, ['staff', 'owner', 'sysadmin'])) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('orders.success', compact('order'));
    }
}
