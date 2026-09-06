<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Xem danh sách giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
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

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Cập nhật số lượng trong giỏ
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int) $request->quantity);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công!');
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}
