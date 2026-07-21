<?php $__env->startSection('title', 'Salesman Dashboard - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Welcome Header -->
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="text-white fw-bold mb-1">Welcome, <?php echo e(auth()->user()->name); ?>!</h2>
                        <p class="mb-0 text-white opacity-85">Manage POS product checkout sales, register new customers, and review stock availability of mobile accessories.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="<?php echo e(route('admin.pos.index')); ?>" class="btn btn-white bg-white text-primary fw-bold px-4 py-2.5 shadow-sm"><i class="ti tabler-device-laptop me-1"></i>Open POS Terminal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Ticket Tracker Card -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important; color: #fff;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-label-info p-2.5 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: rgba(0, 207, 232, 0.16) !important;">
                                <i class="ti tabler-search text-info fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-white">Live Repair Ticket Tracker</h5>
                                <p class="mb-0 text-slate-400 small">Quickly lookup device repair history, active laboratory status, and billing estimates.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <form onsubmit="event.preventDefault(); performLiveTrack(this.ticket_id.value);">
                            <div class="input-group">
                                <input type="text" name="ticket_id" class="form-control text-white" placeholder="Enter Ticket ID (e.g. M3-202607-XXXX)" required style="border-radius: 8px 0 0 8px; background-color: rgba(0,0,0,0.25); border-color: rgba(255,255,255,0.1); color: #fff !important;">
                                <button class="btn btn-primary fw-bold" type="submit">
                                    <i class="ti tabler-search me-1"></i>Trace Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Banner: Low Accessories Stock -->
    <?php if($accessoriesAlertCount > 0): ?>
    <div class="col-12 mb-4">
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center justify-content-between p-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti tabler-alert-triangle fs-3 me-2 text-warning"></i>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Accessories Low Stock!</h6>
                    <p class="mb-0 small">There are <strong><?php echo e($accessoriesAlertCount); ?></strong> mobile accessories in inventory that are running low on stock levels.</p>
                </div>
            </div>
            <a href="<?php echo e(route('admin.inventory.accessories')); ?>" class="btn btn-warning btn-sm fw-bold">Manage Stock</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Stats Cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">My POS Invoices Today</span>
                    <h3 class="card-title fw-extrabold mb-0 text-primary"><?php echo e($mySalesTodayCount); ?></h3>
                </div>
                <div class="rounded-circle bg-label-primary p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-receipt fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">My Revenue Today</span>
                    <h3 class="card-title fw-extrabold mb-0 text-success"><?php echo e(number_format($mySalesTodayRevenue, 2)); ?> BDT</h3>
                </div>
                <div class="rounded-circle bg-label-success p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-currency-dollar fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Accessories In Stock</span>
                    <h3 class="card-title fw-extrabold mb-0 text-info"><?php echo e($activeAccessoriesCount); ?></h3>
                </div>
                <div class="rounded-circle bg-label-info p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-plug fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Low Stock Items</span>
                    <h3 class="card-title fw-extrabold mb-0 text-danger"><?php echo e($accessoriesAlertCount); ?></h3>
                </div>
                <div class="rounded-circle bg-label-danger p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-package fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales Invoices List -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">My Recent Invoices</h5>
                <a href="<?php echo e(route('admin.pos.index')); ?>" class="btn btn-primary btn-sm"><i class="ti tabler-plus me-1"></i>New Sale Checkout</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>Payable Amount</th>
                            <th>Payment Method</th>
                            <th>Date / Time</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><span class="fw-bold text-dark"><?php echo e($sale->invoice_no); ?></span></td>
                            <td>
                                <span class="fw-semibold"><?php echo e($sale->customer ? $sale->customer->name : 'Walk-in Customer'); ?></span>
                                <?php if($sale->customer): ?>
                                    <div class="text-muted small"><?php echo e($sale->customer->phone); ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(number_format($sale->total_amount, 2)); ?> BDT</td>
                            <td><?php echo e(number_format($sale->discount, 2)); ?> BDT</td>
                            <td><span class="fw-bold text-success"><?php echo e(number_format($sale->payable_amount, 2)); ?> BDT</span></td>
                            <td><span class="badge bg-label-primary"><?php echo e($sale->payment_method); ?></span></td>
                            <td><span class="small text-muted"><?php echo e($sale->created_at->format('M d, Y H:i A')); ?></span></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.pos.invoice', $sale->id)); ?>" target="_blank" class="btn btn-icon btn-sm btn-outline-info" title="Print Invoice"><i class="ti tabler-printer"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No sales invoices processed today yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/dashboard/salesman.blade.php ENDPATH**/ ?>