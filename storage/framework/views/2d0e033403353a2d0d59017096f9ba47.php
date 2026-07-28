<?php $__env->startSection('title', 'Mobile Accessories Catalog - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Accessories Shop</h2>
        <div class="ul-breadcrumb-nav">
            <a href="<?php echo e(route('home')); ?>"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Accessories Shop</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- MAIN CONTENT SECTION START -->
<div class="ul-inner-page-container">
    <div class="ul-inner-products-wrapper">
        <div class="ul-container">
            <div class="row ul-bs-row flex-column-reverse flex-md-row">
                <!-- left sidebar filter -->
                <div class="col-lg-3 col-md-4">
                    <div class="ul-products-sidebar">
                        <!-- search widget -->
                        <div class="ul-products-sidebar-widget ul-products-search">
                            <form action="<?php echo e(route('shop.catalog')); ?>" method="GET" class="ul-products-search-form">
                                <input type="text" name="search" id="ul-products-search-field" placeholder="Search Accessories..." value="<?php echo e(request('search')); ?>">
                                <button type="submit"><i class="flaticon-search-interface-symbol"></i></button>
                            </form>
                        </div>

                        <!-- categories widget -->
                        <div class="ul-products-sidebar-widget ul-products-categories">
                            <h3 class="ul-products-sidebar-widget-title">Categories</h3>

                            <div class="ul-products-categories-link">
                                <a href="<?php echo e(route('shop.catalog')); ?>" class="<?php echo e(request('category') == '' ? 'active fw-bold' : ''); ?>">
                                    <span><i class="flaticon-arrow-point-to-right"></i> All Accessories</span>
                                </a>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('shop.catalog', ['category' => $cat->id, 'search' => request('search')])); ?>" class="<?php echo e(request('category') == $cat->id ? 'active fw-bold' : ''); ?>">
                                        <span><i class="flaticon-arrow-point-to-right"></i> <?php echo e($cat->name); ?></span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- product status widget -->
                        <div class="ul-products-sidebar-widget">
                            <h3 class="ul-products-sidebar-widget-title">Filter Options</h3>

                            <div class="ul-products-categories-link">
                                <a href="<?php echo e(route('shop.catalog')); ?>"><span><i class="flaticon-arrow-point-to-right"></i> In Stock Items</span></a>
                                <?php if(request('search') || request('category')): ?>
                                    <a href="<?php echo e(route('shop.catalog')); ?>" class="text-danger"><span><i class="flaticon-close"></i> Clear All Filters</span></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- right products grid -->
                <div class="col-lg-9 col-md-8">
                    <?php if($accessories->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="flaticon-shopping-bag display-1 text-muted"></i>
                            <h3 class="mt-3">No accessories found</h3>
                            <p class="text-muted">Try adjusting your search query or selected category filter.</p>
                            <a href="<?php echo e(route('shop.catalog')); ?>" class="ul-btn mt-3">Browse All Accessories <i class="flaticon-up-right-arrow"></i></a>
                        </div>
                    <?php else: ?>
                        <div class="row ul-bs-row row-cols-lg-3 row-cols-2 row-cols-xxs-1">
                            <?php $__currentLoopData = $accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col mb-4">
                                    <div class="ul-product">
                                        <div class="ul-product-heading">
                                            <span class="ul-product-price">৳<?php echo e(number_format($item->sale_price, 2)); ?></span>
                                            <span class="ul-product-discount-tag">In Stock</span>
                                        </div>

                                        <div class="ul-product-img">
                                            <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->name); ?>" onerror="this.src='<?php echo e(asset('frontend/img/product-img-1.jpg')); ?>'">

                                            <div class="ul-product-actions">
                                                <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?php echo e($item->id); ?>">
                                                    <button type="submit" title="Add to Cart" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="flaticon-shopping-bag"></i></button>
                                                </form>
                                                <form action="<?php echo e(route('wishlist.toggle')); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?php echo e($item->id); ?>">
                                                    <button type="submit" title="Add to Wishlist" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="flaticon-heart"></i></button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="ul-product-txt">
                                            <h4 class="ul-product-title"><a href="<?php echo e(route('shop.show', $item->id)); ?>"><?php echo e($item->name); ?></a></h4>
                                            <h5 class="ul-product-category"><a href="<?php echo e(route('shop.catalog', ['category' => $item->category_id])); ?>"><?php echo e($item->categoryRelation->name ?? $item->category ?? 'Accessory'); ?></a></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- SAAFIE CUSTOM PAGINATION -->
                        <?php if($accessories->hasPages()): ?>
                            <div class="ul-pagination">
                                <ul>
                                    
                                    <?php if($accessories->onFirstPage()): ?>
                                        <li class="disabled"><span><i class="flaticon-left-arrow"></i></span></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo e($accessories->previousPageUrl()); ?>"><i class="flaticon-left-arrow"></i></a></li>
                                    <?php endif; ?>

                                    
                                    <li class="pages">
                                        <?php $__currentLoopData = $accessories->getUrlRange(1, $accessories->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($page == $accessories->currentPage()): ?>
                                                <a href="<?php echo e($url); ?>" class="active"><?php echo e(sprintf('%02d', $page)); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e($url); ?>"><?php echo e(sprintf('%02d', $page)); ?></a>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </li>

                                    
                                    <?php if($accessories->hasMorePages()): ?>
                                        <li><a href="<?php echo e($accessories->nextPageUrl()); ?>"><i class="flaticon-arrow-point-to-right"></i></a></li>
                                    <?php else: ?>
                                        <li class="disabled"><span><i class="flaticon-arrow-point-to-right"></i></span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MAIN CONTENT SECTION END -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/frontend/shop.blade.php ENDPATH**/ ?>