

<?php $__env->startSection('title', 'Purchases & Suppliers - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Purchases & Supplier Management</h4>
            <span class="text-muted small">Record parts/accessories purchase orders and manage supplier records</span>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                <i class="ti tabler-user-plus me-1"></i>Register Supplier
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPurchaseModal">
                <i class="ti tabler-plus me-1"></i>New Stock-In Entry
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php if($errors->any()): ?>
        <div class="col-12 mb-3">
            <div class="alert alert-danger border-0 small py-2">
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Purchases History and Suppliers Tabs -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 pt-3">
                <ul class="nav nav-tabs" id="purchaseTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="purchases-tab" data-bs-toggle="tab" data-bs-target="#purchases-content" type="button" role="tab" aria-controls="purchases-content" aria-selected="true">
                            <i class="ti tabler-receipt me-1"></i>Stock-In Purchase Logs (<?php echo e(count($purchases)); ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers-content" type="button" role="tab" aria-controls="suppliers-content" aria-selected="false">
                            <i class="ti tabler-users me-1"></i>Registered Suppliers (<?php echo e(count($suppliers)); ?>)
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0 tab-content" id="purchaseTabsContent">
                <!-- Tab: Purchases -->
                <div class="tab-pane fade show active p-3" id="purchases-content" role="tabpanel" aria-labelledby="purchases-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Purchase No</th>
                                    <th>Supplier Name</th>
                                    <th>Items Restocked</th>
                                    <th>Total Cost</th>
                                    <th>Date Ordered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><span class="fw-bold text-dark"><?php echo e($purchase->purchase_no); ?></span></td>
                                    <td><?php echo e($purchase->supplier ? $purchase->supplier->name : 'N/A'); ?></td>
                                    <td>
                                        <ul class="list-unstyled mb-0 small">
                                            <?php $__currentLoopData = $purchase->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><i class="ti tabler-circle-filled fs-9 text-primary me-1"></i><?php echo e($detail->item ? $detail->item->name : 'Deleted Item'); ?> (x<?php echo e($detail->quantity); ?> @ <?php echo e(number_format($detail->cost_price, 0)); ?> BDT)</li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </td>
                                    <td><span class="fw-extrabold text-danger"><?php echo e(number_format($purchase->total_amount, 2)); ?> BDT</span></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No stock-in purchases logged.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Suppliers -->
                <div class="tab-pane fade p-3" id="suppliers-content" role="tabpanel" aria-labelledby="suppliers-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Phone Number</th>
                                    <th>Address Details</th>
                                    <th>Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><span class="fw-bold text-dark"><?php echo e($supplier->name); ?></span></td>
                                    <td><span class="fw-semibold text-dark"><?php echo e($supplier->phone); ?></span></td>
                                    <td><?php echo e($supplier->address ?? 'N/A'); ?></td>
                                    <td><?php echo e($supplier->created_at->format('M d, Y')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No registered suppliers found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Supplier -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addSupplierModalLabel">Register Supplier Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.purchases.suppliers')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="sup_name">Supplier / Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="sup_name" class="form-control" placeholder="e.g. Dhaka Parts Depot" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="sup_phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="sup_phone" class="form-control" placeholder="e.g. 01923456789" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="sup_address">Office Address Details</label>
                        <textarea name="address" id="sup_address" rows="3" class="form-control" placeholder="e.g. Level 4, Plaza Tower, Dhaka"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: New Stock-In Entry -->
<div class="modal fade" id="addPurchaseModal" tabindex="-1" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addPurchaseModalLabel">Log Stock-In Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.purchases.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="p_supplier_id">Select Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id" id="p_supplier_id" class="form-select" required>
                                <option value="" disabled selected>Select Supplier</option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="p_purchase_date">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" id="p_purchase_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 text-primary"><i class="ti tabler-list me-1"></i>Purchase Items:</h6>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle mb-3" id="purchase-items-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Catalog Description</th>
                                    <th style="width: 120px;">Qty Purchased</th>
                                    <th style="width: 150px;">Unit Cost (BDT)</th>
                                    <th class="text-center" style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody id="purchase-rows-body">
                                <tr>
                                    <td>
                                        <select name="items[0][inventory_item_id]" class="form-select form-select-sm" required>
                                            <option value="" disabled selected>Select Item...</option>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?> (SKU: <?php echo e($item->sku); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control form-control-sm text-center" value="1" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][cost_price]" step="0.01" min="0" class="form-control form-control-sm text-end" placeholder="0.00" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link btn-sm text-danger disabled remove-purchase-row"><i class="ti tabler-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-item-row-btn">
                        <i class="ti tabler-plus me-1"></i>Add Another Item
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Process Stock-In & Quantities</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = 1;
        const addRowBtn = document.getElementById('add-item-row-btn');
        const rowsBody = document.getElementById('purchase-rows-body');

        // Add row
        addRowBtn.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <select name="items[${rowCount}][inventory_item_id]" class="form-select form-select-sm" required>
                        <option value="" disabled selected>Select Item...</option>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?> (SKU: <?php echo e($item->sku); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][quantity]" class="form-control form-control-sm text-center" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][cost_price]" step="0.01" min="0" class="form-control form-control-sm text-end" placeholder="0.00" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-link btn-sm text-danger remove-purchase-row"><i class="ti tabler-trash"></i></button>
                </td>
            `;
            rowsBody.appendChild(tr);
            rowCount++;
            
            // Enable remove buttons if multiple rows
            updateRemoveButtons();
        });

        // Remove row
        rowsBody.addEventListener('click', function(e) {
            if (e.target.closest('.remove-purchase-row')) {
                const tr = e.target.closest('tr');
                tr.remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const buttons = document.querySelectorAll('.remove-purchase-row');
            if (buttons.length === 1) {
                buttons[0].classList.add('disabled');
            } else {
                buttons.forEach(btn => btn.classList.remove('disabled'));
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/purchases/index.blade.php ENDPATH**/ ?>