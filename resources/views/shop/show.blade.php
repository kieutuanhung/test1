<x-app-layout>
    <div class="bg-pink-50/40 min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-pink-100 p-6 md:p-8 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Ảnh sản phẩm -->
                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-96 object-cover rounded-xl border border-pink-100 shadow-inner">
                    @else
                        <div class="w-full h-96 bg-pink-100 rounded-xl flex items-center justify-center text-pink-400 font-bold">Không có hình ảnh</div>
                    @endif
                </div>

                <!-- Thông tin chi tiết -->
                <div class="flex flex-col justify-between">
                    <div>
                        <span class="text-sm font-semibold text-pink-600 uppercase">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mt-2">{{ $product->name }}</h1>
                        <p class="text-3xl font-extrabold text-pink-600 mt-4">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        
                        <div class="mt-4 text-sm text-gray-500">
                            Kho còn: <span class="font-bold text-gray-800">{{ $product->stock }} sản phẩm</span>
                        </div>

                        <div class="mt-6 border-t border-pink-100 pt-4">
                            <h4 class="font-bold text-gray-700 mb-2">Mô tả sản phẩm:</h4>
                            <p class="text-gray-600 whitespace-pre-line leading-relaxed">{{ $product->description ?: 'Chưa có mô tả chi tiết.' }}</p>
                        </div>
                    </div>

                    <!-- Nút Mua hàng -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-8 flex items-center gap-4">
                        @csrf
                        <div class="flex items-center border border-pink-200 rounded-lg overflow-hidden">
                            <label class="px-3 py-2 bg-pink-50 text-pink-700 text-sm font-bold">Số lượng</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 border-0 text-center text-gray-700 focus:ring-0">
                        </div>
                        <button type="submit" class="flex-1 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-md">
                            + Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
