<x-app-layout>
    <div class="bg-pink-50/40 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Thanh lọc Danh mục -->
            <div class="flex flex-wrap items-center gap-2 mb-8 bg-white p-4 rounded-xl border border-pink-100 shadow-sm">
                <span class="font-bold text-pink-700 mr-2">Danh mục:</span>
                <a href="{{ route('home') }}" class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ !request('category') ? 'bg-pink-600 text-white shadow' : 'bg-pink-100 text-pink-700 hover:bg-pink-200' }}">
                    Tất cả
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}" class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('category') == $cat->slug ? 'bg-pink-600 text-white shadow' : 'bg-pink-100 text-pink-700 hover:bg-pink-200' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Lưới Sản phẩm (Grid Card) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl border border-pink-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-48 bg-pink-100 flex items-center justify-center text-pink-400 font-bold">Không có hình ảnh</div>
                            @endif
                        </a>
                        
                        <div class="p-4 flex flex-col flex-grow justify-between">
                            <div>
                                <span class="text-xs text-pink-500 font-semibold uppercase tracking-wider">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                                <h3 class="font-bold text-gray-800 text-base mt-1 line-clamp-2">
                                    <a href="{{ route('shop.show', $product->slug) }}" class="hover:text-pink-600">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-lg font-bold text-pink-600">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white p-2 rounded-lg transition shadow">
                                        🛒 Thêm
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500 bg-white rounded-2xl border border-pink-100">
                        Chưa có sản phẩm nào trong danh mục này.
                    </div>
                @endforelse
            </div>

            <!-- Phân trang -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
