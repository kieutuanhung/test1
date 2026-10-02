<x-guest-layout>
    <x-slot name="eyebrow">Tài khoản</x-slot>
    <x-slot name="title">Quên mật khẩu</x-slot>
    <x-slot name="subtitle">Đừng lo! Nhập email của bạn, chúng tôi sẽ gửi liên kết để bạn đặt mật khẩu mới.</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Nhập email của bạn" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="au-btn" style="margin-top:1.5rem;">Gửi liên kết đặt lại mật khẩu</button>
    </form>

    <p class="au-alt"><a href="{{ route('login') }}" class="au-link-accent">&larr; Quay lại đăng nhập</a></p>
</x-guest-layout>
