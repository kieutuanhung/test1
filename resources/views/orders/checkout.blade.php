<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Đặt hàng</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    Thông tin thanh toán
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        div.sh-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        @media (min-width:768px){.sh-grid{grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);}}
        .sh-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .sh-title{margin:0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:#fff;padding-bottom:.85rem;border-bottom:1px solid #2e2e37;}
        .sh-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.85rem 1.4rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .sh-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}

        /* Ô nhập liệu trong form */
        .sh-form label{color:#a8a8b3;}
        .sh-form input[type="text"],
        .sh-form input[type="email"]{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.65rem .875rem .65rem 1.1rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .sh-form textarea{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:18px;padding:.75rem 1.1rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .sh-form input::placeholder,
        .sh-form textarea::placeholder{color:#8a8a96;}
        .sh-form input:focus,
        .sh-form textarea:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
    </style>

    <div class="py-6 bg-ink min-h-screen sh-wrap">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('error'))
                <div style="color:#fca5a5; background-color:#f871711a; border:1px solid #f8717166; border-radius:12px; padding:.75rem 1rem; font-size:14px; margin-bottom:1.25rem;">
                    ! {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('order.store') }}" method="POST" class="sh-form sh-grid grid grid-cols-1 gap-6">
                @csrf
                <!-- Cột nhập thông tin người nhận -->
                <div class="sh-card space-y-5" style="padding:1.5rem;">
                    <h3 class="sh-title">1. Địa chỉ nhận hàng</h3>

                    <div>
                        <x-input-label value="Họ và tên người nhận *" />
                        <x-text-input type="text" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" required />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Số điện thoại *" />
                            <x-text-input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" required />
                            @error('customer_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
                <div class="sh-card h-fit space-y-6" style="padding:1.5rem;">
                    <div>
                        <h3 class="sh-title">2. Đơn hàng của bạn</h3>
                        <div class="mt-3 max-h-60 overflow-y-auto pr-3" style="scrollbar-gutter:stable;">
                            @foreach($cart as $item)
                                <div class="py-3 flex items-center justify-between text-sm gap-3" style="{{ !$loop->last ? 'border-bottom:1px solid #2a2a33;' : '' }}">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if(!empty($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-10 h-10 object-cover shrink-0" style="background-color:#16161b; border:1px solid #2e2e37; border-radius:10px;">
                                        @else
                                            <div class="w-10 h-10 shrink-0" style="background-color:#16161b; border:1px solid #2e2e37; border-radius:10px;"></div>
                                        @endif
                                        <span class="min-w-0" style="color:#d4d4dc;">
                                            <span class="block truncate">{{ $item['name'] }} <b class="text-white">x{{ $item['quantity'] }}</b></span>
                                            @if(!empty($item['size']))
                                                <span class="block text-xs" style="color:#8a8a96;">Size: <span class="text-white font-semibold">{{ $item['size'] }}</span></span>
                                            @endif
                                        </span>
                                    </div>
                                    <span class="font-semibold text-white shrink-0">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 flex justify-between items-center" style="border-top:1px solid #2e2e37;">
                            <span style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#a8a8b3;">Tổng thanh toán</span>
                            <span style="font-size:22px; font-weight:900; color:#fbbf24;">{{ number_format($total, 0, ',', '.') }} đ</span>
                        </div>
                        <p class="text-xs mt-2" style="color:#8a8a96;">Hình thức: Quét mã QR</p>
                    </div>

                    <button type="submit" class="sh-btn-red w-full">
                        Xác nhận đặt hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
