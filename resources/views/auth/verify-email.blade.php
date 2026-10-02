<x-guest-layout>
    <x-slot name="eyebrow">Tài khoản</x-slot>
    <x-slot name="title">Xác minh email</x-slot>
    <x-slot name="subtitle">Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác minh địa chỉ email bằng cách bấm vào liên kết chúng tôi vừa gửi. Nếu chưa nhận được email, chúng tôi sẽ gửi lại cho bạn.</x-slot>

    @if (session('status') == 'verification-link-sent')
        <div class="au-ok">
            ✓ Một liên kết xác minh mới đã được gửi tới email bạn dùng khi đăng ký.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="au-btn">Gửi lại email xác minh</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center" style="margin-top:1.25rem;">
        @csrf
        <button type="submit" class="au-link">Đăng xuất</button>
    </form>
</x-guest-layout>
