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
                        @foreach($users as $user)
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
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
