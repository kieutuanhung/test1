<x-app-layout>
    <style>
        /* ====== Trang chi tiết sản phẩm: đồng bộ phong cách với trang chủ / admin ====== */
        .pd-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .pd-back{display:inline-flex;align-items:center;border:1px solid #3a3a45;color:#b8b8c2;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.6rem 1.1rem;border-radius:999px;transition:all .15s;}
        .pd-back:hover{border-color:#fff;color:#fff;}

        .pd-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:1.25rem;padding:1.25rem 1.4rem;}
        .pd-label{display:block;margin-bottom:.7rem;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#a8a8b3;}
        .pd-cat{font-size:12px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:#f26a2e;}

        .pd-frame{position:relative;width:100%;aspect-ratio:3/4;overflow:hidden;border-radius:1.75rem;background:#26262d;border:1px solid #2e2e37;box-shadow:0 18px 40px -16px rgba(0,0,0,.6);}

        .pd-thumb { width:4.5rem; height:4.5rem; flex-shrink:0; border-radius:1rem; overflow:hidden; padding:0;
                    border:2px solid #2e2e37; opacity:.6; cursor:pointer;
                    transition:opacity .2s, border-color .2s; }
        .pd-thumb:hover { opacity:.95; }
        .pd-thumb[aria-current="true"] { border-color:#f26a2e; opacity:1; }

        .pd-slide { transition:opacity .8s ease-in-out; }
        .pd-chip { min-width:3.25rem; height:2.75rem; padding:0 1rem; border-radius:9999px;
                   border:1px solid #3a3a45; background:#16161b;
                   color:#e5e5ee; font-size:.875rem; font-weight:600;
                   display:inline-flex; align-items:center; justify-content:center; cursor:pointer;
                   transition:background-color .2s, border-color .2s, color .2s, box-shadow .2s; }
        .pd-chip:hover { border-color:rgba(255,255,255,.55); }
        .pd-chip[aria-pressed="true"] { background:linear-gradient(135deg,#e0392c,#f26a2e); border-color:transparent; color:#fff;
                                        box-shadow:0 8px 20px -8px rgba(224,57,44,.65); }
        .pd-chip--static { cursor:default; }
        .pd-chip--static:hover { border-color:#3a3a45; }

        .pd-qty { display:inline-flex; align-items:center; height:3.25rem; padding:0 .35rem;
                  border-radius:9999px; border:1px solid #3a3a45; background:#16161b; }
        .pd-qty button { width:2.5rem; height:2.5rem; border-radius:9999px; color:#fff; font-size:1.25rem;
                         line-height:1; cursor:pointer; transition:background-color .2s; }
        .pd-qty button:hover { background:rgba(255,255,255,.12); }
        .pd-qty input { width:3rem; text-align:center; background:transparent; border:0; color:#fff;
                        font-weight:600; -moz-appearance:textfield; appearance:textfield; }
        .pd-qty input:focus { outline:none; box-shadow:none; }
        .pd-qty input::-webkit-outer-spin-button,
        .pd-qty input::-webkit-inner-spin-button { -webkit-appearance:none; margin:0; }

        .pd-btn { flex:1 1 11rem; height:3.25rem; padding:0 1.5rem; border-radius:9999px;
                  font-size:.85rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; cursor:pointer;
                  transition:background-color .2s, border-color .2s, transform .15s, box-shadow .2s, filter .2s; }
        .pd-btn:active { transform:scale(.98); }
        .pd-btn:disabled { opacity:.6; cursor:wait; }
        .pd-btn--ghost { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.22); color:#fff; }
        .pd-btn--ghost:hover { background:rgba(255,255,255,.12); border-color:#fff; }
        .pd-btn--accent { background:linear-gradient(135deg,#e0392c,#f26a2e); border:0; color:#fff;
                          box-shadow:0 12px 26px -12px rgba(224,57,44,.8); }
        .pd-btn--accent:hover { filter:brightness(1.1); }

        .pd-chip:focus-visible, .pd-btn:focus-visible, .pd-thumb:focus-visible, .pd-qty button:focus-visible
            { outline:2px solid #fff; outline-offset:2px; }

        .pd-rel-eyebrow{font-size:11px;font-weight:700;letter-spacing:.25em;text-transform:uppercase;color:#f26a2e;}
        .pd-rel-title{margin-top:4px;font-size:1.5rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;color:#fff;}

        @media (prefers-reduced-motion: reduce) {
            .pd-slide, .pd-thumb, .pd-chip, .pd-qty button, .pd-btn { transition:none; }
            .pd-btn:active { transform:none; }
        }
    </style>

    <div class="pd-wrap">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-6">
            <a href="{{ route('home', ['view' => 'all']) }}" class="pd-back">&larr; Quay lại cửa hàng</a>
        </div>

        @if(session('success'))
            <div class="text-sm px-5 py-3 mb-6" style="border-radius:1rem; color:#6ee7b7; background-color:#34d3991a; border:1px solid #34d39966;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div style="display:flex; flex-wrap:wrap; gap:3rem;">
            <!-- Ảnh sản phẩm: tự chuyển ảnh mỗi 5 giây, bấm ảnh nhỏ để chọn (và tính lại 5 giây) -->
            @php
                $gallery = collect();
                if ($product->image) { $gallery->push(asset('storage/' . $product->image)); }
                foreach ($product->images as $img) { $gallery->push(asset('storage/' . $img->image_path)); }
                $gallery = $gallery->values();
            @endphp
            <div style="flex:1 1 320px; min-width:280px; max-width:100%;"
                 x-data="{
                    images: {{ Illuminate\Support\Js::from($gallery) }},
                    i: 0,
                    timer: null,
                    start() {
                        this.stop();
                        if (this.images.length < 2) return;
                        this.timer = setInterval(() => { this.i = (this.i + 1) % this.images.length; }, 5000);
                    },
                    stop() { clearInterval(this.timer); },
                    go(n) { this.i = n; this.start(); }
                 }"
                 x-init="start()">
                @if($gallery->isNotEmpty())
                    <div class="pd-frame">
                        <template x-for="(src, n) in images" :key="n">
                            <img :src="src" alt="" class="pd-slide" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"
                                 :style="{ opacity: i === n ? 1 : 0 }">
                        </template>
                    </div>
                @else
                    <div class="pd-frame flex items-center justify-center text-neutral-500 text-sm">Chưa có hình ảnh</div>
                @endif

                @if($gallery->count() > 1)
                    <div class="flex gap-3 mt-4 overflow-x-auto pb-1">
                        @foreach($gallery as $n => $url)
                            <button type="button" class="pd-thumb" @click="go({{ $n }})" :aria-current="i === {{ $n }}" aria-label="Xem ảnh {{ $n + 1 }}">
                                <img src="{{ $url }}" class="w-full h-full object-cover" alt="">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Thông tin chi tiết -->
            <div style="flex:1 1 320px; min-width:280px; max-width:100%; display:flex; flex-direction:column; gap:1.5rem;">
                <div>
                    <span class="pd-cat">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                    <h1 class="text-3xl md:text-4xl font-black text-white mt-2 tracking-tight">{{ $product->name }}</h1>
                    <p class="text-3xl font-extrabold text-white mt-4">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                </div>

                <div class="pd-card">
                    <span class="pd-label">Mô tả sản phẩm</span>
                    <p class="text-sm text-neutral-300 whitespace-pre-line leading-7" style="max-width:34rem;">{{ $product->description ?: 'Chưa có mô tả chi tiết.' }}</p>
                </div>

                <!-- Nút Mua hàng: chỉ khách/khách hàng (customer) mới thấy, Owner/Staff/Sysadmin chỉ xem sản phẩm -->
                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="pd-card" style="display:flex; flex-direction:column; gap:1.5rem;"
                          x-data="{ selectedSize: '{{ $product->sizeList[0] ?? '' }}', qty: 1 }">
                        @csrf

                        @if(count($product->sizeList) > 0)
                            <div>
                                <span class="pd-label">Chọn size <span class="text-accent">*</span></span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->sizeList as $size)
                                        <button type="button" class="pd-chip"
                                                @click="selectedSize = '{{ $size }}'"
                                                :aria-pressed="selectedSize === '{{ $size }}'">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="size" :value="selectedSize">
                            </div>
                        @endif

                        <div>
                            <span class="pd-label">Số lượng</span>
                            <div class="pd-qty">
                                <button type="button" aria-label="Giảm số lượng" @click="qty = Math.max(1, qty - 1)">&minus;</button>
                                <input type="number" name="quantity" min="1" x-model.number="qty" aria-label="Số lượng">
                                <button type="button" aria-label="Tăng số lượng" @click="qty = qty + 1">+</button>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <button type="submit" class="pd-btn pd-btn--ghost">
                                Thêm vào giỏ hàng
                            </button>
                            <button type="submit" formaction="{{ route('cart.add', $product->id) }}" name="buy_now" value="1" class="pd-btn pd-btn--accent">
                                Mua ngay
                            </button>
                        </div>
                    </form>
                @else
                    <div class="pd-card" style="display:flex; flex-direction:column; gap:1.25rem;">
                        @if(count($product->sizeList) > 0)
                            <div>
                                <span class="pd-label">Size có sẵn</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->sizeList as $size)
                                        <span class="pd-chip pd-chip--static">{{ $size }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="text-sm text-neutral-400 px-5 py-4" style="border-radius:1rem; border:1px solid #2e2e37; background:#16161b;">
                            Tài khoản quản trị chỉ có thể xem sản phẩm, không thể mua hàng.
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
            <!-- Sản phẩm liên quan (cuộn ngang, có nút mũi tên) -->
            <div class="mt-16">
                <p class="pd-rel-eyebrow">Gợi ý cho bạn</p>
                <h2 class="pd-rel-title mb-6">Sản phẩm liên quan</h2>

                <div class="relative">
                    <div id="track-related" class="flex gap-6 overflow-x-auto pt-2 pb-5 snap-x snap-mandatory scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach($relatedProducts as $related)
                            @include('shop.partials.product-card', ['product' => $related])
                        @endforeach
                    </div>

                    <button type="button" id="prev-related" onclick="document.getElementById('track-related').scrollBy({ left: -document.getElementById('track-related').clientWidth * 0.9, behavior: 'smooth' })"
                            style="z-index:30; cursor:pointer;" aria-label="Sản phẩm trước"
                            class="hidden md:flex items-center justify-center absolute top-1/3 -left-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button type="button" id="next-related" onclick="document.getElementById('track-related').scrollBy({ left: document.getElementById('track-related').clientWidth * 0.9, behavior: 'smooth' })"
                            style="z-index:30; cursor:pointer;" aria-label="Sản phẩm sau"
                            class="hidden md:flex items-center justify-center absolute top-1/3 -right-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>

            <script>
            (function () {
                var track = document.getElementById('track-related');
                var btns = [document.getElementById('prev-related'), document.getElementById('next-related')];
                function updateArrows() {
                    if (!track) return;
                    var canScroll = track.scrollWidth > track.clientWidth + 5;
                    btns.forEach(function (b) { if (b) b.style.display = canScroll ? '' : 'none'; });
                }
                window.addEventListener('load', updateArrows);
                window.addEventListener('resize', updateArrows);
                setTimeout(updateArrows, 300);
            })();
            </script>
        @endif
    </div>
    </div>
</x-app-layout>
