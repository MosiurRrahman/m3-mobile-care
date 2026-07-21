@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Profile - M3 Mobile Care')

@section('content')
@php
    $totalRepairsSpent = $repairs->sum('paid_amount');
    $totalSalesSpent = $sales->sum('paid_amount');
    $totalSpent = $totalRepairsSpent + $totalSalesSpent;
    
    $outstandingRepairsDue = $repairs->sum('due_amount');
    $outstandingSalesDue = $sales->sum('due_amount');
    $totalDue = $outstandingRepairsDue + $outstandingSalesDue;
    
    $activeRepairsCount = $repairs->whereNotIn('status', ['completed', 'delivered', 'cancelled'])->count();

    $unpaidRepairs = $repairs->where('due_amount', '>', 0);
    $unpaidSales = $sales->where('due_amount', '>', 0);
    $hasDues = $unpaidRepairs->count() > 0 || $unpaidSales->count() > 0;
@endphp

<div class="row">
    <!-- Breadcrumb & Back Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Customer Account Overview</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}" class="text-muted text-decoration-none">Customers</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $customer->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary px-3 rounded-pill">
            <i class="ti tabler-arrow-left me-1 fs-5"></i>Back to Registry
        </a>
    </div>

    <!-- Customer Details & Stats Card (12 Columns) -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm overflow-hidden">
            <!-- Header Accent Line -->
            <div class="bg-primary opacity-10" style="height: 6px; background-color: #7367f0 !important;"></div>
            
            <div class="card-body">
                <div class="row align-items-center g-4">
                    <!-- Left: Avatar & Basic Info -->
                    <div class="col-md-3 text-center text-md-start border-end-md pb-3 pb-md-0">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px; font-size: 1.8rem; background-color: #7367f0 !important; flex-shrink: 0;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div class="text-center text-md-start">
                                <h5 class="fw-bold text-dark mb-1">{{ $customer->name }}</h5>
                                <span class="badge bg-label-primary px-2.5 py-1 rounded-pill" style="font-size: 0.75rem;">Registered Customer</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Middle: Contact Details (Grid layout) -->
                    <div class="col-md-5 border-end-md pb-3 pb-md-0">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <span class="small text-muted d-block mb-0.5"><i class="ti tabler-phone text-primary me-1 fs-5"></i>Phone</span>
                                <a href="tel:{{ $customer->phone }}" class="fw-bold text-dark text-decoration-none">{{ $customer->phone }}</a>
                            </div>
                            @if($customer->alt_phone)
                            <div class="col-sm-6">
                                <span class="small text-muted d-block mb-0.5"><i class="ti tabler-phone text-muted me-1 fs-5"></i>Alt Phone</span>
                                <span class="fw-bold text-dark">{{ $customer->alt_phone }}</span>
                            </div>
                            @endif
                            <div class="col-sm-6">
                                <span class="small text-muted d-block mb-0.5"><i class="ti tabler-mail text-success me-1 fs-5"></i>Email</span>
                                <span class="fw-bold text-dark text-break">{{ $customer->email ?? 'N/A' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="small text-muted d-block mb-0.5"><i class="ti tabler-map-pin text-danger me-1 fs-5"></i>District</span>
                                <span class="fw-bold text-dark">{{ $customer->district ?? 'N/A' }}</span>
                            </div>
                            <div class="col-12">
                                <span class="small text-muted d-block mb-0.5"><i class="ti tabler-map text-warning me-1 fs-5"></i>Address</span>
                                <span class="fw-bold text-dark small text-wrap d-block">{{ $customer->address ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right: Quick Financial Stats -->
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-2.5 rounded bg-label-success text-center border-xs-success" style="border: 1px solid rgba(46, 204, 113, 0.1) !important;">
                                    <span class="text-muted d-block small mb-1">Total Paid</span>
                                    <h5 class="fw-bold text-success mb-0">{{ number_format($totalSpent, 2) }} ৳</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2.5 rounded bg-label-danger text-center border-xs-danger" style="border: 1px solid rgba(231, 76, 60, 0.1) !important;">
                                    <span class="text-muted d-block small mb-1">Total Due</span>
                                    <h5 class="fw-bold text-danger mb-0">{{ number_format($totalDue, 2) }} ৳</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2 rounded bg-label-info d-flex align-items-center justify-content-between border-xs-info" style="border: 1px solid rgba(52, 152, 219, 0.1) !important;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti tabler-tool text-info fs-4" style="color: #3498db !important;"></i>
                                        <span class="fw-bold text-dark small">Active repairs</span>
                                    </div>
                                    <span class="badge bg-info rounded-pill px-2.5 py-1 text-white fw-bold" style="background-color: #3498db !important;">{{ $activeRepairsCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Outstanding Dues Ledger (High Priority Box showing only unpaid bills/tickets) -->
    @if($hasDues)
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="border: 1px solid rgba(231, 76, 60, 0.25) !important; background-color: rgba(231, 76, 60, 0.02) !important;">
            <div class="card-header bg-transparent border-0 pb-1 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold text-danger mb-0 d-flex align-items-center">
                    <i class="ti tabler-alert-triangle me-2 fs-3"></i> Outstanding Dues Ledger (অবশিষ্ট বকেয়া তালিকা)
                </h5>
                <span class="badge bg-danger rounded-pill fw-bold px-3 py-1">{{ $unpaidRepairs->count() + $unpaidSales->count() }} Bill(s) Unpaid</span>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive text-nowrap bg-white rounded border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-2.5 ps-3">ID / Reference</th>
                                <th class="py-2.5">Due Type</th>
                                <th class="py-2.5">Product & Service Details</th>
                                <th class="py-2.5">Outstanding Due</th>
                                <th class="py-2.5 text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unpaidSales as $sale)
                            <tr>
                                <td class="ps-3"><span class="fw-bold text-dark">{{ $sale->invoice_no }}</span></td>
                                <td><span class="badge bg-label-primary rounded-pill">POS Sale</span></td>
                                <td class="text-wrap" style="max-width: 300px;">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($sale->details as $detail)
                                            <span class="badge bg-light text-dark border rounded px-2 py-0.5 small" style="font-size: 0.75rem;">
                                                {{ $detail->item ? $detail->item->name : 'Deleted product' }} (x{{ $detail->quantity }})
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td><span class="fw-bold text-danger">{{ number_format($sale->due_amount, 2) }} ৳</span></td>
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-sm btn-success pay-due-btn px-3 py-1 rounded" data-id="{{ $sale->id }}" data-invoice="{{ $sale->invoice_no }}" data-due="{{ $sale->due_amount }}" data-type="sale" data-bs-toggle="modal" data-bs-target="#payDueModal">
                                        <i class="ti tabler-cash me-1 fs-6"></i>Pay Due
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            
                            @foreach($unpaidRepairs as $repair)
                            <tr>
                                <td class="ps-3"><a href="{{ route('admin.repairs.show', $repair->id) }}" class="fw-bold text-primary text-decoration-none">{{ $repair->ticket_id }}</a></td>
                                <td><span class="badge bg-label-info rounded-pill">Device Repair</span></td>
                                <td>
                                    <span class="fw-bold text-dark d-block">{{ $repair->device_brand }} {{ $repair->device_model }}</span>
                                    <span class="text-muted small">Issue: {{ Str::limit($repair->issue_description, 50) }}</span>
                                </td>
                                <td><span class="fw-bold text-danger">{{ number_format($repair->due_amount, 2) }} ৳</span></td>
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-sm btn-warning pay-due-btn px-3 py-1 rounded text-dark" data-id="{{ $repair->id }}" data-invoice="{{ $repair->ticket_id }}" data-due="{{ $repair->due_amount }}" data-type="repair" data-bs-toggle="modal" data-bs-target="#payDueModal">
                                        <i class="ti tabler-cash me-1 fs-6"></i>Pay Due
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- History Tabs (Repairs & POS Purchase History) - 12 Columns -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom pt-3 pb-0">
                <ul class="nav nav-pills mb-3" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold px-4 py-2" id="repairs-tab" data-bs-toggle="tab" data-bs-target="#repairs-content" type="button" role="tab" aria-controls="repairs-content" aria-selected="true">
                            <i class="ti tabler-device-mobile-cog me-1.5 fs-5"></i>Repair History ({{ count($repairs) }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold px-4 py-2" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales-content" type="button" role="tab" aria-controls="sales-content" aria-selected="false">
                            <i class="ti tabler-receipt me-1.5 fs-5"></i>POS Purchase History ({{ count($sales) }})
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="card-body p-0 tab-content" id="profileTabsContent">
                <!-- Repairs Content -->
                <div class="tab-pane fade show active" id="repairs-content" role="tabpanel" aria-labelledby="repairs-tab">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover text-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-4">Ticket ID</th>
                                    <th class="py-3">Device Details</th>
                                    <th class="py-3">Repair Status</th>
                                    <th class="py-3">Payments & Dues</th>
                                    <th class="py-3">Warranty</th>
                                    <th class="py-3 text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($repairs as $repair)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('admin.repairs.show', $repair->id) }}" class="fw-bold text-primary text-decoration-none">{{ $repair->ticket_id }}</a>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark d-block mb-0.5">{{ $repair->device_brand }}</span>
                                        <span class="text-muted small">{{ $repair->device_model }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badges = [
                                                'pending' => 'bg-label-warning',
                                                'diagnosing' => 'bg-label-info',
                                                'waiting_for_approval' => 'bg-label-secondary',
                                                'repairing' => 'bg-label-primary',
                                                'quality_check' => 'bg-label-dark',
                                                'completed' => 'bg-label-success',
                                                'delivered' => 'bg-success text-white',
                                                'cancelled' => 'bg-label-danger'
                                            ];
                                        @endphp
                                        <span class="badge {{ $badges[$repair->status] ?? 'bg-label-secondary' }} px-2.5 py-1 rounded">
                                            {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small">
                                            @if($repair->actual_cost !== null)
                                                <div class="text-dark">Bill: <span class="fw-bold">{{ number_format($repair->actual_cost, 2) }} ৳</span></div>
                                                <div class="text-success">Paid: <span class="fw-bold">{{ number_format($repair->paid_amount, 2) }} ৳</span></div>
                                                @if($repair->due_amount > 0)
                                                    <div class="text-danger mt-0.5">Due: <span class="fw-bold px-1.5 py-0.5 bg-light-danger rounded text-danger" style="font-size: 0.75rem;">{{ number_format($repair->due_amount, 2) }} ৳</span></div>
                                                @endif
                                            @else
                                                <div class="text-muted">Est: {{ number_format($repair->estimated_cost, 2) }} ৳</div>
                                                @if($repair->advance_payment > 0)
                                                    <div class="text-info">Adv: {{ number_format($repair->advance_payment, 2) }} ৳</div>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($repair->status === 'delivered')
                                            @php
                                                $deliveryDate = \Carbon\Carbon::parse($repair->updated_at);
                                                $warrantyExpires = $deliveryDate->copy()->addMonths(6);
                                                $isWarrantyValid = now()->lessThan($warrantyExpires);
                                            @endphp
                                            @if($isWarrantyValid)
                                                <span class="badge bg-label-success rounded-pill" title="Expires {{ $warrantyExpires->format('M d, Y') }}">
                                                    <i class="ti tabler-shield-check me-0.5 small"></i>Valid
                                                </span>
                                            @else
                                                <span class="badge bg-label-danger rounded-pill">Expired</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-1.5 align-items-center">
                                            @if($repair->due_amount > 0)
                                                <button type="button" class="btn btn-sm btn-warning pay-due-btn px-2.5 py-1 rounded text-dark" data-id="{{ $repair->id }}" data-invoice="{{ $repair->ticket_id }}" data-due="{{ $repair->due_amount }}" data-type="repair" data-bs-toggle="modal" data-bs-target="#payDueModal" title="Pay Due Balance">
                                                    <i class="ti tabler-cash me-1 fs-6"></i>Pay Due
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.repairs.show', $repair->id) }}" class="btn btn-icon btn-sm btn-outline-info rounded" title="View Ticket Details"><i class="ti tabler-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted text-wrap">
                                        <i class="ti tabler-info-circle fs-3 d-block mb-2 text-muted"></i>
                                        No repair history logged for this customer.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Purchases POS Content -->
                <div class="tab-pane fade" id="sales-content" role="tabpanel" aria-labelledby="sales-tab">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover text-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-4">Invoice No</th>
                                    <th class="py-3">Products Purchased</th>
                                    <th class="py-3">Total Bill</th>
                                    <th class="py-3">Paid Amount</th>
                                    <th class="py-3">Due Balance</th>
                                    <th class="py-3">Payment</th>
                                    <th class="py-3">Purchase Date</th>
                                    <th class="py-3 text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $sale->invoice_no }}</span>
                                    </td>
                                    <td class="text-wrap" style="max-width: 300px;">
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($sale->details as $detail)
                                                <span class="badge bg-label-secondary text-dark rounded px-2 py-1 small" style="font-size: 0.75rem;">
                                                    {{ $detail->item ? $detail->item->name : 'Deleted product' }} (x{{ $detail->quantity }})
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><span class="fw-bold text-dark">{{ number_format($sale->payable_amount, 2) }} ৳</span></td>
                                    <td><span class="fw-bold text-success">{{ number_format($sale->paid_amount, 2) }} ৳</span></td>
                                    <td>
                                        @if($sale->due_amount > 0)
                                            <span class="badge bg-label-danger fw-bold">{{ number_format($sale->due_amount, 2) }} ৳</span>
                                        @else
                                            <span class="text-muted small">0.00 ৳</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-label-primary px-2.5 py-1 rounded">{{ $sale->payment_method }}</span></td>
                                    <td><span class="small text-muted">{{ $sale->created_at->format('M d, Y') }}</span></td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-1.5 align-items-center">
                                            @if($sale->due_amount > 0)
                                                <button type="button" class="btn btn-sm btn-success pay-due-btn px-2.5 py-1 rounded" data-id="{{ $sale->id }}" data-invoice="{{ $sale->invoice_no }}" data-due="{{ $sale->due_amount }}" data-type="sale" data-bs-toggle="modal" data-bs-target="#payDueModal" title="Pay Due Balance">
                                                    <i class="ti tabler-cash me-1 fs-6"></i>Pay Due
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.pos.invoice', $sale->id) }}" target="_blank" class="btn btn-icon btn-sm btn-outline-info rounded" title="Invoice Print"><i class="ti tabler-printer"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted text-wrap">
                                        <i class="ti tabler-info-circle fs-3 d-block mb-2 text-muted"></i>
                                        No POS purchases logged.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Pay Due -->
<div class="modal fade" id="payDueModal" tabindex="-1" aria-labelledby="payDueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="payDueModalLabel"><i class="ti tabler-wallet me-1.5 text-success"></i>Record Due Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="payDueForm" method="POST" action="">
                @csrf
                <div class="modal-body pt-3">
                    <div class="alert alert-info border-0 shadow-xs mb-3 d-flex align-items-center" style="background-color: rgba(115, 103, 240, 0.08);">
                        <i class="ti tabler-info-circle text-primary fs-4 me-2"></i> 
                        <div>Recording payment for <span id="pd_label_type" class="fw-bold">invoice</span>: <strong id="pd_invoice_no" class="text-dark">INV-XXXX</strong></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="pd_due_display">Outstanding Due Amount</label>
                        <div class="input-group">
                            <input type="text" id="pd_due_display" class="form-control bg-light fw-bold text-danger border-end-0" readonly value="0.00 BDT">
                            <span class="input-group-text bg-light border-start-0 text-danger fw-bold"><i class="ti tabler-alert-circle"></i></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" for="pd_amount_paid">Amount to Pay <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="amount_paid" id="pd_amount_paid" class="form-control fw-bold text-dark" required min="0.01" step="0.01" placeholder="e.g. 500">
                            <span class="input-group-text fw-bold">BDT</span>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-dark" for="pd_payment_method">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" id="pd_payment_method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm" style="background-color: #2ec471 !important; border-color: #2ec471 !important;"><i class="ti tabler-circle-check me-1 fs-5"></i>Confirm Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Premium style improvements */
    .bg-label-secondary {
        background-color: #f1f3f4 !important;
        color: #5f6368 !important;
    }
    .bg-light-danger {
        background-color: rgba(231, 76, 60, 0.08) !important;
    }
    .nav-pills .nav-link {
        color: #5f6368;
        border-radius: 30px;
        transition: all 0.25s ease;
    }
    .nav-pills .nav-link.active {
        background-color: #7367f0 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(115, 103, 240, 0.25);
    }
    .nav-pills .nav-link:not(.active):hover {
        background-color: rgba(115, 103, 240, 0.08);
        color: #7367f0;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(115, 103, 240, 0.02) !important;
    }
    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid rgba(0, 0, 0, 0.08) !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payDueButtons = document.querySelectorAll('.pay-due-btn');
    const payDueForm = document.getElementById('payDueForm');
    const pdInvoiceNo = document.getElementById('pd_invoice_no');
    const pdDueDisplay = document.getElementById('pd_due_display');
    const pdAmountPaid = document.getElementById('pd_amount_paid');
    const pdLabelType = document.getElementById('pd_label_type');

    payDueButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const identifier = this.getAttribute('data-invoice');
            const dueAmount = parseFloat(this.getAttribute('data-due')) || 0;
            const type = this.getAttribute('data-type') || 'sale';

            // Set Form action and dynamic label based on type
            if (type === 'repair') {
                payDueForm.action = `/admin/repairs/${itemId}/pay-due`;
                if (pdLabelType) pdLabelType.textContent = 'ticket';
            } else {
                payDueForm.action = `/admin/sales/${itemId}/pay-due`;
                if (pdLabelType) pdLabelType.textContent = 'invoice';
            }
            
            // Set text displays
            pdInvoiceNo.textContent = identifier;
            pdDueDisplay.value = dueAmount.toFixed(2) + ' BDT';
            
            // Set max attribute and default input value
            pdAmountPaid.max = dueAmount;
            pdAmountPaid.value = dueAmount;
        });
    });
});
</script>
@endsection
