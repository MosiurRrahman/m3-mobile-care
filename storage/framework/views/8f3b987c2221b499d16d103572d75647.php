<?php $__env->startSection('title', 'Admin Dashboard - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Welcome Header -->
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #7367f0 0%, #a097ff 100%) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="text-white fw-bold mb-1">M3 Mobile Care - <?php echo e($showFinancials ? 'Super Admin Portal' : 'Admin Portal'); ?></h2>
                        <p class="mb-0 text-white opacity-85">
                            <?php if($showFinancials): ?>
                                Manage repair tickets, POS checkout transactions, parts/accessories inventory, expenses, and staff productivity reports.
                            <?php else: ?>
                                Manage repair tickets, POS checkout transactions, and parts/accessories inventory.
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="<?php echo e(route('admin.repairs.create')); ?>" class="btn btn-white bg-white text-primary fw-bold px-4 py-2.5 shadow-sm"><i class="ti tabler-plus me-1"></i>Create Job Card</a>
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

    <!-- Alert Banner: Low Stock -->
    <?php if($stockAlertsCount > 0): ?>
    <div class="col-12 mb-4">
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center justify-content-between p-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti tabler-alert-triangle fs-3 me-2 text-warning"></i>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Low Stock Warning!</h6>
                    <p class="mb-0 small">There are <strong><?php echo e($stockAlertsCount); ?></strong> items in inventory that have dropped below their minimum alert threshold levels.</p>
                </div>
            </div>
            <a href="<?php echo e(route('admin.reports.index')); ?>#stock-alerts" class="btn btn-warning btn-sm fw-bold">View Items</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Statistics Cards -->
    <?php if($showFinancials): ?>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Total Revenue</span>
                    <h3 class="card-title fw-extrabold mb-0 text-primary"><?php echo e(number_format($totalRevenue, 2)); ?> BDT</h3>
                    <?php if($totalSalesDues > 0): ?>
                        <span class="text-danger small fw-semibold">Dues: <?php echo e(number_format($totalSalesDues, 2)); ?> BDT</span>
                    <?php else: ?>
                        <span class="text-muted small">No outstanding dues</span>
                    <?php endif; ?>
                </div>
                <div class="rounded-circle bg-label-primary p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-currency-dollar fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Total Expenses</span>
                    <h3 class="card-title fw-extrabold mb-0 text-danger"><?php echo e(number_format($totalExpenses, 2)); ?> BDT</h3>
                </div>
                <div class="rounded-circle bg-label-danger p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-receipt fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Total Jobs Logged</span>
                    <h3 class="card-title fw-extrabold mb-0 text-primary"><?php echo e($totalRepairs); ?></h3>
                </div>
                <div class="rounded-circle bg-label-primary p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-device-mobile fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Pending Confirmation</span>
                    <h3 class="card-title fw-extrabold mb-0 text-danger"><?php echo e($pendingRepairs); ?></h3>
                </div>
                <div class="rounded-circle bg-label-danger p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-ticket fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Active Repairs</span>
                    <h3 class="card-title fw-extrabold mb-0 text-warning"><?php echo e($inProgressRepairs); ?></h3>
                </div>
                <div class="rounded-circle bg-label-warning p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-hourglass fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Stock Alerts</span>
                    <h3 class="card-title fw-extrabold mb-0 text-info"><?php echo e($stockAlertsCount); ?></h3>
                </div>
                <div class="rounded-circle bg-label-info p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-package fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphical Analytics charts -->
    <?php if($showFinancials): ?>
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="fw-bold mb-0 text-dark">Financial Performance Trends</h5>
            </div>
            <div class="card-body py-4">
                <canvas id="financialChart" style="max-height: 290px;"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Repairs Status Breakdown -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Repairs by Status</h5>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-ticket me-2 text-warning"></i>Pending Confirm</span>
                        <span class="badge bg-warning rounded-pill"><?php echo e($statusCounts['pending'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-zoom-check me-2 text-info"></i>Diagnosing</span>
                        <span class="badge bg-info rounded-pill"><?php echo e($statusCounts['diagnosing'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-clock me-2 text-muted"></i>Waiting Approval</span>
                        <span class="badge bg-secondary rounded-pill"><?php echo e($statusCounts['waiting_for_approval'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-tool me-2 text-primary"></i>Repairing</span>
                        <span class="badge bg-primary rounded-pill"><?php echo e($statusCounts['repairing'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-shield-check me-2 text-dark"></i>Quality Check</span>
                        <span class="badge bg-dark rounded-pill"><?php echo e($statusCounts['quality_check'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-circle-check me-2 text-success"></i>Ready (Completed)</span>
                        <span class="badge bg-success rounded-pill"><?php echo e($statusCounts['completed'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-1 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-archive me-2 text-success"></i>Delivered</span>
                        <span class="badge bg-success rounded-pill"><?php echo e($statusCounts['delivered'] ?? 0); ?></span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-0">
                        <span class="d-flex align-items-center"><i class="ti tabler-circle-x me-2 text-danger"></i>Cancelled</span>
                        <span class="badge bg-danger rounded-pill"><?php echo e($statusCounts['cancelled'] ?? 0); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Job Cards Table -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Recent Job Cards</h5>
                <a href="<?php echo e(route('admin.repairs.index')); ?>" class="btn btn-outline-primary btn-sm">View All Tickets</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ticket ID</th>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Est. Cost</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentRepairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(route('admin.repairs.show', $repair->id)); ?>" class="fw-bold text-decoration-none"><?php echo e($repair->ticket_id); ?></a></td>
                            <td>
                                <div class="fw-semibold text-dark"><?php echo e($repair->customer ? $repair->customer->name : 'Walk-in'); ?></div>
                                <div class="text-muted small"><?php echo e($repair->customer ? $repair->customer->phone : ''); ?></div>
                            </td>
                            <td><?php echo e($repair->device_brand); ?> <?php echo e($repair->device_model); ?></td>
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
                            <td><?php echo e(number_format($repair->estimated_cost, 0)); ?> BDT</td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.repairs.show', $repair->id)); ?>" class="btn btn-icon btn-sm btn-outline-info me-1"><i class="ti tabler-eye"></i></a>
                                <a href="<?php echo e(route('admin.repairs.edit', $repair->id)); ?>" class="btn btn-icon btn-sm btn-outline-primary"><i class="ti tabler-edit"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No Job Cards found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock Inventory Warnings -->
    <?php if($stockAlertsCount > 0): ?>
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-label-danger p-2 d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px; background: rgba(234, 84, 85, 0.16) !important;">
                        <i class="ti tabler-alert-triangle text-danger fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Low Stock Inventory Warnings</h5>
                </div>
                <span class="badge bg-danger rounded-pill"><?php echo e($stockAlertsCount); ?> Items Alert</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Current Stock</th>
                            <th>Min. Alert Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-bold text-dark"><?php echo e($item->name); ?></td>
                            <td><span class="badge bg-label-secondary font-monospace"><?php echo e($item->sku); ?></span></td>
                            <td><?php echo e($item->category ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-label-<?php echo e($item->type === 'part' ? 'primary' : 'success'); ?> text-capitalize">
                                    <?php echo e($item->type); ?>

                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-danger"><?php echo e($item->quantity); ?></span>
                            </td>
                            <td>
                                <span class="text-muted"><?php echo e($item->alert_quantity); ?></span>
                            </td>
                            <td>
                                <?php if($item->quantity == 0): ?>
                                <span class="badge bg-danger">Out of Stock</span>
                                <?php else: ?>
                                <span class="badge bg-warning">Low Stock</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(auth()->user()->isSuperAdmin()): ?>
    <!-- Top Technician Leaderboard -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0"><i class="ti tabler-award me-2 text-primary"></i>Top Technicians Performance</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Technician Name</th>
                            <th>Skill Level</th>
                            <th>Jobs Completed</th>
                            <?php if($showFinancials): ?>
                            <th>Revenue Generated</th>
                            <?php endif; ?>
                            <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $topTechnicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-label-primary p-2 d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="ti tabler-user-cog"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?php echo e($tech->name); ?></span>
                                </div>
                            </td>
                            <td><?php echo e($tech->skill_level ?? 'N/A'); ?></td>
                            <td><span class="badge bg-success fs-6"><?php echo e($tech->jobs_count); ?></span></td>
                            <?php if($showFinancials): ?>
                            <td><span class="fw-bold text-success"><?php echo e(number_format($tech->revenue_generated ?? 0, 2)); ?> BDT</span></td>
                            <?php endif; ?>
                            <td><?php echo e($tech->branch ?? 'N/A'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">No technician data recorded yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(auth()->user()->isSuperAdmin()): ?>
    <!-- Recent Staff Activities -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-0">
                <h5 class="fw-bold mb-0"><i class="ti tabler-history me-2 text-primary"></i>Recent Staff Activities</h5>
                <span class="badge bg-label-primary rounded-pill">Real-time Updates</span>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Staff Member</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Resource ID / Link</th>
                                <th>IP Address</th>
                                <th class="text-end">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-label-info p-2 d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            <i class="ti tabler-user"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?php echo e($log->user ? $log->user->name : 'System'); ?></div>
                                            <div class="text-muted small text-capitalize"><?php echo e($log->user ? str_replace('_', ' ', $log->user->role) : ''); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        $actionBadges = [
                                            'created' => 'bg-label-success',
                                            'updated' => 'bg-label-warning',
                                            'deleted' => 'bg-label-danger',
                                        ];
                                        $actionIcons = [
                                            'created' => 'tabler-plus',
                                            'updated' => 'tabler-edit',
                                            'deleted' => 'tabler-trash',
                                        ];
                                        $badgeClass = $actionBadges[$log->action] ?? 'bg-label-secondary';
                                        $iconClass = $actionIcons[$log->action] ?? 'tabler-info-circle';
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?> d-inline-flex align-items-center px-2.5 py-1">
                                        <i class="ti <?php echo e($iconClass); ?> fs-6 me-1"></i><?php echo e(ucfirst($log->action)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark fw-medium"><?php echo e($log->description); ?></span>
                                </td>
                                <td>
                                    <?php
                                        $modelClass = class_basename($log->loggable_type);
                                    ?>
                                    <?php if($modelClass === 'Repair'): ?>
                                        <a href="<?php echo e(route('admin.repairs.show', $log->loggable_id)); ?>" class="badge bg-primary text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-ticket me-1"></i>View Repair
                                        </a>
                                    <?php elseif($modelClass === 'SocialPost'): ?>
                                        <a href="<?php echo e(route('admin.social.index')); ?>" class="badge bg-info text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-share me-1"></i>View Social Posts
                                        </a>
                                    <?php elseif($modelClass === 'Expense'): ?>
                                        <a href="<?php echo e(route('admin.expenses.index')); ?>" class="badge bg-danger text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-receipt me-1"></i>View Expenses
                                        </a>
                                    <?php elseif($modelClass === 'Sale'): ?>
                                        <a href="<?php echo e(route('admin.pos.invoice', $log->loggable_id)); ?>" class="badge bg-success text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-file-invoice me-1"></i>View Invoice
                                        </a>
                                    <?php elseif($modelClass === 'Purchase'): ?>
                                        <a href="<?php echo e(route('admin.purchases.index')); ?>" class="badge bg-warning text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-shopping-cart me-1"></i>View Purchases
                                        </a>
                                    <?php elseif($modelClass === 'InventoryItem'): ?>
                                        <a href="<?php echo e(route('admin.inventory.edit', $log->loggable_id)); ?>" class="badge bg-secondary text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-box me-1"></i>Edit Item
                                        </a>
                                    <?php elseif($modelClass === 'User'): ?>
                                        <a href="<?php echo e(route('admin.users.index')); ?>" class="badge bg-dark text-white text-decoration-none py-1.5 px-2.5">
                                            <i class="ti tabler-users me-1"></i>View Users
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">#<?php echo e($log->loggable_id); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted small font-monospace"><?php echo e($log->ip_address ?? 'N/A'); ?></span>
                                </td>
                                <td class="text-end">
                                    <div class="fw-bold text-dark small" style="white-space: nowrap;"><?php echo e($log->created_at->format('d M, Y')); ?></div>
                                    <div class="text-muted small" style="font-size: 0.75rem; white-space: nowrap;">
                                        <?php echo e($log->created_at->format('h:i A')); ?> (<?php echo e($log->created_at->diffForHumans()); ?>)
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No staff activity recorded yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if($showFinancials): ?>
        const finCtx = document.getElementById('financialChart').getContext('2d');
        new Chart(finCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartMonths); ?>,
                datasets: [
                    {
                        label: 'Revenues (BDT)',
                        data: <?php echo json_encode($chartRevenues); ?>,
                        borderColor: '#7367f0',
                        backgroundColor: 'rgba(115, 103, 240, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Expenses (BDT)',
                        data: <?php echo json_encode($chartExpenses); ?>,
                        borderColor: '#ea5455',
                        backgroundColor: 'rgba(234, 84, 85, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { opacity: 0.1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
        <?php endif; ?>
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>