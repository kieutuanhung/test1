<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if(session('success'))
            <div class="border-l-4 border-accent bg-neutral-900 text-white text-sm px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14">
            <!-- Ảnh sản phẩm -->
            <div>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full aspect-[3/4] object-cover bg-neutral-800 rounded-2xl shadow-lg shadow-black/30">
                @else
                    <div class="w-full aspect-[3/4] bg-neutral-800 flex items-center justify-center text-neutral-600 text-xs uppercase tracking-widest2">Không có hình ảnh</div>
                @endif
            </div>

            <!-- Thông tin chi tiết -->
            <div class="flex flex-col justify-between">
                <div>
                    <span class="label-caps text-neutral-600">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold uppercase text-white mt-2">{{ $product->name }}</h1>
                    <p class="text-xl font-bold text-white mt-4">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>

                    <div class="mt-6 border-t border-neutral-800 pt-6">
                        <h4 class="label-caps text-white mb-2">Mô tả sản phẩm</h4>
                        <p class="text-sm text-neutral-300 whitespace-pre-line leading-relaxed">{{ $product->description ?: 'Chưa có mô tả chi tiết.' }}</p>
                    </div>
                </div>

                <!-- Nút Mua hàng: chỉ khách/khách hàng (customer) mới thấy, Owner/Staff/Sysadmin chỉ xem sản phẩm -->
                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-8 space-y-4"
                          x-data="{ selectedSize: '{{ $product->sizeList[0] ?? '' }}' }">
                        @csrf

                        @if(count($product->sizeList) > 0)
                            <div style="border: 1px solid #404040; border-radius: 0.75rem; padding: 1rem;">
                                <label class="label-caps text-white block mb-3">Chọn Size <span class="text-accent">*</span></label>
                                <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(3.5rem, 1fr)); gap: 0.6rem;">
                                    @foreach($product->sizeList as $size)
                                        <button type="button"
                                                @click="selectedSize = '{{ $size }}'"
                                                :style="selectedSize === '{{ $size }}' ? 'background-color:#e0392c; border-color:#e0392c; color:#fff;' : 'background-color:transparent; border-color:#525252; color:#fff;'"
                                                style="height:3rem; border-width:1px; border-style:solid; border-radius:0.5rem; font-size:0.875rem; font-weight:700; text-transform:uppercase; transition: all .15s;">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="size" :value="selectedSize">
                            </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-neutral-700">
                                <label class="px-3 py-3 bg-neutral-900 text-white text-xs font-semibold uppercase tracking-widest2 border-r border-neutral-700">SL</label>
                                <input type="number" name="quantity" value="1" min="1" class="w-16 border-0 bg-neutral-900 text-center text-white focus:ring-0">
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="btn-secondary flex-1">
                                + Thêm vào giỏ hàng
                            </button>
                            <button type="submit" formaction="{{ route('cart.add', $product->id) }}" name="buy_now" value="1" class="btn-accent flex-1">
                                Mua ngay
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mt-8 space-y-4">
                        @if(count($product->sizeList) > 0)
                            <div style="border: 1px solid #404040; border-radius: 0.75rem; padding: 1rem;">
                                <label class="label-caps text-white block mb-3">Size có sẵn</label>
                                <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(3.5rem, 1fr)); gap: 0.6rem;">
                                    @foreach($product->sizeList as $size)
                                        <span class="flex items-center justify-center" style="height:3rem; border:1px solid #525252; border-radius:0.5rem; font-size:0.875rem; font-weight:700; text-transform:uppercase; color:#fff;">
                                            {{ $size }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="border border-neutral-800 bg-neutral-900 rounded-xl p-4 text-xs uppercase tracking-widest2 text-neutral-400">
                            Tài khoản quản trị chỉ có thể xem sản phẩm, không thể mua hàng.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
