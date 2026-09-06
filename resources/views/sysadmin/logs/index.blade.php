<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Nhật Ký Đăng Nhập Hệ Thống (Login Logs)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tìm kiếm theo từng phần: Email / IP / Thiết bị -->
            <form method="GET" action="{{ route('sysadmin.logs.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                <div class="relative group" style="transition: transform .2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <input type="text" name="email" value="{{ request('email') }}" placeholder="Tìm theo email..."
                           style="border: 2px solid #3b82f6; " class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 pl-4 pr-4 focus:ring-2 focus:ring-blue-400 placeholder:text-neutral-500 transition">
                </div>

                <div class="relative group" style="transition: transform .2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <input type="text" name="ip" value="{{ request('ip') }}" placeholder="Tìm theo địa chỉ IP..."
                           style="border: 2px solid #10b981; " class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 pl-4 pr-4 focus:ring-2 focus:ring-emerald-400 placeholder:text-neutral-500 transition">
                </div>

                <div class="flex gap-2">
                    <div class="relative flex-1 group" style="transition: transform .2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <input type="text" name="device" value="{{ request('device') }}" placeholder="Tìm theo thiết bị..."
                               style="border: 2px solid #a855f7; " class="w-full bg-neutral-900 text-white text-sm rounded-full py-3 pl-4 pr-4 focus:ring-2 focus:ring-purple-400 placeholder:text-neutral-500 transition">
                    </div>
                    <button type="submit"
                            style="background-color:#e0392c; border-radius:9999px; transition: transform .15s;"
                            onmouseover="this.style.transform='scale(1.1) rotate(-6deg)'" onmouseout="this.style.transform='scale(1) rotate(0deg)'"
                            class="shrink-0 px-6 h-12 flex items-center justify-center text-white text-xs font-bold uppercase tracking-widest2 shadow-lg">
                        Tìm
                    </button>
                </div>
            </form>

            @if(request('email') || request('ip') || request('device'))
                <div class="mb-4">
                    <a href="{{ route('sysadmin.logs.index') }}" class="inline-flex items-center gap-1 text-xs text-accent hover:opacity-70 uppercase tracking-widest2 font-semibold">
                        Xóa bộ lọc
                    </a>
                </div>
            @endif

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
                                <td colspan="4" class="px-4 py-8 text-center text-neutral-400">
                                    @if(request('email') || request('ip') || request('device'))
                                        Không tìm thấy bản ghi nào khớp với bộ lọc.
                                    @else
                                        Chưa có bản ghi đăng nhập nào.
                                    @endif
                                </td>
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
