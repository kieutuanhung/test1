<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Tổng Quan Doanh Thu & Báo Cáo Kinh Doanh (Chủ Shop)') }}
        </h2>
    </x-slot>

    <!-- Thư viện Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 4 Thẻ Thống Kê Tổng Quan -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-ink p-6 rounded-none border border-white ">
                    <p class="text-xs font-bold text-neutral-400 uppercase">Tổng Doanh Thu</p>
                    <p class="text-2xl font-black text-white mt-2">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</p>
                </div>
                <div class="bg-ink p-6 rounded-none border border-white ">
                    <p class="text-xs font-bold text-neutral-400 uppercase">Tổng Đơn Hàng</p>
                    <p class="text-2xl font-black text-white mt-2">{{ $totalOrders }}</p>
                </div>
                <div class="bg-ink p-6 rounded-none border border-white ">
                    <p class="text-xs font-bold text-neutral-400 uppercase">Đơn Chờ Gom Hàng</p>
                    <p class="text-2xl font-black text-amber-500 mt-2">{{ $pendingOrders }}</p>
                </div>
                <div class="bg-ink p-6 rounded-none border border-white ">
                    <p class="text-xs font-bold text-neutral-400 uppercase">Đơn Hoàn Thành</p>
                    <p class="text-2xl font-black text-green-600 mt-2">{{ $completedOrders }}</p>
                </div>
            </div>

            <!-- 2 BIỂU ĐỒ PIE / DOUGHNUT CHART -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart 1: Trạng Thái Đơn Hàng -->
                <div class="bg-ink p-6 rounded-none border border-white  flex flex-col items-center">
                    <h3 class="font-bold text-white text-base mb-4 self-start">📊 Tỷ Lệ Trạng Thái Đơn Hàng</h3>
                    <div class="w-full max-w-[280px]">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Cơ Cấu Doanh Thu Sản Phẩm -->
                <div class="bg-ink p-6 rounded-none border border-white  flex flex-col items-center">
                    <h3 class="font-bold text-white text-base mb-4 self-start">💰 Cơ Cấu Doanh Thu Sản Phẩm</h3>
                    <div class="w-full max-w-[280px]">
                        <canvas id="revenuePieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- BẢNG GOM HÀNG CẦN NHẬP VỀ -->
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-none ">
                <h3 class="font-bold text-amber-900 text-lg mb-1">📋 Danh Sách Cần Nhập Về (Khách Đã Chốt Đơn)</h3>
                <p class="text-xs text-amber-700 mb-4">Tổng hợp số lượng sản phẩm từ tất cả đơn hàng Chờ gom.</p>
                
                <div class="bg-ink rounded-none overflow-hidden border border-amber-100">
                    <table class="min-w-full text-sm">
                        <thead class="bg-amber-100/60">
                            <tr class="text-amber-900 text-xs uppercase font-bold">
                                <th class="py-3 px-4 text-left">Tên sản phẩm</th>
                                <th class="py-3 px-4 text-center">Số lượng gom</th>
                                <th class="py-3 px-4 text-right">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-50">
                            @forelse($itemsToRestock as $item)
                                <tr>
                                    <td class="py-3 px-4 font-semibold text-white">{{ $item->product_name }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block bg-amber-100 text-amber-900 px-3 py-1 rounded-full font-black text-sm">
                                            Cần nhập: {{ $item->total_needed }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right text-xs font-bold text-amber-600">Chờ gom hàng</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-neutral-400">Hiện không có đơn chờ gom.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Sản Phẩm Bán Chạy & Đơn Hàng Gần Đây -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-ink p-6 rounded-none border border-white ">
                    <h3 class="font-bold text-white text-lg mb-4">🏆 Top Sản Phẩm Bán Chạy</h3>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-neutral-500 text-xs uppercase">
                                <th class="py-2 text-left">Tên sản phẩm</th>
                                <th class="py-2 text-center">Đã bán</th>
                                <th class="py-2 text-right">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800">
                            @forelse($topProducts as $item)
                                <tr>
                                    <td class="py-3 font-medium text-white">{{ $item->product_name }}</td>
                                    <td class="py-3 text-center font-bold text-white">{{ $item->total_sold }}</td>
                                    <td class="py-3 text-right font-bold">{{ number_format($item->revenue, 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-neutral-500">Chưa có dữ liệu bán hàng.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-ink p-6 rounded-none border border-white ">
                    <h3 class="font-bold text-white text-lg mb-4">📦 Đơn Hàng Mới Đặt</h3>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-neutral-500 text-xs uppercase">
                                <th class="py-2 text-left">Mã Đơn</th>
                                <th class="py-2 text-left">Khách</th>
                                <th class="py-2 text-center">Trạng Thái</th>
                                <th class="py-2 text-right">Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800">
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="py-3 font-mono font-bold text-white">#{{ $order->id }}</td>
                                    <td class="py-3 font-medium text-white">{{ $order->customer_name }}</td>
                                    <td class="py-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold
                                            @if($order->status === 'completed') bg-green-100 text-green-700
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right font-bold">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-neutral-500">Chưa có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Script tạo biểu đồ -->
    <script>
        // 1. Biểu đồ Doughnut Trạng thái đơn hàng
        new Chart(document.getElementById('orderStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Chờ gom', 'Đang nhập & gói', 'Hoàn thành', 'Đã hủy'],
                datasets: [{
                    data: [{{ $pendingOrders }}, {{ $processingOrders }}, {{ $completedOrders }}, {{ $cancelledOrders }}],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // 2. Biểu đồ Pie Doanh thu theo sản phẩm
        const productLabels = {!! json_encode($productLabels) !!};
        const productRevenues = {!! json_encode($productRevenues) !!};

        new Chart(document.getElementById('revenuePieChart'), {
            type: 'pie',
            data: {
                labels: productLabels.length ? productLabels : ['Chưa có dữ liệu'],
                datasets: [{
                    data: productRevenues.length ? productRevenues : [1],
                    backgroundColor: ['#111111', '#525252', '#a3a3a3', '#3b82f6', '#f59e0b'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</x-app-layout>
