<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Bán hàng</p>
            <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                {{ __('Quản lý đơn hàng') }}
            </h2>
        </div>
    </x-slot>

    @php
        $hasFilter = request('order_id') || request('customer') || request('product') || request('phone') || request('status');

        // Mỗi trạng thái: [nhãn, màu] (dùng inline style nên không cần build lại Tailwind)
        $statusMap = [
            'pending'    => ['Chờ gom hàng',         '#fbbf24'], // vàng
            'processing' => ['Đang nhập & Đóng gói', '#38bdf8'], // xanh dương
            'completed'  => ['Hoàn thành',           '#34d399'], // xanh lá
            'cancelled'  => ['Đã hủy',               '#f87171'], // đỏ
        ];
    @endphp

    <style>
        /* Nền sáng hơn, đồng bộ với dashboard chủ shop */
        div.ad-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .ad-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .ad-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;margin-bottom:.4rem;}
        .ad-input{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.65rem .875rem .65rem 1.1rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .ad-input::placeholder{color:#8a8a96;}
        .ad-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .ad-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .ad-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
        .ad-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #3a3a45;color:#b8b8c2;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
        .ad-btn-ghost:hover{border-color:#fff;color:#fff;}

        /* Thẻ thống kê */
        .ad-kpi{--c:96,165,250;display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:14px;
            border:1px solid rgba(var(--c),.30);
            background:linear-gradient(135deg,rgba(var(--c),.18),rgba(var(--c),.03) 60%),#1c1c22;
            transition:transform .2s, border-color .2s;}
        .ad-kpi:hover{transform:translateY(-2px);border-color:rgba(var(--c),.65);}
        .ad-kpi-icon{width:38px;height:38px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:rgba(var(--c),.20);color:rgb(var(--c));}
        .ad-kpi-icon svg{width:18px;height:18px;}
        .ad-kpi-label{margin:0;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#b8b8c2;}
        .ad-kpi-value{margin:4px 0 0;font-size:26px;font-weight:900;line-height:1;color:rgb(var(--c));}

        /* Bảng */
        .ad-tbl{width:100%;border-collapse:collapse;}
        .ad-tbl thead{background-color:#16161b;}
        .ad-tbl th{padding:1rem 1.25rem;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;border-bottom:1px solid #2e2e37;white-space:nowrap;}
        .ad-tbl td{padding:1rem 1.25rem;font-size:14px;color:#d4d4dc;border-bottom:1px solid #2a2a33;vertical-align:middle;}
        .ad-tbl tbody tr:last-child td{border-bottom:0;}
        .ad-tbl tbody tr{transition:background-color .15s;}
        .ad-tbl tbody tr:hover{background-color:rgba(224,57,44,.07);}
        .ad-oid{color:#fbbf24;font-weight:800;white-space:nowrap;}
        .ad-money{color:#fff;font-weight:800;white-space:nowrap;text-align:right;}
        .ad-view{display:inline-block;border:1px solid rgba(96,165,250,.45);color:#93c5fd;background:rgba(96,165,250,.10);font-size:12px;font-weight:700;padding:.4rem .95rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
        .ad-view:hover{background:rgba(96,165,250,.22);border-color:#60a5fa;color:#fff;}
    </style>

    <div class="py-6 bg-ink min-h-screen ad-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            <!-- Thẻ thống kê -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                <div class="ad-kpi" style="--c:96,165,250;">
                    <div>
                        <p class="ad-kpi-label">{{ $hasFilter ? 'Kết quả tìm thấy' : 'Tổng số đơn hàng' }}</p>
                        <p class="ad-kpi-value">{{ $orders->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Bộ lọc: Mã đơn / Khách hàng / Tên hàng / SĐT / Trạng thái -->
            <form method="GET" action="{{ route('admin.orders.index') }}" class="ad-card" style="padding:1.25rem;">
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:1rem; align-items:end;">

                    <div>
                        <label class="ad-label">Mã đơn</label>
                        <input type="text" name="order_id" value="{{ request('order_id') }}" placeholder="VD: 22" class="ad-input">
                    </div>

                    <div>
                        <label class="ad-label">Khách hàng</label>
                        <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Tên khách hàng" class="ad-input">
                    </div>

                    <div>
                        <label class="ad-label">Sản phẩm</label>
                        <input type="text" name="product" value="{{ request('product') }}" placeholder="Tên sản phẩm" class="ad-input">
                    </div>

                    <div>
                        <label class="ad-label">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ request('phone') }}" placeholder="Số điện thoại" class="ad-input">
                    </div>

                    <div>
                        <label class="ad-label">Trạng thái</label>
                        <select name="status" onchange="this.form.submit()" class="ad-input">
                            <option value="">Tất cả</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ gom hàng</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Đang nhập & Đóng gói</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div style="display:flex; gap:.5rem;">
                        <button type="submit" class="ad-btn-red" style="flex:1;">Lọc</button>
                        @if($hasFilter)
                            <a href="{{ route('admin.orders.index') }}" class="ad-btn-ghost">Xóa lọc</a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Bảng -->
            <div class="ad-card" style="overflow:hidden;">
                <div style="overflow-x:auto;">
                    <table class="ad-tbl">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tên hàng</th>
                                <th>Số ĐT</th>
                                <th style="text-align:right;">Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php $st = $statusMap[$order->status] ?? null; @endphp
                                <tr>
                                    <td class="ad-oid">#{{ $order->id }}</td>
                                    <td style="white-space:nowrap; color:#fff; font-weight:600;">{{ $order->customer_name }}</td>
                                    <td style="max-width:240px;">
                                        <span style="color:#fff;">{{ $order->items->first()->product_name ?? '—' }}</span>
                                        @if($order->items->count() > 1)
                                            <span style="color:#8a8a96; font-size:12px;"> +{{ $order->items->count() - 1 }} sản phẩm khác</span>
                                        @endif
                                    </td>
                                    <td style="white-space:nowrap; color:#b8b8c2;">{{ $order->customer_phone }}</td>
                                    <td class="ad-money">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                    <td style="white-space:nowrap;">
                                        @if($st)
                                            <span style="display:inline-flex; align-items:center; gap:.5rem; padding:.25rem .75rem; border-radius:999px; font-size:12px; font-weight:700; color:{{ $st[1] }}; background-color:{{ $st[1] }}1f; border:1px solid {{ $st[1] }}66;">
                                                <span style="width:6px; height:6px; border-radius:999px; background-color:{{ $st[1] }};"></span>
                                                {{ $st[0] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align:right; white-space:nowrap;">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="ad-view">Xem →</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        @if($hasFilter)
                                            Không tìm thấy đơn hàng nào khớp với bộ lọc.
                                        @else
                                            Chưa có đơn hàng nào.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.25rem; border-top:1px solid #2e2e37;">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
