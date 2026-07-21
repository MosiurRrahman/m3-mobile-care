@extends('layouts/contentNavbarLayout')

@section('title', 'Technician Dashboard - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Welcome Header -->
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #2b2b2b 0%, #1a1a1a 100%) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h2 class="text-white fw-bold mb-1">Welcome, Technician {{ auth()->user()->name }}!</h2>
                        <p class="mb-0 text-white opacity-85">Manage your assigned Job Cards. Diagnose issues, update repair status in real-time, and log technical operations details.</p>
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

    <!-- Quick Stats Cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">My Assigned Jobs</span>
                    <h3 class="card-title fw-extrabold mb-0 text-primary">{{ $myTotalRepairs }}</h3>
                </div>
                <div class="rounded-circle bg-label-primary p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-device-mobile-cog fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Pending Confirmation</span>
                    <h3 class="card-title fw-extrabold mb-0 text-warning">{{ $myPendingRepairs }}</h3>
                </div>
                <div class="rounded-circle bg-label-warning p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-ticket fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Under Diagnostics/Repair</span>
                    <h3 class="card-title fw-extrabold mb-0 text-info">{{ $myActiveRepairs }}</h3>
                </div>
                <div class="rounded-circle bg-label-info p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-tool fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Completed / Delivered</span>
                    <h3 class="card-title fw-extrabold mb-0 text-success">{{ $myCompletedRepairs }}</h3>
                </div>
                <div class="rounded-circle bg-label-success p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-checkbox fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Job Cards List -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">My Recent Jobs</h5>
                <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-primary btn-sm">View All Assigned Jobs</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ticket ID</th>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Issue Description</th>
                            <th>Unlock Info</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myRecentRepairs as $repair)
                        <tr>
                            <td><a href="{{ route('admin.repairs.show', $repair->id) }}" class="fw-bold text-decoration-none">{{ $repair->ticket_id }}</a></td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $repair->customer ? $repair->customer->name : 'Walk-in' }}</div>
                                <div class="text-muted small">{{ $repair->customer ? $repair->customer->phone : '' }}</div>
                            </td>
                            <td>{{ $repair->device_brand }} {{ $repair->device_model }}</td>
                            <td>
                                @php
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
                                @endphp
                                <span class="badge {{ $badges[$repair->status] ?? 'bg-secondary' }}">{{ ucfirst(str_replace('_', ' ', $repair->status)) }}</span>
                            </td>
                            <td><span class="small text-dark">{{ \Illuminate\Support\Str::limit($repair->issue_description, 50) }}</span></td>
                            <td><span class="small text-muted">{{ $repair->password_pattern ?? 'None' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.repairs.show', $repair->id) }}" class="btn btn-icon btn-sm btn-outline-info me-1" title="View Detail"><i class="ti tabler-eye"></i></a>
                                <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Update status/notes"><i class="ti tabler-edit"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No Job Cards assigned to you.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
