<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="section-title">
                {{ __('Quản lý Sản phẩm') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.trash') }}" class="border border-white text-white hover:bg-white hover:text-ink font-bold py-2 px-4 rounded-none inline-block transition">
                    Thùng rác
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-accent hover:bg-accent-700 text-white font-bold py-2 px-4 rounded-none inline-block">
                    + Thêm sản phẩm mới
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="border-l-4 border-accent bg-neutral-900 text-white text-sm px-4 py-3 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tìm kiếm / Lọc danh mục / Sắp xếp giá -->
            <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên sản phẩm..."
                       style="border: 2px solid #f59e0b;" onfocus="this.style.transform='scale(1.02)'" onblur="this.style.transform='scale(1)'"
                       class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 px-4 focus:ring-2 focus:ring-amber-400 placeholder:text-neutral-500 transition">

                <select name="category" onchange="this.form.submit()"
                        style="border: 2px solid #3b82f6;"
                        class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 px-4 focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="sort_price" onchange="this.form.submit()"
                        style="border: 2px solid #a855f7;"
                        class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 px-4 focus:ring-2 focus:ring-purple-400 transition">
                    <option value="">Sắp xếp mặc định (mới nhất)</option>
                    <option value="asc" {{ request('sort_price') === 'asc' ? 'selected' : '' }}>Giá: Thấp &rarr; Cao</option>
                    <option value="desc" {{ request('sort_price') === 'desc' ? 'selected' : '' }}>Giá: Cao &rarr; Thấp</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="btn-accent flex-1 !py-0">Lọc</button>
                    @if(request('search') || request('category') || request('sort_price'))
                        <a href="{{ route('admin.products.index') }}" class="btn-secondary flex-1 flex items-center justify-center !py-0">Xóa lọc</a>
                    @endif
                </div>
            </form>

            <div class="bg-ink overflow-hidden  sm:rounded-none border-2 border-white p-6">
                <table class="min-w-full divide-y divide-neutral-800 border">
                    <thead>
                        <tr class="bg-neutral-900 border-b-2 border-accent">
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Hình ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Tên sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Giá</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Size</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-white uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-ink divide-y divide-neutral-800">
                        @forelse($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded-none border border-neutral-700">
                                    @else
                                        <span class="text-xs text-neutral-500">Không ảnh</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-white">
                                    {{ $product->name }}
                                    <div class="flex gap-1 mt-1">
                                        @if($product->is_new_arrival)
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-[10px] font-bold uppercase">New</span>
                                        @endif
                                        @if($product->is_best_seller)
                                            <span class="px-2 py-0.5 bg-accent text-white rounded-full text-[10px] font-bold uppercase">Best</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-neutral-200">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">{{ $product->sizes ?: '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-white hover:text-accent font-bold mr-3">Sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Ẩn sản phẩm này khỏi shop? (Có thể khôi phục lại trong Thùng rác)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-300 font-bold">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-neutral-400">
                                    @if(request('search') || request('category') || request('sort_price'))
                                        Không tìm thấy sản phẩm nào khớp với bộ lọc.
                                    @else
                                        Chưa có sản phẩm nào được tạo.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
