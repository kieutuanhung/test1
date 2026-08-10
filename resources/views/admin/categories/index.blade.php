<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-pink-600 leading-tight">
                {{ __('Quản lý Danh mục') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow inline-block">
                + Thêm danh mục mới
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-pink-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-pink-100 p-6">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                        <tr class="bg-pink-50">
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tên danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Mô tả</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-pink-700 uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $category->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-pink-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->slug }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->description ?? 'Không có' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-pink-600 hover:text-pink-900 font-bold mr-3">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Chưa có danh mục nào được tạo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
