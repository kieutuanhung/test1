<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Mật khẩu của bạn đã sử dụng quá 6 tháng. Vui lòng đổi mật khẩu mới để tiếp tục sử dụng hệ thống.
    </div>

    <form method="POST" action="{{ route('password.expired.update') }}">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="current_password" value="Mật khẩu hiện tại" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Mật khẩu mới" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Xác nhận mật khẩu mới" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Đổi mật khẩu</x-primary-button>
        </div>
    </form>
</x-guest-layout>
