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
                <?php echo e(__('Quản lý Danh mục')); ?>

            </h2>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow inline-block">
                + Thêm danh mục mới
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
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Tên danh mục</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-pink-700 uppercase">Mô tả</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-pink-700 uppercase">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($category->id); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-pink-900"><?php echo e($category->name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($category->slug); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($category->description ?? 'Không có'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="text-pink-600 hover:text-pink-900 font-bold mr-3">Sửa</a>
                                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Chưa có danh mục nào được tạo.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <?php echo e($categories->links()); ?>

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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>