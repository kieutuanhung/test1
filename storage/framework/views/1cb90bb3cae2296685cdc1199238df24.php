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
    <div class="bg-pink-50/40 min-h-screen py-16">
        <div class="max-w-2xl mx-auto px-4 text-center bg-white p-8 rounded-3xl border border-pink-100 shadow-sm">
            <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto text-3xl mb-4">
                ✓
            </div>
            <h1 class="text-2xl font-extrabold text-gray-800">Đặt Hàng Thành Công!</h1>
            <p class="text-gray-500 mt-2">Mã đơn hàng: <b class="text-pink-600">#<?php echo e($order->id); ?></b></p>
            <p class="text-sm text-gray-600 mt-1">Cảm ơn bạn đã mua sắm! Đơn hàng của bạn đang được xử lý.</p>

            <div class="border-t border-pink-100 my-6 pt-4 text-left text-sm text-gray-600 space-y-2">
                <p><b>Người nhận:</b> <?php echo e($order->customer_name); ?> (<?php echo e($order->customer_phone); ?>)</p>
                <p><b>Địa chỉ nhận:</b> <?php echo e($order->customer_address); ?></p>
                <p><b>Tổng thanh toán:</b> <span class="font-bold text-pink-600"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?> VNĐ</span></p>
            </div>

            <a href="<?php echo e(route('home')); ?>" class="inline-block bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow">
                ← Tiếp tục mua sắm
            </a>
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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/orders/success.blade.php ENDPATH**/ ?>