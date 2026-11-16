<!-- Table Section -->
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0 repair-table">
        <thead class="table-light">
            <tr>
                <th class="text-nowrap" style="min-width: 135px;">Ticket ID</th>
                <th>Customer Name</th>
                <th>Device Details</th>
                <th class="text-nowrap">Assigned Tech</th>
                <th class="text-nowrap">Status</th>
                <th class="text-nowrap">Est. / Final Cost</th>
                <th class="text-nowrap">Paid So Far</th>
                <th class="text-nowrap">Expected Date</th>
                <th class="text-end text-nowrap pe-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($repairs as $repair)
            <tr>
                <td class="text-nowrap">
                    <a href="{{ route('admin.repairs.show', $repair->id) }}" class="fw-bold text-decoration-none text-nowrap repair-ticket-link">{{ $repair->ticket_id }}</a>
                    <div class="text-muted mt-1 text-nowrap" style="font-size: 0.7rem;" title="Created: {{ $repair->created_at->format('d M, Y h:i A') }}">
                        <i class="ti tabler-calendar-plus text-primary me-1"></i>Created: {{ $repair->created_at->format('d M, Y') }}
                    </div>
                    @if($repair->has_dhaka_parts)
                        <div><span class="badge bg-label-info mt-1 text-nowrap" style="font-size: 0.65rem;"><i class="ti tabler-truck-delivery me-1"></i>Dhaka Sourced</span></div>
                    @endif
                </td>
                <td>
                    <div class="fw-semibold text-dark text-truncate" style="max-width: 170px; font-size: 0.8125rem;" title="{{ $repair->customer ? $repair->customer->name : 'Walk-in Customer' }}">{{ $repair->customer ? $repair->customer->name : 'Walk-in Customer' }}</div>
                    <div class="text-muted text-nowrap" style="font-size: 0.72rem;">{{ $repair->customer ? $repair->customer->phone : '' }}</div>
                </td>
                <td class="text-nowrap">
                    <div class="fw-semibold text-dark" style="font-size: 0.8125rem;">{{ $repair->device_brand }} <span class="fw-normal">{{ $repair->device_model }}</span></div>
                    @if($repair->serial_imei)
                        <div class="text-muted text-nowrap" style="font-size: 0.7rem;">IMEI: {{ $repair->serial_imei }}</div>
                    @endif
                </td>
                <td class="text-nowrap">
                    @if($repair->technician)
                        <div class="fw-semibold text-dark text-nowrap" style="font-size: 0.78rem;"><i class="ti tabler-user me-1 text-primary"></i>{{ $repair->technician->name }}</div>
                        <div class="text-muted mt-1 text-nowrap" style="font-size: 0.7rem;" title="Assigned on {{ ($repair->assigned_at ?? $repair->created_at)->format('d M, Y h:i A') }}">
                            <i class="ti tabler-calendar-check text-success me-1"></i>Assigned: {{ ($repair->assigned_at ?? $repair->created_at)->format('d M, Y') }}
                        </div>
                    @else
                        <span class="badge bg-label-secondary text-nowrap" style="font-size: 0.7rem;"><i class="ti tabler-user-x me-1"></i>Unassigned</span>
                    @endif
                </td>
                <td class="text-nowrap">
                    @php
                        $badges = [
                            'pending' => 'bg-warning',
                            'diagnosing' => 'bg-info',
                            'waiting_for_approval' => 'bg-secondary',
                            'waiting_for_parts' => 'bg-warning text-dark',
                            'repairing' => 'bg-primary',
                            'quality_check' => 'bg-dark',
                            'completed' => 'bg-success',
                            'delivered' => 'bg-success',
                            'cancelled' => 'bg-danger'
                        ];
                        $statusDate = $repair->status_updated_at ?? $repair->created_at;
                    @endphp
                    <span class="badge {{ $badges[$repair->status] ?? 'bg-secondary' }}" style="font-size: 0.72rem; padding: 0.35em 0.6em;">{{ ucfirst(str_replace('_', ' ', $repair->status)) }}</span>
                    <div class="text-muted mt-1 text-nowrap" style="font-size: 0.7rem;" title="Status updated on {{ $statusDate->format('d M, Y h:i A') }}">
                        <i class="ti tabler-clock-edit text-info me-1"></i>{{ $statusDate->format('d M, Y') }}
                    </div>
                </td>
                <td class="text-nowrap">
                    <div class="text-muted" style="font-size: 0.75rem;">Est: {{ number_format($repair->estimated_cost, 0) }} BDT</div>
                    @if($repair->actual_cost !== null)
                        <div class="text-dark fw-semibold" style="font-size: 0.75rem;">Bill: {{ number_format($repair->actual_cost, 0) }} BDT</div>
                        @if($repair->due_amount > 0)
                            <div class="badge bg-label-danger" style="font-size: 0.65rem; padding: 0.25em 0.5em;">Due: {{ number_format($repair->due_amount, 0) }} BDT</div>
                        @else
                            <div class="badge bg-label-success" style="font-size: 0.65rem; padding: 0.25em 0.5em;">Paid</div>
                        @endif
                    @endif
                </td>
                <td class="text-nowrap">
                    <span class="fw-bold text-dark" style="font-size: 0.8125rem;">{{ number_format($repair->paid_amount, 0) }} BDT</span>
                    @if($repair->advance_payment > 0)
                        <div class="text-muted text-nowrap" style="font-size: 0.7rem;">(Adv: {{ number_format($repair->advance_payment, 0) }})</div>
                    @endif
                </td>
                <td class="text-nowrap">
                    <div style="font-size: 0.78rem;">{{ $repair->expected_delivery_date ? \Carbon\Carbon::parse($repair->expected_delivery_date)->format('M d, Y') : 'Not Set' }}</div>
                    @if($repair->expected_date_reminder_sent_at)
                        <span class="badge bg-label-info p-1 px-2 text-nowrap" style="font-size: 0.65rem;" title="Tech Alert SMS sent on {{ $repair->expected_date_reminder_sent_at->format('d M, h:i A') }}">
                            <i class="ti tabler-bell-check me-1"></i>Alerted
                        </span>
                    @endif
                </td>
                <td class="text-end pe-3 text-nowrap">
                    <div class="d-inline-flex align-items-center gap-1">
                        <a href="{{ route('admin.repairs.show', $repair->id) }}" class="btn btn-icon btn-sm btn-label-info rounded" style="width: 28px; height: 28px; font-size: 0.8rem;" title="View details"><i class="ti tabler-eye"></i></a>
                        <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="btn btn-icon btn-sm btn-label-primary rounded" style="width: 28px; height: 28px; font-size: 0.8rem;" title="Update Job Card"><i class="ti tabler-edit"></i></a>

                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                        <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this Job Card ticket?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-sm btn-label-danger rounded" style="width: 28px; height: 28px; font-size: 0.8rem;" title="Delete"><i class="ti tabler-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-5 text-muted">
                    <i class="ti tabler-info-circle fs-2 d-block mb-2 text-muted"></i>
                    No Job Cards found matching your search.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($repairs->hasPages())
<div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center flex-wrap gap-2" id="repairsPagination">
    <div class="text-muted small">
        Showing {{ $repairs->firstItem() ?? 0 }} to {{ $repairs->lastItem() ?? 0 }} of {{ $repairs->total() }} entries
    </div>
    <div>
        {{ $repairs->links() }}
    </div>
</div>
@endif
