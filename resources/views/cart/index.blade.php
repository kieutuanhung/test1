<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Giỏ Hàng Của Bạn') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if(session('success'))
            <div class="border-l-4 border-accent bg-neutral-900 text-white text-sm px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="border border-neutral-800">
                <table class="min-w-full divide-y divide-neutral-800">
                    <thead>
                        <tr class="bg-neutral-900">
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-white uppercase tracking-widest2">Sản phẩm</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-white uppercase tracking-widest2">Đơn giá</th>
                            <th class="px-4 py-3 text-center text-[11px] font-semibold text-white uppercase tracking-widest2">Số lượng</th>
                            <th class="px-4 py-3 text-right text-[11px] font-semibold text-white uppercase tracking-widest2">Thành tiền</th>
                            <th class="px-4 py-3 text-center text-[11px] font-semibold text-white uppercase tracking-widest2">Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800">
                        @foreach($cart as $id => $item)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if(!empty($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-14 h-14 object-cover bg-neutral-800 rounded-xl">
                                        @endif
                                        <div>
                                            <a href="{{ route('shop.show', $item['slug']) }}" class="font-semibold text-sm text-white hover:opacity-60">
                                                {{ $item['name'] }}
                                            </a>
                                            @if(!empty($item['size']))
                                                <div class="text-xs text-neutral-400 mt-0.5">Size: <span class="text-white font-semibold">{{ $item['size'] }}</span></div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-neutral-300">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                <td class="px-4 py-4 text-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center bg-neutral-900 border border-neutral-700 text-sm text-white rounded-none focus:border-accent focus:ring-0">
                                        <button type="submit" class="text-[11px] uppercase tracking-widest2 font-semibold border border-neutral-700 px-2 py-1.5 hover:border-white">Lưu</button>
                                    </form>
                                </td>
                                <td class="px-4 py-4 text-right font-bold text-white text-sm">
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-neutral-600 hover:text-red-700 font-bold text-lg leading-none">&times;</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-6 border-t border-neutral-800 flex flex-col md:flex-row justify-between items-center gap-6">
                    <a href="{{ route('home') }}" class="text-xs font-semibold uppercase tracking-widest2 text-white hover:opacity-60">&larr; Tiếp tục mua hàng</a>

                    <div class="text-right w-full md:w-auto">
                        <p class="text-xs uppercase tracking-widest2 text-neutral-400">Tổng cộng thanh toán</p>
                        <p class="text-2xl font-extrabold text-white">{{ number_format($total, 0, ',', '.') }} VNĐ</p>
                        <a href="{{ route('order.checkout', ['from_cart' => 1]) }}" class="btn-accent mt-4 w-full md:w-auto">
                            Tiến hành Thanh toán &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="border border-neutral-800 text-center py-20 px-6">
                <p class="text-neutral-400 text-sm mb-6 uppercase tracking-widest2">Giỏ hàng của bạn đang trống</p>
                <a href="{{ route('home') }}" class="btn-accent">
                    Mua sắm ngay
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
