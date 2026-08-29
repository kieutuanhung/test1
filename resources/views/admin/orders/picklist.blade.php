<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Danh Sách Hàng Khách Đặt Cần Nhập Về (Pick List)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-pink-100 p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Tổng hợp số lượng sản phẩm từ tất cả các đơn hàng đang ở trạng thái <strong>Chờ duyệt (Pending)</strong> để nhân viên liên hệ nhập hàng.</p>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">STT</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tên Sản Phẩm</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Số Lượng Cần Lấy/Nhập</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($itemsToPick as $index => $item)
                            <tr>
                                <td class="px-4 py-4 font-bold text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-4 font-bold text-gray-800">{{ $item->product_name }}</td>
                                <td class="px-4 py-4 text-center font-black text-pink-600 text-base">
                                    {{ $item->total_quantity }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">
                                        Chờ nhập hàng
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    Không có đơn hàng nào chờ gom sản phẩm!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
