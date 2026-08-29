<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            Chỉnh sửa Tài khoản: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                <form action="{{ route('sysadmin.users.update', $user->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-pink-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-pink-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phân quyền (Role)</label>
                        <select name="role" class="w-full rounded-xl border-pink-200">
                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Khách hàng (customer)</option>
                            <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Nhân viên bán hàng (staff)</option>
                            <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Chủ shop (owner)</option>
                            <option value="sysadmin" {{ $user->role === 'sysadmin' ? 'selected' : '' }}>Quản trị hệ thống (sysadmin)</option>
                        </select>
                    </div>
                    
                    <div class="border-t border-pink-100 pt-4 mt-4">
                        <h4 class="font-bold text-sm text-pink-600 mb-2">Đổi mật khẩu (Để trống nếu không muốn đổi)</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Mật khẩu mới</label>
                                <input type="password" name="password" class="w-full rounded-xl border-pink-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Nhập lại mật khẩu mới</label>
                                <input type="password" name="password_confirmation" class="w-full rounded-xl border-pink-200 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('sysadmin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-bold">Hủy</a>
                        <button type="submit" class="px-5 py-2 bg-pink-600 text-white rounded-xl font-bold hover:bg-pink-700 shadow">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
