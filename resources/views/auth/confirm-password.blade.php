<x-guest-layout>
    <x-slot name="eyebrow">Bảo mật</x-slot>
    <x-slot name="title">Xác nhận mật khẩu</x-slot>
    <x-slot name="subtitle">Đây là khu vực bảo mật. Vui lòng xác nhận mật khẩu trước khi tiếp tục.</x-slot>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Mật khẩu" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Nhập mật khẩu hiện tại"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="au-btn" style="margin-top:1.5rem;">Xác nhận</button>
    </form>
</x-guest-layout>
