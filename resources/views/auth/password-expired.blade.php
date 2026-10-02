<x-guest-layout>
    <x-slot name="eyebrow">Bảo mật</x-slot>
    <x-slot name="title">Đổi mật khẩu</x-slot>
    <x-slot name="subtitle">Mật khẩu của bạn đã sử dụng quá 6 tháng. Vui lòng đổi mật khẩu mới để tiếp tục sử dụng hệ thống.</x-slot>

    @if (session('status'))
        <div class="au-ok">
            ✓ {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.expired.update') }}">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="current_password" value="Mật khẩu hiện tại" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" placeholder="Nhập mật khẩu hiện tại" required />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Mật khẩu mới" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Nhập mật khẩu mới" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Xác nhận mật khẩu mới" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" placeholder="Nhập lại mật khẩu mới" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="au-btn" style="margin-top:1.5rem;">Đổi mật khẩu</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center" style="margin-top:1.25rem;">
        @csrf
        <button type="submit" class="au-link">Đăng xuất để vào tài khoản khác</button>
    </form>
</x-guest-layout>
