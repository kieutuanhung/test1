<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            <?php echo e(__('Tổng Quan Doanh Thu & Báo Cáo Kinh Doanh (Chủ Shop)')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Thư viện Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 4 Thẻ Thống Kê Tổng Quan -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-500 uppercase">Tổng Doanh Thu</p>
                    <p class="text-2xl font-black text-pink-600 mt-2"><?php echo e(number_format($totalRevenue, 0, ',', '.')); ?> VNĐ</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-500 uppercase">Tổng Đơn Hàng</p>
                    <p class="text-2xl font-black text-gray-800 mt-2"><?php echo e($totalOrders); ?></p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-500 uppercase">Đơn Chờ Gom Hàng</p>
                    <p class="text-2xl font-black text-amber-500 mt-2"><?php echo e($pendingOrders); ?></p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-500 uppercase">Đơn Hoàn Thành</p>
                    <p class="text-2xl font-black text-green-600 mt-2"><?php echo e($completedOrders); ?></p>
                </div>
            </div>

            <!-- 2 BIỂU ĐỒ PIE / DOUGHNUT CHART -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart 1: Trạng Thái Đơn Hàng -->
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center">
                    <h3 class="font-bold text-gray-800 text-base mb-4 self-start">📊 Tỷ Lệ Trạng Thái Đơn Hàng</h3>
                    <div class="w-full max-w-[280px]">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Cơ Cấu Doanh Thu Sản Phẩm -->
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center">
                    <h3 class="font-bold text-gray-800 text-base mb-4 self-start">💰 Cơ Cấu Doanh Thu Sản Phẩm</h3>
                    <div class="w-full max-w-[280px]">
                        <canvas id="revenuePieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- BẢNG GOM HÀNG CẦN NHẬP VỀ -->
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-2xl shadow-sm">
                <h3 class="font-bold text-amber-900 text-lg mb-1">📋 Danh Sách Cần Nhập Về (Khách Đã Chốt Đơn)</h3>
                <p class="text-xs text-amber-700 mb-4">Tổng hợp số lượng sản phẩm từ tất cả đơn hàng Chờ gom.</p>
                
                <div class="bg-white rounded-xl overflow-hidden border border-amber-100">
                    <table class="min-w-full text-sm">
                        <thead class="bg-amber-100/60">
                            <tr class="text-amber-900 text-xs uppercase font-bold">
                                <th class="py-3 px-4 text-left">Tên sản phẩm</th>
                                <th class="py-3 px-4 text-center">Số lượng gom</th>
                                <th class="py-3 px-4 text-right">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-50">
                            <?php $__empty_1 = true; $__currentLoopData = $itemsToRestock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="py-3 px-4 font-semibold text-gray-800"><?php echo e($item->product_name); ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block bg-amber-100 text-amber-900 px-3 py-1 rounded-full font-black text-sm">
                                            Cần nhập: <?php echo e($item->total_needed); ?>

                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right text-xs font-bold text-amber-600">Chờ gom hàng</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-gray-500">Hiện không có đơn chờ gom.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Sản Phẩm Bán Chạy & Đơn Hàng Gần Đây -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">🏆 Top Sản Phẩm Bán Chạy</h3>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-gray-400 text-xs uppercase">
                                <th class="py-2 text-left">Tên sản phẩm</th>
                                <th class="py-2 text-center">Đã bán</th>
                                <th class="py-2 text-right">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="py-3 font-medium text-gray-800"><?php echo e($item->product_name); ?></td>
                                    <td class="py-3 text-center font-bold text-pink-600"><?php echo e($item->total_sold); ?></td>
                                    <td class="py-3 text-right font-bold"><?php echo e(number_format($item->revenue, 0, ',', '.')); ?> đ</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-400">Chưa có dữ liệu bán hàng.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">📦 Đơn Hàng Mới Đặt</h3>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b text-gray-400 text-xs uppercase">
                                <th class="py-2 text-left">Mã Đơn</th>
                                <th class="py-2 text-left">Khách</th>
                                <th class="py-2 text-center">Trạng Thái</th>
                                <th class="py-2 text-right">Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="py-3 font-mono font-bold text-pink-600">#<?php echo e($order->id); ?></td>
                                    <td class="py-3 font-medium text-gray-800"><?php echo e($order->customer_name); ?></td>
                                    <td class="py-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold
                                            <?php if($order->status === 'completed'): ?> bg-green-100 text-green-700
                                            <?php elseif($order->status === 'cancelled'): ?> bg-red-100 text-red-700
                                            <?php else: ?> bg-amber-100 text-amber-700 <?php endif; ?>">
                                            <?php echo e($order->status); ?>

                                        </span>
                                    </td>
                                    <td class="py-3 text-right font-bold"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?> đ</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-400">Chưa có đơn hàng nào.</td>
                                </tr>
                            <?php endif; ?>
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
                    data: [<?php echo e($pendingOrders); ?>, <?php echo e($processingOrders); ?>, <?php echo e($completedOrders); ?>, <?php echo e($cancelledOrders); ?>],
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
        const productLabels = <?php echo json_encode($productLabels); ?>;
        const productRevenues = <?php echo json_encode($productRevenues); ?>;

        new Chart(document.getElementById('revenuePieChart'), {
            type: 'pie',
            data: {
                labels: productLabels.length ? productLabels : ['Chưa có dữ liệu'],
                datasets: [{
                    data: productRevenues.length ? productRevenues : [1],
                    backgroundColor: ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b'],
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/owner/dashboard.blade.php ENDPATH**/ ?>