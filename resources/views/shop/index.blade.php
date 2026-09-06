<x-app-layout>
    <!-- Hero kiểu Levents: banner đen full-width, chữ trắng in hoa, CTA đỏ -->
    <div class="relative isolate bg-neutral-800 text-white overflow-hidden">
        <!-- Nét vẽ trang trí dạng đường cong mềm mại -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-70 z-0" viewBox="0 0 1200 500" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M-30 60 C 60 -10, 120 90, 200 40 S 340 -20, 420 10" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M-30 130 C 80 40, 90 160, 150 130 S 220 60, 260 150 S 260 260, 220 320 S 60 400, 40 480" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M60 220 C 100 190, 160 200, 190 240 S 220 320, 260 300" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M-40 480 C 80 520, 200 470, 340 500 S 560 440, 700 470" stroke="white" stroke-width="2" stroke-linecap="round"/>

            <path d="M900 340 C 980 300, 1000 380, 1080 400 S 1180 340, 1240 300" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M1080 500 C 1130 440, 1180 460, 1220 400" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M1250 340 C 1160 380, 1140 460, 1050 500 S 900 560, 780 620" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M1000 620 C 1060 580, 1120 610, 1170 560 S 1230 470, 1250 400" stroke="white" stroke-width="2" stroke-linecap="round"/>

            <path d="M700 -20 C 780 30, 820 -10, 900 20 S 1020 -20, 1080 30" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M950 -20 C 1000 40, 970 90, 1020 130 S 1120 150, 1160 100" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M1150 -20 C 1180 40, 1160 90, 1200 120" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M760 60 C 800 100, 780 150, 820 180 S 900 190, 920 150" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>


        <!-- Slider Hero: 3 slide, tự động chuyển mượt (fade) mỗi 10 giây, vuốt tay được -->
        <div x-data="{
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
             x-init="setInterval(() => slide = (slide + 1) % 3, 10000)"
             @touchstart="startSwipe($event)" @touchend="endSwipe($event)"
             @mousedown="startSwipe($event)" @mouseup="endSwipe($event)"
             class="relative z-10" style="min-height: 420px; cursor: grab; touch-action: pan-y;">

            <!-- Slide 1: Nội dung hero gốc -->
            <div x-show="slide === 0"
                 x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                    <p class="text-accent text-xs font-bold uppercase tracking-widest2 mb-4">Xin chào</p>
                    <h1 class="text-4xl sm:text-6xl font-black uppercase leading-[1.05]">For Dreamers Only</h1>
                    <p class="mt-6 text-sm sm:text-base text-neutral-300 max-w-xl mx-auto leading-relaxed">
                        Thiết kế dành cho những ai tin rằng những điều nhỏ bé cũng có thể tạo nên vẻ đẹp riêng.
                    </p>
                    <a href="#products" class="btn-accent mt-10">Khám phá ngay</a>
                </div>
            </div>

            <!-- Slide 2: Nội dung hero mới -->
            <div x-show="slide === 1"
                 x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                    <p class="text-accent text-xs font-bold uppercase tracking-widest2 mb-4">Mới ra mắt</p>
                    <h1 class="text-4xl sm:text-6xl font-black uppercase leading-[1.05]">New Collection Drop</h1>
                    <p class="mt-6 text-sm sm:text-base text-neutral-300 max-w-xl mx-auto leading-relaxed">
                        Cập nhật bộ sưu tập mới nhất, giới hạn số lượng — đừng bỏ lỡ.
                    </p>
                    <a href="{{ route('home', ['sort' => 'new']) }}" class="btn-accent mt-10">Xem ngay</a>
                </div>
            </div>

            <!-- Slide 3: Best Seller -->
            <div x-show="slide === 2"
                 x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                    <p class="text-accent text-xs font-bold uppercase tracking-widest2 mb-4">Bán Chạy Nhất</p>
                    <h1 class="text-4xl sm:text-6xl font-black uppercase leading-[1.05]">Best Sellers</h1>
                    <p class="mt-6 text-sm sm:text-base text-neutral-300 max-w-xl mx-auto leading-relaxed">
                        Những sản phẩm được yêu thích và mua nhiều nhất — số lượng có hạn.
                    </p>
                    <a href="{{ route('home', ['sort' => 'bestseller']) }}" class="btn-accent mt-10">Xem ngay</a>
                </div>
            </div>

            <!-- Dấu chấm chuyển slide -->
            <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center gap-2" style="z-index: 20;">
                <button @click="slide = 0" :style="slide === 0 ? 'background-color:#e0392c;' : 'background-color:#737373;'" style="width:0.5rem; height:0.5rem; border-radius:9999px; transition: background-color .3s;"></button>
                <button @click="slide = 1" :style="slide === 1 ? 'background-color:#e0392c;' : 'background-color:#737373;'" style="width:0.5rem; height:0.5rem; border-radius:9999px; transition: background-color .3s;"></button>
                <button @click="slide = 2" :style="slide === 2 ? 'background-color:#e0392c;' : 'background-color:#737373;'" style="width:0.5rem; height:0.5rem; border-radius:9999px; transition: background-color .3s;"></button>
            </div>
        </div>
    </div>

    @if(!request('sort') && !request('category') && !request('view'))
        {{-- ====== TRANG CHỦ MẶC ĐỊNH: Bán Chạy Nhất → New Arrival → Từng Danh Mục ====== --}}

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
            <div class="bg-ink py-20 text-center text-neutral-400 uppercase tracking-widest2 text-xs" id="products">
                Cửa hàng chưa có sản phẩm nào.
            </div>
        @endif
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

        <!-- Thanh lọc Danh mục + Sắp xếp -->
        <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-3 mb-10 border-b border-neutral-700 pb-6">
            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                <a href="{{ route('home', ['view' => 'all']) }}" class="label-caps pb-1 border-b-2 {{ !request('category') ? 'border-accent text-accent' : 'border-transparent text-white hover:text-accent' }}">
                    Tất cả
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}" class="label-caps pb-1 border-b-2 {{ request('category') == $cat->slug ? 'border-accent text-accent' : 'border-transparent text-white hover:text-accent' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Dropdown sắp xếp theo Giá / Số lượng kho -->
            <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2">
                @if(request('view')) <input type="hidden" name="view" value="{{ request('view') }}"> @endif
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                <label class="text-[11px] uppercase tracking-widest2 text-neutral-400">Sắp xếp:</label>
                <select name="sortby" onchange="this.form.submit()" class="bg-neutral-900 border border-neutral-700 text-white text-xs uppercase tracking-widest2 rounded-none py-2 px-3 focus:border-accent focus:ring-accent">
                    <option value="" {{ !request('sortby') ? 'selected' : '' }}>Mặc định</option>
                    <option value="price_asc" {{ request('sortby') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp &rarr; Cao</option>
                    <option value="price_desc" {{ request('sortby') == 'price_desc' ? 'selected' : '' }}>Giá: Cao &rarr; Thấp</option>
                </select>
            </form>
        </div>

        <!-- Bộ lọc Giá (thu gọn) -->
        <div x-data="{ open: {{ request('price_min') || request('price_max') ? 'true' : 'false' }} }" class="mb-10 border border-neutral-800 rounded-2xl overflow-hidden">
            <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-5 py-4 text-white hover:bg-neutral-900 transition">
                <span class="text-sm font-bold uppercase tracking-widest2 text-accent">Giá</span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
            </button>

            <div x-show="open" x-transition class="px-5 pb-5 pt-1 border-t border-neutral-800">
                <form method="GET" action="{{ route('home') }}" class="space-y-4">
                    @if(request('view')) <input type="hidden" name="view" value="{{ request('view') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if(request('sortby')) <input type="hidden" name="sortby" value="{{ request('sortby') }}"> @endif

                    <div class="flex items-center gap-3">
                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Tối thiểu" class="input-field flex-1">
                        <span class="text-neutral-500">—</span>
                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Tối đa" class="input-field flex-1">
                        <button type="submit" class="btn-accent !px-5 !py-2.5 shrink-0">Áp dụng</button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @php
                            $priceRanges = [
                                ['label' => 'Dưới 50K', 'min' => null, 'max' => 50000],
                                ['label' => '50K - 100K', 'min' => 50000, 'max' => 100000],
                                ['label' => '100K - 500K', 'min' => 100000, 'max' => 500000],
                                ['label' => '500K - 1 triệu', 'min' => 500000, 'max' => 1000000],
                                ['label' => 'Trên 1 triệu', 'min' => 1000000, 'max' => null],
                            ];
                        @endphp
                        @foreach($priceRanges as $range)
                            @php
                                $isActive = (string) request('price_min') === (string) ($range['min'] ?? '') && (string) request('price_max') === (string) ($range['max'] ?? '');
                            @endphp
                            <a href="{{ route('home', array_filter(array_merge(request()->except(['price_min','price_max','page']), ['price_min' => $range['min'], 'price_max' => $range['max']]))) }}"
                               class="px-4 py-2 text-xs uppercase tracking-widest2 font-semibold border {{ $isActive ? 'border-accent text-accent' : 'border-neutral-700 text-neutral-300 hover:border-white hover:text-white' }} rounded-full transition">
                                {{ $range['label'] }}
                            </a>
                        @endforeach

                        @if(request('price_min') || request('price_max'))
                            <a href="{{ route('home', request()->except(['price_min','price_max','page'])) }}" class="px-4 py-2 text-xs uppercase tracking-widest2 font-semibold text-neutral-500 hover:text-accent transition">
                                &times; Xóa lọc giá
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Lưới Sản phẩm dạng cuộn ngang (carousel) -->
        <div class="relative" x-data="{
                scrollNext() { this.$refs.track.scrollBy({ left: this.$refs.track.clientWidth * 0.9, behavior: 'smooth' }); },
                scrollPrev() { this.$refs.track.scrollBy({ left: -this.$refs.track.clientWidth * 0.9, behavior: 'smooth' }); }
            }">
            <div x-ref="track" class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @forelse($products as $product)
                    <div class="group flex flex-col snap-start" style="flex-shrink:0; width:45%; max-width:280px;">
                        <a href="{{ route('shop.show', $product->slug) }}" style="display:block; position:relative; overflow:hidden; width:100%; height:280px; border-radius:1rem;" class="bg-neutral-800 border border-transparent group-hover:border-accent shadow-lg shadow-black/30 transition-all duration-300">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" style="width:100%; height:100%; object-fit:cover; display:block;" class="group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-500 text-xs uppercase tracking-widest2">Không có hình ảnh</div>
                            @endif

                            <!-- Badge nhỏ góc trên phải: Best Seller / New Arrival -->
                            <div class="absolute top-2 right-2 flex flex-col gap-1 items-end">
                                @if($product->is_best_seller)
                                    <span class="bg-accent text-white text-[10px] font-black uppercase tracking-widest2 px-2 py-1 rounded shadow-lg" title="Best Seller">Hot</span>
                                @endif
                                @if($product->is_new_arrival)
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-600 text-white text-[10px] font-black shadow-md" title="New Arrival">NEW</span>
                                @endif
                            </div>
                        </a>

                        <div class="pt-3 flex flex-col flex-grow">
                            <span class="text-[11px] text-accent uppercase tracking-widest2">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                            <h3 class="font-semibold text-white text-sm mt-1 leading-snug line-clamp-2">
                                <a href="{{ route('shop.show', $product->slug) }}" class="hover:opacity-60">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-sm font-bold text-white">{{ number_format($product->price, 0, ',', '.') }} đ</span>

                                @if(!Auth::check() || Auth::user()->role === 'customer')
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[11px] uppercase tracking-widest2 font-bold text-accent hover:text-accent-700 transition">
                                            + Thêm
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-16 text-neutral-400 border border-neutral-700 rounded-2xl uppercase tracking-widest2 text-xs">
                        Chưa có sản phẩm nào trong danh mục này.
                    </div>
                @endforelse
            </div>

            @if($products->isNotEmpty())
                <!-- Nút mũi tên điều hướng -->
                <button @click="scrollPrev()" class="hidden md:flex items-center justify-center absolute top-1/3 -left-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="scrollNext()" class="hidden md:flex items-center justify-center absolute top-1/3 -right-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
            @endif
        </div>

        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <!-- Phân trang -->
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
        </div>
    </div>
    @endif
</x-app-layout>
