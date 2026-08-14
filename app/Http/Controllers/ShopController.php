<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Hiển thị trang chủ / danh sách sản phẩm (có hỗ trợ lọc theo Category)
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category')->where('stock', '>', 0);

        // Nếu khách bấm lọc theo danh mục
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->paginate(12);

        return view('shop.index', compact('products', 'categories'));
    }

    // Hiển thị chi tiết 1 sản phẩm qua slug
    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
