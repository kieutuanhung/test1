<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        AuditLog::record('category.created', $category, null, [
            'name' => $category->name,
            'slug' => $category->slug,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $before = $category->only(['name', 'slug', 'description']);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        [$old, $new] = AuditLog::diff($before, $category->only(['name', 'slug', 'description']));
        if (!empty($new)) {
            AuditLog::record('category.updated', $category, $old, $new);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        // Ghi lại số sản phẩm bị ảnh hưởng (FK đang để cascade nên sản phẩm sẽ bị xóa theo)
        $productsCount = $category->products()->withTrashed()->count();

        AuditLog::record('category.deleted', $category, [
            'name'           => $category->name,
            'slug'           => $category->slug,
            'products_count' => $productsCount,
        ], null);

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
