<!-- Thanh thông báo khuyến mãi -->
<div class="bg-white text-ink text-center py-2.5 px-4">
    <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-widest2">
        Freeship cho đơn từ 500.000đ &nbsp;&bull;&nbsp; Đổi trả trong 14 ngày
    </p>
</div>

<nav x-data="{ open: false, searchOpen: false }" class="bg-ink border-b border-neutral-800 sticky top-0 z-40">
    <!-- Primary Navigation Bar: hamburger trái - logo giữa - icon phải -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 items-center h-20">

            <!-- Trái: nút Hamburger (mở menu điều hướng) -->
            <div class="flex items-center">
                <button @click="open = true; searchOpen = false" type="button"
                        class="inline-flex items-center justify-center p-2 -ms-2 text-white hover:text-accent focus:outline-none transition"
                        aria-label="Mở menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Giữa: Logo -->
            <div class="flex items-center justify-center">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-accent"></span>
                    <span class="text-xl font-medium uppercase tracking-wide text-white">{{ config('app.name', 'Shop') }}</span>
                </a>
            </div>

            <!-- Phải: Tìm kiếm / Giỏ hàng / Tài khoản -->
            <div class="flex items-center justify-end gap-4 sm:gap-5">

                <!-- Icon Tìm kiếm -->
                <button @click="searchOpen = !searchOpen; open = false" type="button"
                        class="text-white hover:text-accent focus:outline-none transition"
                        aria-label="Tìm kiếm">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607Z" />
                    </svg>
                </button>

                <!-- Icon Giỏ hàng -->
                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center text-white hover:text-accent transition" aria-label="Giỏ hàng">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.684 2.568-7.135.106-.44-.243-.865-.696-.865H5.106M7.5 14.25L5.106 5.272M7.5 14.25L5.25 18.75m0 0h15" />
                        </svg>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-accent text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <!-- Icon Tài khoản -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-white hover:text-accent focus:outline-none transition" aria-label="Tài khoản">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-[11px] uppercase tracking-wide text-neutral-500 border-b border-neutral-800">
                                {{ Auth::user()->name }}
                            </div>

                            @if(Auth::user()->role === 'customer')
                                <x-dropdown-link :href="route('order.history')">
                                    {{ __('Đơn hàng của tôi') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Hồ sơ cá nhân') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Đăng xuất') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center text-white hover:text-accent transition" aria-label="Đăng nhập">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Ô tìm kiếm xổ xuống -->
        <div x-show="searchOpen" x-transition x-cloak class="pb-5">
            <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm..."
                       class="input-field flex-1" x-ref="searchInput" @keydown.escape="searchOpen = false">
                <button type="submit" class="btn-accent !px-5 !py-2.5 shrink-0">Tìm</button>
                <button type="button" @click="searchOpen = false" class="text-neutral-400 hover:text-white p-2 shrink-0" aria-label="Đóng tìm kiếm">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Menu điều hướng (mở từ icon hamburger) -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50" style="display:none;">
        <!-- Lớp phủ nền -->
        <div class="absolute inset-0 bg-black/60"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="open = false"></div>

        <!-- Bảng menu trượt từ trái -->
        <div class="absolute inset-y-0 left-0 w-72 max-w-[85%] bg-ink border-r border-neutral-800 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

            <div class="flex items-center justify-between p-4 border-b border-neutral-800">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-accent"></span>
                    <span class="text-sm font-medium uppercase tracking-widest2 text-white">{{ config('app.name', 'Shop') }}</span>
                </span>
                <button @click="open = false" class="text-white hover:text-accent p-2" aria-label="Đóng menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto py-2">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home') && !request('category') && !request('sort') && !request('view')">
                    {{ __('Cửa Hàng') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('home', ['view' => 'all'])" :active="request('view') === 'all'">
                    {{ __('Tất Cả Sản Phẩm') }}
                </x-responsive-nav-link>

                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        {{ __('Giỏ Hàng') }} ({{ count(session('cart', [])) }})
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('home', ['sort' => 'new'])" :active="request('sort') === 'new'">
                        {{ __('New Arrival') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('home', ['sort' => 'bestseller'])" :active="request('sort') === 'bestseller'">
                        {{ __('Best Seller') }}
                    </x-responsive-nav-link>
                @endif

                @auth
                    @if(Auth::user()->role === 'customer')
                        <x-responsive-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')">
                            {{ __('Đơn Hàng Của Tôi') }}
                        </x-responsive-nav-link>
                    @endif

                    @if(Auth::user()->role === 'sysadmin')
                        <x-responsive-nav-link :href="route('sysadmin.users.index')" :active="request()->routeIs('sysadmin.users.*')">
                            {{ __('Quản lý User') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('sysadmin.logs.index')" :active="request()->routeIs('sysadmin.logs.*')">
                            {{ __('Nhật ký Đăng nhập') }}
                        </x-responsive-nav-link>
                    @endif

                    @if(Auth::user()->role === 'owner')
                        <x-responsive-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.*')">
                            {{ __('Báo Cáo Doanh Thu') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Danh mục') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('Sản phẩm') }}
                        </x-responsive-nav-link>
                    @endif

                    @if(Auth::user()->role === 'staff')
                        <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show')">
                            {{ __('Đơn hàng') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.orders.picklist')" :active="request()->routeIs('admin.orders.picklist')">
                            {{ __('Gom Hàng') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Danh mục') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('Sản phẩm') }}
                        </x-responsive-nav-link>
                    @endif
                @endauth
            </div>

            <div class="border-t border-neutral-800 p-4">
                @auth
                    <div class="font-semibold text-sm uppercase tracking-wide text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-neutral-400">{{ Auth::user()->email }}</div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Hồ sơ cá nhân') }}
                        </x-responsive-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Đăng xuất') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                @else
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" class="block text-xs font-semibold uppercase tracking-widest2 text-white py-1">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="block text-xs font-semibold uppercase tracking-widest2 text-white py-1">Đăng ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
