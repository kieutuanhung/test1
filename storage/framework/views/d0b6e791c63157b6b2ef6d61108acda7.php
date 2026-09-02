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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-pink-600 leading-tight">
                <?php echo e(__('Quản lý Sản phẩm')); ?>

            </h2>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow inline-block">
                + Thêm sản phẩm mới
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-pink-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-pink-100 p-6">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                        <tr class="bg-pink-50">
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Hình ảnh</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tên sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Giá</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Kho</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-pink-700 uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($product->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="w-12 h-12 object-cover rounded-lg border border-pink-200">
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">Không ảnh</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-pink-900"><?php echo e($product->name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-pink-600 font-medium"><?php echo e($product->category->name ?? 'Uncategorized'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700"><?php echo e(number_format($product->price, 0, ',', '.')); ?> VNĐ</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo e($product->stock); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-pink-600 hover:text-pink-900 font-bold mr-3">Sửa</a>
                                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Chưa có sản phẩm nào được tạo.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <?php echo e($products->links()); ?>

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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/admin/products/index.blade.php ENDPATH**/ ?>