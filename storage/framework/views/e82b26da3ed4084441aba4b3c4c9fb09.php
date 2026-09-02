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
    <div class="bg-pink-50/40 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Thanh lọc Danh mục -->
            <div class="flex flex-wrap items-center gap-2 mb-8 bg-white p-4 rounded-xl border border-pink-100 shadow-sm">
                <span class="font-bold text-pink-700 mr-2">Danh mục:</span>
                <a href="<?php echo e(route('home')); ?>" class="px-4 py-1.5 rounded-full text-sm font-medium transition <?php echo e(!request('category') ? 'bg-pink-600 text-white shadow' : 'bg-pink-100 text-pink-700 hover:bg-pink-200'); ?>">
                    Tất cả
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('home', ['category' => $cat->slug])); ?>" class="px-4 py-1.5 rounded-full text-sm font-medium transition <?php echo e(request('category') == $cat->slug ? 'bg-pink-600 text-white shadow' : 'bg-pink-100 text-pink-700 hover:bg-pink-200'); ?>">
                        <?php echo e($cat->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Lưới Sản phẩm (Grid Card) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-2xl border border-pink-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <a href="<?php echo e(route('shop.show', $product->slug)); ?>">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                            <?php else: ?>
                                <div class="w-full h-48 bg-pink-100 flex items-center justify-center text-pink-400 font-bold">Không có hình ảnh</div>
                            <?php endif; ?>
                        </a>
                        
                        <div class="p-4 flex flex-col flex-grow justify-between">
                            <div>
                                <span class="text-xs text-pink-500 font-semibold uppercase tracking-wider"><?php echo e($product->category->name ?? 'Chưa phân loại'); ?></span>
                                <h3 class="font-bold text-gray-800 text-base mt-1 line-clamp-2">
                                    <a href="<?php echo e(route('shop.show', $product->slug)); ?>" class="hover:text-pink-600">
                                        <?php echo e($product->name); ?>

                                    </a>
                                </h3>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-lg font-bold text-pink-600"><?php echo e(number_format($product->price, 0, ',', '.')); ?> đ</span>
                                
                                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white p-2 rounded-lg transition shadow">
                                        🛒 Thêm
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-12 text-gray-500 bg-white rounded-2xl border border-pink-100">
                        Chưa có sản phẩm nào trong danh mục này.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Phân trang -->
            <div class="mt-8">
                <?php echo e($products->links()); ?>

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
<?php /**PATH /home/kali/WebProject/shopping-website-laravel/resources/views/shop/index.blade.php ENDPATH**/ ?>