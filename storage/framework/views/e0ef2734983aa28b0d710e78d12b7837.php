<?php $__env->startSection('title', 'M3 Mobile Care - Live Service Board'); ?>

<?php $__env->startSection('content'); ?>
<!-- Import Premium Google Fonts & Stylesheets -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: #060913 !important;
        color: #e2e8f0 !important;
        overflow-x: hidden;
    }
    .grid-bg {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
        background-size: 50px 50px;
        background-position: center top;
        pointer-events: none;
        z-index: 0;
    }
    .orb-orange {
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(243, 112, 33, 0.12) 0%, rgba(243, 112, 33, 0) 70%);
        top: -200px;
        right: -100px;
        filter: blur(80px);
        animation: floatOrb 12s infinite alternate;
        pointer-events: none;
        z-index: 1;
    }
    .orb-cyan {
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(0, 207, 232, 0.08) 0%, rgba(0, 207, 232, 0) 70%);
        bottom: -150px;
        left: -100px;
        filter: blur(70px);
        animation: floatOrb 16s infinite alternate-reverse;
        pointer-events: none;
        z-index: 1;
    }
    @keyframes floatOrb {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(60px, 40px) scale(1.15); }
    }

    /* Global Typography contrast overrides */
    h1, h2, h3, h4, h5, h6 {
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    p, .text-slate-400 {
        color: #94a3b8 !important;
    }

    /* Table styling & isolation */
    .table {
        color: #cbd5e1 !important;
    }
    .table th, .table td {
        border-color: rgba(255, 255, 255, 0.08) !important;
        color: #cbd5e1 !important;
    }
    .table thead th {
        color: #94a3b8 !important;
        font-weight: 600 !important;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
    .table-hover tbody tr:hover td {
        color: #ffffff !important;
    }

    .glass-card {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35) !important;
        position: relative;
        overflow: hidden;
        transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
        pointer-events: none;
    }
    .glass-card:hover {
        border-color: rgba(243, 112, 33, 0.35) !important;
        box-shadow: 0 24px 50px rgba(243, 112, 33, 0.16) !important;
    }
    .glass-nav {
        background: rgba(8, 12, 20, 0.75) !important;
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
    }
    .gradient-text {
        background: linear-gradient(135deg, #ffb366 0%, #f37021 50%, #e05300 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #ff7a00 0%, #f37021 100%) !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 8px 20px rgba(243, 112, 33, 0.3) !important;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, #ff8c1a 0%, #f47d33 100%) !important;
        color: #fff !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 12px 24px rgba(243, 112, 33, 0.45) !important;
    }
    .hover-scale {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .hover-scale:hover {
        transform: translateY(-6px);
    }
    .pulse-dot {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(243, 112, 33, 0.5); }
        70% { box-shadow: 0 0 0 10px rgba(243, 112, 33, 0); }
        100% { box-shadow: 0 0 0 0 rgba(243, 112, 33, 0); }
    }

    .bg-slate-900 {
        background-color: #0d1321 !important;
    }
    .bg-slate-950 {
        background-color: #080c14 !important;
    }
    .input-glow {
        background-color: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #fff !important;
        transition: all 0.3s ease;
    }
    .input-glow:focus {
        background-color: rgba(8, 12, 20, 0.9) !important;
        border-color: #f37021 !important;
        box-shadow: 0 0 25px rgba(243, 112, 33, 0.35) !important;
    }

    /* Badges override */
    .badge {
        font-weight: 600 !important;
        letter-spacing: 0.03em;
    }
    .bg-label-primary {
        background-color: rgba(243, 112, 33, 0.16) !important;
        color: #ff944d !important;
    }
    .bg-label-success {
        background-color: rgba(40, 199, 111, 0.16) !important;
        color: #34d399 !important;
    }
    .bg-label-warning {
        background-color: rgba(255, 159, 67, 0.16) !important;
        color: #fbbf24 !important;
    }
    .bg-label-info {
        background-color: rgba(0, 207, 232, 0.16) !important;
        color: #22d3ee !important;
    }
    .bg-label-secondary {
        background-color: rgba(148, 163, 184, 0.16) !important;
        color: #cbd5e1 !important;
    }
    .bg-label-danger {
        background-color: rgba(239, 68, 68, 0.16) !important;
        color: #f87171 !important;
    }

    /* Modal Text Color Overrides for High Contrast Legibility */
    #repairDetailsModal {
        color: #e2e8f0 !important;
    }
    #repairDetailsModal .modal-content {
        background: #080c14 !important; /* Deep solid dark background to prevent bleed-through */
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
    }
    #repairDetailsModal .modal-header,
    #repairDetailsModal .modal-footer {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    #repairDetailsModal h1,
    #repairDetailsModal h2,
    #repairDetailsModal h3,
    #repairDetailsModal h4,
    #repairDetailsModal h5,
    #repairDetailsModal h6,
    #repairDetailsModal strong,
    #repairDetailsModal b {
        color: #ffffff !important;
    }
    #repairDetailsModal .label-title {
        color: #94a3b8 !important;
        font-size: 0.85rem;
        font-weight: 500;
    }
    #repairDetailsModal .value-text {
        color: #ffffff !important;
        font-weight: 600;
    }
    #repairDetailsModal .step-passed {
        color: #34d399 !important; /* Brighter green */
        font-weight: 600;
    }
    #repairDetailsModal .step-active {
        color: #a78bfa !important; /* Violet */
        font-weight: 700;
    }
    #repairDetailsModal .step-pending {
        color: #94a3b8 !important; /* Much lighter than 64748b for high readability */
        font-weight: 500;
    }
    #repairDetailsModal .step-desc {
        color: #cbd5e1 !important; /* Light grey */
    }
    #repairDetailsModal .glass-card {
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    #repairDetailsModal .text-slate-400,
    #repairDetailsModal .text-muted {
        color: #cbd5e1 !important;
    }
    #repairDetailsModal .btn-outline-secondary {
        color: #e2e8f0 !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    #repairDetailsModal .btn-outline-secondary:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
    }
    #repairDetailsModal .btn-close-white {
        filter: invert(1) grayscale(1) brightness(2) !important; /* Guarantee white close button */
    }
