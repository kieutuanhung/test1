<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Mua sắm</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Giỏ hàng của bạn') }}
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
        .sh-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .sh-btn-red{display:inline-block;text-align:center;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.85rem 1.6rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .sh-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
        .sh-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #3a3a45;color:#b8b8c2;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
        .sh-btn-ghost:hover{border-color:#fff;color:#fff;}

        /* Thẻ thống kê */
        .sh-kpi{--c:96,165,250;display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:14px;
            border:1px solid rgba(var(--c),.30);
            background:linear-gradient(135deg,rgba(var(--c),.18),rgba(var(--c),.03) 60%),#1c1c22;
            transition:transform .2s, border-color .2s;}
        .sh-kpi:hover{transform:translateY(-2px);border-color:rgba(var(--c),.65);}
        .sh-kpi-label{margin:0;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#b8b8c2;}
        .sh-kpi-value{margin:4px 0 0;font-size:26px;font-weight:900;line-height:1;color:rgb(var(--c));}

        /* Bảng */
        .sh-tbl{width:100%;border-collapse:collapse;}
        .sh-tbl thead{background-color:#16161b;}
        .sh-tbl th{padding:1rem 1.25rem;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;border-bottom:1px solid #2e2e37;white-space:nowrap;}
        .sh-tbl td{padding:1rem 1.25rem;font-size:14px;color:#d4d4dc;border-bottom:1px solid #2a2a33;vertical-align:middle;}
        .sh-tbl tbody tr:last-child td{border-bottom:0;}
        .sh-tbl tbody tr{transition:background-color .15s;}
        .sh-tbl tbody tr:hover{background-color:rgba(224,57,44,.07);}

        /* Số lượng, nút Lưu, nút Xóa */
        .sh-qty{width:72px;text-align:center;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.5rem .5rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .sh-qty:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .sh-act{display:inline-block;border:1px solid rgba(96,165,250,.45);color:#93c5fd;background:rgba(96,165,250,.10);font-size:12px;font-weight:600;padding:.45rem 1rem;border-radius:999px;cursor:pointer;white-space:nowrap;transition:all .15s;}
        .sh-act:hover{background:rgba(96,165,250,.22);border-color:#60a5fa;color:#fff;}
        .sh-size{background-color:#16161b;color:#fff;border:1px solid #3a3a45;border-radius:999px;padding:.3rem 1.8rem .3rem .85rem;font-size:12px;font-weight:600;cursor:pointer;transition:border-color .15s, box-shadow .15s;}
        .sh-size:hover{border-color:#6b6b78;}
        .sh-size:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .sh-size--empty{border-color:#e0392c;color:#fca5a5;}
        .sh-size option{background-color:#19191f;color:#fff;}
        .sh-pick-box{width:18px;height:18px;accent-color:#e0392c;cursor:pointer;}
        .sh-pick-box:disabled{cursor:not-allowed;opacity:.35;}
        .sh-btn-red:disabled{opacity:.4;cursor:not-allowed;filter:none;transform:none;}
        .sh-del{width:32px;height:32px;border-radius:9999px;display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent;background:transparent;color:#8a8a96;font-size:20px;line-height:1;font-weight:700;cursor:pointer;transition:all .15s;}
        .sh-del:hover{color:#fca5a5;background:rgba(248,113,113,.14);border-color:rgba(248,113,113,.45);}
    </style>

    <div class="py-6 bg-ink min-h-screen sh-wrap">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

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

            @if(count($cart) > 0)
                <!-- Thẻ thống kê -->
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px;">
                    <div class="sh-kpi">
                        <div>
                            <p class="sh-kpi-label">Sản phẩm trong giỏ</p>
                            <p class="sh-kpi-value">{{ count($cart) }}</p>
                        </div>
                    </div>
                </div>

                <div class="sh-card" style="overflow:hidden;">
                    <div style="overflow-x:auto;">
                        <table class="sh-tbl">
                            <thead>
                                <tr>
                                    <th style="width:48px; text-align:center;">
                                        <input type="checkbox" id="sh-pick-all" class="sh-pick-box" aria-label="Chọn tất cả">
                                    </th>
                                    <th style="text-align:left;">Sản phẩm</th>
                                    <th style="text-align:left;">Đơn giá</th>
                                    <th style="text-align:center;">Số lượng</th>
                                    <th style="text-align:right;">Thành tiền</th>
                                    <th style="text-align:center;">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    @php
                                        $opts = $sizeOptions[$item['product_id'] ?? 0] ?? [];
                                        $needsSize = count($opts) > 0 && empty($item['size']);
                                    @endphp
                                    <tr>
                                        <td style="text-align:center; width:48px;">
                                            <input type="checkbox" form="checkout-form" name="items[]" value="{{ $id }}"
                                                   class="sh-pick sh-pick-box"
                                                   data-subtotal="{{ (int) round($item['price'] * $item['quantity']) }}"
                                                   aria-label="Chọn {{ $item['name'] }} để thanh toán"
                                                   @checked(!$needsSize) @disabled($needsSize)>
                                        </td>
                                        <td>
                                            <div style="display:flex; align-items:center; gap:.85rem;">
                                                @if(!empty($item['image']))
                                                    <img src="{{ asset('storage/' . $item['image']) }}" style="width:56px; height:56px; object-fit:cover; background-color:#16161b; border:1px solid #2e2e37; border-radius:12px; flex-shrink:0;">
                                                @endif
                                                <div>
                                                    <a href="{{ route('shop.show', $item['slug']) }}" style="color:#fff; font-weight:600; font-size:14px;" class="hover:opacity-70">
                                                        {{ $item['name'] }}
                                                    </a>
                                                    @if(count($opts) > 0)
                                                        <form action="{{ route('cart.size', $id) }}" method="POST" style="margin-top:6px;">
                                                            @csrf
                                                            <select name="size" onchange="this.form.submit()" aria-label="Chọn size"
                                                                    class="sh-size {{ empty($item['size']) ? 'sh-size--empty' : '' }}">
                                                                @if(empty($item['size']))
                                                                    <option value="" selected disabled>Chọn size</option>
                                                                @endif
                                                                @foreach($opts as $s)
                                                                    <option value="{{ $s }}" @selected(($item['size'] ?? null) === $s)>Size {{ $s }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if($needsSize)
                                                                <div style="font-size:11px; color:#fca5a5; margin-top:4px;">Chọn size để thanh toán</div>
                                                            @endif
                                                        </form>
                                                    @elseif(!empty($item['size']))
                                                        <div style="font-size:12px; color:#8a8a96; margin-top:2px;">Size: <span style="color:#fff; font-weight:700;">{{ $item['size'] }}</span></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="color:#b8b8c2; white-space:nowrap;">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                        <td style="text-align:center;">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline-flex; align-items:center; gap:.5rem;">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="sh-qty">
                                                <button type="submit" class="sh-act">Lưu</button>
                                            </form>
                                        </td>
                                        <td style="text-align:right; color:#fbbf24; font-weight:800; white-space:nowrap;">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                                        </td>
                                        <td style="text-align:center;">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="sh-del" title="Xóa">&times;</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="padding:1.5rem; border-top:1px solid #2e2e37;" class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <a href="{{ route('home') }}" class="sh-btn-ghost">&larr; Tiếp tục mua hàng</a>

                        <div class="text-right w-full md:w-auto">
                            <p style="margin:0; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#a8a8b3;">Tổng cộng thanh toán (<span id="sel-count">0</span> sản phẩm đã chọn)</p>
                            <p style="margin:.25rem 0 0; font-size:28px; font-weight:900; color:#fbbf24;"><span id="sel-total">{{ number_format($total, 0, ',', '.') }}</span> VNĐ</p>
                            <button type="submit" form="checkout-form" id="btn-checkout" class="sh-btn-red mt-4 w-full md:w-auto">
                                Tiến hành thanh toán &rarr;
                            </button>
                            <p id="sel-hint" style="display:none; margin:.6rem 0 0; font-size:12px; color:#fca5a5;">Chọn ít nhất 1 sản phẩm (đã có size) để thanh toán.</p>
                            <form id="checkout-form" method="GET" action="{{ route('order.checkout') }}">
                                <input type="hidden" name="from_cart" value="1">
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="sh-card" style="padding:5rem 1.5rem; text-align:center;">
                    <p style="margin:0 0 1.5rem; color:#8a8a96; font-size:12px; text-transform:uppercase; letter-spacing:.1em;">Giỏ hàng của bạn đang trống</p>
                    <a href="{{ route('home') }}" class="sh-btn-red">Mua sắm ngay</a>
                </div>
            @endif
        </div>
    </div>
    <script>
    (function () {
        var boxes   = Array.prototype.slice.call(document.querySelectorAll('.sh-pick'));
        var all     = document.getElementById('sh-pick-all');
        var totalEl = document.getElementById('sel-total');
        var countEl = document.getElementById('sel-count');
        var btn     = document.getElementById('btn-checkout');
        var hint    = document.getElementById('sel-hint');
        if (!all || !totalEl || !btn) return;

        function refresh() {
            var sum = 0, cnt = 0, eligible = 0;
            boxes.forEach(function (b) {
                if (b.disabled) return;          // dòng chưa chọn size: không tính
                eligible++;
                if (b.checked) { cnt++; sum += Number(b.dataset.subtotal) || 0; }
            });
            totalEl.textContent = sum.toLocaleString('vi-VN');
            countEl.textContent = cnt;
            btn.disabled = cnt === 0;
            hint.style.display = cnt === 0 ? '' : 'none';
            all.disabled = eligible === 0;
            all.checked = eligible > 0 && cnt === eligible;
            all.indeterminate = cnt > 0 && cnt < eligible;
        }

        boxes.forEach(function (b) { b.addEventListener('change', refresh); });
        all.addEventListener('change', function () {
            boxes.forEach(function (b) { if (!b.disabled) b.checked = all.checked; });
            refresh();
        });
        refresh();
    })();
    </script>
</x-app-layout>
