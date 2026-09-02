<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Chỉnh Sửa Danh Mục') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-neutral-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink overflow-hidden  sm:rounded-none p-6 border border-neutral-800 max-w-2xl mx-auto">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Ô cập nhật Tên Danh mục -->
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2">Tên danh mục:</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200" required>
                        @error('name')
                            <p class="text-rose-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ô cập nhật Mô tả -->
                    <div class="mb-6">
                        <label class="block text-white text-sm font-bold mb-2">Mô tả danh mục:</label>
                        <textarea name="description" rows="4" class=" bg-neutral-900 border-neutral-700 focus:border-accent focus:ring-accent rounded-none w-full py-2 px-3 text-neutral-200">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <!-- Nút Thao tác -->
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-accent hover:bg-accent-700 text-white font-bold py-2 px-6 rounded-none  transition duration-200">
                            Cập nhật danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="text-neutral-600 hover:text-white text-sm font-medium">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
