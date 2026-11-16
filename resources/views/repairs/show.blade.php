@extends('layouts/contentNavbarLayout')

@section('title', 'Job Card Ticket Detail - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Job Card Ticket: <span class="text-primary">{{ $repair->ticket_id }}</span></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.repairs.index') }}">Repairs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $repair->ticket_id }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <!-- Send SMS Action Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti tabler-message-2 me-1"></i>Send SMS
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-1">
                    <li>
                        <form action="{{ route('admin.repairs.send-sms', $repair->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="tracking">
                            <button type="submit" class="dropdown-item py-2">
                                <i class="ti tabler-send me-2 text-primary"></i>Send Tracking Link SMS
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.repairs.send-sms', $repair->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="parts_arrived">
                            <button type="submit" class="dropdown-item py-2">
                                <i class="ti tabler-truck-delivery me-2 text-warning"></i>Send Parts Arrived (ঢাকা পার্টস) SMS
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.repairs.send-sms', $repair->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="ready">
                            <button type="submit" class="dropdown-item py-2">
                                <i class="ti tabler-circle-check me-2 text-success"></i>Send Ready for Pickup SMS
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.repairs.send-sms', $repair->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="delivered">
                            <button type="submit" class="dropdown-item py-2">
                                <i class="ti tabler-package me-2 text-info"></i>Send Delivery & Bill SMS
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('admin.repairs.send-sms', $repair->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="technician_reminder">
                            <button type="submit" class="dropdown-item py-2 {{ !$repair->technician ? 'disabled' : '' }}" {{ !$repair->technician ? 'disabled' : '' }}>
                                <i class="ti tabler-bell-ringing me-2 text-warning"></i>Send Technician Alert SMS
                                @if($repair->technician)
                                    <small class="d-block text-muted ps-4">To: {{ $repair->technician->name }} ({{ $repair->technician->phone ?: 'No Phone' }})</small>
                                @endif
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <button type="button" class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#customSmsModal">
                            <i class="ti tabler-pencil me-2 text-secondary"></i>Write Custom SMS...
                        </button>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#updateCustomerModal">
                <i class="ti tabler-user-edit me-1"></i>Customer Info
            </button>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickStatusModal">
                <i class="ti tabler-refresh me-1"></i>Update Status & Note
            </button>
            <a href="{{ route('admin.repairs.print', $repair->id) }}" class="btn btn-outline-secondary" target="_blank"><i class="ti tabler-printer me-1"></i>Print Job Slip</a>
            <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="btn btn-primary"><i class="ti tabler-edit me-1"></i>Edit Ticket</a>
        </div>
    </div>
 
    <!-- Session Alerts -->
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success border-0 py-2 d-flex align-items-center">
                <i class="ti tabler-circle-check fs-4 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="col-12 mb-3">
            <div class="alert alert-danger border-0 py-2 d-flex align-items-center">
                <i class="ti tabler-alert-circle fs-4 me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- Details Card -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-primary mb-0"><i class="ti tabler-user me-2"></i>Customer & Device Details</h5>
                    <button type="button" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateCustomerModal">
                        <i class="ti tabler-edit me-1"></i>Edit Customer Info
                    </button>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Customer Name</label>
                        @if($repair->customer)
                            <a href="{{ route('admin.customers.show', $repair->customer->id) }}" class="fw-bold text-dark fs-5 text-decoration-none">{{ $repair->customer->name }}</a>
                        @else
                            <span class="fw-bold text-dark fs-5">Walk-in Customer</span>
                        @endif
                    </div>
                    @if(!empty($repair->customer?->phone))
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Phone Number</label>
                        <span class="fw-bold text-dark fs-5">{{ $repair->customer->phone }}</span>
                    </div>
                    @endif
                    @if(!empty($repair->customer?->email))
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Email Address</label>
                        <span class="text-dark">{{ $repair->customer->email }}</span>
                    </div>
                    @endif
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Expected Delivery Date</label>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="text-dark fw-semibold">{{ $repair->expected_delivery_date ? \Carbon\Carbon::parse($repair->expected_delivery_date)->format('M d, Y') : 'Not Specified' }}</span>
                            @if($repair->expected_date_reminder_sent_at)
                                <span class="badge bg-label-info" title="Reminder SMS dispatched on {{ $repair->expected_date_reminder_sent_at->format('d M, Y h:i A') }}">
                                    <i class="ti tabler-bell-check me-1"></i>Tech Alerted SMS ({{ $repair->expected_date_reminder_sent_at->format('d M, h:i A') }})
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="my-3 text-muted opacity-25">

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Device Brand & Model</label>
                        <span class="fw-bold text-dark">{{ $repair->device_brand }} {{ $repair->device_model }}</span>
                    </div>
                    @if(!empty($repair->serial_imei))
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">IMEI or Serial Number</label>
                        <span class="text-dark">{{ $repair->serial_imei }}</span>
                    </div>
                    @endif
                    @if($repair->data_loss_consent)
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Customer Data Backup Consent</label>
                        <span class="badge bg-label-success"><i class="ti tabler-circle-check me-1"></i>Consent Verified & Signed</span>
                    </div>
                    @endif
                    <div class="col-sm-12 mb-3">
                        <label class="small text-muted d-block mb-1">Issue Description</label>
                        <span class="text-dark leading-relaxed d-block p-3 bg-light rounded-3">{{ $repair->issue_description }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($repair->device_photos && count($repair->device_photos) > 0)
        <!-- Device Photos Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-camera me-2"></i>Device Photos (At Check-in)</h5>
                <div class="row g-2">
                    @foreach($repair->device_photos as $photo)
                        <div class="col-sm-4 col-md-3">
                            <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="d-block border rounded overflow-hidden shadow-xs hover-zoom" style="height: 120px;">
                                <img src="{{ asset('storage/' . $photo) }}" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Costs Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-report-money me-2"></i>Financial & Payments Summary</h5>

                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                        <div class="p-3 bg-light rounded-3">
                            <span class="small text-muted d-block mb-1">Service Fee</span>
                            <h4 class="fw-bold text-dark mb-0">{{ number_format($repair->repair_charge, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                        <div class="p-3 bg-light rounded-3">
                            <span class="small text-muted d-block mb-1">Parts Cost</span>
                            @php
                                $totalPartsCost = 0;
                                if($repair->used_parts && count($repair->used_parts) > 0) {
                                    foreach($repair->used_parts as $part) {
                                        $totalPartsCost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
                                    }
                                }
                            @endphp
                            <h4 class="fw-bold text-dark mb-0">{{ number_format($totalPartsCost, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3 mb-md-0">
                        <div class="p-3 bg-light rounded-3">
                            <span class="small text-muted d-block mb-1">Total Bill</span>
                            <h4 class="fw-bold text-dark mb-0">{{ number_format($repair->actual_cost !== null ? $repair->actual_cost : $repair->estimated_cost, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3 mb-sm-0">
                        <div class="p-3 bg-label-info rounded-3">
                            <span class="small text-muted d-block mb-1">Paid So Far</span>
                            <h4 class="fw-bold text-info mb-0">{{ number_format($repair->paid_amount, 2) }} BDT</h4>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="p-3 bg-label-danger rounded-3">
                            <span class="small text-muted d-block mb-1">Remaining Due</span>
                            <h4 class="fw-bold text-danger mb-0">{{ number_format($repair->due_amount, 2) }} BDT</h4>
                        </div>
                    </div>
                </div>

                @if($repair->actual_cost !== null)
                <div class="mt-4 p-4 rounded-3" style="background: {{ $repair->due_amount > 0 ? 'linear-gradient(135deg, rgba(243, 156, 18, 0.08) 0%, rgba(230, 126, 34, 0.03) 100%)' : 'linear-gradient(135deg, rgba(46, 204, 113, 0.08) 0%, rgba(39, 174, 96, 0.03) 100%)' }}; border: 1px solid {{ $repair->due_amount > 0 ? 'rgba(243, 156, 18, 0.25)' : 'rgba(46, 204, 113, 0.25)' }}; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-circle d-flex align-items-center justify-content-center {{ $repair->due_amount > 0 ? 'bg-label-warning text-warning' : 'bg-label-success text-success' }}" style="width: 54px; height: 54px;">
                                <i class="ti {{ $repair->due_amount > 0 ? 'tabler-alert-circle' : 'tabler-circle-check' }}" style="font-size: 28px;"></i>
                            </div>
                            <div>
                                <span class="text-uppercase tracking-wider fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Payment Status</span>
                                <h5 class="fw-bold text-dark mb-0 mt-1">
                                    {{ $repair->due_amount > 0 ? 'Partially Paid (Due Balance)' : ($repair->status === 'delivered' ? 'Fully Settled & Delivered' : 'Fully Settled') }}
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            @if($repair->due_amount > 0)
                                <button type="button" class="btn btn-warning px-3 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#payDueModal">
                                    <i class="ti tabler-cash me-1"></i>Pay Due BDT {{ number_format($repair->due_amount, 0) }}
                                </button>
                            @else
                                <span class="badge bg-success px-3 py-2 fs-6"><i class="ti tabler-circle-check me-1"></i>Settled</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4 pt-3 border-top" style="border-top-color: rgba(0, 0, 0, 0.05) !important;">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <span class="small text-muted d-block">Actual/Final Cost (Total Bill)</span>
                            <span class="fs-5 fw-bold text-dark d-block mt-1">{{ number_format($repair->actual_cost, 2) }} BDT</span>
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <span class="small text-muted d-block">Advance Paid (Initially)</span>
                            <span class="fs-5 fw-bold text-info d-block mt-1">{{ number_format($repair->advance_payment, 2) }} BDT</span>
                            @if($repair->advance_payment > 0)
                                <span class="badge bg-label-info mt-1"><i class="ti tabler-wallet me-1"></i>{{ $repair->advance_payment_method ?? 'Cash' }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <span class="small text-muted d-block">Paid at Delivery</span>
                            <span class="fs-5 fw-bold text-success d-block mt-1">{{ number_format($repair->paid_amount - $repair->advance_payment, 2) }} BDT</span>
                            @if($repair->paid_amount > $repair->advance_payment)
                                <span class="badge bg-label-success mt-1"><i class="ti tabler-wallet me-1"></i>{{ $repair->payment_method ?? 'Cash' }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <span class="small text-muted d-block">Remaining Due Balance</span>
                            <span class="fs-5 fw-bold text-danger d-block mt-1">{{ number_format($repair->due_amount, 2) }} BDT</span>
                        </div>
                    </div>

                    @if(($repair->payment_method ?? 'Cash') === 'Cash' && $repair->cash_received !== null)
                    <div class="row mt-3 pt-3 border-top" style="border-top-color: rgba(0, 0, 0, 0.05) !important; border-top-style: dashed !important;">
                        <div class="col-sm-6 mb-2 mb-sm-0">
                            <span class="small text-muted">Cash Received:</span>
                            <span class="fw-bold text-dark ms-2">{{ number_format($repair->cash_received, 2) }} BDT</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="small text-muted">Change Returned:</span>
                            <span class="fw-bold text-success ms-2">{{ number_format($repair->change_returned ?? 0, 2) }} BDT</span>
                        </div>
                    </div>
                    @endif

                    @if(intval($repair->warranty_days) > 0)
                    <div class="row mt-3 pt-3 border-top" style="border-top-color: rgba(0, 0, 0, 0.05) !important; border-top-style: dashed !important;">
                        <div class="col-sm-6 mb-2 mb-sm-0">
                            <span class="small text-muted">Warranty Period:</span>
                            <span class="fw-bold text-dark ms-2">{{ $repair->warranty_days }} Days</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="small text-muted">Warranty Status:</span>
                            @php
                                $isExpired = $repair->warranty_expiry_date && \Carbon\Carbon::parse($repair->warranty_expiry_date)->isPast();
                            @endphp
                            @if($isExpired)
                                <span class="badge bg-label-danger ms-2"><i class="ti tabler-alert-circle me-1"></i>Expired (on {{ \Carbon\Carbon::parse($repair->warranty_expiry_date)->format('M d, Y') }})</span>
                            @else
                                <span class="badge bg-label-success ms-2"><i class="ti tabler-circle-check me-1"></i>Active (Expires on {{ \Carbon\Carbon::parse($repair->warranty_expiry_date)->format('M d, Y') }})</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                @if($repair->due_amount > 0)
                <!-- Modal: Pay Due -->
                <div class="modal fade" id="payDueModal" tabindex="-1" aria-labelledby="payDueModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="payDueModalLabel">Record Due Payment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.repairs.pay-due', $repair->id) }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="alert alert-info d-flex align-items-center mb-3">
                                        <i class="ti tabler-info-circle me-2 fs-4"></i>
                                        <div>Recording payment for ticket: <strong>{{ $repair->ticket_id }}</strong></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Outstanding Due Amount</label>
                                        <input type="text" class="form-control bg-light" readonly value="{{ number_format($repair->due_amount, 2) }} BDT">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" for="amount_paid">Amount to Pay <span class="text-danger">*</span></label>
                                        <input type="number" name="amount_paid" id="amount_paid" class="form-control" step="0.01" min="0.01" max="{{ $repair->due_amount }}" value="{{ $repair->due_amount }}" required>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold" for="pd_payment_method">Payment Method <span class="text-danger">*</span></label>
                                        <select name="payment_method" id="pd_payment_method" class="form-select" required>
                                            <option value="Cash">Cash</option>
                                            <option value="bKash">bKash</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="Rocket">Rocket</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Confirm Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endif

                <!-- Installed Spare Parts -->
                <div class="mt-4 border-top pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0"><i class="ti tabler-box me-1 text-primary"></i>Installed Spare Parts & Sourcing</h6>
                        @if($repair->has_dhaka_parts)
                            <span class="badge bg-label-info"><i class="ti tabler-truck-delivery me-1"></i>Includes Dhaka/Outsourced Parts</span>
                        @endif
                    </div>
                    @if($repair->used_parts && count($repair->used_parts) > 0)
                        <div class="table-responsive border rounded mb-3">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Part Name</th>
                                        <th>Source (উৎস)</th>
                                        <th>Supplier / Shop</th>
                                        <th class="text-center">Qty</th>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                            <th class="text-end">Buying Price</th>
                                            <th class="text-end">Courier (৳)</th>
                                            <th class="text-end">Total Cost</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPartsCost = 0;
                                        $totalCourierCost = 0;
                                    @endphp
                                    @foreach($repair->used_parts as $part)
                                        @php
                                            $qty = intval($part['quantity'] ?? 1);
                                            $buyingPrice = floatval($part['buying_price'] ?? 0);
                                            $courier = floatval($part['courier_cost'] ?? 0);
                                            $partCost = ($buyingPrice * $qty) + $courier;
                                            $totalPartsCost += ($buyingPrice * $qty);
                                            $totalCourierCost += $courier;
                                            $source = $part['source'] ?? (isset($part['inventory_id']) && $part['inventory_id'] ? 'in_house' : 'dhaka_supplier');
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $part['name'] }}</td>
                                            <td>
                                                @if($source === 'in_house')
                                                    <span class="badge bg-label-success">দোকানের স্টক</span>
                                                @elseif($source === 'dhaka_supplier')
                                                    <span class="badge bg-label-warning text-dark"><i class="ti tabler-truck-delivery me-1"></i>ঢাকা সাপ্লায়ার</span>
                                                @elseif($source === 'local_shop')
                                                    <span class="badge bg-label-info">লোকাল দোকান</span>
                                                @else
                                                    <span class="badge bg-label-secondary">অন্যান্য</span>
                                                @endif
                                            </td>
                                            <td class="small text-muted">{{ $part['supplier_name'] ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $qty }}</td>
                                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                                <td class="text-end">{{ number_format($buyingPrice, 2) }} BDT</td>
                                                <td class="text-end">{{ number_format($courier, 2) }} BDT</td>
                                                <td class="text-end fw-bold text-dark">{{ number_format($partCost, 2) }} BDT</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                        <tr class="table-light fw-bold text-dark">
                                            <td colspan="4" class="text-end">Parts + Courier Total:</td>
                                            <td class="text-end">{{ number_format($totalPartsCost, 2) }}</td>
                                            <td class="text-end">{{ number_format($totalCourierCost, 2) }}</td>
                                            <td class="text-end fw-bold text-primary">{{ number_format($totalPartsCost + $totalCourierCost, 2) }} BDT</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                        <div class="p-3 bg-label-success rounded-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-success d-block"><i class="ti tabler-chart-pie me-1"></i>Estimated Shop Net Profit (নিট লাভ)</span>
                                <small class="text-muted">Total Bill - (Parts Cost + Courier + Commission)</small>
                            </div>
                            <h4 class="fw-bold text-success mb-0">{{ number_format($repair->net_profit, 2) }} BDT</h4>
                        </div>
                        @endif
                    @else
                        <div class="p-3 bg-light rounded text-center small text-muted">
                            <i class="ti tabler-info-circle me-1"></i>No new parts were installed for this repair.
                        </div>
                    @endif
                </div>
            </div>
        </div>

         @if(!empty($repair->status_history) && is_array($repair->status_history))
        <!-- Detailed History Log Card -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="ti tabler-history me-2 text-primary"></i>Status & Assignment History Log</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.8rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Date & Time</th>
                                <th>Event / Status</th>
                                <th>Tech Assigned</th>
                                <th>Action By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_reverse($repair->status_history) as $historyItem)
                            <tr>
                                <td class="text-nowrap text-muted">
                                    <i class="ti tabler-clock me-1"></i>{{ \Carbon\Carbon::parse($historyItem['created_at'] ?? now())->format('d M, Y h:i A') }}
                                </td>
                                <td>
                                    @php
                                        $type = $historyItem['type'] ?? 'status_change';
                                        $st = $historyItem['status'] ?? '';
                                        $label = $historyItem['status_label'] ?? ucfirst(str_replace('_', ' ', $st));
                                    @endphp
                                    @if($type === 'assignment')
                                        <span class="badge bg-label-info"><i class="ti tabler-user-check me-1"></i>Assigned</span>
                                    @elseif($type === 'unassignment')
                                        <span class="badge bg-label-secondary"><i class="ti tabler-user-x me-1"></i>Unassigned</span>
                                    @elseif($type === 'created')
                                        <span class="badge bg-label-primary"><i class="ti tabler-plus me-1"></i>Created</span>
                                    @elseif($type === 'sms_alert')
                                        <span class="badge bg-label-warning"><i class="ti tabler-bell-ringing me-1"></i>Tech SMS Alert</span>
                                    @else
                                        <span class="badge bg-label-success">{{ $label }}</span>
                                    @endif

                                    @if(!empty($historyItem['note']))
                                        <small class="d-block text-muted mt-1" style="font-size: 0.72rem;">{{ $historyItem['note'] }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($historyItem['technician_name']))
                                        <span class="text-dark fw-semibold"><i class="ti tabler-user me-1 text-primary"></i>{{ $historyItem['technician_name'] }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-dark">{{ $historyItem['user_name'] ?? 'System' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Timeline Status & Operations Sidebar -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-5"><i class="ti tabler-git-commit me-2"></i>Job Lifecycle Status</h5>

                @php
                    $status = $repair->status;
                    $techNotes = $repair->technician_notes ? $repair->technician_notes : null;

                    $steps = [
                        'pending' => [
                            'Title' => 'Pending Confirmation',
                            'Desc' => 'Ticket #' . $repair->ticket_id . ' logged for ' . $repair->device_brand . ' ' . $repair->device_model . '.',
                            'Icon' => 'tabler-ticket'
                        ],
                        'diagnosing' => [
                            'Title' => 'Diagnosing',
                            'Desc' => 'Diagnosing reported issue: "' . $repair->issue_description . '"',
                            'Icon' => 'tabler-zoom-check'
                        ],
                        'waiting_for_approval' => [
                            'Title' => 'Waiting Approval',
                            'Desc' => 'Estimated cost ' . number_format($repair->estimated_cost, 0) . ' BDT shared, awaiting customer approval.',
                            'Icon' => 'tabler-clock'
                        ],
                        'waiting_for_parts' => [
                            'Title' => 'Waiting for Parts )',
                            'Desc' => 'প্রয়োজনীয় পার্টস ঢাকা/বাইরের সাপ্লায়ার থেকে সংগ্রহ করা হচ্ছে।',
                            'Icon' => 'tabler-truck-delivery'
                        ],
                        'repairing' => [
                            'Title' => 'Repairing',
                            'Desc' => $techNotes ? $techNotes : 'Replacing components or software flashing in lab.',
                            'Icon' => 'tabler-tool'
                        ],
                        'quality_check' => [
                            'Title' => 'Quality Check',
                            'Desc' => 'Testing screen, cameras, battery, and charging stability.',
                            'Icon' => 'tabler-shield-check'
                        ],
                        'completed' => [
                            'Title' => 'Completed (Ready)',
                            'Desc' => 'Job finished! Device ready for pickup.',
                            'Icon' => 'tabler-checkbox'
                        ],
                        'delivered' => [
                            'Title' => 'Delivered',
                            'Desc' => 'Payment settled and device collected by customer.',
                            'Icon' => 'tabler-archive'
                        ]
                    ];

                    $fullStatusOrder = ['pending', 'diagnosing', 'waiting_for_approval', 'waiting_for_parts', 'repairing', 'quality_check', 'completed', 'delivered'];
                    $currentIndex = array_search($status, $fullStatusOrder);

                    if ($status == 'cancelled') {
                        $steps['cancelled'] = ['Title' => 'Cancelled', 'Desc' => 'Repair ticket cancelled.', 'Icon' => 'tabler-square-x'];
                        $statusOrder = ['pending', 'cancelled'];
                        $currentIndex = 1;
                    } else {
                        $statusOrder = $currentIndex !== false ? array_slice($fullStatusOrder, 0, $currentIndex + 1) : $fullStatusOrder;
                    }
                @endphp

                <div class="position-relative ps-4" style="border-left: 2px dashed #cbd5e1; margin-left: 15px;">
                    @foreach($statusOrder as $index => $stepKey)
                        @php
                            $step = $steps[$stepKey];
                            $isPassed = $currentIndex >= $index && $status != 'cancelled';
                            $isActive = $currentIndex === $index;
                            $dotColor = $isActive ? '#7367f0' : ($isPassed ? '#28c76f' : '#82868b');
                            $stepDate = $repair->getStatusDate($stepKey);
                        @endphp
                        <div class="mb-5 position-relative">
                            <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white"
                                 style="left: -32px; top: 0px; width: 30px; height: 30px; {{ $isActive ? 'box-shadow: 0 0 0 5px rgba(115, 103, 240, 0.25);' : '' }} background-color: {{ $dotColor }};">
                                <i class="ti {{ $step['Icon'] }} fs-6"></i>
                            </div>
                            <div class="ps-2">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                                    <h6 class="fw-bold mb-1 {{ $isActive ? 'text-primary' : ($isPassed ? 'text-success' : 'text-muted') }}">
                                        {{ $step['Title'] }}
                                    </h6>
                                    @if($stepDate && ($isPassed || $isActive))
                                        <span class="badge bg-label-secondary text-muted" style="font-size: 0.72rem;">
                                            <i class="ti tabler-calendar-time me-1 text-primary"></i>{{ $stepDate->format('d M, Y • h:i A') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-muted mb-0 small">{{ $step['Desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Technician logs -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-user-cog me-2"></i>Operation Assignments & Logs</h5>
                <div class="row mb-3">
                    <div class="col-12 mb-2">
                        <label class="small text-muted d-block mb-1">Assigned Technician</label>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge bg-label-primary px-3 py-2 fs-6">
                                <i class="ti tabler-user me-1"></i>{{ $repair->technician ? $repair->technician->name : 'Unassigned' }}
                            </span>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                            <button type="button" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickStatusModal" title="Change Technician">
                                <i class="ti tabler-edit"></i> Reassign
                            </button>
                            @endif
                        </div>
                        @if($repair->technician)
                            <div class="text-muted small mt-2">
                                <i class="ti tabler-calendar-check text-success me-1"></i>Assigned on: <strong>{{ ($repair->assigned_at ?? $repair->created_at)->format('d M, Y h:i A') }}</strong>
                            </div>
                            @if($repair->technician->phone)
                            <div class="text-muted small mt-1">
                                <i class="ti tabler-phone text-primary me-1"></i>Phone: <strong>{{ $repair->technician->phone }}</strong>
                            </div>
                            @endif
                            @if($repair->expected_date_reminder_sent_at)
                            <div class="mt-2">
                                <span class="badge bg-label-info" title="Automated reminder sent to technician on {{ $repair->expected_date_reminder_sent_at->format('d M, Y h:i A') }}">
                                    <i class="ti tabler-bell-check me-1"></i>1-Day Alert SMS Sent ({{ $repair->expected_date_reminder_sent_at->format('d M, h:i A') }})
                                </span>
                            </div>
                            @endif
                        @endif
                    </div>
                    @if($repair->commission_type && auth()->user()->isSuperAdmin())
                    <div class="col-12 mt-2">
                        <label class="small text-muted d-block mb-1">Technician Commission</label>
                        <span class="badge bg-label-success px-3 py-2 fs-6">
                            <i class="ti tabler-chart-pie me-1"></i>
                            @if($repair->commission_type === 'percentage')
                                {{ $repair->commission_rate }}% ({{ number_format($repair->commission_amount, 2) }} BDT)
                            @else
                                Flat {{ number_format($repair->commission_rate, 2) }} BDT
                            @endif
                        </span>
                    </div>
                    @endif
                </div>
                <div class="mb-0">
                    <label class="small text-muted d-block mb-1">Technician Log Notes</label>
                    @if($repair->technician_notes)
                        <p class="text-muted leading-relaxed mb-0 p-3 bg-light rounded-3 border-start border-primary border-3">{{ $repair->technician_notes }}</p>
                    @else
                        <p class="text-muted italic small mb-0">No technical logs written yet by staff.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print layout stylesheet -->
<style>
@media print {
    #layout-menu,
    .layout-navbar,
    .btn,
    .nav-tabs,
    .breadcrumb,
    footer {
        display: none !important;
    }
    .layout-page {
        padding: 0 !important;
    }
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>



<!-- Custom SMS Modal -->
<div class="modal fade" id="customSmsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.repairs.send-sms', $repair->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="custom">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="ti tabler-message-2 text-primary me-2"></i>Send Custom SMS to Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Customer Phone</label>
                        <input type="text" class="form-control" value="{{ $repair->customer ? $repair->customer->phone : 'N/A' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="custom_message">SMS Message <span class="text-danger">*</span></label>
                        <textarea name="custom_message" id="custom_message" class="form-control" rows="4" placeholder="Write custom SMS message..." required>Dear {{ $repair->customer ? $repair->customer->name : 'Customer' }}, your device {{ $repair->device_brand }} {{ $repair->device_model }} (Ticket: {{ $repair->ticket_id }}). </textarea>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="ti tabler-send me-1"></i>Send SMS Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Status & Note Update Modal -->
<div class="modal fade" id="quickStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.repairs.quick-status', $repair->id) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="ti tabler-refresh text-primary me-2"></i>Update Job Status & Live ERT Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="qs_status">Repair Job Status <span class="text-danger">*</span></label>
                        <select name="status" id="qs_status" class="form-select" required>
                            <option value="pending" {{ $repair->status == 'pending' ? 'selected' : '' }}> Pending confirmation</option>
                            <option value="diagnosing" {{ $repair->status == 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                            <option value="waiting_for_approval" {{ $repair->status == 'waiting_for_approval' ? 'selected' : '' }}>Waiting Approval</option>
                            <option value="waiting_for_parts" {{ $repair->status == 'waiting_for_parts' ? 'selected' : '' }}>Waiting for Parts - Dhaka</option>
                            <option value="repairing" {{ $repair->status == 'repairing' ? 'selected' : '' }}>Repairing</option>
                            <option value="quality_check" {{ $repair->status == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                            <option value="completed" {{ $repair->status == 'completed' ? 'selected' : '' }}>Completed / Ready for Pickup</option>
                            <option value="delivered" {{ $repair->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $repair->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <div class="text-muted small mt-1">
                            <i class="ti tabler-clock-edit me-1 text-info"></i>Current status updated: {{ ($repair->status_updated_at ?? $repair->created_at)->format('d M, Y h:i A') }}
                        </div>
                    </div>

                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="qs_assigned_technician_id">Assign Technician</label>
                        <select name="assigned_technician_id" id="qs_assigned_technician_id" class="form-select">
                            <option value="">-- Unassigned --</option>
                            @if(isset($technicians))
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}" {{ $repair->assigned_technician_id == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($repair->assigned_technician_id)
                        <div class="text-muted small mt-1">
                            <i class="ti tabler-calendar-check me-1 text-success"></i>Assigned on: {{ ($repair->assigned_at ?? $repair->created_at)->format('d M, Y h:i A') }}
                        </div>
                        @endif
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="qs_technician_notes">
                            Live Description / Technician Note
                            <small class="text-muted d-block fw-normal"></small>
                        </label>
                        <textarea name="technician_notes" id="qs_technician_notes" class="form-control" rows="4" placeholder="যেমন: নতুন অরিজিনাল ডিসপ্লে লাগানো হচ্ছে / মাদারবোর্ড আইসি ডায়াগনসিস সম্পন্ন...">{{ $repair->technician_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="ti tabler-check me-1"></i>Save & Update Live Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Customer Info Update Modal -->
<div class="modal fade" id="updateCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.repairs.update-customer', $repair->id) }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="ti tabler-user-edit text-primary me-2"></i>Update Customer Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="modal_customer_name">Customer Name</label>
                        <input type="text" name="customer_name" id="modal_customer_name" class="form-control" value="{{ $repair->customer ? $repair->customer->name : 'Walk-in Customer' }}" placeholder="e.g. John Doe / Walk-in Customer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="modal_customer_phone">Customer Mobile Number</label>
                        <input type="text" name="customer_phone" id="modal_customer_phone" class="form-control" value="{{ $repair->customer ? $repair->customer->phone : '' }}" placeholder="e.g. 01750121196">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="modal_customer_address">Address</label>
                        <input type="text" name="customer_address" id="modal_customer_address" class="form-control" value="{{ $repair->customer ? $repair->customer->address : '' }}" placeholder="e.g. Dhaka, Bangladesh">
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="ti tabler-check me-1"></i>Save Customer Info
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
