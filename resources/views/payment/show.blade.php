<x-app-layout>
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h2 class="section-title mb-8">
            Thanh Toán Đơn Hàng #{{ $order->id }}
        </h2>

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
    </div>

    <script>
        function checkPayment() {
            const button = document.getElementById('check-payment-btn');
            const message = document.getElementById('payment-message');

            // Đánh dấu người dùng đã yêu cầu kiểm tra
            sessionStorage.setItem(
                'payment_check_requested',
                'true'
            );

            // Ẩn thông báo cũ
            message.classList.add('hidden');
            message.innerHTML = '';

            // Khóa nút trong lúc reload
            button.disabled = true;
            button.innerText = 'Đang kiểm tra...';

            /*
             * Reload trang để Laravel kiểm tra lại
             * payment_status của đơn hàng.
             */
            setTimeout(function () {
                window.location.reload();
            }, 500);
        }

        document.addEventListener('DOMContentLoaded', function () {

            const message = document.getElementById('payment-message');
            const button = document.getElementById('check-payment-btn');

            const checkRequested =
                sessionStorage.getItem('payment_check_requested');

            @if ($order->payment_status !== 'paid')

                /*
                 * Chỉ hiện thông báo nếu người dùng
                 * vừa bấm nút kiểm tra thanh toán.
                 */
                if (checkRequested === 'true') {

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

                    // Xóa trạng thái sau khi đã hiển thị thông báo
                    sessionStorage.removeItem('payment_check_requested');
                }

            @else

                /*
                 * Nếu đơn hàng đã thanh toán thì
                 * xóa trạng thái kiểm tra.
                 */
                sessionStorage.removeItem('payment_check_requested');

            @endif
        });
    </script>

</x-app-layout>
