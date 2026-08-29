<nav x-data="{ open: false }" class="bg-white border-b border-pink-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-pink-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Nút Cửa Hàng -->
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Cửa Hàng') }}
                    </x-nav-link>

                    <!-- Giỏ Hàng: Chỉ hiện với Khách chưa đăng nhập hoặc Khách hàng (Customer) -->
                    @if(!Auth::check() || Auth::user()->role === 'customer')
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                            🛒 {{ __('Giỏ Hàng') }} ({{ count(session('cart', [])) }})
                        </x-nav-link>
                    @endif

                    @auth
                        <!-- 0. Menu Khách Hàng (Customer): Lịch sử đơn hàng -->
                        @if(Auth::user()->role === 'customer')
                            <x-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')" class="text-pink-600 font-bold">
                                📑 {{ __('Đơn Hàng Của Tôi') }}
                            </x-nav-link>
                        @endif

                        <!-- 1. Menu Quản trị Hệ Thống (Sysadmin) -->
                        @if(Auth::user()->role === 'sysadmin')
                            <x-nav-link :href="route('sysadmin.users.index')" :active="request()->routeIs('sysadmin.users.*')" class="text-purple-600 font-bold">
                                👥 {{ __('Quản lý User') }}
                            </x-nav-link>
                            <x-nav-link :href="route('sysadmin.logs.index')" :active="request()->routeIs('sysadmin.logs.*')" class="text-purple-600 font-bold">
                                📜 {{ __('Nhật ký Đăng nhập') }}
                            </x-nav-link>
                        @endif

                        <!-- 2. Menu Chủ Shop (Owner): Báo cáo + Danh mục + Sản phẩm -->
                        @if(Auth::user()->role === 'owner')
                            <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.*')" class="text-emerald-600 font-bold">
                                📊 {{ __('Báo Cáo Doanh Thu') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="text-pink-600 font-bold">
                                🏷️ {{ __('Quản lý Danh mục') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="text-pink-600 font-bold">
                                📦 {{ __('Quản lý Sản phẩm') }}
                            </x-nav-link>
                        @endif

                        <!-- 3. Menu Nhân Viên (Staff) -->
                        @if(Auth::user()->role === 'staff')
                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show')" class="text-pink-600 font-bold">
                                📋 {{ __('Quản lý Đơn hàng') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.orders.picklist')" :active="request()->routeIs('admin.orders.picklist')" class="text-pink-600 font-bold">
                                📦 {{ __('Danh Sách Gom Hàng') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" class="text-pink-600 font-bold">
                                🏷️ {{ __('Quản lý Danh mục') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="text-pink-600 font-bold">
                                🛍️ {{ __('Quản lý Sản phẩm') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Auth Buttons (Góc phải Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Đã đăng nhập: Hiện tên & Dropdown menu -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-pink-700 bg-pink-50 hover:text-pink-900 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Link Xem đơn hàng nếu là Customer -->
                            @if(Auth::user()->role === 'customer')
                                <x-dropdown-link :href="route('order.history')">
                                    📑 {{ __('Đơn hàng của tôi') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Hồ sơ cá nhân') }}
                            </x-dropdown-link>

                            <!-- Đăng xuất -->
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
                    <!-- Chưa đăng nhập: Hiện 2 nút Đăng nhập / Đăng ký -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-pink-600 hover:text-pink-800 transition">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-bold bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl shadow-sm transition">
                            Đăng ký
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-pink-400 hover:text-pink-500 hover:bg-pink-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Cửa Hàng') }}
            </x-responsive-nav-link>
            
            @if(!Auth::check() || Auth::user()->role === 'customer')
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                    🛒 {{ __('Giỏ Hàng') }} ({{ count(session('cart', [])) }})
                </x-responsive-nav-link>
            @endif

            @auth
                @if(Auth::user()->role === 'customer')
                    <x-responsive-nav-link :href="route('order.history')" :active="request()->routeIs('order.history')">
                        📑 {{ __('Đơn Hàng Của Tôi') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-pink-100 px-4">
            @auth
                <div class="font-medium text-base text-pink-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-pink-500">{{ Auth::user()->email }}</div>

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
                <div class="py-2 space-y-2">
                    <a href="{{ route('login') }}" class="block font-bold text-pink-600 py-1">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="block font-bold text-pink-600 py-1">Đăng ký</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
