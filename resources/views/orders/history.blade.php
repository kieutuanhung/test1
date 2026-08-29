<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Lịch Sử Đơn Hàng Của Tôi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse($orders as $order)
                <div class="bg-white rounded-2xl p-6 border border-pink-100 shadow-sm">
                    <div class="flex flex-wrap justify-between items-center border-b pb-4 mb-4 gap-2">
                        <div>
                            <span class="font-mono font-bold text-pink-600">Đơn hàng #{{ $order->id }}</span>
                            <span class="text-xs text-gray-500 ml-2">({{ $order->created_at->format('d/m/Y H:i') }})</span>
                        </div>
                        <div>
                            @if($order->status === 'pending')
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">⏳ Chờ gom hàng</span>
                            @elseif($order->status === 'processing')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">📦 Đang nhập & Đóng gói</span>
                            @elseif($order->status === 'completed')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">✅ Đã giao thành công</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">❌ Đã hủy</span>
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="py-2 flex justify-between items-center text-sm">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $item->product_name }}</p>
                                    <p class="text-xs text-gray-500">Số lượng: x{{ $item->quantity }}</p>
                                </div>
                                <span class="font-semibold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-600">Tổng thanh toán:</span>
                        <span class="text-lg font-black text-pink-600">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-pink-100">
                    <p class="text-gray-500 mb-4">Bạn chưa có đơn đặt hàng nào.</p>
                    <a href="{{ route('home') }}" class="inline-block bg-pink-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-pink-700 transition">
                        Đặt hàng ngay
                    </a>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
