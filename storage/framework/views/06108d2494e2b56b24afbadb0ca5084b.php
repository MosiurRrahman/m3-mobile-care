<?php $__env->startSection('title', 'System Activity Logs - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">System Activity Logs</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.users.index')); ?>">Staff Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activity Logs</li>
            </ol>
        </nav>
    </div>

    <!-- Filters Card -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="<?php echo e(route('admin.activity-logs.index')); ?>" method="GET" class="row g-3 align-items-end">
                    <!-- Keyword Search -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-dark small" for="search">Search Keywords</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Search description, ticket, etc." value="<?php echo e(request('search')); ?>">
                    </div>

                    <!-- Staff Filter -->
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="user_id">Staff Operator</label>
                        <select name="user_id" id="user_id" class="form-select form-select-sm">
                            <option value="">-- All Staff --</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($u->id); ?>" <?php echo e(request('user_id') == $u->id ? 'selected' : ''); ?>><?php echo e($u->name); ?> (<?php echo e(ucfirst($u->role)); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Action Type Filter -->
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="action">Action Type</label>
                        <select name="action" id="action" class="form-select form-select-sm">
                            <option value="">-- All Actions --</option>
                            <option value="created" <?php echo e(request('action') == 'created' ? 'selected' : ''); ?>>Created (সংযোজন)</option>
                            <option value="updated" <?php echo e(request('action') == 'updated' ? 'selected' : ''); ?>>Updated (সংশোধন)</option>
                            <option value="deleted" <?php echo e(request('action') == 'deleted' ? 'selected' : ''); ?>>Deleted (মুছে ফেলা)</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="<?php echo e(request('start_date')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="<?php echo e(request('end_date')); ?>">
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti tabler-filter"></i></button>
                        <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="btn btn-sm btn-light w-100 text-secondary" title="Clear Filters"><i class="ti tabler-refresh"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logs Table Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 170px;">Timestamp</th>
                                <th style="width: 180px;">Operator / Staff</th>
                                <th style="width: 100px;">Action</th>
                                <th style="width: 140px;">Entity / Target</th>
                                <th>Description</th>
                                <th style="width: 140px;">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $actionColors = [
                                    'created' => 'bg-label-success',
                                    'updated' => 'bg-label-info',
                                    'deleted' => 'bg-label-danger'
                                ];
                                $color = $actionColors[$log->action] ?? 'bg-label-secondary';
                            ?>
                            <tr>
                                <td>
                                    <span class="fw-semibold text-dark d-block mb-0"><?php echo e(\Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s')); ?></span>
                                    <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($log->created_at)->diffForHumans()); ?></small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($log->user && $log->user->avatar): ?>
                                            <img src="<?php echo e(asset('storage/' . $log->user->avatar)); ?>" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-label-primary p-1.5 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="ti tabler-user fs-6"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <span class="fw-bold text-dark d-block mb-0" style="line-height: 1.2;"><?php echo e($log->user ? $log->user->name : 'System/Guest'); ?></span>
                                            <small class="text-muted" style="font-size: 10px;"><?php echo e($log->user ? ucfirst($log->user->role) : 'N/A'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($color); ?> px-2 py-1 fs-7 fw-bold"><?php echo e(ucfirst($log->action)); ?></span>
                                </td>
                                <td>
                                    <span class="text-secondary fw-semibold"><?php echo e(class_basename($log->loggable_type ?: 'System')); ?></span>
                                    <small class="text-muted d-block" style="font-size: 10px;">ID: <?php echo e($log->loggable_id ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <div class="text-dark"><?php echo e($log->description); ?></div>
                                    
                                    <!-- Collapsible Change Details for Updates -->
                                    <?php if($log->action === 'updated' && $log->changes && count($log->changes) > 0): ?>
                                        <button class="btn btn-xs btn-outline-info py-0.5 px-1.5 mt-1 border-0 shadow-none d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#changes-<?php echo e($log->id); ?>" style="font-size: 11px;">
                                            <i class="ti tabler-eye fs-6"></i> View Updated Fields
                                        </button>
                                        <div class="collapse mt-2" id="changes-<?php echo e($log->id); ?>">
                                            <div class="p-3 bg-light rounded border-0 text-start" style="max-width: 500px;">
                                                <table class="table table-sm table-borderless mb-0" style="font-size: 0.78rem;">
                                                    <thead>
                                                        <tr class="border-bottom text-muted">
                                                            <th class="py-1 ps-0">Tracked Field</th>
                                                            <th class="py-1">Old Value</th>
                                                            <th class="py-1 text-end pe-0">New Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $log->changes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td class="fw-bold text-dark ps-0 py-1"><?php echo e(str_replace('_', ' ', ucfirst($field))); ?></td>
                                                                <td class="text-danger py-1" style="word-break: break-all;">
                                                                    <?php echo e(is_array($val['old']) ? json_encode($val['old']) : ($val['old'] ?? 'Null')); ?>

                                                                </td>
                                                                <td class="text-success text-end pe-0 py-1" style="word-break: break-all;">
                                                                    <?php echo e(is_array($val['new']) ? json_encode($val['new']) : ($val['new'] ?? 'Null')); ?>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted"><i class="ti tabler-world me-1 fs-6"></i><?php echo e($log->ip_address ?? '127.0.0.1'); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ti tabler-info-circle fs-2 d-block mb-2 text-secondary"></i>
                                    No activity logs found matching the filter query.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination Footer -->
            <?php if($logs->hasPages()): ?>
            <div class="card-footer border-top bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
                <div class="text-muted small">
                    Showing <?php echo e($logs->firstItem()); ?> to <?php echo e($logs->lastItem()); ?> of <?php echo e($logs->total()); ?> logs
                </div>
                <div>
                    <?php echo e($logs->appends(request()->query())->links()); ?>

                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/users/activity-logs.blade.php ENDPATH**/ ?>