</style>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark glass-nav sticky-top py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('assets/img/branding/logo-dark-icon.png')); ?>" alt="M3 Logo" style="height: 38px; width: auto; object-fit: contain;" class="me-2.5">
            <span class="fs-4 fw-extrabold text-white" style="font-family: 'Outfit', sans-serif;">M3 <span style="color: #f37021;">MOBILE CARE</span></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#track">Track Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#recent-activity">Live Service Board</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-gradient px-4 py-2 rounded-pill" href="<?php echo e(route('login')); ?>"><i class="ti tabler-lock-open me-1"></i>Staff Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero / Tracker Section -->
<div id="track" class="position-relative overflow-hidden py-5 bg-slate-950">
    <div class="grid-bg"></div>
    <div class="orb-orange"></div>
    <div class="orb-cyan"></div>

    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-5 border border-white border-opacity-10 mb-4">
                    <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                    <span class="text-slate-400 small fw-semibold text-uppercase tracking-wider">Live Repair Lab Diagnostics</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3">Livesss Service & Ticket Tracker</h1>
                <p class="lead text-slate-400 mb-5">Trace hardware updates, diagnostic status, and expected delivery times.</p>

                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-8">
                        <div class="glass-card p-4 shadow-lg">
                            <form action="<?php echo e(route('track.search')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <div class="flex-grow-1">
                                        <input type="text" name="ticket_id" class="form-control form-control-lg input-glow text-center text-sm-start" placeholder="Enter Ticket ID (e.g. M3-202607-XXXX)" value="<?php echo e(request('ticket_id')); ?>" required style="border-radius: 12px; height: 54px;">
                                    </div>
                                    <button type="submit" class="btn btn-gradient btn-lg px-4 rounded-pill" style="height: 54px; min-width: 180px;">
                                        <i class="ti tabler-search me-1"></i>Trace Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Last 3 Days Activity & Repairs Dashboard Section (Service Board) -->
