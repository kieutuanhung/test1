<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Nhật Ký Đăng Nhập Hệ Thống (Login Logs)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink overflow-hidden  rounded-none border-2 border-white p-6">
                <table class="min-w-full divide-y divide-neutral-800">
                    <thead class="bg-neutral-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Thời Gian</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Tài Khoản (Email)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Địa Chỉ IP</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase">Thiết Bị / Trình Duyệt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800 text-sm">
                        @forelse($logs as $log)
                            <tr>
                                <td class="px-4 py-3 font-medium text-neutral-200">{{ $log->logged_in_at }}</td>
                                <td class="px-4 py-3 font-bold text-white">{{ $log->email }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-neutral-300">{{ $log->ip_address }}</td>
                                <td class="px-4 py-3 text-xs text-neutral-400 max-w-md truncate" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-neutral-400">Chưa có bản ghi đăng nhập nào.</td>
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
