<x-app-layout>
    <div class="bg-pink-50/40 min-h-screen py-16">
        <div class="max-w-2xl mx-auto px-4 text-center bg-white p-8 rounded-3xl border border-pink-100 shadow-sm">
            <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto text-3xl mb-4">
                ✓
            </div>
            <h1 class="text-2xl font-extrabold text-gray-800">Đặt Hàng Thành Công!</h1>
            <p class="text-gray-500 mt-2">Mã đơn hàng: <b class="text-pink-600">#{{ $order->id }}</b></p>
            <p class="text-sm text-gray-600 mt-1">Cảm ơn bạn đã mua sắm! Đơn hàng của bạn đang được xử lý.</p>

            <div class="border-t border-pink-100 my-6 pt-4 text-left text-sm text-gray-600 space-y-2">
                <p><b>Người nhận:</b> {{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                <p><b>Địa chỉ nhận:</b> {{ $order->customer_address }}</p>
                <p><b>Tổng thanh toán:</b> <span class="font-bold text-pink-600">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span></p>
            </div>

            <a href="{{ route('home') }}" class="inline-block bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow">
                ← Tiếp tục mua sắm
            </a>
        </div>
    </div>
</x-app-layout>
