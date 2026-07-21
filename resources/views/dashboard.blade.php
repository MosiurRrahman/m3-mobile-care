@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Welcome Header -->
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #7367f0 0%, #a097ff 100%) !important;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <h2 class="text-white fw-bold mb-2">Welcome Back, {{ auth()->user()->name }}!</h2>
                        <p class="mb-0 text-white opacity-85">Here's a summary of M3 Mobile Care repairs and revenue. You can manage tickets, track statuses, and update services catalog.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('admin.repairs.create') }}" class="btn btn-white bg-white text-primary fw-bold px-4 py-2.5 shadow-sm"><i class="ti tabler-plus me-1"></i>New Repair Ticket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Total Revenue</span>
                    <h3 class="card-title fw-extrabold mb-0 text-primary">{{ number_format($totalRevenue, 2) }} BDT</h3>
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
                    <span class="text-muted fw-semibold d-block mb-1">Total Repairs</span>
                    <h3 class="card-title fw-extrabold mb-0">{{ $totalRepairs }}</h3>
                </div>
                <div class="rounded-circle bg-label-success p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-device-mobile-cog fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Pending Repairs</span>
                    <h3 class="card-title fw-extrabold mb-0 text-warning">{{ $pendingRepairs }}</h3>
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
                    <span class="text-muted fw-semibold d-block mb-1">Completed Repairs</span>
                    <h3 class="card-title fw-extrabold mb-0 text-success">{{ $completedRepairs }}</h3>
                </div>
                <div class="rounded-circle bg-label-info p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-checkbox fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdowns & Quick Stats -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4">Repairs by Status</h5>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-ticket me-2 text-warning"></i>Pending</span>
                        <span class="badge bg-warning rounded-pill">{{ $statusCounts['pending'] ?? 0 }}</span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-tool me-2 text-primary"></i>In Progress</span>
                        <span class="badge bg-primary rounded-pill">{{ $statusCounts['in_progress'] ?? 0 }}</span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-circle-check me-2 text-success"></i>Ready for Pickup</span>
                        <span class="badge bg-success rounded-pill">{{ $statusCounts['completed'] ?? 0 }}</span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                        <span class="d-flex align-items-center"><i class="ti tabler-archive me-2 text-info"></i>Delivered / Collected</span>
                        <span class="badge bg-info rounded-pill">{{ $statusCounts['picked_up'] ?? 0 }}</span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between mb-0">
                        <span class="d-flex align-items-center"><i class="ti tabler-circle-x me-2 text-danger"></i>Cancelled</span>
                        <span class="badge bg-danger rounded-pill">{{ $statusCounts['cancelled'] ?? 0 }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Repairs Table -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Recent Repair Tickets</h5>
                <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-primary btn-sm">View All Tickets</a>
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
                        @forelse($recentRepairs as $repair)
                        <tr>
                            <td><a href="{{ route('admin.repairs.show', $repair->id) }}" class="fw-bold text-decoration-none">{{ $repair->ticket_id }}</a></td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $repair->customer_name }}</div>
                                <div class="text-muted small">{{ $repair->customer_phone }}</div>
                            </td>
                            <td>{{ $repair->device_brand }} {{ $repair->device_model }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'pending' => 'bg-warning',
                                        'in_progress' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        'picked_up' => 'bg-info',
                                        'cancelled' => 'bg-danger'
                                    ];
                                    $labels = [
                                        'pending' => 'Pending',
                                        'in_progress' => 'In Progress',
                                        'completed' => 'Completed',
                                        'picked_up' => 'Delivered',
                                        'cancelled' => 'Cancelled'
                                    ];
                                @endphp
                                <span class="badge {{ $badges[$repair->status] ?? 'bg-secondary' }}">{{ $labels[$repair->status] ?? $repair->status }}</span>
                            </td>
                            <td>{{ number_format($repair->estimated_cost, 0) }} BDT</td>
                            <td class="text-end">
                                <a href="{{ route('admin.repairs.show', $repair->id) }}" class="btn btn-icon btn-sm btn-outline-info me-1"><i class="ti tabler-eye"></i></a>
                                <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="btn btn-icon btn-sm btn-outline-primary"><i class="ti tabler-edit"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No repair tickets found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
