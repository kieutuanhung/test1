<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Trang hiện mã QR thanh toán — chỉ chủ đơn hàng (đã đăng nhập) mới xem được.
     */
public function show(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    if ($order->payment_status === 'paid') {
        return redirect()->route('order.success', $order->id);
    }

    // Phòng trường hợp đơn hàng cũ chưa có payment_code (tạo trước khi thêm tính năng này)
    if (empty($order->payment_code)) {
        $order->update(['payment_code' => (string) \Illuminate\Support\Str::uuid()]);
    }

    $confirmUrl = route('payment.confirm-link', $order->payment_code);

    return view('payment.show', compact('order', 'confirmUrl'));
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
                'paid_at' => now(),
            ]);
        }

        return view('payment.confirmed', compact('order'));
    }
}
