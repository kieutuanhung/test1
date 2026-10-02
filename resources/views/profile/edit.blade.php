<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Tài khoản</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Hồ sơ của tôi') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <style>
        div.pf-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .pf-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;padding:1.75rem;}
        .pf-card-danger{border-color:rgba(248,113,113,.30);}
        .pf-head{padding-bottom:1rem;margin-bottom:1.25rem;border-bottom:1px solid #2e2e37;}
        .pf-title{margin:0;font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:.14em;color:#fff;}
        .pf-desc{margin:.4rem 0 0;font-size:13px;line-height:1.55;color:#a8a8b3;}

        /* Nhãn và ô nhập (cả trong thẻ lẫn hộp xác nhận xóa) */
        .pf-card label,.pf-modal label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;margin-bottom:.4rem;}
        .pf-card input[type="text"],.pf-card input[type="email"],.pf-card input[type="password"],
        .pf-modal input[type="text"],.pf-modal input[type="email"],.pf-modal input[type="password"]{
            width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.7rem 1.1rem;font-size:.9rem;color:#fff;box-shadow:none;transition:border-color .15s, box-shadow .15s;}
        .pf-card input::placeholder,.pf-modal input::placeholder{color:#8a8a96;}
        .pf-card input[type="text"]:focus,.pf-card input[type="email"]:focus,.pf-card input[type="password"]:focus,
        .pf-modal input[type="text"]:focus,.pf-modal input[type="email"]:focus,.pf-modal input[type="password"]:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}

        /* Sửa màu xanh nhạt do trình duyệt tự điền */
        .pf-card input:-webkit-autofill,.pf-card input:-webkit-autofill:hover,.pf-card input:-webkit-autofill:focus,
        .pf-modal input:-webkit-autofill,.pf-modal input:-webkit-autofill:hover,.pf-modal input:-webkit-autofill:focus{
            -webkit-box-shadow:0 0 0 1000px #16161b inset !important;
            -webkit-text-fill-color:#fff !important;
            caret-color:#fff;
            border:1px solid #3a3a45;
            transition:background-color 9999s ease-in-out 0s;
        }

        /* Nút */
        .pf-btn,.pf-btn-ghost,.pf-btn-danger,.pf-btn-danger-solid{display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.8rem 1.6rem;border-radius:999px;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s, all .15s;}
        .pf-btn{background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;border:0;}
        .pf-btn:hover{filter:brightness(1.1);transform:translateY(-1px);}
        .pf-btn-ghost{background:transparent;border:1px solid #3a3a45;color:#b8b8c2;}
        .pf-btn-ghost:hover{border-color:#fff;color:#fff;}
        .pf-btn-danger{border:1px solid rgba(248,113,113,.45);color:#fca5a5;background:rgba(248,113,113,.10);}
        .pf-btn-danger:hover{background:rgba(248,113,113,.22);border-color:#f87171;color:#fff;}
        .pf-btn-danger-solid{background:linear-gradient(135deg,#dc2626,#b91c1c);color:#fff;border:0;}
        .pf-btn-danger-solid:hover{filter:brightness(1.12);transform:translateY(-1px);}
        .pf-link{font-size:12px;font-weight:700;color:#fbbf24;background:none;border:0;padding:0;cursor:pointer;text-decoration:underline;text-underline-offset:3px;}
        .pf-link:hover{filter:brightness(1.15);}
        .pf-saved{display:inline-flex;align-items:center;gap:.4rem;color:#6ee7b7;background-color:#34d3991a;border:1px solid #34d39966;border-radius:999px;padding:.3rem .85rem;font-size:12px;font-weight:700;}

        /* Thông báo lỗi */
        .pf-card .text-red-600,.pf-card .text-red-400,.pf-card .text-red-500,
        .pf-modal .text-red-600,.pf-modal .text-red-400,.pf-modal .text-red-500{color:#fca5a5 !important;}
    </style>

    <div class="py-6 bg-ink min-h-screen pf-wrap">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(min(100%,340px),1fr)); gap:1.25rem; align-items:start;">
                <div class="pf-card">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="pf-card">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="pf-card pf-card-danger">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
