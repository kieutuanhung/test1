<x-app-layout>
    <div class="py-16">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-neutral-900 border-2 border-accent rounded-2xl shadow-2xl shadow-accent/20 text-center p-10">
                <div class="w-16 h-16 bg-emerald-600 text-white rounded-full flex items-center justify-center mx-auto text-3xl mb-5 shadow-lg shadow-emerald-600/40">
                    &check;
                </div>
                <h1 class="text-2xl font-extrabold uppercase tracking-wide text-white">Đặt Hàng Thành Công!</h1>
                <p class="text-neutral-400 mt-2 text-sm">Mã đơn hàng: <b class="text-white">#{{ $order->id }}</b></p>
                <p class="text-sm text-neutral-400 mt-1">Cảm ơn bạn đã mua sắm! Đơn hàng của bạn đang được xử lý.</p>

                <div class="border-t border-neutral-800 my-6 pt-6 text-left text-sm text-neutral-300 space-y-2">
                    <p><b class="text-white">Người nhận:</b> {{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                    <p><b class="text-white">Địa chỉ nhận:</b> {{ $order->customer_address }}</p>
                    <p><b class="text-white">Tổng thanh toán:</b> <span class="font-bold text-white">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span></p>
                </div>

                <a href="{{ route('home') }}" class="btn-primary">
                    &larr; Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
