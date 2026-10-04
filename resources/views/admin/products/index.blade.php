<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Quản trị</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Quản lý sản phẩm') }}
                </h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.products.trash') }}" class="ad-btn-ghost">Thùng rác</a>
                <a href="{{ route('admin.products.create') }}" class="ad-btn-red">+ Thêm sản phẩm</a>
            </div>
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
        .ad-kpi-icon{width:38px;height:38px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:rgba(var(--c),.20);color:rgb(var(--c));}
        .ad-kpi-icon svg{width:18px;height:18px;}
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

        /* Nút hành động */
        .ad-act{display:inline-block;border:1px solid rgba(96,165,250,.45);color:#93c5fd;background:rgba(96,165,250,.10);font-size:12px;font-weight:600;padding:.4rem .95rem;border-radius:999px;cursor:pointer;white-space:nowrap;transition:all .15s;}
        .ad-act:hover{background:rgba(96,165,250,.22);border-color:#60a5fa;color:#fff;}
        .ad-act-red{color:#fca5a5;border-color:rgba(248,113,113,.45);background:rgba(248,113,113,.10);}
        .ad-act-red:hover{background:rgba(248,113,113,.22);border-color:#f87171;color:#fff;}

        .ad-chip{display:inline-block;padding:.1rem .55rem;border-radius:9999px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;}
        .ad-size{display:inline-block;min-width:28px;text-align:center;padding:.15rem .5rem;border-radius:6px;background-color:#16161b;border:1px solid #3a3a45;font-size:12px;font-weight:600;color:#d4d4dc;}
        .ad-price{color:#fbbf24;font-weight:800;white-space:nowrap;}
        .ad-catpill{display:inline-block;padding:.2rem .7rem;border-radius:999px;background:rgba(52,211,153,.10);border:1px solid rgba(52,211,153,.35);color:#6ee7b7;font-size:12px;font-weight:600;white-space:nowrap;}
    </style>

    @php
        $hasFilter = request('search') || request('category') || request('sort_price');
    @endphp

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
                        <p class="ad-kpi-label">{{ $hasFilter ? 'Kết quả tìm thấy' : 'Tổng số sản phẩm' }}</p>
                        <p class="ad-kpi-value">{{ $products->total() }}</p>
                    </div>
                </div>
                <div class="ad-kpi" style="--c:52,211,153;">
                    <div>
                        <p class="ad-kpi-label">Số danh mục</p>
                        <p class="ad-kpi-value">{{ $categories->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tìm kiếm / Lọc danh mục / Sắp xếp giá -->
            <form method="GET" action="{{ route('admin.products.index') }}" class="ad-card" style="padding:1.25rem;">
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem; align-items:end;">
                    <div>
                        <label class="ad-label">Tìm kiếm</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên sản phẩm" class="ad-input">
                    </div>
                    <div>
                        <label class="ad-label">Danh mục</label>
                        <select name="category" onchange="this.form.submit()" class="ad-input">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (string) request('category') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="ad-label">Sắp xếp</label>
                        <select name="sort_price" onchange="this.form.submit()" class="ad-input">
                            <option value="">Mặc định (mới nhất)</option>
                            <option value="asc" {{ request('sort_price') === 'asc' ? 'selected' : '' }}>Giá: Thấp &rarr; Cao</option>
                            <option value="desc" {{ request('sort_price') === 'desc' ? 'selected' : '' }}>Giá: Cao &rarr; Thấp</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:.5rem;">
                        <button type="submit" class="ad-btn-red" style="flex:1;">Lọc</button>
                        @if($hasFilter)
                            <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">Xóa lọc</a>
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
                                <th style="width:90px;">Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Size</th>
                                <th style="text-align:right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" style="width:52px; height:52px; object-fit:cover; border-radius:10px; border:1px solid #3a3a45; display:block;">
                                        @else
                                            <span style="font-size:12px; color:#6b6b78;">Không ảnh</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="color:#fff; font-weight:600;">{{ $product->name }}</div>
                                        @if($product->is_new_arrival || $product->is_best_seller)
                                            <div style="display:flex; gap:.35rem; margin-top:.35rem;">
                                                @if($product->is_new_arrival)
                                                    <span class="ad-chip" style="color:#38bdf8; background-color:#38bdf81f; border:1px solid #38bdf866;">New</span>
                                                @endif
                                                @if($product->is_best_seller)
                                                    <span class="ad-chip" style="color:#fbbf24; background-color:#fbbf241f; border:1px solid #fbbf2466;">Best</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td><span class="ad-catpill">{{ $product->category->name ?? 'Uncategorized' }}</span></td>
                                    <td class="ad-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        @if(count($product->size_list))
                                            <div style="display:flex; flex-wrap:wrap; gap:.3rem;">
                                                @foreach($product->size_list as $size)
                                                    <span class="ad-size">{{ $size }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span style="color:#6b6b78;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex; justify-content:flex-end; align-items:center; gap:.5rem;">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="ad-act">Sửa</a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ẩn sản phẩm này khỏi shop? (Có thể khôi phục lại trong Thùng rác)')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ad-act ad-act-red">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        @if($hasFilter)
                                            Không tìm thấy sản phẩm nào khớp với bộ lọc.
                                        @else
                                            Chưa có sản phẩm nào được tạo.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.25rem; border-top:1px solid #2e2e37;">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
