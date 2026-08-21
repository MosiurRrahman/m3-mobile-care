@extends('layouts/contentNavbarLayout')

@section('title', 'System Activity Logs - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">System Activity Logs</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Staff Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activity Logs</li>
            </ol>
        </nav>
    </div>

    <!-- Filters Card -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="row g-3 align-items-end">
                    <!-- Keyword Search -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-dark small" for="search">Search Keywords</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Search description, ticket, etc." value="{{ request('search') }}">
                    </div>

                    <!-- Staff Filter -->
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="user_id">Staff Operator</label>
                        <select name="user_id" id="user_id" class="form-select form-select-sm">
                            <option value="">-- All Staff --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ ucfirst($u->role) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Type Filter -->
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="action">Action Type</label>
                        <select name="action" id="action" class="form-select form-select-sm">
                            <option value="">-- All Actions --</option>
                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created (সংযোজন)</option>
                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated (সংশোধন)</option>
                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted (মুছে ফেলা)</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-dark small" for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti tabler-filter"></i></button>
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-light w-100 text-secondary" title="Clear Filters"><i class="ti tabler-refresh"></i></a>
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
                            @forelse($logs as $log)
                            @php
                                $actionColors = [
                                    'created' => 'bg-label-success',
                                    'updated' => 'bg-label-info',
                                    'deleted' => 'bg-label-danger'
                                ];
                                $color = $actionColors[$log->action] ?? 'bg-label-secondary';
                            @endphp
                            <tr>
                                <td>
                                    <span class="fw-semibold text-dark d-block mb-0">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($log->user && $log->user->avatar)
                                            <img src="{{ asset('storage/' . $log->user->avatar) }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-label-primary p-1.5 d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <i class="ti tabler-user fs-6"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="fw-bold text-dark d-block mb-0" style="line-height: 1.2;">{{ $log->user ? $log->user->name : 'System/Guest' }}</span>
                                            <small class="text-muted" style="font-size: 10px;">{{ $log->user ? ucfirst($log->user->role) : 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $color }} px-2 py-1 fs-7 fw-bold">{{ ucfirst($log->action) }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary fw-semibold">{{ class_basename($log->loggable_type ?: 'System') }}</span>
                                    <small class="text-muted d-block" style="font-size: 10px;">ID: {{ $log->loggable_id ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <div class="text-dark">{{ \Illuminate\Support\Str::limit($log->description, 50) }}</div>

                                    {{-- Details Modal Trigger --}}
                                    <button class="btn btn-xs btn-outline-info py-0.5 px-1.5 mt-1 border-0 shadow-none d-flex align-items-center gap-1"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailsModal-{{ $log->id }}"
                                            style="font-size: 11px;">
                                        <i class="ti tabler-eye fs-6"></i> View Details
                                    </button>
                                </td>
                                <td>
                                    <span class="text-muted"><i class="ti tabler-world me-1 fs-6"></i>{{ $log->ip_address ?? '127.0.0.1' }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ti tabler-info-circle fs-2 d-block mb-2 text-secondary"></i>
                                    No activity logs found matching the filter query.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Footer -->
            @if($logs->hasPages())
            <div class="card-footer border-top bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
                <div class="text-muted small">
                    Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} logs
                </div>
                <div>
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Activity Log Details Modals --}}
@foreach($logs as $log)
<div class="modal fade" id="detailsModal-{{ $log->id }}" tabindex="-1" aria-labelledby="detailsModalLabel-{{ $log->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel-{{ $log->id }}">
                    <i class="ti tabler-list-details me-1"></i> Activity Log Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Timestamp</label>
                            <div class="text-dark">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}
                                <small class="text-muted">({{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }})</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Operator / Staff</label>
                            <div class="d-flex align-items-center">
                                @if($log->user && $log->user->avatar)
                                    <img src="{{ asset('storage/' . $log->user->avatar) }}" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-label-primary d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                                        <i class="ti tabler-user fs-6"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="fw-bold text-dark">{{ $log->user ? $log->user->name : 'System/Guest' }}</span>
                                    <small class="text-muted d-block" style="font-size: 10px;">{{ $log->user ? ucfirst($log->user->role) : 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Action</label>
                            <div>
                                @php
                                    $modalActionColors = [
                                        'created' => 'bg-label-success',
                                        'updated' => 'bg-label-info',
                                        'deleted' => 'bg-label-danger'
                                    ];
                                    $modalColor = $modalActionColors[$log->action] ?? 'bg-label-secondary';
                                @endphp
                                <span class="badge {{ $modalColor }} px-2 py-1 fs-7 fw-bold">{{ ucfirst($log->action) }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">Entity / Target</label>
                            <div>
                                <span class="fw-semibold text-dark">{{ class_basename($log->loggable_type ?: 'System') }}</span>
                                <small class="text-muted">(ID: {{ $log->loggable_id ?? 'N/A' }})</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small mb-1">IP Address</label>
                            <div class="text-muted"><i class="ti tabler-world me-1 fs-6"></i>{{ $log->ip_address ?? '127.0.0.1' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small mb-1">Description</label>
                    <div class="p-3 bg-light rounded text-dark">{{ $log->description }}</div>
                </div>

                {{-- Change Details for Updates --}}
                @if($log->action === 'updated' && $log->changes && count($log->changes) > 0)
                <div>
                    <label class="form-label fw-bold text-muted small mb-1">Updated Fields</label>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0" style="font-size: 0.82rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-2">Tracked Field</th>
                                    <th class="py-2">Old Value</th>
                                    <th class="py-2">New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($log->changes as $field => $val)
                                <tr>
                                    <td class="fw-bold text-dark py-2">{{ str_replace('_', ' ', ucfirst($field)) }}</td>
                                    <td class="text-danger py-2" style="word-break: break-all;">
                                        {{ is_array($val['old']) ? json_encode($val['old']) : ($val['old'] ?? 'Null') }}
                                    </td>
                                    <td class="text-success py-2" style="word-break: break-all;">
                                        {{ is_array($val['new']) ? json_encode($val['new']) : ($val['new'] ?? 'Null') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
