<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Tạo Tài Khoản Mới') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink p-6 rounded-none border border-neutral-800 ">
                <form action="{{ route('sysadmin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-neutral-200 mb-1">Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-neutral-900 rounded-none border-neutral-700 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-200 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-neutral-900 rounded-none border-neutral-700 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-200 mb-1">Phân quyền (Role)</label>
                        <select name="role" class="w-full bg-neutral-900 rounded-none border-neutral-700 text-white">
                            <option value="customer">Khách hàng (customer)</option>
                            <option value="staff">Nhân viên bán hàng (staff)</option>
                            <option value="owner">Chủ shop (owner)</option>
                            <option value="sysadmin">Quản trị hệ thống (sysadmin)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-200 mb-1">Mật khẩu</label>
                        <input type="password" name="password" required class="w-full bg-neutral-900 rounded-none border-neutral-700 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-200 mb-1">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" required class="w-full bg-neutral-900 rounded-none border-neutral-700 text-white">
                    </div>
                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('sysadmin.users.index') }}" class="px-4 py-2 border border-neutral-700 text-white rounded-none font-bold text-xs uppercase tracking-widest2 hover:border-white">Hủy</a>
                        <button type="submit" class="px-5 py-2 bg-accent text-white rounded-none font-bold text-xs uppercase tracking-widest2 hover:bg-accent-700">Tạo User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

