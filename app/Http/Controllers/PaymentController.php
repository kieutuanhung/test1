<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Trang hiện mã QR hoặc thông báo đã thanh toán — chỉ chủ đơn hàng (đã đăng nhập) mới xem được.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Phòng trường hợp đơn hàng cũ chưa có payment_code
        if (empty($order->payment_code)) {
            $order->update(['payment_code' => (string) \Illuminate\Support\Str::uuid()]);
        }

        $confirmUrl = route('payment.confirm-link', $order->payment_code);

        // Không redirect nữa - luôn render cùng 1 trang,
        // trang tự biết hiển thị QR hay hiển thị "đã thanh toán" dựa vào $order->payment_status
        return view('payment.show', compact('order', 'confirmUrl'));
    }

    /**
     * API nhỏ để JS trên trang QR tự động hỏi xem đã thanh toán chưa (polling).
     */
    public function status(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return response()->json([
            'paid' => $order->payment_status === 'paid',
        ]);
    }

    /**
     * Link ẩn trong mã QR - KHÔNG yêu cầu đăng nhập,
     * vì đây là link được "quét" từ thiết bị khác (giả lập cổng thanh toán gọi về).
     */
    public function confirmByCode(string $code)
    {
        $order = Order::where('payment_code', $code)->firstOrFail();

        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'status'         => 'pending',   // có tiền rồi shop mới thấy đơn
                'paid_at'        => now(),
            ]);
        }

        return view('payment.confirmed', compact('order'));
    }
}
