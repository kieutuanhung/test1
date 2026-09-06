<!-- Thanh thông báo khuyến mãi -->
<div class="bg-white text-ink text-center py-2.5 px-4">
    <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-widest2">
        Freeship cho đơn từ 500.000đ &nbsp;&bull;&nbsp; Đổi trả trong 14 ngày
    </p>
</div>

<nav x-data="{ open: false }" class="bg-ink border-b border-neutral-800 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-accent"></span>
                        <span class="text-xl font-black uppercase tracking-wide text-white">{{ config('app.name', 'Shop') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home') && !request('category') && !request('sort') && !request('view')">
                        {{ __('Cửa Hàng') }}
                    </x-nav-link>

                    <x-nav-link :href="route('home', ['view' => 'all'])" :active="request('view') === 'all'">
                        {{ __('Tất Cả Sản Phẩm') }}
                    </x-nav-link>

                    @if(!Auth::check() || Auth::user()->role === 'customer')
                        <x-nav-link :href="route('home', ['sort' => 'new'])" :active="request('sort') === 'new'">
                            {{ __('New Arrival') }}
                        </x-nav-link>
                        <x-nav-link :href="route('home', ['sort' => 'bestseller'])" :active="request('sort') === 'bestseller'">
                            {{ __('Best Seller') }}
                        </x-nav-link>
                    @endif

                    @auth
                        @if(Auth::user()->role === 'customer')
                            <x-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')">
                                {{ __('Đơn Hàng Của Tôi') }}
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->role === 'sysadmin')
                            <x-nav-link :href="route('sysadmin.users.index')" :active="request()->routeIs('sysadmin.users.*')">
                                {{ __('Quản lý User') }}
                            </x-nav-link>
                            <x-nav-link :href="route('sysadmin.logs.index')" :active="request()->routeIs('sysadmin.logs.*')">
                                {{ __('Nhật ký Đăng nhập') }}
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->role === 'owner')
                            <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.*')">
                                {{ __('Báo Cáo Doanh Thu') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                {{ __('Danh mục') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                                {{ __('Sản phẩm') }}
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->role === 'staff')
                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show')">
                                {{ __('Đơn hàng') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.orders.picklist')" :active="request()->routeIs('admin.orders.picklist')">
                                {{ __('Gom Hàng') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                {{ __('Danh mục') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                                {{ __('Sản phẩm') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Auth Buttons (Góc phải Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-5">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest2 text-white hover:text-accent focus:outline-none transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
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
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest2 text-white hover:text-accent transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span>Đăng nhập</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn-accent !px-4 !py-2">
                        Đăng ký
                    </a>
                @endauth

                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center text-white hover:text-accent transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
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
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-white hover:opacity-60 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-neutral-800">
        <div class="pt-2 pb-3 space-y-1">
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

        <div class="pt-4 pb-3 border-t border-neutral-800 px-4">
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
                <div class="py-2 space-y-3">
                    <a href="{{ route('login') }}" class="block text-xs font-semibold uppercase tracking-widest2 text-white py-1">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="block text-xs font-semibold uppercase tracking-widest2 text-white py-1">Đăng ký</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
