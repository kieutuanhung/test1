<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            div.au-wrap{
                background:
                    radial-gradient(900px 420px at 12% -8%, rgba(224,57,44,.18), transparent 60%),
                    radial-gradient(800px 420px at 95% 0%, rgba(245,158,11,.13), transparent 60%),
                    #151519;
            }

            /* Logo */
            .au-logo{display:flex;flex-direction:column;align-items:center;gap:.7rem;margin-bottom:1.5rem;text-decoration:none;}
            .au-logo-img{display:block;height:72px;width:auto;transition:transform .3s;}
            .au-logo:hover .au-logo-img{transform:scale(1.05);}
            .au-logo-mark{width:58px;height:58px;border-radius:9999px;background:linear-gradient(135deg,#e0392c,#f26a2e);display:flex;align-items:center;justify-content:center;color:#fff;font-family:Georgia,'Times New Roman',serif;font-weight:700;font-size:27px;box-shadow:0 10px 30px rgba(224,57,44,.35);}
            .au-logo-text{font-size:13px;font-weight:800;letter-spacing:.3em;text-transform:uppercase;color:#fff;}

            /* Thẻ */
            .au-card{width:100%;max-width:440px;background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:20px;padding:2rem;box-shadow:0 24px 60px rgba(0,0,0,.45);}
            .au-eyebrow{margin:0;font-size:11px;font-weight:700;letter-spacing:.25em;text-transform:uppercase;color:#e0392c;}
            .au-title{margin:.35rem 0 0;font-size:24px;font-weight:900;text-transform:uppercase;letter-spacing:.03em;color:#fff;}
            .au-sub{margin:.6rem 0 0;font-size:14px;line-height:1.6;color:#a8a8b3;}
            .au-head{margin-bottom:1.5rem;}

            /* Nhãn và ô nhập */
            .au-card label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;margin-bottom:.4rem;}
            .au-card input[type="text"],
            .au-card input[type="email"],
            .au-card input[type="password"]{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.75rem 1.1rem;font-size:.9rem;color:#fff;box-shadow:none;transition:border-color .15s, box-shadow .15s;}
            .au-card input::placeholder{color:#8a8a96;}
            .au-card input[type="text"]:focus,
            .au-card input[type="email"]:focus,
            .au-card input[type="password"]:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}

            /* Sửa màu xanh nhạt do trình duyệt tự điền */
            .au-card input:-webkit-autofill,
            .au-card input:-webkit-autofill:hover,
            .au-card input:-webkit-autofill:focus{
                -webkit-box-shadow:0 0 0 1000px #16161b inset !important;
                -webkit-text-fill-color:#fff !important;
                caret-color:#fff;
                border:1px solid #3a3a45;
                transition:background-color 9999s ease-in-out 0s;
            }

            /* Ô tích */
            .au-card label.au-check{display:inline-flex;align-items:center;gap:.6rem;margin:0;cursor:pointer;color:#b8b8c2;font-size:12px;font-weight:600;letter-spacing:.04em;text-transform:none;}
            .au-card input[type="checkbox"]{appearance:none;-webkit-appearance:none;width:18px;height:18px;border-radius:5px;border:1px solid #3a3a45;background-color:#16161b;background-image:none;cursor:pointer;display:inline-block;position:relative;padding:0;margin:0;flex-shrink:0;box-shadow:none;transition:all .15s;}
            .au-card input[type="checkbox"]:hover{border-color:#e0392c;}
            .au-card input[type="checkbox"]:checked{background:linear-gradient(135deg,#e0392c,#f26a2e);border-color:#e0392c;}
            .au-card input[type="checkbox"]:checked::after{content:"";position:absolute;left:5px;top:1px;width:5px;height:10px;border:solid #fff;border-width:0 2px 2px 0;transform:rotate(45deg);}
            .au-card input[type="checkbox"]:focus{outline:none;box-shadow:0 0 0 2px rgba(224,57,44,.35);}

            /* Nút và liên kết */
            .au-btn{display:block;width:100%;text-align:center;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;padding:.9rem 1.4rem;border-radius:999px;border:0;cursor:pointer;transition:transform .15s, filter .15s;}
            .au-btn:hover{filter:brightness(1.1);transform:translateY(-1px);}
            .au-link{font-size:12px;font-weight:600;color:#b8b8c2;text-decoration:none;background:none;border:0;cursor:pointer;padding:0;transition:color .15s;}
            .au-link:hover{color:#fff;}
            .au-link-accent{font-weight:700;color:#fbbf24;text-decoration:none;transition:filter .15s;}
            .au-link-accent:hover{filter:brightness(1.15);}
            .au-row{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;}
            .au-alt{margin:1.5rem 0 0;text-align:center;font-size:13px;color:#8a8a96;}

            /* Thông báo */
            .au-ok{color:#6ee7b7;background-color:#34d3991a;border:1px solid #34d39966;border-radius:12px;padding:.7rem 1rem;font-size:13px;margin-bottom:1rem;}
            .au-card .text-red-600,
            .au-card .text-red-400,
            .au-card .text-red-500{color:#fca5a5 !important;}
            .au-card .text-green-600{color:#6ee7b7 !important;}

            .au-foot{margin:1.5rem 0 0;font-size:11px;color:#6b6b76;letter-spacing:.05em;}
        </style>
    </head>
    <body class="font-sans text-white antialiased">
        <div class="au-wrap min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-ink">
            <a href="/" class="au-logo">
                <img src="{{ asset('images/logo-ha.svg') }}" alt="{{ config('app.name', 'Shop') }}" class="au-logo-img">
            </a>

            <div class="au-card">
                @if(isset($title) || isset($eyebrow) || isset($subtitle))
                    <div class="au-head">
                        @isset($eyebrow)
                            <p class="au-eyebrow">{{ $eyebrow }}</p>
                        @endisset
                        @isset($title)
                            <h1 class="au-title">{{ $title }}</h1>
                        @endisset
                        @isset($subtitle)
                            <p class="au-sub">{{ $subtitle }}</p>
                        @endisset
                    </div>
                @endif

                {{ $slot }}
            </div>

            <p class="au-foot">&copy; {{ date('Y') }} {{ config('app.name', 'Shop') }}</p>
        </div>
    </body>
</html>
