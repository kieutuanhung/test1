<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Chỉnh Sửa Sản Phẩm') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink overflow-hidden  sm:rounded-none p-6 border border-neutral-800 max-w-2xl mx-auto">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Danh mục sản phẩm:</label>
                        <select name="category_id" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Tên sản phẩm:</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                        @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-white text-sm font-bold mb-2">Giá bán (VNĐ):</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                            @error('price') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-white text-sm font-bold mb-2">Size có sẵn (cách nhau bởi dấu phẩy):</label>
                            <input type="text" name="sizes" placeholder="VD: S, M, L, XL" value="{{ old('sizes', $product->sizes) }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200">
                            @error('sizes') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                            <p class="text-xs text-neutral-500 mt-1">Để trống nếu sản phẩm không phân loại theo size.</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Hình ảnh sản phẩm:</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-none border border-neutral-700">
                            </div>
                        @endif
                        <input type="file" name="image" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200">
                        @error('image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-white text-sm font-bold mb-2">Mô tả sản phẩm:</label>
                        <textarea name="description" rows="4" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-6 flex flex-wrap gap-6 border border-neutral-800 bg-neutral-900 rounded-none p-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }} class="w-4 h-4 rounded border-neutral-600 bg-neutral-800 text-accent focus:ring-accent">
                            <span class="text-white text-sm font-semibold uppercase tracking-wide">🆕 New Arrival</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }} class="w-4 h-4 rounded border-neutral-600 bg-neutral-800 text-accent focus:ring-accent">
                            <span class="text-accent text-sm font-bold uppercase tracking-wide">Best Seller</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-accent hover:bg-accent-700 text-white font-bold py-2 px-6 rounded-none transition">
                            Cập nhật sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="text-neutral-600 hover:text-white text-sm font-medium">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
