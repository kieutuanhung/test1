<x-app-layout>
@php
    // Tự động tìm đúng ảnh theo tên, không quan tâm đuôi file là .jpg, .jpeg, .png hay .webp
    $heroImage = function ($name) {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            if (file_exists(public_path("images/{$name}.{$ext}"))) {
                return asset("images/{$name}.{$ext}");
            }
        }
        return asset("images/{$name}.jpg"); // mặc định nếu chưa tìm thấy file nào
    };
@endphp

    <!-- Hero kiểu Levents: banner ảnh nền full-width, chữ trắng in hoa, CTA đỏ -->
    <div class="relative isolate text-white overflow-hidden"
         x-data="{
                slide: 0,
                touchX: 0,
                startSwipe(e) { this.touchX = e.touches ? e.touches[0].clientX : e.clientX; },
                endSwipe(e) {
                    const endX = e.changedTouches ? e.changedTouches[0].clientX : e.clientX;
                    const diff = this.touchX - endX;
                    if (diff > 50) { this.slide = (this.slide + 1) % 3; }      // vuốt sang trái -> slide kế tiếp
                    else if (diff < -50) { this.slide = (this.slide + 2) % 3; } // vuốt sang phải -> slide trước
                }
             }"
             x-init="setInterval(() => slide = (slide + 1) % 3, 5000)"
             @touchstart="startSwipe($event)" @touchend="endSwipe($event)"
             @mousedown="startSwipe($event)" @mouseup="endSwipe($event)"
             style="min-height: 420px; cursor: grab; touch-action: pan-y;">

        <!-- Lớp ảnh nền: mỗi slide 1 ảnh riêng, tự chuyển mờ dần theo cùng biến "slide" -->
        <div class="absolute inset-0 z-0">
            <div x-show="slide === 0"
                 x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute inset-0" style="background-image: url('{{ $heroImage('hero-bg-1') }}'); background-size: cover; background-position: center;"></div>
            <div x-show="slide === 1"
                 x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute inset-0" style="background-image: url('{{ $heroImage('hero-bg-2') }}'); background-size: cover; background-position: center;"></div>
            <div x-show="slide === 2"
                 x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute inset-0" style="background-image: url('{{ $heroImage('hero-bg-3') }}'); background-size: cover; background-position: center;"></div>
        </div>

        <!-- Lớp phủ tối để chữ luôn đọc rõ trên mọi ảnh nền -->
        <div class="absolute inset-0 z-10" style="background:rgba(17,17,17,.38);"></div>
        <div class="absolute inset-0 z-10" style="background:radial-gradient(900px 380px at 12% 0%, rgba(224,57,44,.22), transparent 60%), radial-gradient(800px 380px at 95% 10%, rgba(245,158,11,.16), transparent 60%), linear-gradient(180deg, rgba(17,17,17,.15) 0%, rgba(17,17,17,0) 40%, #111111 100%);"></div>

        <!-- Nội dung chữ từng slide -->
        <div class="relative z-20" style="min-height: 420px;">

            <!-- Slide 1: Nội dung hero gốc -->
            <div x-show="slide === 0"
                 x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                    <p class="text-accent text-xs font-bold uppercase tracking-widest2 mb-4">Xin chào</p>
                    <h1 class="text-4xl sm:text-6xl font-light uppercase leading-[1.05]">For Dreamers Only</h1>
                    <p class="mt-6 text-sm sm:text-base text-neutral-300 max-w-xl mx-auto leading-relaxed">
                        Thiết kế dành cho những ai tin rằng những điều nhỏ bé cũng có thể tạo nên vẻ đẹp riêng.
                    </p>
                    <a href="#products" class="btn-accent mt-10">Khám phá ngay</a>
                </div>
            </div>

            <!-- Slide 2: Nội dung hero mới -->
            <div x-show="slide === 1"
                 x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                    <p class="text-accent text-xs font-bold uppercase tracking-widest2 mb-4">Mới ra mắt</p>
                    <h1 class="text-4xl sm:text-6xl font-light uppercase leading-[1.05]">New Collection Drop</h1>
                    <p class="mt-6 text-sm sm:text-base text-neutral-300 max-w-xl mx-auto leading-relaxed">
                        Cập nhật bộ sưu tập mới nhất, giới hạn số lượng — đừng bỏ lỡ.
                    </p>
                    <a href="{{ route('home', ['sort' => 'new']) }}" class="btn-accent mt-10">Xem ngay</a>
                </div>
            </div>

            <!-- Slide 3: Best Seller -->
            <div x-show="slide === 2"
                 x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                    <p class="text-accent text-xs font-bold uppercase tracking-widest2 mb-4">Bán Chạy Nhất</p>
                    <h1 class="text-4xl sm:text-6xl font-light uppercase leading-[1.05]">Best Sellers</h1>
                    <p class="mt-6 text-sm sm:text-base text-neutral-300 max-w-xl mx-auto leading-relaxed">
                        Những sản phẩm được yêu thích và mua nhiều nhất — số lượng có hạn.
                    </p>
                    <a href="{{ route('home', ['sort' => 'bestseller']) }}" class="btn-accent mt-10">Xem ngay</a>
                </div>
            </div>

            <!-- Dấu chấm chuyển slide -->
            <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center gap-2" style="z-index: 30;">
                <button @click="slide = 0" :style="slide === 0 ? 'background-color:#e0392c;' : 'background-color:#737373;'" style="width:0.5rem; height:0.5rem; border-radius:9999px; transition: background-color .3s;"></button>
                <button @click="slide = 1" :style="slide === 1 ? 'background-color:#e0392c;' : 'background-color:#737373;'" style="width:0.5rem; height:0.5rem; border-radius:9999px; transition: background-color .3s;"></button>
                <button @click="slide = 2" :style="slide === 2 ? 'background-color:#e0392c;' : 'background-color:#737373;'" style="width:0.5rem; height:0.5rem; border-radius:9999px; transition: background-color .3s;"></button>
            </div>
        </div>
    </div>


    @if(!request('sort') && !request('category') && !request('view'))
        {{-- ====== TRANG CHỦ MẶC ĐỊNH: Bán Chạy Nhất → New Arrival → Từng Danh Mục ====== --}}

        {{-- ====== GIỚI THIỆU (About us) ====== --}}
        <section class="hx-about" id="about">
            <div class="hx-about__inner">
                <h2 class="hx-about__title">CAM ON VI <span class="hx-about__accent">DA DEN</span></h2>
                <div class="hx-about__body">
                    <p class="hx-about__lead">HAIAH xuất phát từ những con người đam mê, yêu thích và hướng đến cái đẹp.</p>
                    <p>Mỗi thiết kế được chọn lọc và sản xuất với số lượng giới hạn, nên bạn sẽ không thấy nó trên người của cả con phố.</p>
                    {{-- Thay bằng số liệu thật của shop, hoặc xoá cả <ul> nếu chưa cần --}}
                    <ul class="hx-about__facts">
                        <li><strong>2026</strong><span>Năm thành lập</span></li>
                        <li><strong>50+</strong><span>Thiết kế</span></li>
                        <li><strong>Giới hạn</strong><span>Mỗi đợt ra mắt</span></li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- ====== VIDEO (file tải về): tự chạy, không tiếng, lặp lại, không có nút điều khiển. Đặt file tại public/videos/intro.mp4 ====== --}}
        <section class="hx-reel" aria-hidden="true" inert>
            <video autoplay muted loop playsinline preload="auto"
                   disablepictureinpicture disableremoteplayback
                   controlslist="nodownload nofullscreen noremoteplayback"
                   tabindex="-1"
                   oncontextmenu="return false;">
                <source src="{{ asset('videos/intro.mp4') }}" type="video/mp4">
            </video>
        </section>

        <style>
            .hx-about{--hx-orange:#ff4a1c;position:relative;overflow:hidden;background:#111111;padding:clamp(72px,10vw,140px) clamp(20px,6vw,96px);color:#fff;}
            .hx-about::before{content:"";position:absolute;left:-10%;top:-20%;width:60%;height:140%;background:radial-gradient(closest-side,rgba(255,74,28,.16),transparent);pointer-events:none;}
            .hx-about__accent{color:var(--hx-orange);}
            .hx-about__inner{position:relative;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.1fr 1fr;gap:clamp(32px,6vw,96px);align-items:start;}
            .hx-about__title{margin:0;font-size:clamp(2rem,5vw,4.25rem);line-height:1.04;font-weight:300;text-transform:uppercase;letter-spacing:-.01em;}
            .hx-about__body p{margin:0 0 1.25em;max-width:60ch;color:#a3a3a3;font-size:1.05rem;line-height:1.7;}
            .hx-about__body p.hx-about__lead{color:#fff;font-size:1.2rem;}
            .hx-about__facts{display:flex;flex-wrap:wrap;gap:12px 36px;margin:32px 0 0;padding:24px 0 0;border-top:1px solid rgba(255,74,28,.35);list-style:none;}
            .hx-about__facts strong{display:block;font-size:1.5rem;font-weight:600;color:#fff;}
            .hx-about__facts li:first-child strong{color:var(--hx-orange);}
            .hx-about__facts span{color:#8a8a96;font-size:.9rem;}

            /* Khung video: phủ kín chiều ngang, video cover khung, không nhận chuột */
            .hx-reel{position:relative;width:100%;aspect-ratio:16/9;max-height:90vh;background:#000;overflow:hidden;pointer-events:none;user-select:none;-webkit-user-select:none;}
            .hx-reel video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border:0;pointer-events:none;}
            .hx-reel video::-webkit-media-controls,
            .hx-reel video::-webkit-media-controls-panel,
            .hx-reel video::-webkit-media-controls-start-playback-button{display:none !important;-webkit-appearance:none;}

            @media (max-width:800px){
                .hx-about__inner{grid-template-columns:1fr;}
            }
        </style>

        {{-- ====== SẢN PHẨM (mốc neo #products cho nút "Khám phá ngay" ở hero) ====== --}}
        <div id="products">


        @if($bestSellers->isNotEmpty())
            @include('shop.partials.product-row', [
                'rowProducts'   => $bestSellers,
                'rowTitle'      => 'Bán Chạy Nhất',
                'rowViewAllUrl' => route('home', ['sort' => 'bestseller']),
                'rowId'         => 'bestseller',
            ])
        @endif

        @if($newArrivals->isNotEmpty())
            @include('shop.partials.product-row', [
                'rowProducts'   => $newArrivals,
                'rowTitle'      => 'New Arrival',
                'rowViewAllUrl' => route('home', ['sort' => 'new']),
                'rowId'         => 'newarrival',
            ])
        @endif

        @foreach($categorySections as $cat)
            @include('shop.partials.product-row', [
                'rowProducts'   => $cat->products,
                'rowTitle'      => $cat->name,
                'rowViewAllUrl' => route('home', ['category' => $cat->slug]),
                'rowId'         => 'cat' . $cat->id,
            ])
        @endforeach

        @if($bestSellers->isEmpty() && $newArrivals->isEmpty() && $categorySections->isEmpty())
            <div class="bg-ink py-20 text-center text-neutral-400 uppercase tracking-widest2 text-xs">
                Cửa hàng chưa có sản phẩm nào.
            </div>
        @endif
        </div>
    @else
        {{-- ====== TRANG LỌC: theo Danh mục / New Arrival / Best Seller ====== --}}
        <div class="relative bg-neutral-900" id="products">
        <!-- Nét vẽ trang trí nền (nằm phía sau toàn bộ nội dung) -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-10 z-0" viewBox="0 0 1200 800" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M 103.0 120.0 L 103.8 121.5 L 103.8 123.6 L 102.7 125.8 L 100.5 127.5 L 97.3 128.3 L 93.7 127.6 L 90.4 125.3 L 88.0 121.5 L 87.2 116.7 L 88.4 111.5 L 91.7 106.9 L 96.9 103.6 L 103.3 102.5 L 110.2 104.0 L 116.3 108.2 L 120.6 114.7 L 122.2 122.8 L 120.6 131.3 L 115.7 139.0 L 108.0 144.5 L 98.3 146.9 L 88.0 145.4 L 78.7 140.0 L 71.8 131.2 L 68.5 120.0 L 69.7 108.0 L 75.4 96.9 L 85.1 88.4 L 97.7 84.0 L 111.5 84.6 L 124.4 90.5 L 134.6 101.0 L 140.3 114.9 L 140.4 130.4 L 134.7 145.2 L 123.6 157.2 L 108.5 164.4 L 91.3 165.5 L 74.6 160.1 L 60.7 148.6 L 51.8 132.4 L 49.5 113.6 L 54.4 94.9 L 66.1 79.0 L 83.2 68.4 L 103.5 64.7 L 124.1 68.8 L 142.1 80.5 L 154.7 98.3 L 160.0 120.0" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
            <path d="M 1123.0 200.0 L 1123.8 201.4 L 1123.9 203.3 L 1123.0 205.3 L 1121.2 207.1 L 1118.5 208.1 L 1115.2 207.9 L 1112.0 206.5 L 1109.3 203.6 L 1107.6 199.7 L 1107.5 195.1 L 1109.2 190.4 L 1112.7 186.3 L 1117.7 183.6 L 1123.7 182.8 L 1130.0 184.3 L 1135.6 188.1 L 1139.7 193.9 L 1141.7 201.1 L 1140.9 208.9 L 1137.3 216.3 L 1131.1 222.2 L 1122.9 225.7 L 1113.6 226.2 L 1104.4 223.2 L 1096.5 217.0 L 1091.1 208.2 L 1089.0 197.7 L 1090.8 186.7 L 1096.4 176.7 L 1105.4 169.1 L 1116.9 164.9 L 1129.5 165.0 L 1141.6 169.5 L 1151.6 178.2 L 1158.2 190.2 L 1160.2 204.1 L 1157.3 218.1 L 1149.5 230.6 L 1137.6 239.9 L 1122.8 244.5 L 1107.0 243.7 L 1092.1 237.4 L 1080.0 226.1 L 1072.5 210.9 L 1070.6 193.8 L 1074.8 176.6 L 1085.0 161.7 L 1099.9 151.0 L 1118.0 146.1 L 1137.0 147.7" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
            <path d="M 83.0 650.0 L 83.9 651.6 L 83.9 653.9 L 82.6 656.2 L 80.1 658.0 L 76.6 658.6 L 72.8 657.5 L 69.3 654.7 L 67.1 650.3 L 66.8 645.0 L 68.8 639.5 L 73.1 634.9 L 79.3 632.1 L 86.6 632.1 L 93.7 635.0 L 99.5 640.8 L 102.8 648.9 L 102.7 658.0 L 98.9 666.9 L 91.6 673.9 L 81.7 677.7 L 70.7 677.5 L 60.1 672.8 L 51.8 664.1 L 47.3 652.5 L 47.7 639.5 L 53.1 627.2 L 63.2 617.6 L 76.7 612.4 L 91.6 612.8 L 105.6 619.0 L 116.6 630.5 L 122.5 645.7 L 122.1 662.5 L 115.2 678.3 L 102.4 690.7 L 85.4 697.3 L 66.7 697.0 L 49.0 689.4 L 35.3 675.3 L 27.8 656.6 L 28.0 636.0 L 36.3 616.5 L 51.6 601.3 L 72.1 593.0 L 94.6 593.0 L 115.9 601.9 L 132.5 618.5 L 141.8 640.6 L 142.0 665.1 L 132.6 688.2" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
            <path d="M 1133.0 700.0 L 1133.7 701.3 L 1133.9 703.0 L 1133.2 704.8 L 1131.8 706.5 L 1129.5 707.7 L 1126.7 708.0 L 1123.7 707.2 L 1120.9 705.3 L 1118.8 702.3 L 1117.7 698.4 L 1118.0 694.2 L 1119.8 690.0 L 1123.2 686.4 L 1127.8 684.0 L 1133.2 683.2 L 1138.9 684.3 L 1144.2 687.4 L 1148.3 692.2 L 1150.8 698.4 L 1151.1 705.4 L 1149.0 712.4 L 1144.6 718.6 L 1138.2 723.2 L 1130.3 725.6 L 1121.8 725.2 L 1113.6 722.0 L 1106.6 716.1 L 1101.8 708.0 L 1099.8 698.5 L 1101.0 688.5 L 1105.5 679.2 L 1113.0 671.6 L 1122.8 666.8 L 1133.9 665.3 L 1145.3 667.5 L 1155.6 673.5 L 1163.6 682.6 L 1168.3 694.2 L 1169.0 706.9 L 1165.6 719.6 L 1158.1 730.6 L 1147.1 738.9 L 1133.8 743.3 L 1119.5 743.1 L 1105.7 738.2 L 1094.0 729.0 L 1085.7 716.3 L 1081.9 701.2 L 1083.2 685.4 L 1089.5 670.6" stroke="white" stroke-width="2.5" stroke-linecap="round" fill="none"/>
        </svg>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if(session('success'))
            <div class="border-l-4 border-accent bg-neutral-950 text-white text-sm px-4 py-3 mb-8">
                {{ session('success') }}
            </div>
        @endif

        @php
            $activeCat   = $categories->firstWhere('slug', request('category'));
            $hasPrice    = request()->filled('price_min') || request()->filled('price_max');
            $filterCount = ($activeCat ? 1 : 0) + ($hasPrice ? 1 : 0);
            $total       = $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->total() : $products->count();

            $pageEyebrow = request('sort') === 'bestseller' ? 'Bán chạy nhất' : (request('sort') === 'new' ? 'Hàng mới về' : 'Cửa hàng');
            $pageTitle   = $activeCat->name
                ?? (request('sort') === 'bestseller' ? 'Best Sellers' : (request('sort') === 'new' ? 'New Arrival' : 'Tất cả sản phẩm'));

            $pMin = request('price_min');
            $pMax = request('price_max');
            $priceLabel = null;
            if ($hasPrice) {
                $fmt = fn($n) => number_format((float) $n, 0, ',', '.') . 'đ';
                $priceLabel = ($pMin !== null && $pMin !== '' && $pMax !== null && $pMax !== '')
                    ? $fmt($pMin) . ' – ' . $fmt($pMax)
                    : (($pMin !== null && $pMin !== '') ? 'Từ ' . $fmt($pMin) : 'Đến ' . $fmt($pMax));
            }

            $priceRanges = [
                ['label' => 'Dưới 50K',        'min' => '',      'max' => '50000'],
                ['label' => '50K - 100K',      'min' => '50000', 'max' => '100000'],
                ['label' => '100K - 500K',     'min' => '100000','max' => '500000'],
                ['label' => '500K - 1 triệu',  'min' => '500000','max' => '1000000'],
                ['label' => 'Trên 1 triệu',    'min' => '1000000','max' => ''],
            ];
        @endphp

        <style>
            .fl-eyebrow{font-size:11px;font-weight:700;letter-spacing:.25em;text-transform:uppercase;color:#f26a2e;}
            .fl-title{margin-top:4px;font-size:1.75rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;color:#fff;line-height:1.1;}
            .fl-count{margin-top:6px;font-size:13px;color:#8a8a96;}

            .fl-bar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;}
            .fl-left{display:flex;flex-wrap:wrap;align-items:center;gap:8px;}
            .fl-btn{display:inline-flex;align-items:center;gap:8px;border:1px solid #3a3a45;background:#1c1c22;color:#e5e5ee;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.6rem 1.1rem;border-radius:999px;cursor:pointer;transition:all .15s;}
            .fl-btn:hover,.fl-btn.is-open{border-color:#f26a2e;color:#fff;}
            .fl-btn svg{width:15px;height:15px;}
            .fl-badge{min-width:18px;height:18px;padding:0 5px;display:inline-flex;align-items:center;justify-content:center;border-radius:999px;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:10px;font-weight:800;}
            .fl-tag{display:inline-flex;align-items:center;gap:6px;border:1px solid rgba(242,106,46,.45);background:rgba(242,106,46,.10);color:#fdba74;font-size:12px;font-weight:600;padding:.4rem .5rem .4rem .9rem;border-radius:999px;}
            .fl-tag a{display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px;border-radius:999px;color:#fdba74;transition:all .15s;}
            .fl-tag a:hover{background:rgba(242,106,46,.30);color:#fff;}

            .fl-sort{display:flex;align-items:center;gap:10px;}
            .fl-sort label{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#8a8a96;}
            .fl-select{appearance:none;-webkit-appearance:none;background:#1c1c22 url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23b8b8c2' stroke-width='3'><path d='M19 9l-7 7-7-7'/></svg>") no-repeat right 14px center;border:1px solid #3a3a45;border-radius:999px;color:#fff;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.6rem 2.4rem .6rem 1.1rem;cursor:pointer;transition:border-color .15s;}
            .fl-select:hover,.fl-select:focus{outline:none;border-color:#f26a2e;box-shadow:none;}
            .fl-select option{background:#1c1c22;color:#fff;}

            .fl-panel{margin-top:14px;padding:1.25rem 1.4rem;border-radius:16px;border:1px solid #2e2e37;background:linear-gradient(180deg,#1f1f26,#19191f);}
            .fl-group + .fl-group{margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #2e2e37;}
            .fl-label{display:block;margin-bottom:.6rem;font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#a8a8b3;}
            .fl-chips{display:flex;flex-wrap:wrap;gap:8px;}
            .fl-chip{position:relative;display:inline-flex;align-items:center;border:1px solid #3a3a45;background:#16161b;color:#c8c8d2;font-size:12px;font-weight:600;padding:.5rem 1rem;border-radius:999px;cursor:pointer;transition:all .15s;}
            .fl-chip:hover{border-color:#fff;color:#fff;}
            .fl-chip input{position:absolute;opacity:0;pointer-events:none;}
            .fl-chip:has(input:checked),.fl-chip.is-on{border-color:transparent;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;}
            .fl-price-row{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:.8rem;}
            .fl-num{width:150px;background:#16161b;border:1px solid #3a3a45;border-radius:999px;color:#fff;font-size:13px;padding:.55rem 1rem;transition:border-color .15s;}
            .fl-num::placeholder{color:#8a8a96;}
            .fl-num:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
            .fl-actions{display:flex;justify-content:flex-end;align-items:center;gap:10px;margin-top:1.25rem;padding-top:1.1rem;border-top:1px solid #2e2e37;}
            .fl-clear{font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#a8a8b3;padding:.6rem 1rem;border-radius:999px;border:1px solid #3a3a45;transition:all .15s;}
            .fl-clear:hover{color:#fff;border-color:#fff;}
            .fl-apply{border:0;cursor:pointer;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.65rem 1.4rem;border-radius:999px;transition:filter .15s, transform .15s;}
            .fl-apply:hover{filter:brightness(1.1);transform:translateY(-1px);}
        </style>

        <!-- Tiêu đề trang lọc -->
        <div class="mb-6">
            <p class="fl-eyebrow">{{ $pageEyebrow }}</p>
            <h1 class="fl-title">{{ $pageTitle }}</h1>
            <p class="fl-count">{{ $total }} sản phẩm</p>
        </div>

        <!-- Lọc & Sắp xếp (gộp 1 thanh gọn) -->
        <form method="GET" action="{{ route('home') }}" class="mb-10"
              x-data="{ open: false, min: '{{ $pMin }}', max: '{{ $pMax }}', setPrice(a, b) { this.min = a; this.max = b; } }"
              onsubmit="this.querySelectorAll('input[type=number]').forEach(function (i) { if (!i.value) i.disabled = true; })">
            <input type="hidden" name="view" value="all">
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

            <div class="fl-bar">
                <div class="fl-left">
                    <button type="button" class="fl-btn" :class="open ? 'is-open' : ''" @click="open = !open">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M6 12h12M10 19h4"/></svg>
                        Lọc
                        @if($filterCount > 0)
                            <span class="fl-badge">{{ $filterCount }}</span>
                        @endif
                    </button>

                    @if($activeCat)
                        <span class="fl-tag">
                            {{ $activeCat->name }}
                            <a href="{{ route('home', array_merge(request()->except(['category', 'page']), ['view' => 'all'])) }}" title="Bỏ lọc danh mục">&times;</a>
                        </span>
                    @endif
                    @if($priceLabel)
                        <span class="fl-tag">
                            {{ $priceLabel }}
                            <a href="{{ route('home', array_merge(request()->except(['price_min', 'price_max', 'page']), ['view' => 'all'])) }}" title="Bỏ lọc giá">&times;</a>
                        </span>
                    @endif
                </div>

                <div class="fl-sort">
                    <label for="sortby">Sắp xếp</label>
                    <select id="sortby" name="sortby" class="fl-select" onchange="this.form.requestSubmit()">
                        <option value="" {{ !request('sortby') ? 'selected' : '' }}>Mặc định</option>
                        <option value="price_asc" {{ request('sortby') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
                        <option value="price_desc" {{ request('sortby') == 'price_desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
                    </select>
                </div>
            </div>

            <!-- Bảng lọc mở rộng -->
            <div class="fl-panel" x-show="open" x-transition style="display:none;">
                <div class="fl-group">
                    <span class="fl-label">Danh mục</span>
                    <div class="fl-chips">
                        <label class="fl-chip">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}>
                            Tất cả
                        </label>
                        @foreach($categories as $cat)
                            <label class="fl-chip">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                {{ $cat->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="fl-group">
                    <span class="fl-label">Khoảng giá (VNĐ)</span>
                    <div class="fl-price-row">
                        <input type="number" name="price_min" x-model="min" placeholder="Tối thiểu" class="fl-num" min="0">
                        <span style="color:#6b6b78;">—</span>
                        <input type="number" name="price_max" x-model="max" placeholder="Tối đa" class="fl-num" min="0">
                    </div>
                    <div class="fl-chips">
                        @foreach($priceRanges as $range)
                            <button type="button" class="fl-chip"
                                    :class="(min == '{{ $range['min'] }}' && max == '{{ $range['max'] }}') ? 'is-on' : ''"
                                    @click="setPrice('{{ $range['min'] }}', '{{ $range['max'] }}')">
                                {{ $range['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="fl-actions">
                    @if($filterCount > 0)
                        <a href="{{ route('home', array_filter(['view' => 'all', 'sort' => request('sort')])) }}" class="fl-clear">Xóa lọc</a>
                    @endif
                    <button type="submit" class="fl-apply">Áp dụng</button>
                </div>
            </div>
        </form>

        <!-- Lưới Sản phẩm dạng cuộn ngang (carousel) -->
        <div class="relative" x-data="{
                scrollNext() { this.$refs.track.scrollBy({ left: this.$refs.track.clientWidth * 0.9, behavior: 'smooth' }); },
                scrollPrev() { this.$refs.track.scrollBy({ left: -this.$refs.track.clientWidth * 0.9, behavior: 'smooth' }); }
            }">
            <div x-ref="track" class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @forelse($products as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @empty
                    <div class="w-full text-center py-16 text-neutral-400 border border-neutral-700 rounded-2xl uppercase tracking-widest2 text-xs">
                        Chưa có sản phẩm nào trong danh mục này.
                    </div>
                @endforelse
            </div>

            @if($products->isNotEmpty())
                <!-- Nút mũi tên điều hướng -->
                <button @click="scrollPrev()" style="z-index:30;" class="hidden md:flex items-center justify-center absolute top-1/3 -left-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="scrollNext()" style="z-index:30;" class="hidden md:flex items-center justify-center absolute top-1/3 -right-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
            @endif
        </div>

        </div>
    </div>

    <script>
    // Tự động đổi sang ảnh thứ 2 mỗi 10 giây cho các thẻ sản phẩm có nhiều hơn 1 ảnh
    if (!window.__productImgSwapInit) {
        window.__productImgSwapInit = true;
        setInterval(function () {
            document.querySelectorAll('.img-swap-2').forEach(function (img2) {
                var img1 = img2.previousElementSibling;
                if (!img1 || !img1.classList.contains('img-swap-1')) return;
                var showing2 = img2.style.opacity === '1';
                img1.style.opacity = showing2 ? '1' : '0';
                img2.style.opacity = showing2 ? '0' : '1';
            });
        }, 5000);
    }
    </script>
    @endif
</x-app-layout>
