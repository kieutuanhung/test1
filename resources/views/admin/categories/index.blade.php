<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="section-title">
                {{ __('Quản lý Danh mục') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="bg-accent hover:bg-accent-700 text-white font-bold py-2 px-4 rounded-none inline-block">
                + Thêm danh mục mới
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="border-l-4 border-accent bg-neutral-900 text-white text-sm px-4 py-3 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-ink overflow-hidden  sm:rounded-none border-2 border-white p-6">
                <table class="min-w-full divide-y divide-neutral-800 border">
                    <thead>
                        <tr class="bg-neutral-900 border-b-2 border-accent">
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Tên danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Mô tả</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-white uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-ink divide-y divide-neutral-800">
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $category->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-white">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">{{ $category->slug }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">{{ $category->description ?? 'Không có' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-white hover:text-accent font-bold mr-3">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-300 font-bold">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-neutral-400">Chưa có danh mục nào được tạo.</td>
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
