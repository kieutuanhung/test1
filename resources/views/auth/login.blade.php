<x-guest-layout>
    <x-slot name="eyebrow">Tài khoản</x-slot>
    <x-slot name="title">Đăng nhập</x-slot>
    <x-slot name="subtitle">Chào mừng trở lại! Đăng nhập để tiếp tục.</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Nhập email của bạn" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mật khẩu" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Nhập mật khẩu"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot -->
        <div class="au-row mt-4">
            <label for="remember_me" class="au-check">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Ghi nhớ đăng nhập</span>
            </label>

            @if (Route::has('password.request'))
                <a class="au-link" href="{{ route('password.request') }}">Quên mật khẩu?</a>
            @endif
        </div>

        <button type="submit" class="au-btn" style="margin-top:1.5rem;">Đăng nhập</button>
    </form>

    @if (Route::has('register'))
        <p class="au-alt">Chưa có tài khoản? <a href="{{ route('register') }}" class="au-link-accent">Đăng ký ngay</a></p>
    @endif
</x-guest-layout>
