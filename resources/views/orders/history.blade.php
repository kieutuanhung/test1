<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Tài khoản</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Lịch sử đơn hàng của tôi') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        div.sh-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .sh-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;transition:border-color .2s, transform .2s;}
        .sh-card:hover{border-color:rgba(224,57,44,.45);transform:translateY(-1px);}
        .sh-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .sh-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
    </style>

    @php
        $statusMap = [
            'pending'    => ['Chờ gom hàng',       '#fbbf24'],
            'processing' => ['Đang đóng gói',      '#60a5fa'],
            'completed'  => ['Đã giao thành công', '#34d399'],
        ];
    @endphp

    <div class="py-6 bg-ink min-h-screen sh-wrap">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @forelse($orders as $order)
                @php
                    [$stLabel, $stColor] = $statusMap[$order->status] ?? ['Đã hủy', '#f87171'];
                @endphp
                <div class="sh-card" style="padding:1.5rem;">
                    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:.75rem; border-bottom:1px solid #2e2e37; padding-bottom:1rem; margin-bottom:.5rem;">
                        <div style="display:flex; align-items:baseline; gap:.6rem; flex-wrap:wrap;">
                            <span style="color:#fbbf24; font-weight:800; font-size:15px;">Đơn hàng #{{ $order->id }}</span>
                            <span style="font-size:12px; color:#8a8a96;">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <span style="display:inline-flex; align-items:center; gap:.5rem; padding:.25rem .8rem; border-radius:9999px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:{{ $stColor }}; background-color:{{ $stColor }}1f; border:1px solid {{ $stColor }}55;">
                            <span style="width:7px; height:7px; border-radius:9999px; background-color:{{ $stColor }};"></span>
                            {{ $stLabel }}
                        </span>
                    </div>

                    <div>
                        @foreach($order->items as $item)
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:.75rem; padding:.85rem 0; {{ !$loop->last ? 'border-bottom:1px solid #2a2a33;' : '' }}">
                                <div style="display:flex; align-items:center; gap:.85rem; min-width:0;">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" style="width:52px; height:52px; object-fit:cover; background-color:#16161b; border:1px solid #2e2e37; border-radius:12px; flex-shrink:0;">
                                    @else
                                        <div style="width:52px; height:52px; background-color:#16161b; border:1px solid #2e2e37; border-radius:12px; flex-shrink:0;"></div>
                                    @endif
                                    <div style="min-width:0;">
                                        <p style="margin:0; color:#fff; font-weight:600; font-size:14px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            {{ $item->product_name }}
                                            @if($item->size)
                                                <span style="color:#a8a8b3; font-weight:400;">(Size: {{ $item->size }})</span>
                                            @endif
                                        </p>
                                        <p style="margin:2px 0 0; font-size:12px; color:#8a8a96;">Số lượng: x{{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <span style="color:#fff; font-weight:700; font-size:14px; flex-shrink:0;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="border-top:1px solid #2e2e37; padding-top:1rem; margin-top:.5rem; display:flex; justify-content:space-between; align-items:center; gap:1rem;">
                        <span style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#a8a8b3;">Tổng thanh toán</span>
                        <span style="font-size:20px; font-weight:900; color:#fbbf24;">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            @empty
                <div class="sh-card" style="padding:3.5rem 1rem; text-align:center;">
                    <p style="margin:0 0 1.5rem; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">Bạn chưa có đơn đặt hàng nào</p>
                    <a href="{{ route('home') }}" class="sh-btn-red">Đặt hàng ngay</a>
                </div>
            @endforelse

            <div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
