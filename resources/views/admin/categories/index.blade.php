<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Quản trị</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Quản lý danh mục') }}
                </h2>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="ad-btn-red">
                + Thêm danh mục
            </a>
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
        .ad-kpi-label{margin:0;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#b8b8c2;}
        .ad-kpi-value{margin:4px 0 0;font-size:26px;font-weight:900;line-height:1;color:rgb(var(--c));}

        /* Bảng */
        .ad-tbl{width:100%;border-collapse:collapse;}
        .ad-tbl thead{background-color:#16161b;}
        .ad-tbl th{padding:1rem 1.25rem;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;border-bottom:1px solid #2e2e37;}
        .ad-tbl td{padding:1rem 1.25rem;font-size:14px;color:#d4d4dc;border-bottom:1px solid #2a2a33;vertical-align:middle;}
        .ad-tbl tbody tr:last-child td{border-bottom:0;}
        .ad-tbl tbody tr{transition:background-color .15s;}
        .ad-tbl tbody tr:hover{background-color:rgba(224,57,44,.07);}
        .ad-id{color:#fbbf24;font-weight:800;}
        .ad-slug{display:inline-block;padding:.2rem .65rem;border-radius:999px;background:rgba(96,165,250,.12);border:1px solid rgba(96,165,250,.35);font-family:ui-monospace,monospace;font-size:12px;color:#93c5fd;}

        /* Nút hành động */
        .ad-act{display:inline-block;border:1px solid rgba(96,165,250,.45);color:#93c5fd;background:rgba(96,165,250,.10);font-size:12px;font-weight:600;padding:.4rem .95rem;border-radius:999px;cursor:pointer;white-space:nowrap;transition:all .15s;}
        .ad-act:hover{background:rgba(96,165,250,.22);border-color:#60a5fa;color:#fff;}
        .ad-act-red{color:#fca5a5;border-color:rgba(248,113,113,.45);background:rgba(248,113,113,.10);}
        .ad-act-red:hover{background:rgba(248,113,113,.22);border-color:#f87171;color:#fff;}
    </style>

    <div class="py-6 bg-ink min-h-screen ad-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div style="color:#6ee7b7; background-color:#34d3991a; border:1px solid #34d39966; border-radius:12px; padding:.75rem 1rem; font-size:14px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Thẻ thống kê -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                <div class="ad-kpi" style="--c:96,165,250;">
                    <div>
                        <p class="ad-kpi-label">{{ request('search') ? 'Kết quả tìm thấy' : 'Tổng số danh mục' }}</p>
                        <p class="ad-kpi-value">{{ $categories->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tìm kiếm -->
            <form method="GET" action="{{ route('admin.categories.index') }}" class="ad-card" style="padding:1.25rem;">
                <div style="display:grid; grid-template-columns:minmax(220px,1fr) auto; gap:1rem; align-items:end; max-width:640px;">
                    <div>
                        <label class="ad-label">Tên danh mục</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên danh mục" class="ad-input">
                    </div>
                    <div style="display:flex; gap:.5rem;">
                        <button type="submit" class="ad-btn-red">Tìm</button>
                        @if(request('search'))
                            <a href="{{ route('admin.categories.index') }}" class="ad-btn-ghost">Xóa lọc</a>
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
                                <th style="width:70px;">ID</th>
                                <th>Tên danh mục</th>
                                <th>Slug</th>
                                <th>Mô tả</th>
                                <th style="text-align:right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="ad-id">{{ $category->id }}</td>
                                    <td style="color:#fff; font-weight:600; white-space:nowrap;">{{ $category->name }}</td>
                                    <td><span class="ad-slug">{{ $category->slug }}</span></td>
                                    <td style="max-width:360px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:{{ $category->description ? '#b8b8c2' : '#6b6b78' }};" title="{{ $category->description }}">
                                        {{ $category->description ?: 'Không có' }}
                                    </td>
                                    <td>
                                        <div style="display:flex; justify-content:flex-end; align-items:center; gap:.5rem;">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="ad-act">Sửa</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa danh mục này sẽ chuyển TẤT CẢ sản phẩm bên trong vào Thùng rác. Tiếp tục?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ad-act ad-act-red">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        @if(request('search'))
                                            Không tìm thấy danh mục nào khớp với "{{ request('search') }}".
                                        @else
                                            Chưa có danh mục nào được tạo.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.25rem; border-top:1px solid #2e2e37;">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
