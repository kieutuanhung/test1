<x-app-layout>
    <div class="bg-pink-50/40 min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Thông Tin Thanh Toán (COD)</h2>

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('order.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @csrf
                <!-- Cột nhập thông tin người nhận -->
                <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-pink-600 border-b border-pink-100 pb-3">1. Địa chỉ nhận hàng</h3>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Họ và tên người nhận *</label>
                        <input type="text" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" required class="w-full rounded-xl border-pink-200 focus:border-pink-500 focus:ring-pink-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Số điện thoại *</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full rounded-xl border-pink-200 focus:border-pink-500 focus:ring-pink-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Email (không bắt buộc)</label>
                            <input type="email" name="customer_email" value="{{ Auth::check() ? Auth::user()->email : old('customer_email') }}" class="w-full rounded-xl border-pink-200 focus:border-pink-500 focus:ring-pink-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Địa chỉ giao hàng chi tiết *</label>
                        <textarea name="customer_address" rows="3" required class="w-full rounded-xl border-pink-200 focus:border-pink-500 focus:ring-pink-500" placeholder="Số nhà, tên đường, phường/xã, quận/huyện...">{{ old('customer_address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ghi chú đơn hàng</label>
                        <textarea name="note" rows="2" class="w-full rounded-xl border-pink-200 focus:border-pink-500 focus:ring-pink-500" placeholder="Lưu ý khi giao hàng...">{{ old('note') }}</textarea>
                    </div>
                </div>

                <!-- Cột tóm tắt đơn hàng -->
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col justify-between h-fit space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-pink-600 border-b border-pink-100 pb-3">2. Đơn hàng của bạn</h3>
                        <div class="divide-y divide-gray-100 mt-3 max-h-60 overflow-y-auto">
                            @foreach($cart as $item)
                                <div class="py-2 flex justify-between text-sm">
                                    <span class="text-gray-700 font-medium">{{ $item['name'] }} <b class="text-pink-600">x{{ $item['quantity'] }}</b></span>
                                    <span class="font-bold text-gray-800">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-pink-100 mt-4 pt-4 flex justify-between items-center">
                            <span class="font-bold text-gray-700">Tổng thanh toán:</span>
                            <span class="text-2xl font-extrabold text-pink-600">{{ number_format($total, 0, ',', '.') }} đ</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Hình thức: Thanh toán khi nhận hàng (COD)</p>
                    </div>

                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition">
                        Xác Nhận Đặt Hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
