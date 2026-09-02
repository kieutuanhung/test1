<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Thêm Sản Phẩm Mới') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink overflow-hidden  sm:rounded-none p-6 border border-neutral-800 max-w-2xl mx-auto">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Danh mục sản phẩm:</label>
                        <select name="category_id" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Tên sản phẩm:</label>
                        <input type="text" name="name" value="{{ old('name') }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                        @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-white text-sm font-bold mb-2">Giá bán (VNĐ):</label>
                            <input type="number" name="price" value="{{ old('price') }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                            @error('price') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-white text-sm font-bold mb-2">Số lượng kho:</label>
                            <input type="number" name="stock" value="{{ old('stock', 10) }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                            @error('stock') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Hình ảnh sản phẩm:</label>
                        <input type="file" name="image" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200">
                        @error('image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-white text-sm font-bold mb-2">Mô tả sản phẩm:</label>
                        <textarea name="description" rows="4" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-accent hover:bg-accent-700 text-white font-bold py-2 px-6 rounded-none transition">
                            Lưu sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="text-neutral-600 hover:text-white text-sm font-medium">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
