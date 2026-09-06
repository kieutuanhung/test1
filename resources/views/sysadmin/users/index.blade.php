<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="section-title">
                {{ __('Quản trị Tài Khoản & Người Dùng (Sysadmin)') }}
            </h2>
            <a href="{{ route('sysadmin.users.create') }}" class="bg-accent hover:bg-accent-700 text-white font-bold py-2 px-4 rounded-none text-sm transition shadow">
                + Thêm Tài Khoản Mới
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-none ">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="border border-red-700 bg-red-50 text-red-700 text-sm px-4 py-3 ">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tìm kiếm theo từng phần: Tên / Email / Vai trò -->
            <form method="GET" action="{{ route('sysadmin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="relative group" style="transition: transform .2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Tìm theo tên..."
                           style="border: 2px solid #f59e0b; "
                           class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 pl-4 pr-4 focus:ring-2 focus:ring-amber-400 placeholder:text-neutral-500 transition">
                </div>

                <div class="relative group" style="transition: transform .2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <input type="text" name="email" value="{{ request('email') }}" placeholder="Tìm theo email..."
                           style="border: 2px solid #3b82f6; "
                           class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 pl-4 pr-4 focus:ring-2 focus:ring-blue-400 placeholder:text-neutral-500 transition">
                </div>

                <div class="flex gap-2">
                    <div class="relative flex-1 group" style="transition: transform .2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <select name="role" onchange="this.form.submit()"
                                style="border: 2px solid #a855f7; "
                                class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 pl-4 pr-4 focus:ring-2 focus:ring-purple-400 transition appearance-none">
                            <option value="">Tất cả vai trò</option>
                            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="sysadmin" {{ request('role') === 'sysadmin' ? 'selected' : '' }}>Sysadmin</option>
                        </select>
                    </div>
                    <button type="submit"
                            style="background-color:#e0392c; border-radius:9999px; transition: transform .15s;"
                            onmouseover="this.style.transform='scale(1.1) rotate(-6deg)'" onmouseout="this.style.transform='scale(1) rotate(0deg)'"
                            class="shrink-0 px-6 h-12 flex items-center justify-center text-white text-xs font-bold uppercase tracking-widest2 shadow-lg">
                        Tìm
                    </button>
                </div>
            </form>

            @if(request('name') || request('email') || request('role'))
                <div>
                    <a href="{{ route('sysadmin.users.index') }}" class="inline-flex items-center gap-1 text-xs text-accent hover:opacity-70 uppercase tracking-widest2 font-semibold">
                        Xóa bộ lọc
                    </a>
                </div>
            @endif

            <div class="bg-ink overflow-hidden  rounded-none border-2 border-white p-6">
                <table class="min-w-full divide-y divide-neutral-800">
                    <thead class="bg-neutral-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Tên</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Email</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase">Vai Trò (Role)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-white uppercase">Trạng Thái</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white uppercase">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800 text-sm">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-4 font-bold">{{ $user->id }}</td>
                                <td class="px-4 py-4 font-semibold text-white">{{ $user->name }}</td>
                                <td class="px-4 py-4 text-neutral-300">{{ $user->email }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                        @if($user->role === 'sysadmin') bg-purple-100 text-purple-800
                                        @elseif($user->role === 'owner') bg-ink text-white
                                        @elseif($user->role === 'staff') bg-blue-100 text-blue-800
                                        @else bg-neutral-800 text-neutral-300 @endif">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($user->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Hoạt động</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Đã khóa</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right space-x-2">
                                    <a href="{{ route('sysadmin.users.edit', $user->id) }}" class="text-white hover:text-accent font-bold">Sửa / Reset Pass</a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('sysadmin.users.toggleStatus', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="font-bold {{ $user->is_active ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' }}">
                                                {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-neutral-400">Không tìm thấy tài khoản nào khớp với bộ lọc.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
