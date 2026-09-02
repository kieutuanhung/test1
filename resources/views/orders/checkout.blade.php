<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="section-title mb-8">Thông Tin Thanh Toán (COD)</h2>

        @if(session('error'))
            <div class="border border-red-700 bg-red-50 text-red-700 text-sm px-4 py-3 mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @csrf
            <!-- Cột nhập thông tin người nhận -->
            <div class="md:col-span-2 border border-neutral-800 p-6 space-y-5">
                <h3 class="label-caps text-white border-b border-neutral-800 pb-3">1. Địa chỉ nhận hàng</h3>

                <div>
                    <x-input-label value="Họ và tên người nhận *" />
                    <x-text-input type="text" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" required />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label value="Số điện thoại *" />
                        <x-text-input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required />
                    </div>
                    <div>
                        <x-input-label value="Email (không bắt buộc)" />
                        <x-text-input type="email" name="customer_email" value="{{ Auth::check() ? Auth::user()->email : old('customer_email') }}" />
                    </div>
                </div>

                <div>
                    <x-input-label value="Địa chỉ giao hàng chi tiết *" />
                    <textarea name="customer_address" rows="3" required class="input-field" placeholder="Số nhà, tên đường, phường/xã, quận/huyện...">{{ old('customer_address') }}</textarea>
                </div>

                <div>
                    <x-input-label value="Ghi chú đơn hàng" />
                    <textarea name="note" rows="2" class="input-field" placeholder="Lưu ý khi giao hàng...">{{ old('note') }}</textarea>
                </div>
            </div>

            <!-- Cột tóm tắt đơn hàng -->
            <div class="border border-neutral-800 p-6 flex flex-col justify-between h-fit space-y-6">
                <div>
                    <h3 class="label-caps text-white border-b border-neutral-800 pb-3">2. Đơn hàng của bạn</h3>
                    <div class="divide-y divide-neutral-800 mt-3 max-h-60 overflow-y-auto">
                        @foreach($cart as $item)
                            <div class="py-2 flex items-center justify-between text-sm gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if(!empty($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-10 h-10 object-cover bg-neutral-800 rounded-lg shrink-0">
                                    @else
                                        <div class="w-10 h-10 bg-neutral-800 rounded-lg shrink-0"></div>
                                    @endif
                                    <span class="text-neutral-300 truncate">{{ $item['name'] }} <b class="text-white">x{{ $item['quantity'] }}</b></span>
                                </div>
                                <span class="font-semibold text-white shrink-0">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-neutral-800 mt-4 pt-4 flex justify-between items-center">
                        <span class="text-xs uppercase tracking-widest2 font-semibold text-neutral-300">Tổng thanh toán</span>
                        <span class="text-xl font-extrabold text-white">{{ number_format($total, 0, ',', '.') }} đ</span>
                    </div>
                    <p class="text-xs text-neutral-600 mt-2">Hình thức: Thanh toán khi nhận hàng (COD)</p>
                </div>

                <button type="submit" class="btn-accent w-full">
                    Xác Nhận Đặt Hàng
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
