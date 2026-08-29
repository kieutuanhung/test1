<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Nhật Ký Đăng Nhập Hệ Thống (Login Logs)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-pink-100 p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Thời Gian</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tài Khoản (Email)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Địa Chỉ IP</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Thiết Bị / Trình Duyệt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($logs as $log)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $log->logged_in_at }}</td>
                                <td class="px-4 py-3 font-bold text-pink-600">{{ $log->email }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $log->ip_address }}</td>
                                <td class="px-4 py-3 text-xs text-gray-500 max-w-md truncate" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">Chưa có bản ghi đăng nhập nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
