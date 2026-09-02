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
            <?php echo e(__('Lịch Sử Đơn Hàng Của Tôi')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-2xl p-6 border border-pink-100 shadow-sm">
                    <div class="flex flex-wrap justify-between items-center border-b pb-4 mb-4 gap-2">
                        <div>
                            <span class="font-mono font-bold text-pink-600">Đơn hàng #<?php echo e($order->id); ?></span>
                            <span class="text-xs text-gray-500 ml-2">(<?php echo e($order->created_at->format('d/m/Y H:i')); ?>)</span>
                        </div>
                        <div>
                            <?php if($order->status === 'pending'): ?>
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">⏳ Chờ gom hàng</span>
                            <?php elseif($order->status === 'processing'): ?>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">📦 Đang nhập & Đóng gói</span>
                            <?php elseif($order->status === 'completed'): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">✅ Đã giao thành công</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">❌ Đã hủy</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="py-2 flex justify-between items-center text-sm">
                                <div>
                                    <p class="font-bold text-gray-800"><?php echo e($item->product_name); ?></p>
                                    <p class="text-xs text-gray-500">Số lượng: x<?php echo e($item->quantity); ?></p>
                                </div>
                                <span class="font-semibold"><?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?> đ</span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="border-t pt-4 mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-600">Tổng thanh toán:</span>
                        <span class="text-lg font-black text-pink-600"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?> VNĐ</span>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-white rounded-2xl p-12 text-center border border-pink-100">
                    <p class="text-gray-500 mb-4">Bạn chưa có đơn đặt hàng nào.</p>
                    <a href="<?php echo e(route('home')); ?>" class="inline-block bg-pink-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-pink-700 transition">
                        Đặt hàng ngay
                    </a>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <?php echo e($orders->links()); ?>

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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/orders/history.blade.php ENDPATH**/ ?>