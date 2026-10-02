<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    // Lưu giỏ vào session, và vào DB nếu đã đăng nhập
    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);

        if ($user = auth()->user()) {
            Cache::forever("cart_user_" . $user->id, $cart);
        }
    }

    // Xem danh sách giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Danh sách size của từng sản phẩm trong giỏ (để chọn/đổi size ngay trong giỏ)
        $productIds = collect($cart)->pluck('product_id')->unique()->all();
        $sizeOptions = Product::whereIn('id', $productIds)->get()
            ->mapWithKeys(fn ($p) => [$p->id => (array) $p->sizeList])
            ->all();

        return view('cart.index', compact('cart', 'total', 'sizeOptions'));
    }

    // Thêm sản phẩm vào giỏ hàng (hoặc lưu riêng để "Mua ngay" nếu có cờ buy_now)
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $size = $request->input('size'); // null nếu sản phẩm không có size

        $item = [
            'product_id' => $product->id,
            'name'     => $product->name,
            'size'     => $size,
            'quantity' => $request->input('quantity', 1),
            'price'    => $product->price,
            'image'    => $product->image,
            'slug'     => $product->slug,
        ];

        // "Mua ngay": lưu riêng vào session 'buy_now', KHÔNG động vào giỏ hàng chính
        if ($request->boolean('buy_now')) {
            session()->put('buy_now', $item);
            return redirect()->route('order.checkout');
        }

        // Thêm vào giỏ hàng bình thường
        $key = $size ? $id . '_' . $size : (string) $id; // key riêng cho từng size của cùng 1 sản phẩm
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $item['quantity'];
        } else {
            $cart[$key] = $item;
        }

        $this->saveCart($cart);

        // Gọi bằng AJAX: trả JSON, không redirect (trang không load lại)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cart_count' => array_sum(array_column($cart, 'quantity')), // tổng số lượng
                'cart_lines' => count($cart),                                   // số dòng sản phẩm
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Cập nhật số lượng trong giỏ
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int) $request->quantity);
            $this->saveCart($cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công!');
    }

    // Chọn / đổi size cho 1 dòng trong giỏ
    public function updateSize(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $size = $request->input('size');

        if ($size && isset($cart[$id])) {
            $item = $cart[$id];
            $product = Product::find($item['product_id']);

            if ($product && in_array($size, (array) $product->sizeList, true)) {
                $item['size'] = $size;
                $newKey = $item['product_id'] . '_' . $size;

                unset($cart[$id]);
                if (isset($cart[$newKey])) {
                    // Đã có sẵn cùng sản phẩm + size này -> cộng dồn số lượng
                    $cart[$newKey]['quantity'] += $item['quantity'];
                } else {
                    $cart[$newKey] = $item;
                }

                $this->saveCart($cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật size!');
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->saveCart($cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}
