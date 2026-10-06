<x-app-layout>
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h2 class="section-title mb-8">
            Thanh Toán Đơn Hàng #{{ $order->id }}
        </h2>

        @if ($order->payment_status === 'paid')

            {{-- ĐÃ THANH TOÁN --}}
            <div class="border border-green-600/50 bg-green-500/10 text-green-300 p-6 rounded text-center">
                <p class="text-lg font-bold mb-2">✅ Đã thanh toán thành công!</p>
                <p class="text-sm">Đơn hàng #{{ $order->id }} đã được ghi nhận thanh toán.</p>
                <p class="text-sm mt-2">Số tiền: {{ number_format($order->total_price, 0, ',', '.') }} đ</p>

                <a href="{{ route('order.success', $order->id) }}" class="btn-accent inline-block mt-4">
                    Xem chi tiết đơn hàng
                </a>
            </div>

        @else

            {{-- CHƯA THANH TOÁN - hiện QR --}}

            {{-- Thông báo khi hệ thống chưa nhận được thanh toán --}}
            <div id="payment-message"
                 class="hidden mb-6 border border-yellow-500/50 bg-yellow-500/10 text-yellow-300 px-4 py-3 rounded">
            </div>

            <div class="border border-neutral-800 p-6 space-y-4 text-center">

                {{-- Số tiền --}}
                <p class="text-sm text-neutral-400">
                    Số tiền cần thanh toán
                </p>

                <p class="text-3xl font-extrabold text-white">
                    {{ number_format($order->total_price, 0, ',', '.') }} đ
                </p>

                {{-- Mã QR thanh toán --}}
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($confirmUrl) }}"
                    alt="Mã QR thanh toán"
                    class="mx-auto bg-white p-2 rounded"
                >

                <p class="text-xs text-neutral-500">
                    Quét mã QR bằng điện thoại khác
                    để xác nhận thanh toán.
                </p>

                {{-- Nút kiểm tra thanh toán --}}
                <button
                    type="button"
                    id="check-payment-btn"
                    onclick="checkPayment()"
                    class="btn-accent w-full mt-4"
                >
                    Tôi đã thanh toán, kiểm tra lại
                </button>

            </div>

        @endif

    </div>

    @if ($order->payment_status !== 'paid')
    <script>
        const successUrl = "{{ route('order.success', $order->id) }}";
        let pollTimer = null;

        // Cứ 3 giây tải ngầm trang này để xem đơn đã paid chưa.
        // Nếu HTML trả về không còn nút "check-payment-btn" => đã paid
        // => chuyển thẳng sang trang thành công.
        async function isPaid() {
            try {
                const res = await fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    cache: 'no-store',
                    credentials: 'same-origin',
                });
                const html = await res.text();
                return !html.includes('id="check-payment-btn"');
            } catch (e) {
                return false; // lỗi mạng tạm thời, lần sau thử lại
            }
        }

        async function autoCheck() {
            if (document.hidden) return;

            if (await isPaid()) {
                clearInterval(pollTimer);
                window.location.href = successUrl;
            }
        }

        async function checkPayment() {
            const button = document.getElementById('check-payment-btn');
            const message = document.getElementById('payment-message');

            message.classList.add('hidden');
            message.innerHTML = '';

            button.disabled = true;
            button.innerText = 'Đang kiểm tra...';

            if (await isPaid()) {
                clearInterval(pollTimer);
                window.location.href = successUrl;
                return;
            }

            message.innerHTML = `
                <strong>⚠ Chưa nhận được thanh toán</strong>
                <br>
                <span class="text-sm">
                    Hệ thống chưa ghi nhận thanh toán cho
                    đơn hàng #{{ $order->id }}.
                    Vui lòng thực hiện thanh toán và thử kiểm tra lại.
                </span>
            `;
            message.classList.remove('hidden');

            button.disabled = false;
            button.innerText = 'Tôi đã thanh toán, kiểm tra lại';
        }

        document.addEventListener('DOMContentLoaded', function () {
            pollTimer = setInterval(autoCheck, 3000);
        });
    </script>
    @endif

</x-app-layout>
