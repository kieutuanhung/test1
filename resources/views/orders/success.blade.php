<x-app-layout>
    <style>
        div.sh-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .sh-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .sh-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.8rem 1.6rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .sh-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
    </style>

    <div class="py-16 bg-ink min-h-screen sh-wrap">
        <div class="max-w-2xl mx-auto px-4">
            <div class="sh-card text-center" style="padding:2.5rem; border-color:rgba(52,211,153,.35); box-shadow:0 20px 50px rgba(52,211,153,.08);">
                <div style="width:64px; height:64px; border-radius:9999px; background:rgba(52,211,153,.18); border:1px solid rgba(52,211,153,.55); color:#34d399; display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem; font-size:30px; font-weight:800;">
                    &check;
                </div>
                <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.25em; color:#34d399;">Đặt hàng</p>
                <h1 style="margin:.35rem 0 0; font-size:24px; font-weight:900; text-transform:uppercase; letter-spacing:.04em; color:#fff;">Đặt hàng thành công!</h1>
                <p style="margin:.6rem 0 0; font-size:14px; color:#a8a8b3;">Mã đơn hàng: <b style="color:#fbbf24;">#{{ $order->id }}</b></p>
                <p style="margin:.25rem 0 0; font-size:14px; color:#a8a8b3;">Cảm ơn bạn đã mua sắm! Đơn hàng của bạn đang được xử lý.</p>

                <div style="border-top:1px solid #2e2e37; margin:1.5rem 0; padding-top:1.5rem; text-align:left; font-size:14px; color:#d4d4dc;" class="space-y-2">
                    <p><b class="text-white">Người nhận:</b> {{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                    <p><b class="text-white">Địa chỉ nhận:</b> {{ $order->customer_address }}</p>
                    <p><b class="text-white">Tổng thanh toán:</b> <span style="font-weight:800; color:#fbbf24;">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span></p>
                </div>

                <a href="{{ route('home') }}" class="sh-btn-red">
                    &larr; Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
