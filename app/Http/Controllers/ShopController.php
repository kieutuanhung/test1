<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Hiển thị trang chủ / danh sách sản phẩm (có hỗ trợ lọc theo Category + sắp xếp)
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        // Nếu khách bấm lọc theo danh mục
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        // Sắp xếp theo Giá / Số lượng kho (áp dụng cho mọi trang danh sách)
        $sortby = $request->sortby;
        $applySortBy = function ($q) use ($sortby) {
            return match ($sortby) {
                'price_asc'  => $q->orderBy('price', 'asc'),
                'price_desc' => $q->orderBy('price', 'desc'),
                default      => $q,
            };
        };

        // Sắp xếp / lọc: mới nhất (mặc định), New Arrival, hoặc Best Seller (do Owner/Staff tự đánh dấu)
        if ($request->sort === 'bestseller') {
            // Best Seller: chỉ lấy sản phẩm được Owner/Staff đánh dấu "Best Seller"
            $query->where('is_best_seller', true)
                  ->withSum(['orderItems as total_sold' => function ($q) {
                        $q->whereHas('order', function ($q2) {
                            $q2->where('status', '!=', 'cancelled');
                        });
                    }], 'quantity');

            if ($sortby) {
                $applySortBy($query);
            } else {
                $query->orderByDesc('total_sold');
            }

            $products = $query->get(); // hiển thị toàn bộ sản phẩm đã đánh dấu, không phân trang
        } elseif ($request->sort === 'new') {
            // New Arrival: chỉ lấy sản phẩm được Owner/Staff đánh dấu "New Arrival"
            $query->where('is_new_arrival', true);
            $sortby ? $applySortBy($query) : $query->latest();
            $products = $query->get();
        } else {
            $sortby ? $applySortBy($query) : $query->latest();
            $products = $query->paginate(12)->appends($request->query());
        }

        // Top 4 sản phẩm Best Seller (do Owner/Staff đánh dấu) - hiển thị ở trang chủ
        $bestSellers = Product::with('category')
            ->where('is_best_seller', true)
            ->withSum(['orderItems as total_sold' => function ($q) {
                    $q->whereHas('order', function ($q2) {
                        $q2->where('status', '!=', 'cancelled');
                    });
                }], 'quantity')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        // Sản phẩm New Arrival (do Owner/Staff đánh dấu) - hiển thị ở trang chủ
        $newArrivals = Product::with('category')
            ->where('is_new_arrival', true)
            ->latest()
            ->take(8)
            ->get();

        // Từng Danh mục - mỗi danh mục 1 khu vực sản phẩm riêng ở trang chủ
        $categorySections = Category::with(['products' => function ($q) {
                $q->latest()->take(8);
            }])
            ->get()
            ->filter(fn($cat) => $cat->products->isNotEmpty());

        return view('shop.index', compact('products', 'categories', 'bestSellers', 'newArrivals', 'categorySections'));
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
