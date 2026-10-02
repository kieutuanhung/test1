<style>
    /* Thanh điều hướng */
    .nv-bar{background-color:rgba(18,18,22,.92);-webkit-backdrop-filter:blur(12px);backdrop-filter:blur(12px);border-bottom:1px solid #2e2e37;}
    .nv-icon-btn{width:40px;height:40px;border-radius:9999px;display:inline-flex;align-items:center;justify-content:center;color:#fff;border:1px solid transparent;transition:all .15s;background:transparent;cursor:pointer;}
    .nv-icon-btn:hover{background:rgba(255,255,255,.08);border-color:#2e2e37;}
    .nv-badge{position:absolute;top:-6px;right:-8px;min-width:18px;height:18px;padding:0 4px;border-radius:9999px;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;box-shadow:0 0 0 2px #121216;}
    .nv-user-btn{display:inline-flex;align-items:center;gap:.5rem;color:#fff;padding:.35rem .8rem .35rem .45rem;border-radius:9999px;border:1px solid transparent;transition:all .15s;background:transparent;cursor:pointer;}
    .nv-user-btn:hover{background:rgba(255,255,255,.07);border-color:#2e2e37;}
    .nv-user-name{display:none;}
    @media (min-width:640px){.nv-user-name{display:inline;}}
    .nv-avatar{width:28px;height:28px;border-radius:9999px;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;flex-shrink:0;}
    .nv-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:.55rem 1.1rem;border-radius:9999px;transition:transform .15s, filter .15s;}
    .nv-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
    .nv-btn-ghost{display:inline-block;border:1px solid #3a3a45;color:#d4d4dc;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:.55rem 1.1rem;border-radius:9999px;transition:all .15s;}
    .nv-btn-ghost:hover{border-color:#fff;color:#fff;}

    /* Menu mở ra */
    .nv-panel{
        border-top:1px solid #26262e;
        background:
            radial-gradient(700px 260px at 8% 0%, rgba(224,57,44,.09), transparent 65%),
            radial-gradient(600px 260px at 95% 0%, rgba(245,158,11,.05), transparent 65%),
            linear-gradient(180deg, rgba(19,19,23,.99), rgba(13,13,16,.99));
        -webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);
        box-shadow:0 24px 50px rgba(0,0,0,.5);
        max-height:calc(100vh - 8rem);overflow-y:auto;
    }
    .nv-grid{display:flex;flex-direction:column;gap:.35rem;}
    .nv-link{display:flex;align-items:center;gap:.8rem;padding:.8rem 1rem;border-radius:12px;font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:#d4d4dc;border:1px solid transparent;transition:all .15s;background:transparent;cursor:pointer;text-align:left;width:100%;}
    .nv-link::before{content:"";width:6px;height:6px;border-radius:9999px;background:#3a3a45;flex-shrink:0;transition:background .15s;}
    .nv-link:hover{background:rgba(255,255,255,.06);color:#fff;}
    .nv-link:hover::before{background:#e0392c;}
    .nv-link.is-active{color:#fff;background:linear-gradient(90deg,rgba(224,57,44,.20),rgba(224,57,44,.04));border-color:rgba(224,57,44,.45);}
    .nv-link.is-active::before{background:linear-gradient(135deg,#e0392c,#f26a2e);}
    .nv-link-icon::before{display:none;}
    .nv-link-icon svg{width:18px;height:18px;flex-shrink:0;color:#a8a8b3;}
    .nv-link-icon:hover svg{color:#fff;}
    .nv-danger{color:#fca5a5;}
    .nv-danger svg{color:#fca5a5 !important;}
    .nv-danger:hover{background:rgba(248,113,113,.14);color:#fff;border-color:rgba(248,113,113,.4);}
    .nv-account{display:flex;align-items:center;gap:.85rem;padding:.9rem 1rem;border-radius:14px;border:1px solid #26262e;background:linear-gradient(180deg,#18181d,#121216);margin-bottom:.75rem;}
    .nv-account .nv-avatar{width:40px;height:40px;font-size:15px;}
    .nv-divider{border-top:1px solid #26262e;}

    /* Menu tài khoản (dropdown) */
    .nv-dd{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:12px;padding:.4rem;}
    .nv-dd-head{padding:.6rem .8rem;border-bottom:1px solid #2e2e37;margin-bottom:.3rem;}
    .nv-dd-link{display:block;width:100%;text-align:left;padding:.6rem .8rem;border-radius:8px;font-size:13px;font-weight:600;color:#d4d4dc;background:transparent;border:0;cursor:pointer;transition:all .15s;}
    .nv-dd-link:hover{background:rgba(255,255,255,.07);color:#fff;}
    .nv-dd-danger{color:#fca5a5;}
    .nv-dd-danger:hover{background:rgba(248,113,113,.14);color:#fff;}
</style>

<!-- Thanh thông báo khuyến mãi -->
<div class="bg-white text-ink text-center py-2.5 px-4">
    <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-widest2">
        Freeship cho đơn từ 500.000đ &nbsp;&bull;&nbsp; Đổi trả trong 14 ngày
    </p>
</div>

<nav x-data="{ open: false }" @keydown.escape.window="open = false" class="nv-bar sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20" style="position:relative;">

            <!-- Nút Hamburger: luôn hiện, mở menu chứa toàn bộ link -->
            <button @click="open = ! open" class="nv-icon-btn focus:outline-none" style="z-index:20;" :aria-expanded="open.toString()" aria-label="Mở menu">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Logo: đặt tuyệt đối ở chính giữa thanh nav -->
            <div style="position:absolute; left:50%; top:50%; transform:translate(-50%, -50%); z-index:10;">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:linear-gradient(135deg,#e0392c,#f26a2e);"></span>
                    <span style="font-weight:300; letter-spacing:.15em;" class="text-2xl uppercase text-white">{{ config('app.name', 'Shop') }}</span>
                </a>
            </div>

            <!-- Icon bên phải: Tài khoản + Giỏ hàng -->
            <div class="flex items-center gap-2 sm:gap-3" style="z-index:20;">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="nv-user-btn focus:outline-none" title="{{ Auth::user()->name }}">
                                <span class="nv-avatar">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                                <span class="nv-user-name text-xs font-semibold uppercase tracking-wide">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="nv-dd">
                                <div class="nv-dd-head">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-white truncate">{{ Auth::user()->name }}</p>
                                </div>

                                @if(Auth::user()->role === 'customer')
                                    <a href="{{ route('order.history') }}" class="nv-dd-link">{{ __('Đơn hàng của tôi') }}</a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="nv-dd-link">{{ __('Hồ sơ cá nhân') }}</a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nv-dd-link nv-dd-danger">{{ __('Đăng xuất') }}</button>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold uppercase tracking-wide text-white hover:text-accent transition px-2">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="nv-btn-red">
                        Đăng ký
                    </a>
                @endif

                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <a href="{{ route('cart.index') }}" class="nv-icon-btn relative" title="Giỏ hàng">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.684 2.568-7.135.106-.44-.243-.865-.696-.865H5.106M7.5 14.25L5.106 5.272M7.5 14.25L5.25 18.75m0 0h15" />
                        </svg>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="nv-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Menu đầy đủ (mở ra khi bấm Hamburger, dùng cho mọi kích thước màn hình) -->
    <div x-show="open" x-transition @click.away="open = false" class="nv-panel" style="display:none;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="nv-grid">
                @if(!Auth::check() || in_array(Auth::user()->role, ['customer', 'owner', 'staff']))
                    <a href="{{ route('home') }}" class="nv-link {{ request()->routeIs('home') && !request('category') && !request('sort') && !request('view') ? 'is-active' : '' }}">
                        {{ __('Trang Chủ') }}
                    </a>

                    <a href="{{ route('home', ['view' => 'all']) }}" class="nv-link {{ request('view') === 'all' ? 'is-active' : '' }}">
                        {{ __('Tất Cả Sản Phẩm') }}
                    </a>
                @endif

                @if(!Auth::check() || Auth::user()->role === 'customer')
                    <a href="{{ route('home', ['sort' => 'bestseller']) }}" class="nv-link {{ request('sort') === 'bestseller' ? 'is-active' : '' }}">
                        {{ __('Best Seller') }}
                    </a>
                    <a href="{{ route('home', ['sort' => 'new']) }}" class="nv-link {{ request('sort') === 'new' ? 'is-active' : '' }}">
                        {{ __('New Arrival') }}
                    </a>
                @endif

                @auth
                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('order.history') }}" class="nv-link {{ request()->routeIs('order.history') ? 'is-active' : '' }}">
                            {{ __('Đơn Hàng Của Tôi') }}
                        </a>
                    @endif

                    @if(Auth::user()->role === 'sysadmin')
                        <a href="{{ route('sysadmin.users.index') }}" class="nv-link {{ request()->routeIs('sysadmin.users.*') ? 'is-active' : '' }}">
                            {{ __('Quản lý User') }}
                        </a>
                        <a href="{{ route('sysadmin.logs.index') }}" class="nv-link {{ request()->routeIs('sysadmin.logs.*') ? 'is-active' : '' }}">
                            {{ __('Nhật ký Đăng nhập') }}
                        </a>
                    @endif

                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="nv-link {{ request()->routeIs('owner.*') ? 'is-active' : '' }}">
                            {{ __('Báo Cáo Doanh Thu') }}
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nv-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                            {{ __('Danh mục') }}
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nv-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
                            {{ __('Sản phẩm') }}
                        </a>
                    @endif

                    @if(Auth::user()->role === 'staff')
                        <a href="{{ route('admin.orders.index') }}" class="nv-link {{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') ? 'is-active' : '' }}">
                            {{ __('Đơn hàng') }}
                        </a>
                        <a href="{{ route('admin.orders.picklist') }}" class="nv-link {{ request()->routeIs('admin.orders.picklist') ? 'is-active' : '' }}">
                            {{ __('Gom Hàng') }}
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nv-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                            {{ __('Danh mục') }}
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nv-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
                            {{ __('Sản phẩm') }}
                        </a>
                    @endif
                @endauth
            </div>

            <div class="nv-divider" style="margin-top:1rem; padding-top:1rem;">
                @auth
                    <div class="nv-account">
                        <span class="nv-avatar">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                        <div style="min-width:0;">
                            <div class="font-semibold text-sm uppercase tracking-wide text-white truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs truncate" style="color:#a8a8b3;">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="nv-grid">
                        <a href="{{ route('profile.edit') }}" class="nv-link nv-link-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z"/></svg>
                            {{ __('Hồ sơ cá nhân') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="nv-link nv-link-icon nv-danger">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                                {{ __('Đăng xuất') }}
                            </button>
                        </form>
                    </div>
                @else
                    <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
                        <a href="{{ route('login') }}" class="nv-btn-ghost">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="nv-btn-red">Đăng ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
