<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Hệ thống</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Nhật ký đăng nhập') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        /* Nền sáng hơn, đồng bộ với trang quản trị tài khoản */
        div.sa-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .sa-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .sa-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;margin-bottom:.4rem;}
        .sa-input{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.65rem .875rem .65rem 1.1rem;font-size:.875rem;color:#fff;color-scheme:dark;transition:border-color .15s, box-shadow .15s;}
        .sa-input::placeholder{color:#8a8a96;}
        .sa-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .sa-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .sa-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
        .sa-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #3a3a45;color:#b8b8c2;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
        .sa-btn-ghost:hover{border-color:#fff;color:#fff;}
        .sa-btn-filter{display:inline-flex;align-items:center;gap:.55rem;border:1px solid #3a3a45;background-color:#16161b;color:#d4d4dc;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.7rem 1.2rem;border-radius:999px;cursor:pointer;white-space:nowrap;transition:all .15s;}
        .sa-btn-filter:hover{border-color:#fff;color:#fff;}
        .sa-btn-filter svg{width:16px;height:16px;}
        .sa-btn-filter.is-open{border-color:#e0392c;color:#fff;background-color:rgba(224,57,44,.14);}
        .sa-badge{min-width:18px;height:18px;padding:0 5px;border-radius:999px;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:11px;font-weight:800;letter-spacing:0;display:inline-flex;align-items:center;justify-content:center;}
        .sa-filter-panel[hidden]{display:none;}

        /* Thẻ thống kê */
        .sa-kpi{--c:96,165,250;display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:14px;
            border:1px solid rgba(var(--c),.30);
            background:linear-gradient(135deg,rgba(var(--c),.18),rgba(var(--c),.03) 60%),#1c1c22;
            transition:transform .2s, border-color .2s;}
        .sa-kpi:hover{transform:translateY(-2px);border-color:rgba(var(--c),.65);}
        .sa-kpi-label{margin:0;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#b8b8c2;}
        .sa-kpi-value{margin:4px 0 0;font-size:26px;font-weight:900;line-height:1;color:rgb(var(--c));}

        /* Bảng */
        .sa-tbl{width:100%;border-collapse:collapse;}
        .sa-tbl thead{background-color:#16161b;}
        .sa-tbl th{padding:1rem 1.25rem;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;border-bottom:1px solid #2e2e37;white-space:nowrap;}
        .sa-tbl td{padding:1rem 1.25rem;font-size:14px;color:#d4d4dc;border-bottom:1px solid #2a2a33;vertical-align:middle;}
        .sa-tbl tbody tr:last-child td{border-bottom:0;}
        .sa-tbl tbody tr{transition:background-color .15s;}
        .sa-tbl tbody tr:hover{background-color:rgba(224,57,44,.07);}
    </style>

    @php
        $hasFilter = request('email') || request('ip') || request('device') || request('from_date') || request('to_date');
        $filterCount = collect(['email', 'ip', 'device', 'from_date', 'to_date'])->filter(fn ($k) => request()->filled($k))->count();
    @endphp

    <div class="py-6 bg-ink min-h-screen sa-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            <!-- Thẻ thống kê -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                <div class="sa-kpi" style="--c:96,165,250;">
                    <div>
                        <p class="sa-kpi-label">{{ $hasFilter ? 'Kết quả tìm thấy' : 'Tổng số lượt đăng nhập' }}</p>
                        <p class="sa-kpi-value">{{ $logs->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Nút lọc -->
            <div style="display:flex; align-items:center; gap:.75rem; flex-wrap:wrap;">
                <button type="button" id="sa-filter-toggle" class="sa-btn-filter {{ $hasFilter ? 'is-open' : '' }}" aria-expanded="{{ $hasFilter ? 'true' : 'false' }}" aria-controls="sa-filter-panel">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18l-7 8v6l-4 2v-8L3 4z"/></svg>
                    Lọc
                    @if($filterCount)
                        <span class="sa-badge">{{ $filterCount }}</span>
                    @endif
                </button>
                @if($hasFilter)
                    <a href="{{ route('sysadmin.logs.index') }}" class="sa-btn-ghost">Xóa lọc</a>
                @endif
            </div>

            <!-- Bộ lọc (ẩn, bấm nút Lọc để hiện) -->
            <form id="sa-filter-panel" method="GET" action="{{ route('sysadmin.logs.index') }}" class="sa-card sa-filter-panel" style="padding:1.25rem;" @if(!$hasFilter) hidden @endif>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:1rem; align-items:end;">
                    <div>
                        <label class="sa-label">Email</label>
                        <input type="text" name="email" value="{{ request('email') }}" placeholder="Tìm theo email" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Địa chỉ IP</label>
                        <input type="text" name="ip" value="{{ request('ip') }}" placeholder="Tìm theo IP" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Thiết bị</label>
                        <input type="text" name="device" value="{{ request('device') }}" placeholder="Tìm theo thiết bị" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Từ ngày</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="sa-input" style="padding-right:.9rem;">
                    </div>
                    <div>
                        <label class="sa-label">Đến ngày</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="sa-input" style="padding-right:.9rem;">
                    </div>
                    <div style="display:flex; gap:.5rem;">
                        <button type="submit" class="sa-btn-red" style="flex:1;">Tìm</button>
                    </div>
                </div>
            </form>

            <!-- Bảng -->
            <div class="sa-card" style="overflow:hidden;">
                <div style="overflow-x:auto;">
                    <table class="sa-tbl">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Tài khoản (Email)</th>
                                <th>Địa chỉ IP</th>
                                <th>Thiết bị / Trình duyệt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td style="white-space:nowrap; color:#fbbf24; font-weight:700;">
                                        {{ \Carbon\Carbon::parse($log->logged_in_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:.75rem;">
                                            <span style="width:34px; height:34px; border-radius:9999px; background:linear-gradient(135deg,#e0392c,#f26a2e); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; flex-shrink:0;">
                                                {{ mb_strtoupper(mb_substr($log->email, 0, 1)) }}
                                            </span>
                                            <span style="color:#fff; font-weight:600;">{{ $log->email }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="display:inline-block; padding:.2rem .7rem; border-radius:9999px; background-color:#60a5fa1f; border:1px solid #60a5fa55; font-family:ui-monospace,monospace; font-size:12px; color:#93c5fd;">
                                            {{ $log->ip_address }}
                                        </span>
                                    </td>
                                    <td style="max-width:420px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-size:12px; color:#8a8a96;" title="{{ $log->user_agent }}">
                                        {{ $log->user_agent }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        @if($hasFilter)
                                            Không tìm thấy bản ghi nào khớp với bộ lọc.
                                        @else
                                            Chưa có bản ghi đăng nhập nào.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.25rem; border-top:1px solid #2e2e37;">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('sa-filter-toggle');
        var panel = document.getElementById('sa-filter-panel');
        if (!btn || !panel) return;
        btn.addEventListener('click', function () {
            var willOpen = panel.hasAttribute('hidden');
            if (willOpen) { panel.removeAttribute('hidden'); } else { panel.setAttribute('hidden', ''); }
            btn.classList.toggle('is-open', willOpen);
            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            if (willOpen) { var f = panel.querySelector('input, select'); if (f) f.focus(); }
        });
    });
    </script>
</x-app-layout>
