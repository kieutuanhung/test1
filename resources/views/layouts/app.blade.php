<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-ink">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-ink border-b border-neutral-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <style>
                .ft{border-top:2px solid var(--tw-accent, #e0392c);background:#0f1012;margin-top:4rem;font-family:"Inter",system-ui,sans-serif;}
                .ft-in{max-width:80rem;margin:0 auto;padding:3.5rem 1.5rem 2rem;display:grid;grid-template-columns:1fr 1fr;gap:3rem;}
                .ft h3{margin:0 0 1.25rem;font-size:13px;font-weight:600;letter-spacing:.08em;color:#fff;}
                .ft p{margin:0 0 1.25rem;font-size:14px;line-height:1.7;color:#9a9ca3;}
                .ft ul{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:.5rem;}
                .ft-link{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.85rem 1rem;border:1px solid #26272b;border-radius:10px;font-size:14px;color:#e4e4e7;text-decoration:none;transition:border-color .15s,color .15s,background .15s;}
                .ft-link small{font-size:13px;color:#9a9ca3;transition:color .15s;}
                .ft-link:hover{border-color:#e0392c;color:#fff;background:rgba(224,57,44,.08);}
                .ft-link:hover small{color:#fff;}
                .ft-link:focus-visible{outline:2px solid #e0392c;outline-offset:2px;}
                .ft-bottom{max-width:80rem;margin:0 auto;padding:1.5rem;border-top:1px solid #26272b;display:flex;flex-direction:column;align-items:center;gap:1rem;}
                .ft-bottom img{height:2.5rem;width:auto;}
                .ft-bottom span{font-size:12px;color:#7b7d85;letter-spacing:.03em;}
                @media (max-width:700px){.ft-in{grid-template-columns:1fr;gap:2.25rem;padding-top:2.5rem;}}
            </style>
            <footer class="ft">
                <div class="ft-in">

                    <section>
                        <h3>HỖ TRỢ</h3>
                        <p>Cần giúp đỡ về đơn hàng hay sản phẩm? Chọn cách liên hệ thuận tiện nhất với bạn.</p>
                        <ul>
                            <li><a class="ft-link" href="tel:0978462050">Gọi hotline <small>0978 462 050</small></a></li>
                            <li><a class="ft-link" href="https://zalo.me/0978462050" target="_blank" rel="noopener">Nhắn tin qua Zalo <small>Zalo</small></a></li>
                            <li><a class="ft-link" href="mailto:kieutuanhungnh@gmail.com?subject=Hỗ trợ khách hàng">Gửi email hỗ trợ <small>Email</small></a></li>
                        </ul>
                    </section>

                    <section>
                        <h3>LIÊN HỆ</h3>
                        <p>Thông tin liên hệ trực tiếp của cửa hàng.</p>
                        <ul>
                            <li><a class="ft-link" href="tel:0978462050">Điện thoại <small>0978 462 050</small></a></li>
                            <li><a class="ft-link" href="mailto:kieutuanhungnh@gmail.com">Email <small>kieutuanhungnh@gmail.com</small></a></li>
                        </ul>
                    </section>

                </div>

                <div class="ft-bottom">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo-ha.svg') }}" alt="{{ config('app.name', 'Shop') }}">
                    </a>
                    <span>&copy; {{ date('Y') }} {{ config('app.name', 'Shop') }}. All rights reserved.</span>
                </div>
            </footer>
        </div>
       <script src="{{ asset('js/cart-ajax.js') }}"></script>
       @include('components.chatbot-widget')
    </body>
</html>
