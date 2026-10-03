<x-app-layout>
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <div class="border border-green-700 bg-green-50 text-green-800 p-6 rounded">
            <p class="text-lg font-bold mb-2">✅ Xác nhận thanh toán thành công!</p>
            <p class="text-sm">Đơn hàng #{{ $order->id }} đã được ghi nhận thanh toán.</p>
            <p class="text-sm mt-2">Số tiền: {{ number_format($order->total_price, 0, ',', '.') }} đ</p>
        </div>
        <p class="text-xs text-neutral-500 mt-6">
            Bạn có thể quay lại trang đặt hàng trên thiết bị ban đầu để tiếp tục.
        </p>
    </div>
</x-app-layout>
