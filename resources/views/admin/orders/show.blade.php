<x-app-layout>
    @php
        // [nhãn, màu] - dùng inline style nên không cần build lại Tailwind
        $statusMap = [
            'pending'    => ['Chờ gom hàng',         '#fbbf24'],
            'processing' => ['Đang nhập & Đóng gói', '#38bdf8'],
            'completed'  => ['Hoàn thành',           '#34d399'],
            'cancelled'  => ['Đã hủy',               '#f87171'],
        ];
        $st = $statusMap[$order->status] ?? null;
        $labelClass = 'text-[11px] font-bold uppercase tracking-widest text-neutral-500';
    @endphp

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4">
                <h2 class="section-title">
                    Chi Tiết Đơn Hàng #{{ $order->id }}
                </h2>
                @if($st)
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold"
                          style="color: {{ $st[1] }}; background-color: {{ $st[1] }}1f; border: 1px solid {{ $st[1] }}66;">
                        <span class="rounded-full" style="width:6px; height:6px; background-color: {{ $st[1] }};"></span>
                        {{ $st[0] }}
                    </span>
                @endif
                @if($order->payment_status === 'refunded')
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold"
                          style="color: #a78bfa; background-color: #a78bfa1f; border: 1px solid #a78bfa66;">
                        Đã hoàn tiền
                    </span>
                @endif
            </div>

            <a href="{{ route('admin.orders.index') }}"
               class="border border-neutral-600 text-neutral-300 hover:border-white hover:text-white text-xs font-bold uppercase tracking-widest px-4 py-2.5 rounded-lg transition">
                ← Quay lại danh sách
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-ink min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-lg px-4 py-3 text-sm"
                     style="color:#6ee7b7; background-color:#34d3991a; border:1px solid #34d39966;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-lg px-4 py-3 text-sm"
                     style="color:#fca5a5; background-color:#f871711a; border:1px solid #f8717166;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-lg px-4 py-3 text-sm"
                     style="color:#fca5a5; background-color:#f871711a; border:1px solid #f8717166;">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Thông tin nhận hàng: xếp ngang cho gọn -->
            <div class="bg-neutral-900/50 border border-neutral-800 rounded-2xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-5">Thông tin nhận hàng</h3>

                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1.25rem 2rem;">
                    <div>
                        <p class="{{ $labelClass }}">Khách hàng</p>
                        <p class="text-white mt-1">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="{{ $labelClass }}">Số điện thoại</p>
                        <p class="text-white mt-1">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="{{ $labelClass }}">Email</p>
                        <p class="text-white mt-1 break-all">{{ $order->customer_email ?: 'Không có' }}</p>
                    </div>
                    <div>
                        <p class="{{ $labelClass }}">Địa chỉ</p>
                        <p class="text-white mt-1">{{ $order->customer_address }}</p>
                    </div>
                    <div>
                        <p class="{{ $labelClass }}">Ghi chú</p>
                        <p class="text-white mt-1">{{ $order->note ?: 'Không có' }}</p>
                    </div>
                    <div>
                        <p class="{{ $labelClass }}">Ngày đặt</p>
                        <p class="text-white mt-1">{{ optional($order->created_at)->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="align-items:start;">

                <!-- Danh sách sản phẩm -->
                <div class="md:col-span-2 bg-neutral-900/50 border border-neutral-800 rounded-2xl p-6">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-5">Danh sách sản phẩm</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-neutral-700 text-neutral-500 text-[11px] uppercase tracking-widest">
                                    <th class="text-left pb-3 font-bold">Tên sản phẩm</th>
                                    <th class="text-center pb-3 font-bold">SL</th>
                                    <th class="text-right pb-3 font-bold">Đơn giá</th>
                                    <th class="text-right pb-3 font-bold">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="text-neutral-300">
                                @foreach($order->items as $item)
                                    <tr class="border-b border-neutral-800 last:border-b-0">
                                        <td class="py-4 pr-4">
                                            <div class="flex items-center gap-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 object-cover bg-neutral-800 rounded-lg shrink-0">
                                                @else
                                                    <div class="w-14 h-14 bg-neutral-800 rounded-lg shrink-0"></div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-white">{{ $item->product_name }}</p>
                                                    @if($item->size)
                                                        <p class="text-xs text-neutral-500 mt-0.5">Size: {{ $item->size }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="py-4 text-right whitespace-nowrap">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                        <td class="py-4 text-right font-bold text-white whitespace-nowrap">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 pt-5 border-t border-neutral-700 flex items-center justify-end gap-4">
                        <span class="text-xs font-bold uppercase tracking-widest text-neutral-400">Tổng tiền đơn hàng</span>
                        <span class="text-2xl font-black text-white">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>

                <!-- Cột phải: cập nhật trạng thái + hoàn tiền -->
                <div class="space-y-6">

                    <!-- Cập nhật trạng thái -->
                    <div class="bg-neutral-900/50 border border-neutral-800 rounded-2xl p-6">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-5">Cập nhật trạng thái</h3>

                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <select name="status"
                                    class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-accent focus:ring-1 focus:ring-accent transition mb-3">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>1. Chờ gom hàng</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>2. Đang nhập & Đóng gói</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>3. Hoàn thành / Đã giao</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>4. Hủy đơn</option>
                            </select>

                            <button type="submit"
                                    class="w-full bg-accent hover:bg-accent-700 text-white text-xs font-bold uppercase tracking-widest py-3 rounded-lg transition">
                                Lưu trạng thái
                            </button>
                        </form>

                        <div class="mt-6 pt-5 border-t border-neutral-800 space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-500">Số mặt hàng</span>
                                <span class="text-white font-semibold">{{ $order->items->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-500">Tổng số lượng</span>
                                <span class="text-white font-semibold">{{ $order->items->sum('quantity') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hoàn tiền: đơn đã hủy nhưng khách đã chuyển khoản -->
                    @if($order->status === 'cancelled' && $order->payment_status === 'paid')
                        <div class="rounded-2xl p-6"
                             style="background-color:#f871711a; border:1px solid #f8717166;">
                            <h3 class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#fca5a5;">Cần hoàn tiền cho khách</h3>

                            <p class="text-sm text-neutral-300 mb-1">
                                Số tiền: <span class="text-white font-bold">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                            </p>
                            <p class="text-sm text-neutral-300 mb-4">
                                Liên hệ khách: <span class="text-white font-bold">{{ $order->customer_phone }}</span>
                                để xin số tài khoản nhận lại tiền, chuyển khoản xong rồi bấm xác nhận.
                            </p>

                            <form action="{{ route('admin.orders.refund', $order->id) }}" method="POST"
                                  onsubmit="return confirm('Xác nhận bạn ĐÃ chuyển khoản hoàn tiền cho khách?');">
                                @csrf
                                @method('PATCH')

                                <input type="text" name="refund_note" maxlength="255" required
                                       value="{{ old('refund_note') }}"
                                       placeholder="Mã giao dịch / ghi chú hoàn tiền"
                                       class="w-full bg-neutral-900 border border-neutral-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-accent focus:ring-1 focus:ring-accent transition mb-3">

                                <button type="submit"
                                        class="w-full bg-accent hover:bg-accent-700 text-white text-xs font-bold uppercase tracking-widest py-3 rounded-lg transition">
                                    Đã hoàn tiền
                                </button>
                            </form>
                        </div>
                    @elseif($order->payment_status === 'refunded')
                        <div class="rounded-2xl p-6"
                             style="background-color:#a78bfa1a; border:1px solid #a78bfa66;">
                            <h3 class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#c4b5fd;">Đã hoàn tiền</h3>
                            <p class="text-sm text-neutral-300">
                                Số tiền: <span class="text-white font-bold">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                            </p>
                            <p class="text-sm text-neutral-300 mt-1">
                                Lúc: <span class="text-white">{{ optional($order->refunded_at)->format('d/m/Y H:i') ?? '—' }}</span>
                            </p>
                            <p class="text-sm text-neutral-300 mt-1">
                                Ghi chú: <span class="text-white">{{ $order->refund_note }}</span>
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
