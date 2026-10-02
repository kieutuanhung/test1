<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="section-title">
                {{ __('Tạo tài khoản mới') }}
            </h2>
            <a href="{{ route('sysadmin.users.index') }}" class="sa-btn-ghost">← Quay lại danh sách</a>
        </div>
    </x-slot>

    <style>
        .sa-card{background-color:#101010;border:1px solid #262626;border-radius:16px;}
        .sa-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#737373;margin-bottom:.4rem;}
        .sa-input{width:100%;background-color:#171717;border:1px solid #404040;border-radius:8px;padding-top:.65rem;padding-bottom:.65rem;padding-left:.875rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .sa-input::placeholder{color:#737373;}
        .sa-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .sa-btn-red{display:inline-block;background-color:#e0392c;color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.5rem;border-radius:8px;border:0;cursor:pointer;transition:background-color .15s;}
        .sa-btn-red:hover{background-color:#c42f23;}
        .sa-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #404040;color:#a3a3a3;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.25rem;border-radius:8px;white-space:nowrap;transition:all .15s;}
        .sa-btn-ghost:hover{border-color:#fff;color:#fff;}
    </style>

    <div class="py-8 bg-ink min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="sa-card" style="padding:1.75rem;">

                @if ($errors->any())
                    <div style="color:#fca5a5; background-color:#f871711a; border:1px solid #f8717166; border-radius:8px; padding:.75rem 1rem; font-size:14px; margin-bottom:1.25rem;">
                        <ul style="list-style:disc; padding-left:1.1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sysadmin.users.store') }}" method="POST" style="display:flex; flex-direction:column; gap:1.25rem;">
                    @csrf

                    <div>
                        <label class="sa-label">Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="sa-input">
                    </div>

                    <div>
                        <label class="sa-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="sa-input">
                    </div>

                    <div>
                        <label class="sa-label">Phân quyền (Role)</label>
                        <select name="role" class="sa-input">
                            <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Khách hàng (customer)</option>
                            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Nhân viên bán hàng (staff)</option>
                            <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>Chủ shop (owner)</option>
                            <option value="sysadmin" {{ old('role') === 'sysadmin' ? 'selected' : '' }}>Quản trị hệ thống (sysadmin)</option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem;">
                        <div>
                            <label class="sa-label">Mật khẩu</label>
                            <input type="password" name="password" required class="sa-input">
                        </div>
                        <div>
                            <label class="sa-label">Nhập lại mật khẩu</label>
                            <input type="password" name="password_confirmation" required class="sa-input">
                        </div>
                    </div>

                    <div style="padding-top:1.25rem; border-top:1px solid #262626; display:flex; justify-content:flex-end; gap:.75rem;">
                        <a href="{{ route('sysadmin.users.index') }}" class="sa-btn-ghost">Hủy</a>
                        <button type="submit" class="sa-btn-red">Tạo tài khoản</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
