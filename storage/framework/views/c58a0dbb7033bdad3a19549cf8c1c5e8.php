

<?php $__env->startSection('title', 'Job Cards - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h4 class="fw-bold mb-0">Repair Job Cards</h4>
        <?php if(auth()->user()->isSuperAdmin()): ?>
        <a href="<?php echo e(route('admin.repairs.create')); ?>" class="btn btn-primary"><i class="ti tabler-plus me-1"></i>Create Job Card</a>
        <?php endif; ?>
    </div>



    <!-- Filter & Search Section -->
    <div class="card-body bg-light border-top border-bottom py-3">
        <form action="<?php echo e(route('admin.repairs.index')); ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by Ticket ID or Phone..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending confirmation</option>
                    <option value="diagnosing" <?php echo e(request('status') == 'diagnosing' ? 'selected' : ''); ?>>Diagnosing</option>
                    <option value="waiting_for_approval" <?php echo e(request('status') == 'waiting_for_approval' ? 'selected' : ''); ?>>Waiting Approval</option>
                    <option value="repairing" <?php echo e(request('status') == 'repairing' ? 'selected' : ''); ?>>Repairing</option>
                    <option value="quality_check" <?php echo e(request('status') == 'quality_check' ? 'selected' : ''); ?>>Quality Check</option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed (Ready)</option>
                    <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="month" name="month" class="form-control" value="<?php echo e(request('month')); ?>">
            </div>
            <div class="col-md-2">
                <select name="per_page" class="form-select">
                    <option value="10" <?php echo e(request('per_page', '10') == '10' ? 'selected' : ''); ?>>10 / Page</option>
                    <option value="25" <?php echo e(request('per_page') == '25' ? 'selected' : ''); ?>>25 / Page</option>
                    <option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50 / Page</option>
                    <option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100 / Page</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1.5">
                <button type="submit" class="btn btn-primary w-100 px-2"><i class="ti tabler-search me-1"></i>Filter</button>
                <a href="<?php echo e(route('admin.repairs.index')); ?>" class="btn btn-outline-secondary w-100 px-2">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ticket ID</th>
                    <th>Customer Name</th>
                    <th>Device Details</th>
                    <th>Status</th>
                    <th>Est. / Final Cost</th>
                    <th>Paid So Far</th>
                    <th>Expected Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $repairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('admin.repairs.show', $repair->id)); ?>" class="fw-bold text-decoration-none"><?php echo e($repair->ticket_id); ?></a>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark"><?php echo e($repair->customer ? $repair->customer->name : 'Walk-in Customer'); ?></div>
                        <div class="text-muted small"><?php echo e($repair->customer ? $repair->customer->phone : ''); ?></div>
                    </td>
                    <td>
                        <span class="fw-semibold text-dark"><?php echo e($repair->device_brand); ?></span>
                        <span><?php echo e($repair->device_model); ?></span>
                        <?php if($repair->serial_imei): ?>
                            <div class="text-muted small">IMEI: <?php echo e($repair->serial_imei); ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $badges = [
                                'pending' => 'bg-warning',
                                'diagnosing' => 'bg-info',
                                'waiting_for_approval' => 'bg-secondary',
                                'repairing' => 'bg-primary',
                                'quality_check' => 'bg-dark',
                                'completed' => 'bg-success',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger'
                            ];
                        ?>
                        <span class="badge <?php echo e($badges[$repair->status] ?? 'bg-secondary'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $repair->status))); ?></span>
                    </td>
                    <td>
                        <div class="small text-muted">Est: <?php echo e(number_format($repair->estimated_cost, 0)); ?> BDT</div>
                        <?php if($repair->actual_cost !== null): ?>
                            <div class="small text-dark">Bill: <?php echo e(number_format($repair->actual_cost, 0)); ?> BDT</div>
                            <?php if($repair->due_amount > 0): ?>
                                <div class="badge bg-label-danger" style="font-size: 0.7rem;">Due: <?php echo e(number_format($repair->due_amount, 0)); ?> BDT</div>
                            <?php else: ?>
                                <div class="badge bg-label-success" style="font-size: 0.7rem;">Paid</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="fw-bold text-dark"><?php echo e(number_format($repair->paid_amount, 0)); ?> BDT</span>
                        <?php if($repair->advance_payment > 0): ?>
                            <div class="text-muted" style="font-size: 0.75rem;">(Adv: <?php echo e(number_format($repair->advance_payment, 0)); ?>)</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo e($repair->expected_delivery_date ? \Carbon\Carbon::parse($repair->expected_delivery_date)->format('M d, Y') : 'Not Set'); ?>

                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex">
                            <a href="<?php echo e(route('admin.repairs.show', $repair->id)); ?>" class="btn btn-icon btn-sm btn-outline-info me-1" title="View details"><i class="ti tabler-eye"></i></a>
                            <a href="<?php echo e(route('admin.repairs.edit', $repair->id)); ?>" class="btn btn-icon btn-sm btn-outline-primary me-1" title="Update Job Card"><i class="ti tabler-edit"></i></a>
                            
                            <?php if(auth()->user()->isSuperAdmin()): ?>
                            <form action="<?php echo e(route('admin.repairs.destroy', $repair->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this Job Card ticket?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="ti tabler-info-circle fs-2 d-block mb-2 text-muted"></i>
                        No Job Cards registered or assigned.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($repairs->hasPages()): ?>
    <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
        <?php echo e($repairs->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/repairs/index.blade.php ENDPATH**/ ?>