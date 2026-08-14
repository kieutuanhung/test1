<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-pink-600 leading-tight">
                {{ __('Quản lý Sản phẩm') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow inline-block">
                + Thêm sản phẩm mới
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
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Hình ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tên sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Giá</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Kho</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-pink-700 uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded-lg border border-pink-200">
                                    @else
                                        <span class="text-xs text-gray-400">Không ảnh</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-pink-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-pink-600 font-medium">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->stock }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-pink-600 hover:text-pink-900 font-bold mr-3">Sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Chưa có sản phẩm nào được tạo.</td>
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
