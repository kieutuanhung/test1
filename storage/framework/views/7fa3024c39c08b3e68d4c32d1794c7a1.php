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
            <?php echo e(__('Quản lý Đơn Hàng')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-pink-100 p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Mã Đơn</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Khách hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Số ĐT</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Tổng tiền</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Trạng thái</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-4 py-4 font-bold text-gray-800">#<?php echo e($order->id); ?></td>
                                <td class="px-4 py-4"><?php echo e($order->customer_name); ?></td>
                                <td class="px-4 py-4"><?php echo e($order->customer_phone); ?></td>
                                <td class="px-4 py-4 text-right font-bold text-pink-600"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?> đ</td>
                                <td class="px-4 py-4 text-center">
                                    <?php if($order->status == 'pending'): ?>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">Chờ duyệt</span>
                                    <?php elseif($order->status == 'processing'): ?>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">Đang giao</span>
                                    <?php elseif($order->status == 'completed'): ?>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Hoàn thành</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">Đã hủy</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="text-pink-600 hover:text-pink-900 font-bold">Xem →</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Chưa có đơn hàng nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-6">
                    <?php echo e($orders->links()); ?>

                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>