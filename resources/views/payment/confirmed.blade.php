<x-app-layout>
    <div class="py-16" style="background:radial-gradient(ellipse 60% 50% at 0% 0%, rgba(232,68,44,0.14), transparent 70%), radial-gradient(ellipse 60% 50% at 100% 0%, rgba(234,150,8,0.10), transparent 70%), #0d0d0f; margin-bottom:-4rem; min-height:60vh; padding-top:4rem; padding-bottom:4rem;">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="rounded-2xl"
                 style="padding:2rem; background:#1a1c24; border:1px solid rgba(232,68,44,0.45); box-shadow:0 8px 24px rgba(0,0,0,0.4);">
                <p class="text-xl font-bold mb-3" style="color:#4ade80;">✅ Xác nhận thanh toán thành công!</p>
                <p class="text-sm" style="color:#e5e7eb;">Đơn hàng #{{ $order->id }} đã được ghi nhận thanh toán.</p>
                <p class="text-sm mt-2" style="color:#ffffff; font-weight:700;">Số tiền: {{ number_format($order->total_price, 0, ',', '.') }} đ</p>
            </div>

            <a href="{{ route('home') }}"
               class="inline-block font-bold uppercase rounded transition hover:opacity-90"
               style="margin-top:1.5rem; padding:0.75rem 1.75rem; background:#e8442c; color:#fff; font-size:0.875rem; letter-spacing:0.1em;">
                Quay lại trang chủ
            </a>

            <p class="text-xs text-neutral-400" style="margin-top:1.5rem;">
                Bạn có thể quay lại trang đặt hàng trên thiết bị ban đầu để tiếp tục.
            </p>
        </div>
    </div>
</x-app-layout>
