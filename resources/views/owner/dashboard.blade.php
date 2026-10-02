<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-2">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Chủ shop</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Tổng quan doanh thu') }}
                </h2>
            </div>
            <p class="text-xs text-neutral-500">Báo cáo kinh doanh · Tháng {{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('m/Y') }}</p>
        </div>
    </x-slot>

    <!-- Thư viện Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth)->format('m/Y');
        $statusTotal = $pendingOrders + $processingOrders + $completedOrders + $cancelledOrders;
        $hasProductData = collect($productLabels)->isNotEmpty();
        $completionRate = $totalOrders > 0 ? round($completedOrders / $totalOrders * 100) : 0;
        $statusMap = [
            'pending'    => 'Chờ gom',
            'processing' => 'Đang xử lý',
            'completed'  => 'Hoàn thành',
            'cancelled'  => 'Đã hủy',
        ];
    @endphp

    <style>
        /* Nền sáng hơn: thêm quầng màu đỏ/cam nhẹ thay vì đen đặc */
        div.hd-wrap {
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .hd-wrap .hd-card {
            background: linear-gradient(180deg, #1f1f26, #19191f);
            border-color: #2e2e37;
        }

        /* Thẻ thống kê gọn, không phụ thuộc bản build Tailwind */
        .hd-kpi-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
        @media (max-width: 1100px) { .hd-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 520px)  { .hd-kpi-grid { grid-template-columns: 1fr; } }

        .hd-kpi {
            --c: 255,99,88;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid rgba(var(--c), .30);
            background: linear-gradient(135deg, rgba(var(--c), .18), rgba(var(--c), .03) 60%), #1c1c22;
            transition: transform .2s, border-color .2s;
        }
        .hd-kpi:hover { transform: translateY(-2px); border-color: rgba(var(--c), .65); }
        .hd-red   { --c: 255,99,88; }
        .hd-blue  { --c: 96,165,250; }
        .hd-amber { --c: 251,191,36; }
        .hd-green { --c: 52,211,153; }

        .hd-kpi-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .hd-kpi-label { margin: 0; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #b8b8c2; }
        .hd-kpi-icon {
            width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: rgba(var(--c), .20); color: rgb(var(--c));
        }
        .hd-kpi-icon svg { width: 16px; height: 16px; }
        .hd-kpi-value { margin: 10px 0 0; font-size: 26px; font-weight: 900; line-height: 1; color: #fff; }
        .hd-kpi-value small { margin-left: 5px; font-size: 12px; font-weight: 700; color: #a8a8b3; }
        .hd-amber .hd-kpi-value, .hd-green .hd-kpi-value { color: rgb(var(--c)); }
        .hd-kpi-sub { margin: 6px 0 0; font-size: 11px; color: #a8a8b3; }
        .hd-amber .hd-kpi-sub { color: rgb(var(--c)); }
        .hd-bar { height: 4px; margin-top: 8px; border-radius: 99px; background: rgba(255,255,255,.12); overflow: hidden; }
        .hd-bar span { display: block; height: 100%; border-radius: 99px; background: rgb(var(--c)); }
    </style>

    <div class="py-6 bg-ink min-h-screen hd-wrap">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            <!-- Bộ lọc theo tháng -->
            <form method="GET" action="{{ route('owner.dashboard') }}"
                  class="flex flex-wrap items-center gap-x-4 gap-y-2">
                <label class="text-xs font-bold uppercase tracking-widest2 text-accent shrink-0">Xem báo cáo tháng</label>
                <select name="month" onchange="this.form.submit()"
                        class="bg-neutral-900 border border-neutral-700 text-white text-sm rounded-full py-2 pl-4 pr-9 focus:outline-none focus:ring-1 focus:ring-accent focus:border-accent transition">
                    @foreach($availableMonths as $ym)
                        <option value="{{ $ym }}" {{ $ym === $selectedMonth ? 'selected' : '' }}>
                            Tháng {{ \Carbon\Carbon::createFromFormat('Y-m', $ym)->format('m/Y') }}
                        </option>
                    @endforeach
                </select>
                <span class="flex items-center gap-1.5 text-xs text-neutral-500">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8h.01M11 12h1v4h1"/>
                    </svg>
                    "Chờ gom hàng" và "Đơn hàng mới đặt" luôn hiển thị việc cần xử lý hiện tại, không theo tháng đã chọn.
                </span>
            </form>

            <!-- 4 Thẻ Thống Kê Tổng Quan -->
            <div class="hd-kpi-grid">
                <!-- Doanh thu -->
                <div class="hd-kpi hd-red">
                    <div class="hd-kpi-top">
                        <p class="hd-kpi-label">Tổng doanh thu</p>
                        <span class="hd-kpi-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m3-9.5c-.5-1-1.6-1.5-3-1.5-1.7 0-3 .9-3 2.2 0 3 6 1.6 6 4.6 0 1.3-1.3 2.2-3 2.2-1.4 0-2.5-.5-3-1.5"/>
                            </svg>
                        </span>
                    </div>
                    <p class="hd-kpi-value">{{ number_format($totalRevenue, 0, ',', '.') }}<small>VNĐ</small></p>
                    <p class="hd-kpi-sub">Tháng {{ $monthLabel }}</p>
                </div>

                <!-- Tổng đơn -->
                <div class="hd-kpi hd-blue">
                    <div class="hd-kpi-top">
                        <p class="hd-kpi-label">Tổng đơn hàng</p>
                        <span class="hd-kpi-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h14l-1.5 9H8L6 4H3m5 16a1 1 0 100-2 1 1 0 000 2zm9 0a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="hd-kpi-value">{{ $totalOrders }}</p>
                    <p class="hd-kpi-sub">Đơn đặt trong tháng {{ $monthLabel }}</p>
                </div>

                <!-- Chờ gom -->
                <div class="hd-kpi hd-amber">
                    <div class="hd-kpi-top">
                        <p class="hd-kpi-label">Đơn chờ gom hàng</p>
                        <span class="hd-kpi-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </span>
                    </div>
                    <p class="hd-kpi-value">{{ $pendingOrders }}</p>
                    <p class="hd-kpi-sub">Cần xử lý hiện tại</p>
                </div>

                <!-- Hoàn thành -->
                <div class="hd-kpi hd-green">
                    <div class="hd-kpi-top">
                        <p class="hd-kpi-label">Đơn hoàn thành</p>
                        <span class="hd-kpi-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                    </div>
                    <p class="hd-kpi-value">{{ $completedOrders }}</p>
                    <div class="hd-bar"><span style="width: {{ $completionRate }}%"></span></div>
                    <p class="hd-kpi-sub">{{ $completionRate }}% tổng đơn</p>
                </div>
            </div>

            <!-- 2 BIỂU ĐỒ -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart 1: Trạng Thái Đơn Hàng -->
                <div class="hd-card p-6 rounded-2xl border border-neutral-800">
                    <h3 class="font-bold text-white text-base border-l-4 border-accent pl-3">Tỷ lệ trạng thái đơn hàng</h3>
                    <p class="text-xs text-neutral-500 pl-4 mt-1 mb-4">Tháng {{ $monthLabel }}</p>
                    @if($statusTotal > 0)
                        <div class="relative" style="height:240px">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    @else
                        <div class="h-64 flex flex-col items-center justify-center text-center text-neutral-500 border border-dashed border-neutral-800 rounded-xl">
                            <svg class="w-10 h-10 mb-2 text-neutral-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.06A9 9 0 1020.94 13H11V3.06zM15 3.5A9 9 0 0120.5 9H15V3.5z"/>
                            </svg>
                            <p class="text-sm">Chưa có đơn hàng trong tháng này</p>
                        </div>
                    @endif
                </div>

                <!-- Chart 2: Cơ Cấu Doanh Thu Sản Phẩm -->
                <div class="hd-card p-6 rounded-2xl border border-neutral-800">
                    <h3 class="font-bold text-white text-base border-l-4 border-accent pl-3">Cơ cấu doanh thu sản phẩm</h3>
                    <p class="text-xs text-neutral-500 pl-4 mt-1 mb-4">Tháng {{ $monthLabel }}</p>
                    @if($hasProductData)
                        <div class="relative" style="height:240px">
                            <canvas id="revenuePieChart"></canvas>
                        </div>
                    @else
                        <div class="h-64 flex flex-col items-center justify-center text-center text-neutral-500 border border-dashed border-neutral-800 rounded-xl">
                            <svg class="w-10 h-10 mb-2 text-neutral-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.06A9 9 0 1020.94 13H11V3.06zM15 3.5A9 9 0 0120.5 9H15V3.5z"/>
                            </svg>
                            <p class="text-sm">Chưa có doanh thu trong tháng này</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BẢNG GOM HÀNG CẦN NHẬP VỀ -->
            <div class="hd-card border border-neutral-800 rounded-2xl p-6">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-1">
                    <h3 class="font-bold text-white text-lg border-l-4 border-amber-500 pl-3">Danh sách cần nhập về <span class="text-neutral-500 font-medium text-sm">(khách đã chốt đơn)</span></h3>

                    <form method="GET" action="{{ route('owner.dashboard') }}" class="flex flex-wrap items-center gap-2">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">

                        <div class="relative">
                            <input type="text" name="restock_search" value="{{ request('restock_search') }}" placeholder="Tìm tên sản phẩm..."
                                   class="bg-neutral-900 text-xs border border-neutral-700 rounded-full pl-4 pr-9 py-2 text-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-amber-400 focus:border-amber-400 transition">
                            <button type="submit" class="absolute right-0 top-0 h-full px-3 text-neutral-500 hover:text-amber-400 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>

                        <label class="text-xs font-bold text-neutral-400 uppercase">Sắp xếp</label>
                        <select name="restock_sort" onchange="this.form.submit()"
                                class="bg-neutral-900 text-xs border border-neutral-700 rounded-full py-2 pl-3 pr-8 text-white focus:outline-none focus:ring-1 focus:ring-amber-400 focus:border-amber-400 transition">
                            <option value="quantity" {{ $restockSort === 'quantity' ? 'selected' : '' }}>Số lượng cần lấy</option>
                            <option value="time" {{ $restockSort === 'time' ? 'selected' : '' }}>Thời gian (mới đặt gần đây nhất)</option>
                            <option value="orders" {{ $restockSort === 'orders' ? 'selected' : '' }}>Số đơn hàng</option>
                            <option value="amount" {{ $restockSort === 'amount' ? 'selected' : '' }}>Số tiền</option>
                        </select>
                    </form>
                </div>
                <p class="text-xs text-neutral-500 mb-4 pl-4">Tổng hợp số lượng sản phẩm từ tất cả đơn hàng Chờ gom.</p>

                <div class="rounded-xl overflow-x-auto border border-neutral-800">
                    <table class="min-w-full text-sm">
                        <thead class="bg-neutral-900">
                            <tr class="text-neutral-400 text-[11px] uppercase font-bold tracking-wider">
                                <th class="py-3 px-4 text-left">Tên sản phẩm</th>
                                <th class="py-3 px-4 text-center">Số lượng gom</th>
                                <th class="py-3 px-4 text-center">Số đơn hàng</th>
                                <th class="py-3 px-4 text-center">Số tiền</th>
                                <th class="py-3 px-4 text-center">Đặt gần nhất</th>
                                <th class="py-3 px-4 text-right">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800/70">
                            @forelse($itemsToRestock as $item)
                                <tr class="hover:bg-neutral-900/60 transition-colors">
                                    <td class="py-3 px-4 font-semibold text-white">{{ $item->product_name }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block bg-amber-500/15 text-amber-400 px-3 py-1 rounded-full font-black text-xs whitespace-nowrap">
                                            Cần nhập: {{ $item->total_needed }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center text-neutral-300">{{ $item->total_orders }} đơn</td>
                                    <td class="py-3 px-4 text-center text-neutral-300 whitespace-nowrap">{{ number_format($item->total_amount, 0, ',', '.') }} đ</td>
                                    <td class="py-3 px-4 text-center text-neutral-400 text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($item->latest_order_at)->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-500 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Chờ gom hàng
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-neutral-500">
                                        @if(request('restock_search'))
                                            Không tìm thấy sản phẩm nào khớp với "{{ request('restock_search') }}".
                                        @else
                                            Hiện không có đơn chờ gom.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Sản Phẩm Bán Chạy & Đơn Hàng Gần Đây -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="hd-card p-6 rounded-2xl border border-neutral-800">
                    <h3 class="font-bold text-white text-lg border-l-4 border-accent pl-3">Top sản phẩm bán chạy</h3>
                    <p class="text-xs text-neutral-500 pl-4 mt-1 mb-4">Tháng {{ $monthLabel }}</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-neutral-800 text-neutral-400 text-[11px] uppercase tracking-wider">
                                    <th class="py-2 text-left">Sản phẩm</th>
                                    <th class="py-2 text-center">Đã bán</th>
                                    <th class="py-2 text-right">Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-800/70">
                                @forelse($topProducts as $item)
                                    <tr class="hover:bg-neutral-900/60 transition-colors">
                                        <td class="py-3">
                                            <div class="flex items-center gap-3">
                                                <span class="w-6 h-6 rounded-full text-[11px] font-black flex items-center justify-center shrink-0
                                                    {{ $loop->first ? 'bg-accent text-white' : 'bg-neutral-800 text-neutral-400' }}">
                                                    {{ $loop->iteration }}
                                                </span>
                                                <span class="font-medium text-white">{{ $item->product_name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-center font-bold text-white">{{ $item->total_sold }}</td>
                                        <td class="py-3 text-right font-bold text-neutral-200 whitespace-nowrap">{{ number_format($item->revenue, 0, ',', '.') }} đ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-10 text-center text-neutral-500">Chưa có dữ liệu bán hàng.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="hd-card p-6 rounded-2xl border border-neutral-800">
                    <h3 class="font-bold text-white text-lg border-l-4 border-accent pl-3 mb-5">Đơn hàng mới đặt</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-neutral-800 text-neutral-400 text-[11px] uppercase tracking-wider">
                                    <th class="py-2 text-left">Mã đơn</th>
                                    <th class="py-2 text-left">Khách</th>
                                    <th class="py-2 text-left">Sản phẩm</th>
                                    <th class="py-2 text-center">Trạng thái</th>
                                    <th class="py-2 text-right">Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-800/70">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-neutral-900/60 transition-colors">
                                        <td class="py-3 pr-3 font-mono font-bold text-white">#{{ $order->id }}</td>
                                        <td class="py-3 pr-3 font-medium text-white">{{ $order->customer_name }}</td>
                                        <td class="py-3 pr-3 text-neutral-300 max-w-[180px] truncate" title="{{ $order->product_names_display }}">{{ $order->product_names_display }}</td>
                                        <td class="py-3 text-center">
                                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold whitespace-nowrap
                                                @if($order->status === 'completed') bg-green-500/15 text-green-400
                                                @elseif($order->status === 'cancelled') bg-red-500/15 text-red-400
                                                @else bg-amber-500/15 text-amber-400 @endif">
                                                {{ $statusMap[$order->status] ?? $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-right font-bold text-neutral-200 whitespace-nowrap">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-neutral-500">Chưa có đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script tạo biểu đồ -->
    <script>
        // Màu chữ sáng cho nền tối (mặc định của Chart.js là xám đậm, rất khó đọc)
        Chart.defaults.color = '#a3a3a3';
        Chart.defaults.font.family = 'inherit';

        const legendOptions = {
            position: 'bottom',
            labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, boxWidth: 8 }
        };

        // 1. Biểu đồ Doughnut Trạng thái đơn hàng
        const statusEl = document.getElementById('orderStatusChart');
        if (statusEl) {
            new Chart(statusEl, {
                type: 'doughnut',
                data: {
                    labels: ['Chờ gom', 'Đang nhập & gói', 'Hoàn thành', 'Đã hủy'],
                    datasets: [{
                        data: [{{ $pendingOrders }}, {{ $processingOrders }}, {{ $completedOrders }}, {{ $cancelledOrders }}],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: { legend: legendOptions }
                }
            });
        }

        // 2. Biểu đồ Doughnut Doanh thu theo sản phẩm
        const productLabels = {!! json_encode($productLabels) !!};
        const productRevenues = {!! json_encode($productRevenues) !!};
        const revenueEl = document.getElementById('revenuePieChart');

        if (revenueEl) {
            new Chart(revenueEl, {
                type: 'doughnut',
                data: {
                    labels: productLabels,
                    datasets: [{
                        data: productRevenues,
                        backgroundColor: ['#e0392c', '#f59e0b', '#10b981', '#3b82f6', '#a855f7'],
                        borderWidth: 0,
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%',
                    plugins: {
                        legend: legendOptions,
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ' ' + ctx.label + ': ' + Number(ctx.parsed).toLocaleString('vi-VN') + ' đ'
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
