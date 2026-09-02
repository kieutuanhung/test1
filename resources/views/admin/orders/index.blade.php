<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Quản lý Đơn Hàng') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink overflow-hidden  rounded-none border-2 border-white p-6">
                <table class="min-w-full divide-y divide-neutral-800">
                    <thead class="bg-neutral-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Mã Đơn</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Khách hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Tên hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Số ĐT</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white uppercase">Tổng tiền</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase">Trạng thái</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white uppercase">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800 text-sm">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-4 py-4 font-bold text-white">#{{ $order->id }}</td>
                                <td class="px-4 py-4">{{ $order->customer_name }}</td>
                                <td class="px-4 py-4 max-w-[220px]">
                                    <span class="text-white">{{ $order->items->first()->product_name ?? '—' }}</span>
                                    @if($order->items->count() > 1)
                                        <span class="text-neutral-400 text-xs"> +{{ $order->items->count() - 1 }} sản phẩm khác</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">{{ $order->customer_phone }}</td>
                                <td class="px-4 py-4 text-right font-bold text-white">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
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
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-white hover:text-accent font-bold">Xem →</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-neutral-400">Chưa có đơn hàng nào.</td>
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