<div id="recent-activity" class="py-5 bg-slate-900">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-label-primary mb-2 px-3 py-1.5 fs-7 text-uppercase fw-bold" style="background: rgba(115, 103, 240, 0.1); color: #a78bfa;">Live Operations</span>
            <h2 class="fw-bold text-white mb-1">Last 3 Days Activity Tracker</h2>
            <p class="text-slate-400 max-w-2xl mx-auto">Real-time status updates and activity logs from our device laboratories in the last 72 hours.</p>
        </div>

        <!-- Stat summaries (Repairs by Status) -->
        <div class="row g-4 mb-5">
            <div class="col-6 col-md-3">
                <div class="glass-card p-4 text-center h-100 hover-scale">
                    <div class="avatar bg-label-primary rounded p-2 d-inline-flex mb-3" style="width: 48px; height: 48px; background: rgba(115, 103, 240, 0.1);">
                        <i class="ti tabler-clipboard-list text-primary fs-3"></i>
                    </div>
                    <h6 class="text-slate-400 mb-1 small">Total Logged</h6>
                    <h3 class="fw-bold text-white mb-0"><?php echo e($recentRepairs->count()); ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="glass-card p-4 text-center h-100 hover-scale">
                    <div class="avatar bg-label-warning rounded p-2 d-inline-flex mb-3" style="width: 48px; height: 48px; background: rgba(255, 159, 67, 0.1);">
                        <i class="ti tabler-zoom-check text-warning fs-3"></i>
                    </div>
                    <h6 class="text-slate-400 mb-1 small">Diagnosing</h6>
                    <h3 class="fw-bold text-white mb-0"><?php echo e($repairsByStatus['diagnosing'] ?? 0); ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="glass-card p-4 text-center h-100 hover-scale">
                    <div class="avatar bg-label-info rounded p-2 d-inline-flex mb-3" style="width: 48px; height: 48px; background: rgba(0, 207, 232, 0.1);">
                        <i class="ti tabler-tool text-info fs-3"></i>
                    </div>
                    <h6 class="text-slate-400 mb-1 small">Repairing</h6>
                    <h3 class="fw-bold text-white mb-0"><?php echo e($repairsByStatus['repairing'] ?? 0); ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="glass-card p-4 text-center h-100 hover-scale">
                    <div class="avatar bg-label-success rounded p-2 d-inline-flex mb-3" style="width: 48px; height: 48px; background: rgba(40, 199, 111, 0.1);">
                        <i class="ti tabler-circle-check text-success fs-3"></i>
                    </div>
                    <h6 class="text-slate-400 mb-1 small">Ready/Delivered</h6>
                    <h3 class="fw-bold text-white mb-0">
                        <?php echo e(($repairsByStatus['completed'] ?? 0) + ($repairsByStatus['delivered'] ?? 0)); ?>

                    </h3>
                </div>
            </div>
        </div>

        <!-- Recent Job Cards Table -->
        <div class="row">
            <div class="col-12">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-white mb-0"><i class="ti tabler-list-check text-primary me-2"></i>Recent Job Cards</h5>
                        <span class="badge bg-slate-800 text-slate-300">Showing last 10 entries</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-white" style="--bs-table-bg: transparent; --bs-table-hover-bg: rgba(255,255,255,0.02);">
                            <thead>
                                <tr class="text-slate-400 border-bottom border-white border-opacity-10 small">
                                    <th class="py-3">Ticket ID</th>
                                    <th>Customer</th>
                                    <th>Device Model</th>
                                    <th>Assigned Issue</th>
                                    <th>Status</th>
                                    <th class="text-end">Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentRepairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="border-bottom border-white border-opacity-5">
                                        <td class="py-3.5 fw-bold text-primary"><?php echo e($recent->ticket_id); ?></td>
                                        <td>
                                            <?php if($recent->customer): ?>
                                                <?php echo e(\Illuminate\Support\Str::limit($recent->customer->name, 12)); ?>

                                                <span class="text-slate-500 small d-block"><?php echo e(substr($recent->customer->phone, 0, 4)); ?>****<?php echo e(substr($recent->customer->phone, -4)); ?></span>
                                            <?php else: ?>
                                                <span class="text-slate-400">Walk-in</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-white d-flex align-items-center">
                                                <i class="ti tabler-device-mobile text-muted me-1.5 small"></i><?php echo e($recent->device_brand); ?> <?php echo e($recent->device_model); ?>

                                            </span>
                                        </td>
                                        <td class="small text-slate-400"><?php echo e(\Illuminate\Support\Str::limit($recent->issue_description, 35)); ?></td>
                                        <td>
                                            <?php
                                                $badgeClass = match($recent->status) {
                                                    'pending' => 'bg-label-secondary',
                                                    'diagnosing' => 'bg-label-warning',
                                                    'waiting_for_approval' => 'bg-label-info',
                                                    'repairing' => 'bg-label-primary',
                                                    'quality_check' => 'bg-label-info',
                                                    'completed' => 'bg-label-success',
                                                    'delivered' => 'bg-label-success',
                                                    default => 'bg-label-danger'
                                                };
                                            ?>
                                            <span class="badge <?php echo e($badgeClass); ?> text-uppercase fs-9 py-1 px-2.5"><?php echo e(str_replace('_', ' ', $recent->status)); ?></span>
                                        </td>
                                        <td class="text-end small text-slate-400">
                                            <?php echo e($recent->created_at->diffForHumans()); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-slate-500">
                                            <i class="ti tabler-device-mobile-cog fs-1 mb-2"></i>
                                            <p class="mb-0">No job cards registered in the last 3 days.</p>
                                        </td>
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

<!-- Tracking Results Modal -->
<?php if($searched): ?>
<div class="modal fade" id="repairDetailsModal" tabindex="-1" aria-labelledby="repairDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content glass-card p-0 border-0" style="background: rgba(13, 19, 33, 0.95); backdrop-filter: blur(25px); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="modal-header border-bottom border-white border-opacity-10 p-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="<?php echo e(asset('assets/img/branding/logo-dark-icon.png')); ?>" alt="M3 Logo" style="height: 36px; width: auto; object-fit: contain;" class="me-3">
                    <div>
                        <h4 class="modal-title fw-bold text-white mb-0" id="repairDetailsModalLabel">Your Repair Details</h4>
                        <span class="text-slate-400 small">Traced Code: <strong style="color: #f37021 !important;"><?php echo e(request('ticket_id')); ?></strong></span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <?php echo $__env->make('_partials.track-modal-body', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div class="modal-footer border-top border-white border-opacity-10 p-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('repairDetailsModal'));
        myModal.show();
    });
</script>
<?php endif; ?>

<!-- Footer -->
<footer class="bg-slate-950 border-top border-white border-opacity-5 py-4">
    <div class="container text-center">
        <p class="text-slate-500 small mb-0">&copy; 2026 M3 Mobile Care. All rights reserved. &bull; Internal Operations System</p>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/blankLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/home.blade.php ENDPATH**/ ?>