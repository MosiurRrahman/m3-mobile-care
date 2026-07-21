<?php $__env->startSection('title', 'Cash Register & History - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Cash Register & Flow</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Cash Register</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="ti tabler-circle-check me-2 fs-4"></i>
            <span><?php echo e(session('success')); ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Filters Block -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('admin.cash.index')); ?>" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold" for="start_date">From Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo e($startDate); ?>">
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold" for="end_date">To Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo e($endDate); ?>">
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold" for="payment_method">Account / Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="Cash" <?php echo e($paymentMethod == 'Cash' ? 'selected' : ''); ?>>Cash (Drawer/Hand)</option>
                        <option value="bKash" <?php echo e($paymentMethod == 'bKash' ? 'selected' : ''); ?>>bKash Account</option>
                        <option value="Card" <?php echo e($paymentMethod == 'Card' ? 'selected' : ''); ?>>Card Transactions</option>
                    </select>
                </div>
                
                <?php if(auth()->user()->isSalesman()): ?>
                    <input type="hidden" name="register_type" value="pos">
                <?php else: ?>
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label fw-semibold" for="register_type">Register / Cash Type</label>
                        <select name="register_type" id="register_type" class="form-select">
                            <option value="combined" <?php echo e($registerType == 'combined' ? 'selected' : ''); ?>>Combined Ledger</option>
                            <option value="pos" <?php echo e($registerType == 'pos' ? 'selected' : ''); ?>>POS Cash Sales Only</option>
                            <option value="service" <?php echo e($registerType == 'service' ? 'selected' : ''); ?>>Mobile Servicing Only</option>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="col-md-8">
                    <?php if($paymentMethod === 'Cash'): ?>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="include_expenses" id="include_expenses" value="1" <?php echo e($includeExpenses ? 'checked' : ''); ?>>
                        <label class="form-check-label fw-semibold text-muted" for="include_expenses">
                            Include Business Expenses (Subtract outflow from this balance)
                        </label>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="ti tabler-filter me-1"></i>Filter</button>
                    <a href="<?php echo e(route('admin.cash.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="row mb-4">
        <!-- Opening Balance -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted d-block mb-1">Opening Balance</span>
                        <h4 class="fw-bold text-dark mb-0"><?php echo e(number_format($openingBalance, 2)); ?> BDT</h4>
                    </div>
                    <div class="p-3 bg-label-secondary rounded-3">
                        <i class="ti tabler-archive text-secondary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Inflow -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted d-block mb-1">Total Inflow (+)</span>
                        <h4 class="fw-bold text-success mb-0">+<?php echo e(number_format($totalInflow, 2)); ?> BDT</h4>
                    </div>
                    <div class="p-3 bg-label-success rounded-3">
                        <i class="ti tabler-arrow-up-right text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Outflow -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-sm-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted d-block mb-1">Total Outflow (-)</span>
                        <h4 class="fw-bold text-danger mb-0">-<?php echo e(number_format($totalOutflow, 2)); ?> BDT</h4>
                    </div>
                    <div class="p-3 bg-label-danger rounded-3">
                        <i class="ti tabler-arrow-down-left text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Closing Balance -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.1) 0%, rgba(var(--bs-primary-rgb), 0.03) 100%); border: 1px solid rgba(var(--bs-primary-rgb), 0.15) !important;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-primary fw-semibold d-block mb-1">Net Balance (In Hand)</span>
                        <h4 class="fw-bold text-primary mb-0"><?php echo e(number_format($closingBalance, 2)); ?> BDT</h4>
                    </div>
                    <div class="p-3 bg-primary rounded-3 text-white">
                        <i class="ti tabler-wallet fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Ledger/History Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-bottom d-flex align-items-center justify-content-between bg-white py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="ti tabler-list me-2"></i>
                <?php if($registerType === 'pos'): ?>
                    POS Cash Register
                <?php elseif($registerType === 'service'): ?>
                    Mobile Servicing Cash Register
                <?php else: ?>
                    Combined Cash Register
                <?php endif; ?>
            </h5>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#recordOutflowModal">
                    <i class="ti tabler-minus me-1"></i>Record Outflow
                </button>
                <span class="badge bg-label-primary px-3 py-2"><i class="ti tabler-brand-cash me-1"></i><?php echo e($paymentMethod); ?> Account</span>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-semibold">Date & Time</th>
                        <th class="fw-semibold">Type</th>
                        <th class="fw-semibold">Reference</th>
                        <th class="fw-semibold">Description / Customer</th>
                        <th class="fw-semibold text-end">Inflow (+)</th>
                        <th class="fw-semibold text-end">Outflow (-)</th>
                        <th class="fw-semibold text-center">Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(\Carbon\Carbon::parse($tx['date'])->format('d M, Y h:i A')); ?></td>
                            <td>
                                <?php if(str_contains($tx['type'], 'POS')): ?>
                                    <span class="badge bg-label-primary"><i class="ti tabler-device-laptop me-1"></i><?php echo e($tx['type']); ?></span>
                                <?php elseif(str_contains($tx['type'], 'Advance')): ?>
                                    <span class="badge bg-label-info"><i class="ti tabler-circle-plus me-1"></i><?php echo e($tx['type']); ?></span>
                                <?php elseif(str_contains($tx['type'], 'Final')): ?>
                                    <span class="badge bg-label-success"><i class="ti tabler-circle-check me-1"></i><?php echo e($tx['type']); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-label-danger"><i class="ti tabler-arrow-bar-to-down me-1"></i><?php echo e($tx['type']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(str_contains($tx['type'], 'POS')): ?>
                                    <span class="fw-semibold text-dark"><?php echo e($tx['ref']); ?></span>
                                <?php elseif(str_contains($tx['type'], 'Repair')): ?>
                                    <a href="<?php echo e(route('admin.repairs.show', $tx['ref'])); ?>" class="fw-semibold text-primary">#<?php echo e($tx['ref']); ?></a>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e($tx['ref']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-wrap" style="max-width: 250px;"><?php echo e($tx['customer']); ?></td>
                            <td class="text-end fw-semibold <?php echo e($tx['inflow'] > 0 ? 'text-success' : 'text-muted'); ?>">
                                <?php echo e($tx['inflow'] > 0 ? '+' . number_format($tx['inflow'], 2) : '-'); ?>

                            </td>
                            <td class="text-end fw-semibold <?php echo e($tx['outflow'] > 0 ? 'text-danger' : 'text-muted'); ?>">
                                <?php echo e($tx['outflow'] > 0 ? '-' . number_format($tx['outflow'], 2) : '-'); ?>

                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-secondary"><?php echo e($tx['payment_method']); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="p-3">
                                    <i class="ti tabler-cash-off text-muted mb-2" style="font-size: 48px;"></i>
                                    <h5 class="fw-semibold text-dark mt-2">No transaction flows recorded</h5>
                                    <p class="text-muted small mb-0">There are no matching cash flows in the selected date range and payment method.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Record Outflow Modal -->
