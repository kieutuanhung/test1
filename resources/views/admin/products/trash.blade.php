<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="section-title">
                {{ __('Thùng rác sản phẩm') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">← Quay lại danh sách</a>
        </div>
    </x-slot>

    <style>
        .ad-card{background-color:#101010;border:1px solid #262626;border-radius:16px;}
        .ad-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#737373;margin-bottom:.4rem;}
        .ad-input{width:100%;background-color:#171717;border:1px solid #404040;border-radius:8px;padding-top:.65rem;padding-bottom:.65rem;padding-left:.875rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .ad-input::placeholder{color:#737373;}
        .ad-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .ad-file{padding-top:.5rem;padding-bottom:.5rem;color:#a3a3a3;}
        .ad-file::file-selector-button{background-color:#262626;color:#e5e5e5;border:0;border-radius:6px;padding:.4rem .8rem;margin-right:.75rem;font-size:12px;font-weight:600;cursor:pointer;}
        .ad-file::file-selector-button:hover{background-color:#333;}
        .ad-btn-red{display:inline-block;background-color:#e0392c;color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:8px;border:0;cursor:pointer;white-space:nowrap;transition:background-color .15s;}
        .ad-btn-red:hover{background-color:#c42f23;}
        .ad-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #404040;color:#a3a3a3;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:8px;white-space:nowrap;transition:all .15s;}
        .ad-btn-ghost:hover{border-color:#fff;color:#fff;}
        .ad-err{color:#f87171;font-size:12px;margin-top:.35rem;}
        .ad-hint{color:#737373;font-size:12px;margin-top:.35rem;}

        .ad-tbl{width:100%;border-collapse:collapse;}
        .ad-tbl th{padding:1rem 1.25rem;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#737373;border-bottom:1px solid #404040;}
        .ad-tbl td{padding:1rem 1.25rem;font-size:14px;color:#d4d4d4;border-bottom:1px solid #262626;vertical-align:middle;}
        .ad-tbl tbody tr:last-child td{border-bottom:0;}
        .ad-tbl tbody tr:hover{background-color:#171717;}
        .ad-act{display:inline-block;border:1px solid #404040;color:#d4d4d4;font-size:12px;font-weight:600;padding:.4rem .9rem;border-radius:8px;background:transparent;cursor:pointer;white-space:nowrap;transition:all .15s;}
        .ad-act:hover{border-color:#fff;color:#fff;}
        .ad-act-red{color:#f87171;border-color:#f8717166;}
        .ad-act-red:hover{background-color:#f871711f;border-color:#f87171;color:#f87171;}
        .ad-act-green{color:#34d399;border-color:#34d39966;}
        .ad-act-green:hover{background-color:#34d3991f;border-color:#34d399;color:#34d399;}
        .ad-chip{display:inline-block;padding:.1rem .55rem;border-radius:9999px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;}
        .ad-size{display:inline-block;min-width:28px;text-align:center;padding:.15rem .5rem;border-radius:6px;background-color:#1f1f1f;border:1px solid #333;font-size:12px;font-weight:600;color:#d4d4d4;}
    </style>

    <div class="py-8 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div style="color:#6ee7b7; background-color:#34d3991a; border:1px solid #34d39966; border-radius:8px; padding:.75rem 1rem; font-size:14px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <p style="font-size:14px; color:#a3a3a3;">
                Sản phẩm ở đây đã bị ẩn khỏi shop nhưng
                <span style="color:#fff; font-weight:600;">dữ liệu doanh thu cũ vẫn được giữ nguyên</span>.
                Bạn có thể khôi phục lại bất cứ lúc nào, hoặc xóa vĩnh viễn nếu chắc chắn không cần nữa.
            </p>

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
                                            <img src="{{ asset('storage/' . $product->image) }}" style="width:52px; height:52px; object-fit:cover; border-radius:8px; border:1px solid #333; display:block; opacity:.5;">
                                        @else
                                            <span style="font-size:12px; color:#525252;">Không ảnh</span>
                                        @endif
                                    </td>
                                    <td style="color:#737373; font-weight:600; text-decoration:line-through;">{{ $product->name }}</td>
                                    <td style="color:#737373; white-space:nowrap;">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                    <td style="color:#737373; font-weight:700; white-space:nowrap;">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                                    <td style="color:#737373; font-size:13px; white-space:nowrap;">{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
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
                                    <td colspan="6" style="padding:4rem 1rem; text-align:center; color:#737373; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">
                                        Thùng rác đang trống.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:1rem 1.25rem; border-top:1px solid #262626;">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
