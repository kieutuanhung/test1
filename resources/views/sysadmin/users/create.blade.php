<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Tạo Tài Khoản Mới') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                <form action="{{ route('sysadmin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-pink-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border-pink-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phân quyền (Role)</label>
                        <select name="role" class="w-full rounded-xl border-pink-200">
                            <option value="customer">Khách hàng (customer)</option>
                            <option value="staff">Nhân viên bán hàng (staff)</option>
                            <option value="owner">Chủ shop (owner)</option>
                            <option value="sysadmin">Quản trị hệ thống (sysadmin)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Mật khẩu</label>
                        <input type="password" name="password" required class="w-full rounded-xl border-pink-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-xl border-pink-200">
                    </div>
                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('sysadmin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-bold">Hủy</a>
                        <button type="submit" class="px-5 py-2 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 shadow">Tạo User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

