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

            <!-- Tìm kiếm danh mục -->
            <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-4">
                <div class="relative max-w-sm">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên danh mục..."
                           class="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-full pl-4 pr-9 py-2.5 focus:border-accent focus:ring-accent placeholder:text-neutral-500">
                    <button type="submit" class="absolute right-0 top-0 h-full px-3 text-neutral-500 hover:text-accent transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

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
                                <td colspan="5" class="px-6 py-4 text-center text-neutral-400">
                                    @if(request('search'))
                                        Không tìm thấy danh mục nào khớp với "{{ request('search') }}".
                                    @else
                                        Chưa có danh mục nào được tạo.
                                    @endif
                                </td>
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
