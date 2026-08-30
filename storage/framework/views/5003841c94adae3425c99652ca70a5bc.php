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
            <?php echo e(__('Giỏ Hàng Của Bạn')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-pink-50/40 min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(count($cart) > 0): ?>
                <div class="bg-white rounded-2xl border border-pink-100 overflow-hidden shadow-sm p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-pink-50">
                                <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Sản phẩm</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase">Đơn giá</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Số lượng</th>
                                <th class="px-4 py-3 text-right text-xs font-bold text-pink-700 uppercase">Thành tiền</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase">Xóa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-4 flex items-center gap-3">
                                        <?php if(!empty($item['image'])): ?>
                                            <img src="<?php echo e(asset('storage/' . $item['image'])); ?>" class="w-12 h-12 object-cover rounded-lg border border-pink-200">
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('shop.show', $item['slug'])); ?>" class="font-bold text-gray-800 hover:text-pink-600">
                                            <?php echo e($item['name']); ?>

                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600"><?php echo e(number_format($item['price'], 0, ',', '.')); ?> đ</td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="<?php echo e(route('cart.update', $id)); ?>" method="POST" class="inline-flex items-center gap-1">
                                            <?php echo csrf_field(); ?>
                                            <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" class="w-16 text-center border-pink-200 rounded-lg text-sm">
                                            <button type="submit" class="text-xs bg-pink-100 hover:bg-pink-200 text-pink-700 px-2 py-1.5 rounded">Lưu</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 text-right font-bold text-pink-600">
                                        <?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?> đ
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">✕</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="mt-8 border-t border-pink-100 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <a href="<?php echo e(route('home')); ?>" class="text-pink-600 hover:underline font-bold text-sm">← Tiếp tục mua hàng</a>
                        
                        <div class="text-right">
                            <p class="text-lg font-medium text-gray-600">Tổng cộng thanh toán:</p>
                            <p class="text-3xl font-extrabold text-pink-600"><?php echo e(number_format($total, 0, ',', '.')); ?> VNĐ</p>
                            <a href="<?php echo e(route('order.checkout')); ?>" class="mt-4 inline-block bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">
                                Tiến hành Thanh toán (Checkout) →
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-2xl border border-pink-100 text-center py-16 p-6 shadow-sm">
                    <p class="text-gray-500 text-lg mb-4">Giỏ hàng của bạn đang trống trơn!</p>
                    <a href="<?php echo e(route('home')); ?>" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow">
                        Mua sắm ngay
                    </a>
                </div>
            <?php endif; ?>
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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/cart/index.blade.php ENDPATH**/ ?>