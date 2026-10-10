<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Hệ thống</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Nhật ký hoạt động hệ thống') }}
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
        $hasFilter = request('actor') || request('action') || request('target_type') || request('target_id') || request('from_date') || request('to_date');
        $filterCount = collect(['actor', 'action', 'target_type', 'target_id', 'from_date', 'to_date'])->filter(fn ($k) => request()->filled($k))->count();

        // Nhãn + màu hiển thị cho từng hành động
        $actionMap = [
            'order.status_changed'          => ['Đổi trạng thái đơn', 'fbbf24'],
            'order.refunded'                => ['Hoàn tiền đơn hàng', 'f87171'],
            'payment.confirmed'             => ['Xác nhận thanh toán', '34d399'],
            'user.created'                  => ['Tạo tài khoản', '34d399'],
            'user.updated'                  => ['Sửa thông tin tài khoản', '60a5fa'],
            'user.role_changed'             => ['Đổi quyền (role)', 'f87171'],
            'user.password_changed_by_admin'=> ['Admin đổi mật khẩu user', 'fbbf24'],
            'user.activated'                => ['Mở khóa tài khoản', '34d399'],
            'user.deactivated'              => ['Khóa tài khoản', 'f87171'],
            'product.created'               => ['Thêm sản phẩm', '34d399'],
            'product.updated'               => ['Sửa sản phẩm', '60a5fa'],
            'product.deleted'               => ['Ẩn sản phẩm', 'fbbf24'],
            'product.restored'              => ['Khôi phục sản phẩm', '34d399'],
            'product.force_deleted'         => ['Xóa vĩnh viễn sản phẩm', 'f87171'],
            'product.image_deleted'         => ['Xóa ảnh sản phẩm', 'fbbf24'],
            'category.created'              => ['Thêm danh mục', '34d399'],
            'category.updated'              => ['Sửa danh mục', '60a5fa'],
            'category.deleted'              => ['Xóa danh mục', 'f87171'],
        ];

        $roleMap = [
            'sysadmin' => 'Sysadmin',
            'owner'    => 'Owner',
            'staff'    => 'Staff',
            'customer' => 'Khách hàng',
        ];

        // Các trường là tiền, sẽ hiển thị theo định dạng VND
        $moneyKeys = ['price', 'total_price'];

        // Hiển thị 1 giá trị (mảng/bool/null/tiền) thành chuỗi ngắn gọn
        $fmt = function ($v, $key = null) use ($moneyKeys) {
            if (is_null($v)) return '—';
            if (in_array($key, $moneyKeys, true) && is_numeric($v)) {
                return number_format((float) $v, 0, ',', '.') . ' ₫';
            }
            if (is_bool($v)) return $v ? 'true' : 'false';
            if (is_array($v)) return json_encode($v, JSON_UNESCAPED_UNICODE);
            $s = (string) $v;
            return mb_strlen($s) > 80 ? mb_substr($s, 0, 80) . '…' : $s;
        };
    @endphp

    <div class="py-6 bg-ink min-h-screen sa-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @include('sysadmin.logs._tabs')

            <!-- Thẻ thống kê -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                <div class="sa-kpi" style="--c:96,165,250;">
                    <div>
                        <p class="sa-kpi-label">{{ $hasFilter ? 'Kết quả tìm thấy' : 'Tổng số bản ghi' }}</p>
                        <p class="sa-kpi-value">{{ $logs->total() }}</p>
                    </div>
                </div>
                <div class="sa-kpi" style="--c:52,211,153;">
                    <div>
                        <p class="sa-kpi-label">Hôm nay</p>
                        <p class="sa-kpi-value">{{ $stats['today'] }}</p>
                    </div>
                </div>
                <div class="sa-kpi" style="--c:251,191,36;">
                    <div>
                        <p class="sa-kpi-label">Đơn hàng &amp; thanh toán</p>
                        <p class="sa-kpi-value">{{ $stats['order'] }}</p>
                    </div>
                </div>
                <div class="sa-kpi" style="--c:248,113,113;">
                    <div>
                        <p class="sa-kpi-label">Quản lý tài khoản</p>
                        <p class="sa-kpi-value">{{ $stats['account'] }}</p>
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
                    <a href="{{ route('sysadmin.audit.index') }}" class="sa-btn-ghost">Xóa lọc</a>
                @endif
            </div>

            <!-- Bộ lọc -->
            <form id="sa-filter-panel" method="GET" action="{{ route('sysadmin.audit.index') }}" class="sa-card sa-filter-panel" style="padding:1.25rem;" @if(!$hasFilter) hidden @endif>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:1rem; align-items:end;">
                    <div>
                        <label class="sa-label">Người thực hiện</label>
                        <input type="text" name="actor" value="{{ request('actor') }}" placeholder="Tìm theo email" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Hành động</label>
                        <select name="action" class="sa-input">
                            <option value="">Tất cả</option>
                            @foreach($actions as $act)
                                <option value="{{ $act }}" @selected(request('action') === $act)>{{ $actionMap[$act][0] ?? $act }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="sa-label">Loại đối tượng</label>
                        <select name="target_type" class="sa-input">
                            <option value="">Tất cả</option>
                            @foreach($targetTypes as $tt)
                                <option value="{{ $tt }}" @selected(request('target_type') === $tt)>{{ $tt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="sa-label">ID đối tượng</label>
                        <input type="number" min="1" name="target_id" value="{{ request('target_id') }}" placeholder="VD: 12" class="sa-input">
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
                                <th>Người thực hiện</th>
                                <th>Hành động</th>
                                <th>Đối tượng</th>
                                <th>Thay đổi (cũ → mới)</th>
                                <th>Địa chỉ IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                @php
                                    $st = $actionMap[$log->action] ?? [$log->action, '9ca3af'];
                                    $oldV = $log->old_values ?? [];
                                    $newV = $log->new_values ?? [];
                                    $keys = array_unique(array_merge(array_keys($oldV), array_keys($newV)));
                                @endphp
                                <tr>
                                    <td style="white-space:nowrap; color:#fbbf24; font-weight:700;">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td>
                                        @if($log->user_email)
                                            <div style="color:#fff; font-weight:600;">{{ $log->user_email }}</div>
                                            <div style="font-size:11px; color:#8a8a96; text-transform:uppercase; letter-spacing:.08em;">
                                                {{ $roleMap[$log->user_role] ?? $log->user_role }}
                                            </div>
                                        @else
                                            <span style="color:#8a8a96; font-style:italic;">Hệ thống / chưa đăng nhập</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="display:inline-block; padding:.2rem .7rem; border-radius:9999px; background-color:#{{ $st[1] }}1f; border:1px solid #{{ $st[1] }}66; font-size:12px; font-weight:700; color:#{{ $st[1] }}; white-space:nowrap;">
                                            {{ $st[0] }}
                                        </span>
                                    </td>
                                    <td style="white-space:nowrap;">
                                        @if($log->target_type)
                                            <span style="color:#fff; font-weight:600;">{{ $log->target_type }}</span>
                                            <span style="font-family:ui-monospace,monospace; color:#93c5fd;">#{{ $log->target_id }}</span>
                                        @else
                                            <span style="color:#8a8a96;">—</span>
                                        @endif
                                    </td>
                                    <td style="font-size:12px; min-width:260px;">
                                        @forelse($keys as $k)
                                            <div style="margin-bottom:2px;">
                                                <span style="color:#a8a8b3;">{{ $k }}:</span>
                                                @if(array_key_exists($k, $oldV))
                                                    <span style="color:#f87171;">{{ $fmt($oldV[$k], $k) }}</span>
                                                @endif
                                                @if(array_key_exists($k, $oldV) && array_key_exists($k, $newV))
                                                    <span style="color:#8a8a96;">→</span>
                                                @endif
                                                @if(array_key_exists($k, $newV))
                                                    <span style="color:#34d399;">{{ $fmt($newV[$k], $k) }}</span>
                                                @endif
                                            </div>
                                        @empty
                                            <span style="color:#8a8a96;">—</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <span style="display:inline-block; padding:.2rem .7rem; border-radius:9999px; background-color:#60a5fa1f; border:1px solid #60a5fa55; font-family:ui-monospace,monospace; font-size:12px; color:#93c5fd;" title="{{ $log->user_agent }}">
                                            {{ $log->ip_address }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        @if($hasFilter)
                                            Không tìm thấy bản ghi nào khớp với bộ lọc.
                                        @else
                                            Chưa có hoạt động nào được ghi nhận.
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
