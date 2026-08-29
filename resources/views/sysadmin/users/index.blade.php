<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-pink-600 leading-tight">
                {{ __('Quản trị Tài Khoản & Người Dùng (Sysadmin)') }}
            </h2>
            <a href="{{ route('sysadmin.users.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-xl text-sm transition shadow">
                + Thêm Tài Khoản Mới
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-pink-100 p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tên</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Email</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Vai Trò (Role)</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Trạng Thái</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-4 font-bold">{{ $user->id }}</td>
                                <td class="px-4 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                        @if($user->role === 'sysadmin') bg-purple-100 text-purple-800
                                        @elseif($user->role === 'owner') bg-pink-100 text-pink-800
                                        @elseif($user->role === 'staff') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-700 @endif">
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
                                    <a href="{{ route('sysadmin.users.edit', $user->id) }}" class="text-pink-600 hover:text-pink-900 font-bold">Sửa / Reset Pass</a>
                                    
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
