<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Giỏ Hàng Của Bạn') }}
        </h2>
    </x-slot>

    <div class="bg-pink-50/40 min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="bg-white rounded-2xl border border-pink-100 overflow-hidden shadow-sm p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-pink-50">
                                <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Sản phẩm</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Đơn giá</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Số lượng</th>
                                <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Thành tiền</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Xóa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($cart as $id => $item)
                                <tr>
                                    <td class="px-4 py-4 flex items-center gap-3">
                                        @if(!empty($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-12 h-12 object-cover rounded-lg border border-pink-200">
                                        @endif
                                        <a href="{{ route('shop.show', $item['slug']) }}" class="font-bold text-gray-800 hover:text-pink-600">
                                            {{ $item['name'] }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline-flex items-center gap-1">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center border-pink-200 rounded-lg text-sm">
                                            <button type="submit" class="text-xs bg-pink-100 hover:bg-pink-200 text-pink-700 px-2 py-1.5 rounded">Lưu</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 text-right font-bold text-pink-600">
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">✕</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-8 border-t border-pink-100 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <a href="{{ route('home') }}" class="text-pink-600 hover:underline font-bold text-sm">← Tiếp tục mua hàng</a>
                        
                        <div class="text-right">
                            <p class="text-lg font-medium text-gray-600">Tổng cộng thanh toán:</p>
                            <p class="text-3xl font-extrabold text-pink-600">{{ number_format($total, 0, ',', '.') }} VNĐ</p>
                            <a href="#" class="mt-4 inline-block bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">
                                Tiến hành Thanh toán (Checkout) →
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-pink-100 text-center py-16 p-6 shadow-sm">
                    <p class="text-gray-500 text-lg mb-4">Giỏ hàng của bạn đang trống trơn!</p>
                    <a href="{{ route('home') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow">
                        Mua sắm ngay
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
