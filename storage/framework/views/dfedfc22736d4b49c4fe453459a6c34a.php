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
            <?php echo e(__('Chỉnh Sửa Sản Phẩm')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-pink-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-pink-100 max-w-2xl mx-auto">
                <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="mb-4">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Danh mục sản phẩm:</label>
                        <select name="category_id" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Tên sản phẩm:</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-pink-700 text-sm font-bold mb-2">Giá bán (VNĐ):</label>
                            <input type="number" name="price" value="<?php echo e(old('price', $product->price)); ?>" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700" required>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="block text-pink-700 text-sm font-bold mb-2">Số lượng kho:</label>
                            <input type="number" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700" required>
                            <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Hình ảnh sản phẩm:</label>
                        <?php if($product->image): ?>
                            <div class="mb-2">
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="w-20 h-20 object-cover rounded-lg border border-pink-200">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700">
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-rose-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-6">
                        <label class="block text-pink-700 text-sm font-bold mb-2">Mô tả sản phẩm:</label>
                        <textarea name="description" rows="4" class="shadow-sm border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-lg w-full py-2 px-3 text-gray-700"><?php echo e(old('description', $product->description)); ?></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            Cập nhật sản phẩm
                        </button>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-pink-400 hover:text-pink-600 text-sm font-medium">Hủy bỏ</a>
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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>