@php
    $navUser = Auth::user();
    $navRole = $navUser->role ?? null;
    $navGuest = !$navUser;

    // Danh sách link chính theo vai trò (dùng chung cho menu desktop và menu mobile)
    $navLinks = [];

    if ($navGuest || in_array($navRole, ['customer', 'owner', 'staff'])) {
        $navLinks[] = ['label' => 'Trang Chủ', 'url' => route('home'),
            'active' => request()->routeIs('home') && !request('category') && !request('sort') && !request('view')];
        $navLinks[] = ['label' => 'Tất Cả Sản Phẩm', 'url' => route('home', ['view' => 'all']),
            'active' => request('view') === 'all'];
    }

    if ($navGuest || $navRole === 'customer') {
        $navLinks[] = ['label' => 'Best Seller', 'url' => route('home', ['sort' => 'bestseller']),
            'active' => request('sort') === 'bestseller'];
        $navLinks[] = ['label' => 'New Arrival', 'url' => route('home', ['sort' => 'new']),
            'active' => request('sort') === 'new'];
    }

    if ($navRole === 'customer') {
        $navLinks[] = ['label' => 'Đơn Hàng Của Tôi', 'url' => route('order.history'),
            'active' => request()->routeIs('order.history')];
    }

    if ($navRole === 'sysadmin') {
        $navLinks[] = ['label' => 'Quản lý User', 'url' => route('sysadmin.users.index'),
            'active' => request()->routeIs('sysadmin.users.*')];
        $navLinks[] = ['label' => 'Nhật ký Đăng nhập', 'url' => route('sysadmin.logs.index'),
            'active' => request()->routeIs('sysadmin.logs.*')];
    }

    if ($navRole === 'owner') {
        $navLinks[] = ['label' => 'Báo Cáo Doanh Thu', 'url' => route('owner.dashboard'),
            'active' => request()->routeIs('owner.*')];
        $navLinks[] = ['label' => 'Danh mục', 'url' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*')];
        $navLinks[] = ['label' => 'Sản phẩm', 'url' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*')];
    }

    if ($navRole === 'staff') {
        $navLinks[] = ['label' => 'Đơn hàng', 'url' => route('admin.orders.index'),
            'active' => request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show')];
        $navLinks[] = ['label' => 'Gom Hàng', 'url' => route('admin.orders.picklist'),
            'active' => request()->routeIs('admin.orders.picklist')];
        $navLinks[] = ['label' => 'Danh mục', 'url' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*')];
        $navLinks[] = ['label' => 'Sản phẩm', 'url' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*')];
    }

    $cartCount = count(session('cart', []));
@endphp

<style>
    /* ===== Thanh điều hướng ===== */
    .nv-bar{background-color:rgba(18,18,22,.88);-webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);border-bottom:1px solid #2e2e37;transition:box-shadow .25s;}
    .nv-bar.is-scrolled{box-shadow:0 10px 30px rgba(0,0,0,.45);background-color:rgba(14,14,18,.94);}
    .nv-row{display:flex;justify-content:space-between;align-items:center;height:72px;position:relative;transition:height .25s;}
    .nv-bar.is-scrolled .nv-row{height:60px;}

    .nv-icon-btn{width:40px;height:40px;border-radius:9999px;display:inline-flex;align-items:center;justify-content:center;color:#fff;border:1px solid transparent;transition:all .15s;background:transparent;cursor:pointer;}
    .nv-icon-btn:hover{background:rgba(255,255,255,.08);border-color:#2e2e37;}
    .nv-badge{position:absolute;top:-4px;right:-6px;min-width:18px;height:18px;padding:0 4px;border-radius:9999px;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;box-shadow:0 0 0 2px #121216;transition:transform .2s;}
    .nv-icon-btn:hover .nv-badge{transform:scale(1.12);}

    /* Logo: mobile căn giữa tuyệt đối, desktop (>=1280px) nằm bên trái */
    .nv-logo{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);z-index:10;}
    .nv-logo a{display:flex;align-items:center;gap:.5rem;}
    .nv-logo-dot{width:7px;height:7px;border-radius:9999px;background:linear-gradient(135deg,#e0392c,#f26a2e);box-shadow:0 0 0 0 rgba(224,57,44,.6);transition:box-shadow .3s;}
    .nv-logo a:hover .nv-logo-dot{box-shadow:0 0 0 5px rgba(224,57,44,.22);}
    .nv-logo-text{font-weight:300;letter-spacing:.2em;font-size:1.5rem;line-height:1;text-transform:uppercase;color:#fff;}

    /* Link desktop */
    .nv-desktop-links{display:none;}
    .nv-top-link{position:relative;padding:.5rem .15rem;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:#a8a8b3;white-space:nowrap;transition:color .15s;}
    .nv-top-link::after{content:"";position:absolute;left:0;right:0;bottom:-2px;height:2px;border-radius:2px;background:linear-gradient(90deg,#e0392c,#f26a2e);transform:scaleX(0);transform-origin:left;transition:transform .25s ease;}
    .nv-top-link:hover{color:#fff;}
    .nv-top-link:hover::after{transform:scaleX(1);}
    .nv-top-link.is-active{color:#fff;}
    .nv-top-link.is-active::after{transform:scaleX(1);}

    /* Nút tài khoản */
    .nv-user-btn{display:inline-flex;align-items:center;gap:.5rem;color:#fff;padding:.3rem .6rem .3rem .35rem;border-radius:9999px;border:1px solid #2e2e37;transition:all .15s;background:rgba(255,255,255,.03);cursor:pointer;}
    .nv-user-btn:hover{background:rgba(255,255,255,.08);border-color:#4a4a57;}
    .nv-user-btn .nv-chev{width:14px;height:14px;color:#8a8a96;transition:transform .2s;}
    .nv-user-btn[aria-expanded="true"] .nv-chev{transform:rotate(180deg);}
    .nv-user-name{display:none;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    @media (min-width:640px) and (max-width:1279px){.nv-user-name{display:inline;}}
    @media (min-width:1536px){.nv-user-name{display:inline;}}
    .nv-avatar{width:28px;height:28px;border-radius:9999px;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;flex-shrink:0;}
    .nv-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:.55rem 1.1rem;border-radius:9999px;transition:transform .15s, filter .15s;}
    .nv-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
    .nv-btn-ghost{display:inline-block;border:1px solid #3a3a45;color:#d4d4dc;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:.55rem 1.1rem;border-radius:9999px;transition:all .15s;}
    .nv-btn-ghost:hover{border-color:#fff;color:#fff;}

    /* Desktop >= 1280px: hiện link ngang, ẩn hamburger + menu mở ra */
    @media (min-width:1280px){
        .nv-burger{display:none !important;}
        .nv-panel{display:none !important;}
        .nv-logo{position:static;transform:none;margin-right:2rem;}
        .nv-desktop-links{display:flex;align-items:center;gap:1.6rem;flex:1;}
    }

    /* ===== Menu mở ra (mobile / tablet) ===== */
    .nv-panel{
        border-top:1px solid #26262e;
        background:
            radial-gradient(700px 260px at 8% 0%, rgba(224,57,44,.09), transparent 65%),
            radial-gradient(600px 260px at 95% 0%, rgba(245,158,11,.05), transparent 65%),
            linear-gradient(180deg, rgba(19,19,23,.99), rgba(13,13,16,.99));
        -webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);
        box-shadow:0 24px 50px rgba(0,0,0,.5);
        max-height:calc(100vh - 7rem);overflow-y:auto;
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

    /* ===== Dropdown tài khoản ===== */
    .nv-dd{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:14px;padding:.4rem;box-shadow:0 18px 40px rgba(0,0,0,.5);}
    .nv-dd-head{display:flex;align-items:center;gap:.7rem;padding:.7rem .8rem;border-bottom:1px solid #2e2e37;margin-bottom:.3rem;}
    .nv-dd-link{display:flex;align-items:center;gap:.6rem;width:100%;text-align:left;padding:.6rem .8rem;border-radius:8px;font-size:13px;font-weight:600;color:#d4d4dc;background:transparent;border:0;cursor:pointer;transition:all .15s;}
    .nv-dd-link:hover{background:rgba(255,255,255,.07);color:#fff;}
    .nv-dd-danger{color:#fca5a5;}
    .nv-dd-danger:hover{background:rgba(248,113,113,.14);color:#fff;}
</style>

<nav x-data="{ open: false, scrolled: false }"
     @keydown.escape.window="open = false"
     @scroll.window="scrolled = window.scrollY > 10"
     :class="{ 'is-scrolled': scrolled }"
     class="nv-bar sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="nv-row">

            <!-- Hamburger (chỉ hiện dưới 1280px) -->
            <button @click="open = ! open" class="nv-icon-btn nv-burger focus:outline-none" style="z-index:20;" :aria-expanded="open.toString()" aria-label="Mở menu">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Logo -->
            <div class="nv-logo">
                <a href="{{ route('home') }}">
                    <span class="nv-logo-dot"></span>
                    <span class="nv-logo-text">{{ config('app.name', 'Shop') }}</span>
                </a>
            </div>

            <!-- Link ngang (desktop) -->
            <nav class="nv-desktop-links" aria-label="Menu chính">
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="nv-top-link {{ $link['active'] ? 'is-active' : '' }}">{{ __($link['label']) }}</a>
                @endforeach
            </nav>

            <!-- Bên phải: Tài khoản + Giỏ hàng -->
            <div class="flex items-center gap-2 sm:gap-3" style="z-index:20;">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="nv-user-btn focus:outline-none" title="{{ Auth::user()->name }}">
                                <span class="nv-avatar">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                                <span class="nv-user-name text-xs font-semibold uppercase tracking-wide">{{ Auth::user()->name }}</span>
                                <svg class="nv-chev" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="nv-dd">
                                <div class="nv-dd-head">
                                    <span class="nv-avatar" style="width:34px;height:34px;font-size:13px;">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                                    <div style="min-width:0;">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-white truncate">{{ Auth::user()->name }}</p>
                                        <p class="truncate" style="font-size:11px;color:#8a8a96;margin:2px 0 0;">{{ Auth::user()->email }}</p>
                                    </div>
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
                        @if($cartCount > 0)
                            <span class="nv-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Menu đầy đủ (mở bằng hamburger, dưới 1280px) -->
    <div x-show="open" x-transition @click.away="open = false" class="nv-panel" style="display:none;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="nv-grid">
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="nv-link {{ $link['active'] ? 'is-active' : '' }}">{{ __($link['label']) }}</a>
                @endforeach
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
