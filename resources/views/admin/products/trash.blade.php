<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Quản trị</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Thùng rác sản phẩm') }}
                </h2>
            </div>
            <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">← Quay lại danh sách</a>
        </div>
    </x-slot>

    <style>
        /* Nền sáng hơn, đồng bộ với trang quản lý danh mục */
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
        .ad-err{color:#f87171;font-size:12px;margin-top:.35rem;}
        .ad-hint{color:#8a8a96;font-size:12px;margin-top:.35rem;}

        /* Ô ghi chú */
        .ad-note{display:flex;align-items:flex-start;gap:12px;padding:14px 18px;border-radius:14px;
            border:1px solid rgba(96,165,250,.30);
            background:linear-gradient(135deg,rgba(96,165,250,.16),rgba(96,165,250,.03) 60%),#1c1c22;
            font-size:14px;line-height:1.55;color:#c8c8d2;}
        .ad-note-ico{flex-shrink:0;width:30px;height:30px;border-radius:9px;display:flex;align-items:center;justify-content:center;background:rgba(96,165,250,.20);color:#93c5fd;}
        .ad-note-ico svg{width:16px;height:16px;}

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
        .ad-act-green{color:#6ee7b7;border-color:rgba(52,211,153,.45);background:rgba(52,211,153,.10);}
        .ad-act-green:hover{background:rgba(52,211,153,.22);border-color:#34d399;color:#fff;}
        .ad-chip{display:inline-block;padding:.1rem .55rem;border-radius:9999px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;}
        .ad-size{display:inline-block;min-width:28px;text-align:center;padding:.15rem .5rem;border-radius:6px;background-color:#1f1f26;border:1px solid #3a3a45;font-size:12px;font-weight:600;color:#d4d4dc;}
    </style>

    <div class="py-6 bg-ink min-h-screen ad-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div style="color:#6ee7b7; background-color:#34d3991a; border:1px solid #34d39966; border-radius:12px; padding:.75rem 1rem; font-size:14px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <div class="ad-note">
                <span class="ad-note-ico">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8h.01M11 12h1v4h1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <p style="margin:0;">
                    Sản phẩm ở đây đã bị ẩn khỏi shop nhưng
                    <span style="color:#fff; font-weight:700;">dữ liệu doanh thu cũ vẫn được giữ nguyên</span>.
                    Bạn có thể khôi phục lại bất cứ lúc nào, hoặc xóa vĩnh viễn nếu chắc chắn không cần nữa.
                </p>
            </div>

            <div class="ad-card" style="overflow:hidden;">
                <div style="overflow-x:auto;">
                    <table class="ad-tbl">
                        <thead>
                            <tr>
                                <th style="width:90px;">Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Đã xóa lúc</th>
                                <th style="text-align:right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" style="width:52px; height:52px; object-fit:cover; border-radius:10px; border:1px solid #3a3a45; display:block; opacity:.7;">
                                        @else
                                            <span style="font-size:12px; color:#8a8a96;">Không ảnh</span>
                                        @endif
                                    </td>
                                    <td style="color:#9a9aa6; font-weight:600; text-decoration:line-through;">{{ $product->name }}</td>
                                    <td style="color:#a8a8b3; white-space:nowrap;">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                    <td style="color:#fbbf24; font-weight:800; white-space:nowrap;">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                    <td style="color:#a8a8b3; font-size:13px; white-space:nowrap;">{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div style="display:flex; justify-content:flex-end; align-items:center; gap:.5rem;">
                                            <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="ad-act ad-act-green">Khôi phục</button>
                                            </form>
                                            <form action="{{ route('admin.products.forceDelete', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa VĨNH VIỄN sản phẩm này? Không thể khôi phục lại được nữa!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ad-act ad-act-red">Xóa vĩnh viễn</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding:4rem 1rem; text-align:center; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        Thùng rác đang trống.
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
