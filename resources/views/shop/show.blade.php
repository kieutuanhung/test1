<x-app-layout>
    <style>
        /* ====== Trang chi tiết sản phẩm: giao diện mềm ====== */
        .pd-thumb { width:4.5rem; height:4.5rem; flex-shrink:0; border-radius:1rem; overflow:hidden; padding:0;
                    border:2px solid transparent; opacity:.55; cursor:pointer;
                    transition:opacity .2s, border-color .2s; }
        .pd-thumb:hover { opacity:.9; }
        .pd-thumb[aria-current="true"] { border-color:#e0392c; opacity:1; }

        .pd-slide { transition:opacity .8s ease-in-out; }
        .pd-chip { min-width:3.25rem; height:2.75rem; padding:0 1rem; border-radius:9999px;
                   border:1px solid rgba(255,255,255,.14); background:rgba(255,255,255,.04);
                   color:#e5e5e5; font-size:.875rem; font-weight:600;
                   display:inline-flex; align-items:center; justify-content:center; cursor:pointer;
                   transition:background-color .2s, border-color .2s, color .2s, box-shadow .2s; }
        .pd-chip:hover { border-color:rgba(255,255,255,.35); }
        .pd-chip[aria-pressed="true"] { background:#e0392c; border-color:#e0392c; color:#fff;
                                        box-shadow:0 8px 20px -8px rgba(224,57,44,.65); }
        .pd-chip--static { cursor:default; }
        .pd-chip--static:hover { border-color:rgba(255,255,255,.14); }

        .pd-qty { display:inline-flex; align-items:center; height:3.25rem; padding:0 .35rem;
                  border-radius:9999px; border:1px solid rgba(255,255,255,.14); background:rgba(255,255,255,.04); }
        .pd-qty button { width:2.5rem; height:2.5rem; border-radius:9999px; color:#fff; font-size:1.25rem;
                         line-height:1; cursor:pointer; transition:background-color .2s; }
        .pd-qty button:hover { background:rgba(255,255,255,.12); }
        .pd-qty input { width:3rem; text-align:center; background:transparent; border:0; color:#fff;
                        font-weight:600; -moz-appearance:textfield; appearance:textfield; }
        .pd-qty input:focus { outline:none; box-shadow:none; }
        .pd-qty input::-webkit-outer-spin-button,
        .pd-qty input::-webkit-inner-spin-button { -webkit-appearance:none; margin:0; }

        .pd-btn { flex:1 1 11rem; height:3.25rem; padding:0 1.5rem; border-radius:9999px;
                  font-size:.95rem; font-weight:600; cursor:pointer;
                  transition:background-color .2s, border-color .2s, transform .15s, box-shadow .2s; }
        .pd-btn:active { transform:scale(.98); }
        .pd-btn:disabled { opacity:.6; cursor:wait; }
        .pd-btn--ghost { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.18); color:#fff; }
        .pd-btn--ghost:hover { background:rgba(255,255,255,.12); }
        .pd-btn--accent { background:#e0392c; border:1px solid #e0392c; color:#fff;
                          box-shadow:0 12px 26px -12px rgba(224,57,44,.8); }
        .pd-btn--accent:hover { background:#ea4b3e; border-color:#ea4b3e; }

        .pd-chip:focus-visible, .pd-btn:focus-visible, .pd-thumb:focus-visible, .pd-qty button:focus-visible
            { outline:2px solid #fff; outline-offset:2px; }

        @media (prefers-reduced-motion: reduce) {
            .pd-slide, .pd-thumb, .pd-chip, .pd-qty button, .pd-btn { transition:none; }
            .pd-btn:active { transform:none; }
        }
    </style>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if(session('success'))
            <div class="bg-neutral-900 text-white text-sm px-5 py-3 mb-6" style="border-radius:1rem; border:1px solid rgba(255,255,255,.1);">
                {{ session('success') }}
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
                    <div class="bg-neutral-800 shadow-lg shadow-black/30" style="position:relative; width:100%; aspect-ratio:3/4; overflow:hidden; border-radius:1.75rem;">
                        <template x-for="(src, n) in images" :key="n">
                            <img :src="src" alt="" class="pd-slide" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"
                                 :style="{ opacity: i === n ? 1 : 0 }">
                        </template>
                    </div>
                @else
                    <div class="w-full aspect-[3/4] bg-neutral-800 flex items-center justify-center text-neutral-500 text-sm" style="border-radius:1.75rem;">Chưa có hình ảnh</div>
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
            <div style="flex:1 1 320px; min-width:280px; max-width:100%; display:flex; flex-direction:column; gap:2rem;">
                <div>
                    <span class="text-sm text-accent">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                    <h1 class="text-3xl font-bold text-white mt-2 tracking-tight">{{ $product->name }}</h1>
                    <p class="text-2xl font-semibold text-white mt-4">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>

                    <div class="mt-6 pt-6" style="border-top:1px solid rgba(255,255,255,.08);">
                        <h4 class="text-sm font-semibold text-white mb-2">Mô tả sản phẩm</h4>
                        <p class="text-sm text-neutral-400 whitespace-pre-line leading-7" style="max-width:34rem;">{{ $product->description ?: 'Chưa có mô tả chi tiết.' }}</p>
                    </div>
                </div>

                <!-- Nút Mua hàng: chỉ khách/khách hàng (customer) mới thấy, Owner/Staff/Sysadmin chỉ xem sản phẩm -->
                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:flex; flex-direction:column; gap:1.5rem;"
                          x-data="{ selectedSize: '{{ $product->sizeList[0] ?? '' }}', qty: 1 }">
                        @csrf

                        @if(count($product->sizeList) > 0)
                            <div>
                                <p class="text-sm font-semibold text-white mb-3">Chọn size <span class="text-accent">*</span></p>
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
                            <p class="text-sm font-semibold text-white mb-3">Số lượng</p>
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
                    <div style="display:flex; flex-direction:column; gap:1.5rem;">
                        @if(count($product->sizeList) > 0)
                            <div>
                                <p class="text-sm font-semibold text-white mb-3">Size có sẵn</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->sizeList as $size)
                                        <span class="pd-chip pd-chip--static">{{ $size }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="bg-neutral-900 text-sm text-neutral-400 px-5 py-4" style="border-radius:1rem; border:1px solid rgba(255,255,255,.08);">
                            Tài khoản quản trị chỉ có thể xem sản phẩm, không thể mua hàng.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
