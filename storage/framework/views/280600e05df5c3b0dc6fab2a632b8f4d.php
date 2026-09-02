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
            <?php echo e(__('Chỉnh Sửa Danh Mục')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-pink-100 max-w-2xl mx-auto">
                <form action="<?php echo e(route('admin.categories.update', $category)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Ô cập nhật Tên Danh mục -->
                    <div class="mb-4">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Tên danh mục:</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $category->name)); ?>" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rose-500 text-xs italic mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Ô cập nhật Mô tả -->
                    <div class="mb-6">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Mô tả danh mục:</label>
                        <textarea name="description" rows="4" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700"><?php echo e(old('description', $category->description)); ?></textarea>
                    </div>

                    <!-- Nút Thao tác -->
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                            Cập nhật danh mục
                        </button>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-pink-400 hover:text-pink-600 text-sm font-medium">Hủy bỏ</a>
                    </div>
                </form>
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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/admin/categories/edit.blade.php ENDPATH**/ ?>