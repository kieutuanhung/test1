<x-app-layout>
    @php
        $rows      = collect($itemsToPick);
        $totalType = $rows->count();
        $totalQty  = $rows->sum('total_quantity');
        $amber     = '#fbbf24';
    @endphp

    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Bán hàng</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Pick List - Hàng cần nhập') }}
                </h2>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="ad-btn-ghost">← Danh sách đơn</a>
        </div>
    </x-slot>

    <style>
        /* Nền sáng hơn, đồng bộ với dashboard chủ shop */
        div.ad-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .ad-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
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
        .ad-qty{display:inline-block;min-width:44px;padding:.2rem .8rem;border-radius:999px;background:rgba(251,191,36,.12);border:1px solid rgba(251,191,36,.40);color:#fbbf24;font-size:16px;font-weight:900;}
    </style>

    <div class="py-6 bg-ink min-h-screen ad-wrap">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            <p style="font-size:14px; color:#b8b8c2;">
                Tổng hợp số lượng sản phẩm từ tất cả các đơn hàng đang ở trạng thái
                <span style="color:#fff; font-weight:600;">Chờ gom hàng (Pending)</span>
                để nhân viên liên hệ nhập hàng.
            </p>

            <!-- Tóm tắt nhanh -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                <div class="ad-kpi" style="--c:96,165,250;">
                    <span class="ad-kpi-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h7v7H4zM13 6h7v7h-7zM4 15h7v5H4zM13 15h7v5h-7z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="ad-kpi-label">Loại sản phẩm cần nhập</p>
                        <p class="ad-kpi-value">{{ $totalType }}</p>
                    </div>
                </div>
                <div class="ad-kpi" style="--c:251,191,36;">
                    <span class="ad-kpi-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    <div>
                        <p class="ad-kpi-label">Tổng số lượng cần nhập</p>
                        <p class="ad-kpi-value">{{ $totalQty }}</p>
                    </div>
                </div>
            </div>

            <!-- Bảng -->
            <div class="ad-card" style="overflow:hidden;">
                <div style="overflow-x:auto;">
                    <table class="ad-tbl">
                        <thead>
                            <tr>
                                <th style="width:70px;">STT</th>
                                <th>Tên sản phẩm</th>
                                <th style="text-align:center;">Số lượng cần nhập</th>
                                <th style="text-align:center;">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itemsToPick as $index => $item)
                                <tr>
                                    <td style="color:#fbbf24; font-weight:800;">{{ $index + 1 }}</td>
                                    <td style="color:#fff; font-weight:600;">{{ $item->product_name }}</td>
                                    <td style="text-align:center;"><span class="ad-qty">{{ $item->total_quantity }}</span></td>
                                    <td style="text-align:center; white-space:nowrap;">
                                        <span style="display:inline-flex; align-items:center; gap:.5rem; padding:.25rem .75rem; border-radius:999px; font-size:12px; font-weight:700; color:{{ $amber }}; background-color:{{ $amber }}1f; border:1px solid {{ $amber }}66;">
                                            <span style="width:6px; height:6px; border-radius:999px; background-color:{{ $amber }};"></span>
                                            Chờ nhập hàng
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        Không có đơn hàng nào chờ gom sản phẩm!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
