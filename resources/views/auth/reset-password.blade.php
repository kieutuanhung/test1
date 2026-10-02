<x-guest-layout>
    <x-slot name="eyebrow">Tài khoản</x-slot>
    <x-slot name="title">Đặt lại mật khẩu</x-slot>
    <x-slot name="subtitle">Nhập mật khẩu mới cho tài khoản của bạn.</x-slot>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mật khẩu mới" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Nhập mật khẩu mới" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Xác nhận mật khẩu mới" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"
                                placeholder="Nhập lại mật khẩu mới"
                                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="au-btn" style="margin-top:1.5rem;">Đặt lại mật khẩu</button>
    </form>
</x-guest-layout>
