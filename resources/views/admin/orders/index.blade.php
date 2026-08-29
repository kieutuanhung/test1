<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Quản lý Đơn Hàng') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-pink-100 p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Mã Đơn</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Khách hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Số ĐT</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Tổng tiền</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Trạng thái</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-4 py-4 font-bold text-gray-800">#{{ $order->id }}</td>
                                <td class="px-4 py-4">{{ $order->customer_name }}</td>
                                <td class="px-4 py-4">{{ $order->customer_phone }}</td>
                                <td class="px-4 py-4 text-right font-bold text-pink-600">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                <td class="px-4 py-4 text-center">
				@if($order->status === 'pending')
    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Chờ gom hàng</span>
@elseif($order->status === 'processing')
    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Đang nhập & Đóng gói</span>
@elseif($order->status === 'completed')
    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Hoàn thành</span>
@elseif($order->status === 'cancelled')
    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Đã hủy</span>
@endif
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-pink-600 hover:text-pink-900 font-bold">Xem →</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Chưa có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
