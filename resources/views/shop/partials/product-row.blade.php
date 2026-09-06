{{--
    Partial: 1 dòng sản phẩm cuộn ngang có tiêu đề + nút "Xem tất cả"
    Biến truyền vào:
    - $rowProducts   : danh sách sản phẩm
    - $rowTitle      : tiêu đề khu vực (VD: "New Arrival")
    - $rowViewAllUrl : (tùy chọn) link "Xem tất cả"
    - $rowId         : id duy nhất cho khung cuộn (để x-ref không trùng)
--}}
<div class="bg-ink border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="section-title">{{ $rowTitle }}</h2>
            @isset($rowViewAllUrl)
                <a href="{{ $rowViewAllUrl }}" class="text-xs font-semibold uppercase tracking-widest2 text-accent hover:opacity-70 transition">
                    Xem tất cả &rarr;
                </a>
            @endisset
        </div>

        <div class="relative" x-data="{
                scrollNext() { this.$refs.track_{{ $rowId }}.scrollBy({ left: this.$refs.track_{{ $rowId }}.clientWidth * 0.9, behavior: 'smooth' }); },
                scrollPrev() { this.$refs.track_{{ $rowId }}.scrollBy({ left: -this.$refs.track_{{ $rowId }}.clientWidth * 0.9, behavior: 'smooth' }); }
            }">
            <div x-ref="track_{{ $rowId }}" class="flex gap-6 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach($rowProducts as $product)
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
                @endforeach
            </div>

            <button @click="scrollPrev()" class="hidden md:flex items-center justify-center absolute top-1/3 -left-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button @click="scrollNext()" class="hidden md:flex items-center justify-center absolute top-1/3 -right-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>
    </div>
</div>
