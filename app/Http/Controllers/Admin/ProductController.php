<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('category'), function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->when($request->filled('sort_price'), function ($q) use ($request) {
                $q->orderBy('price', $request->sort_price === 'asc' ? 'asc' : 'desc');
            }, function ($q) {
                $q->latest();
            })
            ->paginate(10)
            ->appends($request->query());

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // 2. Giao diện form thêm sản phẩm
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. Xử lý lưu sản phẩm + Upload ảnh
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'sizes'       => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'price'       => $request->price,
            'sizes'       => $request->sizes,
	    'slug'        => Str::slug($request->name),
            'image'       => $imagePath,
            'description' => $request->description,
            'is_new_arrival' => $request->boolean('is_new_arrival'),
            'is_best_seller' => $request->boolean('is_best_seller'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // 4. Giao diện form sửa sản phẩm
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. Xử lý cập nhật sản phẩm + Đổi ảnh
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'sizes'       => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'price'       => $request->price,
	    'slug'        => Str::slug($request->name),
            'sizes'       => $request->sizes,
            'image'       => $imagePath,
            'description' => $request->description,
            'is_new_arrival' => $request->boolean('is_new_arrival'),
            'is_best_seller' => $request->boolean('is_best_seller'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // 6. Xử lý xóa sản phẩm (Soft Delete - chỉ ẩn đi, không xóa ảnh/dữ liệu thật)
    public function destroy(Product $product)
    {
        $product->delete(); // Soft delete: chỉ set cột deleted_at, ảnh & dữ liệu vẫn giữ nguyên

        return redirect()->route('admin.products.index')->with('success', 'Đã ẩn sản phẩm (chuyển vào Thùng rác). Doanh thu cũ vẫn được giữ nguyên.');
    }

    // 7. Danh sách sản phẩm đã xóa mềm (Thùng rác)
    public function trash()
    {
        $products = Product::onlyTrashed()->with('category')->latest('deleted_at')->paginate(10);
        return view('admin.products.trash', compact('products'));
    }

    // 8. Khôi phục sản phẩm đã xóa mềm
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trash')->with('success', 'Đã khôi phục sản phẩm thành công!');
    }

    // 9. Xóa vĩnh viễn (chỉ dùng khi chắc chắn không cần khôi phục nữa)
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();

        return redirect()->route('admin.products.trash')->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    }
}
