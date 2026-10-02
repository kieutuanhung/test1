<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Hệ thống</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Quản trị tài khoản') }}
                </h2>
            </div>
            <a href="{{ route('sysadmin.users.create') }}" class="sa-btn-red">
                + Thêm tài khoản
            </a>
        </div>
    </x-slot>

    <style>
        /* Nền sáng hơn, đồng bộ với dashboard chủ shop */
        div.sa-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .sa-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .sa-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;margin-bottom:.4rem;}
        .sa-input{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.65rem .875rem .65rem 1.1rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .sa-input::placeholder{color:#8a8a96;}
        .sa-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .sa-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .sa-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
        .sa-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #3a3a45;color:#b8b8c2;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
        .sa-btn-ghost:hover{border-color:#fff;color:#fff;}

        /* Nút lọc */
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
        .sa-kpi-icon{width:38px;height:38px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:rgba(var(--c),.20);color:rgb(var(--c));}
        .sa-kpi-icon svg{width:18px;height:18px;}
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

        /* Nút hành động */
        .sa-act{display:inline-block;border:1px solid rgba(96,165,250,.45);color:#93c5fd;background:rgba(96,165,250,.10);font-size:12px;font-weight:600;padding:.4rem .95rem;border-radius:999px;cursor:pointer;white-space:nowrap;transition:all .15s;}
        .sa-act:hover{background:rgba(96,165,250,.22);border-color:#60a5fa;color:#fff;}
        .sa-act-red{color:#fca5a5;border-color:rgba(248,113,113,.45);background:rgba(248,113,113,.10);}
        .sa-act-red:hover{background:rgba(248,113,113,.22);border-color:#f87171;color:#fff;}
        .sa-act-green{color:#6ee7b7;border-color:rgba(52,211,153,.45);background:rgba(52,211,153,.10);}
        .sa-act-green:hover{background:rgba(52,211,153,.22);border-color:#34d399;color:#fff;}
    </style>

    @php
        $roleColors  = ['sysadmin' => '#c084fc', 'owner' => '#fbbf24', 'staff' => '#38bdf8', 'customer' => '#a3a3a3'];
        $hasFilter   = request('name') || request('email') || request('role');
        $filterCount = collect(['name', 'email', 'role'])->filter(fn ($k) => request()->filled($k))->count();
    @endphp

    <div class="py-6 bg-ink min-h-screen sa-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div style="color:#6ee7b7; background-color:#34d3991a; border:1px solid #34d39966; border-radius:12px; padding:.75rem 1rem; font-size:14px;">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="color:#fca5a5; background-color:#f871711a; border:1px solid #f8717166; border-radius:12px; padding:.75rem 1rem; font-size:14px;">
                    ! {{ session('error') }}
                </div>
            @endif

            <!-- Thẻ thống kê -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                <div class="sa-kpi" style="--c:96,165,250;">
                    <span class="sa-kpi-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 11a4 4 0 100-8 4 4 0 000 8zm0 2a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zm8-9.87a4 4 0 010 7.74"/>
                        </svg>
                    </span>
                    <div>
                        <p class="sa-kpi-label">{{ $hasFilter ? 'Kết quả tìm thấy' : 'Tổng số tài khoản' }}</p>
                        <p class="sa-kpi-value">{{ $users->total() }}</p>
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
                    <a href="{{ route('sysadmin.users.index') }}" class="sa-btn-ghost">Xóa lọc</a>
                @endif
            </div>

            <!-- Bộ lọc (ẩn, bấm nút Lọc để hiện) -->
            <form id="sa-filter-panel" method="GET" action="{{ route('sysadmin.users.index') }}" class="sa-card sa-filter-panel" style="padding:1.25rem;" @if(!$hasFilter) hidden @endif>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; align-items:end;">
                    <div>
                        <label class="sa-label">Tên</label>
                        <input type="text" name="name" value="{{ request('name') }}" placeholder="Tìm theo tên" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Email</label>
                        <input type="text" name="email" value="{{ request('email') }}" placeholder="Tìm theo email" class="sa-input">
                    </div>
                    <div>
                        <label class="sa-label">Vai trò</label>
                        <select name="role" onchange="this.form.submit()" class="sa-input">
                            <option value="">Tất cả</option>
                            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="sysadmin" {{ request('role') === 'sysadmin' ? 'selected' : '' }}>Sysadmin</option>
                        </select>
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
                                <th style="width:70px;">ID</th>
                                <th>Người dùng</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th style="text-align:right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                @php $rc = $roleColors[$user->role] ?? '#a3a3a3'; @endphp
                                <tr>
                                    <td style="color:#fbbf24; font-weight:800;">#{{ $user->id }}</td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:.75rem;">
                                            <span style="width:34px; height:34px; border-radius:9999px; background:linear-gradient(135deg,#e0392c,#f26a2e); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; flex-shrink:0;">
                                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                            </span>
                                            <span style="color:#fff; font-weight:600;">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td style="color:#b8b8c2;">{{ $user->email }}</td>
                                    <td>
                                        <span style="display:inline-block; padding:.2rem .7rem; border-radius:9999px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:{{ $rc }}; background-color:{{ $rc }}1f; border:1px solid {{ $rc }}55;">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span style="display:inline-flex; align-items:center; gap:.5rem; color:#34d399; font-size:13px; font-weight:600;">
                                                <span style="width:7px; height:7px; border-radius:9999px; background-color:#34d399;"></span> Hoạt động
                                            </span>
                                        @else
                                            <span style="display:inline-flex; align-items:center; gap:.5rem; color:#f87171; font-size:13px; font-weight:600;">
                                                <span style="width:7px; height:7px; border-radius:9999px; background-color:#f87171;"></span> Đã khóa
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex; justify-content:flex-end; align-items:center; gap:.5rem;">
                                            <a href="{{ route('sysadmin.users.edit', $user->id) }}" class="sa-act">Sửa / Reset pass</a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('sysadmin.users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="sa-act {{ $user->is_active ? 'sa-act-red' : 'sa-act-green' }}">
                                                        {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        Không tìm thấy tài khoản nào khớp với bộ lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.25rem; border-top:1px solid #2e2e37;">
                    {{ $users->links() }}
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
