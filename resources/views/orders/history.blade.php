<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Lịch Sử Đơn Hàng Của Tôi') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @forelse($orders as $order)
            <div class="border border-neutral-800 p-6">
                <div class="flex flex-wrap justify-between items-center border-b border-neutral-800 pb-4 mb-4 gap-2">
                    <div>
                        <span class="font-mono font-bold text-white text-sm">Đơn hàng #{{ $order->id }}</span>
                        <span class="text-xs text-neutral-400 ml-2">({{ $order->created_at->format('d/m/Y H:i') }})</span>
                    </div>
                    <div>
                        @if($order->status === 'pending')
                            <span class="px-3 py-1 border border-amber-600 text-amber-700 text-[11px] font-semibold uppercase tracking-wide">Chờ gom hàng</span>
                        @elseif($order->status === 'processing')
                            <span class="px-3 py-1 border border-blue-600 text-blue-700 text-[11px] font-semibold uppercase tracking-wide">Đang đóng gói</span>
                        @elseif($order->status === 'completed')
                            <span class="px-3 py-1 border border-green-700 text-green-700 text-[11px] font-semibold uppercase tracking-wide">Đã giao thành công</span>
                        @else
                            <span class="px-3 py-1 border border-red-700 text-red-700 text-[11px] font-semibold uppercase tracking-wide">Đã hủy</span>
                        @endif
                    </div>
                </div>

                <div class="divide-y divide-neutral-800">
                    @foreach($order->items as $item)
                        <div class="py-2 flex items-center justify-between text-sm gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 object-cover bg-neutral-800 rounded-lg shrink-0">
                                @else
                                    <div class="w-12 h-12 bg-neutral-800 rounded-lg shrink-0"></div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-white truncate">{{ $item->product_name }} @if($item->size) <span class="text-neutral-400 font-normal">(Size: {{ $item->size }})</span> @endif</p>
                                    <p class="text-xs text-neutral-400">Số lượng: x{{ $item->quantity }}</p>
                                </div>
                            </div>
                            <span class="font-semibold text-white shrink-0">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-neutral-800 pt-4 mt-4 flex justify-between items-center">
                    <span class="text-xs uppercase tracking-widest2 text-neutral-400">Tổng thanh toán</span>
                    <span class="text-lg font-extrabold text-white">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                </div>
            </div>
        @empty
            <div class="border border-neutral-800 p-14 text-center">
                <p class="text-neutral-400 mb-6 text-sm uppercase tracking-widest2">Bạn chưa có đơn đặt hàng nào</p>
                <a href="{{ route('home') }}" class="btn-accent">
                    Đặt hàng ngay
                </a>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
