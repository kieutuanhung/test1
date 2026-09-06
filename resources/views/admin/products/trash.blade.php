<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="section-title">
                {{ __('THÙNG RÁC SẢN PHẨM') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="border border-white text-white hover:bg-white hover:text-ink font-bold py-2 px-4 rounded-none inline-block transition">
                &larr; Quay lại danh sách
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

            <p class="text-sm text-neutral-400 mb-4">
                Sản phẩm ở đây đã bị ẩn khỏi shop nhưng <strong class="text-white">dữ liệu doanh thu cũ vẫn được giữ nguyên</strong>. Bạn có thể khôi phục lại bất cứ lúc nào, hoặc xóa vĩnh viễn nếu chắc chắn không cần nữa.
            </p>

            <div class="bg-ink overflow-hidden sm:rounded-none border-2 border-white p-6">
                <table class="min-w-full divide-y divide-neutral-800 border">
                    <thead>
                        <tr class="bg-neutral-900 border-b-2 border-accent">
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Hình ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Tên sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Giá</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase">Đã xóa lúc</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-white uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-ink divide-y divide-neutral-800">
                        @forelse($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded-none border border-neutral-700 opacity-50">
                                    @else
                                        <span class="text-xs text-neutral-500">Không ảnh</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-neutral-400 line-through">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-neutral-400">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-emerald-400 hover:text-emerald-300 font-bold mr-3">Khôi phục</button>
                                    </form>
                                    <form action="{{ route('admin.products.forceDelete', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa VĨNH VIỄN sản phẩm này? Không thể khôi phục lại được nữa!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-300 font-bold">Xóa vĩnh viễn</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-neutral-400 uppercase tracking-widest2 text-xs">Thùng rác đang trống.</td>
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
