

<?php $__env->startSection('title', 'Spare Parts Stock - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Spare Parts Inventory</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Spare Parts</li>
                </ol>
            </nav>
        <a href="<?php echo e(route('admin.inventory.create', ['type' => 'spare_part'])); ?>" class="btn btn-primary">
            <i class="ti tabler-plus me-1"></i>Add Spare Part
        </a>
    </div>

    <!-- Alert Notifications -->

    <!-- Main Content -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 py-3">
                <form action="<?php echo e(route('admin.inventory.parts')); ?>" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search SKU, name..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2">
                        <select name="category_id" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="supplier_id" class="form-select form-select-sm">
                            <option value="">All Suppliers</option>
                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sup->id); ?>" <?php echo e(request('supplier_id') == $sup->id ? 'selected' : ''); ?>><?php echo e($sup->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="stock_status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="in" <?php echo e(request('stock_status') == 'in' ? 'selected' : ''); ?>>In Stock</option>
                            <option value="low" <?php echo e(request('stock_status') == 'low' ? 'selected' : ''); ?>>Low Stock Alert</option>
                            <option value="out" <?php echo e(request('stock_status') == 'out' ? 'selected' : ''); ?>>Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="per_page" class="form-select form-select-sm">
                            <option value="10" <?php echo e(request('per_page', '10') == '10' ? 'selected' : ''); ?>>10 / Page</option>
                            <option value="25" <?php echo e(request('per_page') == '25' ? 'selected' : ''); ?>>25 / Page</option>
                            <option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50 / Page</option>
                            <option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100 / Page</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1.5">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti tabler-search me-0.5"></i>Filter</button>
                        <a href="<?php echo e(route('admin.inventory.parts')); ?>" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">Image</th>
                            <th>SKU</th>
                            <th>Part Name</th>
                            <th>Category</th>
                            <th>Barcode</th>
                            <th>Stock Quantity</th>
                            <th>Cost Price</th>
                            <th>Sale Price</th>
                            <th class="text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $isLowStock = $item->quantity <= $item->alert_quantity;
                        ?>
                        <tr class="<?php echo e($isLowStock ? 'table-warning' : ''); ?>">
                            <td>
                                <?php if(!empty($item->images) && is_array($item->images) && count($item->images) > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->images[0])); ?>" class="rounded shadow-xs" alt="<?php echo e($item->name); ?>" style="width: 42px; height: 42px; object-fit: cover; border: 1px solid rgba(0,0,0,0.08);">
                                <?php else: ?>
                                    <div class="rounded d-flex align-items-center justify-content-center bg-light text-muted" style="width: 42px; height: 42px; border: 1px solid rgba(0,0,0,0.08);">
                                        <i class="ti tabler-photo fs-4 text-secondary"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><span class="fw-bold text-dark"><?php echo e($item->sku); ?></span></td>
                            <td>
                                <div class="fw-semibold text-dark"><?php echo e($item->name); ?></div>
                                <?php if($isLowStock): ?>
                                    <span class="badge bg-label-danger fs-9">Low Stock Alert (Threshold: <?php echo e($item->alert_quantity); ?>)</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($item->categoryRelation ? $item->categoryRelation->name : $item->category); ?></td>
                            <td><?php echo e($item->barcode ?? 'N/A'); ?></td>
                            <td>
                                <span class="fw-extrabold text-dark fs-5 <?php echo e($isLowStock ? 'text-danger' : 'text-success'); ?>"><?php echo e($item->quantity); ?></span> pcs
                            </td>
                            <td><?php echo e(number_format($item->purchase_price, 2)); ?> BDT</td>
                            <td><span class="fw-bold text-success"><?php echo e(number_format($item->sale_price, 2)); ?> BDT</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex">
                                    <a href="<?php echo e(route('admin.inventory.edit', $item->id)); ?>" class="btn btn-icon btn-sm btn-outline-primary me-1" title="Edit Item">
                                        <i class="ti tabler-edit"></i>
                                    </a>
                                    
                                    <form action="<?php echo e(route('admin.inventory.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to remove this item from catalog?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">No spare parts matching search details.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($items->hasPages()): ?>
            <div class="card-footer bg-transparent border-0 d-flex justify-content-end py-3">
                <?php echo e($items->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/inventory/parts.blade.php ENDPATH**/ ?>