<div class="modal fade" id="recordOutflowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-danger"><i class="ti tabler-arrow-down-left me-1"></i>Record Cash Outflow</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.cash.outflow')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <?php if(auth()->user()->isSalesman()): ?>
                        <input type="hidden" name="register_type" value="pos">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Cash Register Source</label>
                            <input type="text" class="form-control bg-light" value="POS Cash Register" readonly>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="register_type_outflow">Cash Register Source</label>
                            <select name="register_type" id="register_type_outflow" class="form-select" required>
                                <option value="pos" <?php echo e($registerType == 'pos' ? 'selected' : ''); ?>>POS Cash Register</option>
                                <option value="service" <?php echo e($registerType == 'service' ? 'selected' : ''); ?>>Mobile Servicing Cash Register</option>
                                <option value="general" <?php echo e($registerType == 'combined' ? 'selected' : ''); ?>>General / Other Cash Drawer</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="category">Outflow Category</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="Cash Outflow">Cash Outflow / Withdrawal</option>
                            <option value="Purchase">Purchase Outflow</option>
                            <option value="Salary">Salary Payment</option>
                            <option value="Rent">Rent Payment</option>
                            <option value="Utility">Utility Payment</option>
                            <option value="Other">Other Expense</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="amount">Amount (BDT) *</label>
                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" placeholder="Enter amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="expense_date">Date *</label>
                        <input type="date" name="expense_date" id="expense_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="description">Description / Purpose</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter details about this outflow"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Outflow</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/layoutMaster', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/cash/index.blade.php ENDPATH**/ ?>