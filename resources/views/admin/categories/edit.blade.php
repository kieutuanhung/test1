<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Chỉnh Sửa Danh Mục') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-pink-100 max-w-2xl mx-auto">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Ô cập nhật Tên Danh mục -->
                    <div class="mb-4">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Tên danh mục:</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700" required>
                        @error('name')
                            <p class="text-rose-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ô cập nhật Mô tả -->
                    <div class="mb-6">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Mô tả danh mục:</label>
                        <textarea name="description" rows="4" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <!-- Nút Thao tác -->
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                            Cập nhật danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="text-pink-400 hover:text-pink-600 text-sm font-medium">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
