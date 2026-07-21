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
            <a href="{{ route('admin.repairs.print', $repair->id) }}" class="btn btn-outline-secondary" target="_blank"><i class="ti tabler-printer me-1"></i>Print Job Slip</a>
            <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="btn btn-primary"><i class="ti tabler-edit me-1"></i>Edit Ticket</a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-user me-2"></i>Customer & Device Details</h5>
                
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Customer Name</label>
                        @if($repair->customer)
                            <a href="{{ route('admin.customers.show', $repair->customer->id) }}" class="fw-bold text-dark fs-5 text-decoration-none">{{ $repair->customer->name }}</a>
                        @else
                            <span class="fw-bold text-dark fs-5">Walk-in Customer</span>
                        @endif
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Phone Number</label>
                        <span class="fw-bold text-dark fs-5">{{ $repair->customer ? $repair->customer->phone : 'N/A' }}</span>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Email Address</label>
                        <span class="text-dark">{{ $repair->customer?->email ?? 'N/A' }}</span>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Expected Delivery Date</label>
                        <span class="text-dark fw-semibold">{{ $repair->expected_delivery_date ? \Carbon\Carbon::parse($repair->expected_delivery_date)->format('M d, Y') : 'Not Specified' }}</span>
                    </div>
                </div>

                <hr class="my-3 text-muted opacity-25">

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Device Brand & Model</label>
                        <span class="fw-bold text-dark">{{ $repair->device_brand }} {{ $repair->device_model }}</span>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">IMEI or Serial Number</label>
                        <span class="text-dark">{{ $repair->serial_imei ?? 'N/A' }}</span>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="small text-muted d-block mb-1">Pattern Screen Unlock / Passwords</label>
                        <span class="text-dark fw-semibold p-2 bg-light rounded-3 d-block border-start border-warning border-3 mb-2"><i class="ti tabler-key me-1 text-warning"></i>{{ $repair->password_pattern ?? 'No lock credentials shared.' }}</span>
                        
                        @if($repair->pattern_lock_path)
                        <div id="read-only-pattern-wrapper" class="card p-2 border mt-2" style="width: fit-content; background: #f8f9fa;">
                            <div id="pattern-holder" style="width: 140px; height: 140px; position: relative; background: #eef1f6; border-radius: 8px;">
                                <svg id="pattern-svg" style="width:100%; height:100%; position:absolute; top:0; left:0; pointer-events:none;"></svg>
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(3, 1fr); height: 100%; width: 100%; padding: 8px; box-sizing: border-box;">
                                    @for($i = 1; $i <= 9; $i++)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="pattern-dot" data-index="{{ $i }}" style="width: 10px; height: 10px; border-radius: 50%; background: #a1b0cb;"></div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                            <input type="hidden" id="pattern_lock_path" value="{{ $repair->pattern_lock_path }}">
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="small text-muted d-block mb-1">Customer Data Backup Consent</label>
                        @if($repair->data_loss_consent)
                            <span class="badge bg-label-success"><i class="ti tabler-circle-check me-1"></i>Consent Verified & Signed</span>
                        @else
                            <span class="badge bg-label-warning"><i class="ti tabler-alert-circle me-1"></i>No Consent Logged</span>
                        @endif
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="small text-muted d-block mb-1">Issue Description</label>
                        <span class="text-dark leading-relaxed d-block p-3 bg-light rounded-3">{{ $repair->issue_description }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checklist & Photos Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-clipboard-check me-2"></i>Device Checklist & Physical Condition</h5>
                
                @php
                    $checklist = $repair->device_checklist ?? [];
                    $labels = [
                        'scratches' => 'Body Scratches / Dents',
                        'display_ok' => 'Display Functional',
                        'touch_ok' => 'Touch Screen Working',
                        'camera_ok' => 'Cameras Working',
                        'audio_ok' => 'Speakers & Audio Working',
                        'buttons_ok' => 'Physical Buttons OK',
                    ];
                @endphp
                <div class="row mb-3">
                    @foreach($labels as $key => $label)
                        @php
                            $checked = isset($checklist[$key]) && $checklist[$key] == 'yes';
                            if ($key !== 'scratches') {
                                // Default is working if not explicitly set
                                if (!isset($checklist[$key])) {
                                    $checked = true;
                                }
                            }
                        @endphp
                        <div class="col-sm-6 col-md-4 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                @if($key === 'scratches')
                                    {{-- Scratches is bad if true, good if false --}}
                                    @if($checked)
                                        <span class="badge bg-label-danger rounded-circle p-1"><i class="ti tabler-x fs-6"></i></span>
                                        <span class="text-danger fw-semibold small">{{ $label }}</span>
                                    @else
                                        <span class="badge bg-label-success rounded-circle p-1"><i class="ti tabler-check fs-6"></i></span>
                                        <span class="text-success fw-semibold small">{{ $label }} (No)</span>
                                    @endif
                                @else
                                    {{-- Functional checks --}}
                                    @if($checked)
                                        <span class="badge bg-label-success rounded-circle p-1"><i class="ti tabler-check fs-6"></i></span>
                                        <span class="text-success fw-semibold small">{{ $label }}</span>
                                    @else
                                        <span class="badge bg-label-danger rounded-circle p-1"><i class="ti tabler-x fs-6"></i></span>
                                        <span class="text-danger fw-semibold small">{{ $label }} (Faulty)</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($repair->device_photos && count($repair->device_photos) > 0)
                    <hr class="my-3 text-muted opacity-25">
                    <label class="fw-bold mb-3 text-dark d-block">Device Photos (At Check-in)</label>
                    <div class="row g-2">
                        @foreach($repair->device_photos as $photo)
                            <div class="col-sm-4 col-md-3">
                                <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="d-block border rounded overflow-hidden shadow-xs hover-zoom" style="height: 120px;">
                                    <img src="{{ asset('storage/' . $photo) }}" class="w-100 h-100 object-fit-cover">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-center small text-muted">
                        <i class="ti tabler-photo-off me-1"></i>No condition photos uploaded at check-in.
                    </div>
                @endif
            </div>
        </div>

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
                    <h6 class="fw-bold text-dark mb-3"><i class="ti tabler-box me-1 text-primary"></i>Installed Spare Parts</h6>
                    @if($repair->used_parts && count($repair->used_parts) > 0)
                        <div class="table-responsive border rounded">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Part Name</th>
                                        <th>Quantity</th>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                            <th class="text-end">Buying Price</th>
                                            <th class="text-end">Total Price</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPartsCost = 0;
                                    @endphp
                                    @foreach($repair->used_parts as $part)
                                        @php
                                            $partCost = floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
                                            $totalPartsCost += $partCost;
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $part['name'] }}</td>
                                            <td>{{ $part['quantity'] }}</td>
                                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                                <td class="text-end">{{ number_format($part['buying_price'], 2) }} BDT</td>
                                                <td class="text-end fw-bold text-dark">{{ number_format($partCost, 2) }} BDT</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                                        <tr class="table-light fw-bold text-dark">
                                            <td colspan="3" class="text-end">Total Parts Cost:</td>
                                            <td class="text-end">{{ number_format($totalPartsCost, 2) }} BDT</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded text-center small text-muted">
                            <i class="ti tabler-info-circle me-1"></i>No new parts were installed for this repair.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Technician logs -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-user-cog me-2"></i>Operation Assignments & Logs</h5>
                <div class="row mb-3">
                    <div class="col-sm-6 mb-2 mb-sm-0">
                        <label class="small text-muted d-block mb-1">Assigned Technician</label>
                        <span class="badge bg-label-primary px-3 py-2 fs-6">
                            <i class="ti tabler-user me-1"></i>{{ $repair->technician ? $repair->technician->name : 'Unassigned' }}
                        </span>
                    </div>
                    @if($repair->commission_type && auth()->user()->isSuperAdmin())
                    <div class="col-sm-6">
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

    <!-- Timeline Status -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-5"><i class="ti tabler-git-commit me-2"></i>Job Lifecycle Status</h5>
                
                @php
                    $status = $repair->status;
                    $steps = [
                        'pending' => ['Title' => 'Pending Confirmation', 'Desc' => 'Ticket logged. Awaiting confirmation.', 'Icon' => 'tabler-ticket'],
                        'diagnosing' => ['Title' => 'Diagnosing', 'Desc' => 'Device open, checking fault details.', 'Icon' => 'tabler-zoom-check'],
                        'waiting_for_approval' => ['Title' => 'Waiting Approval', 'Desc' => 'Estimated costs shared, awaiting approval.', 'Icon' => 'tabler-clock'],
                        'repairing' => ['Title' => 'Repairing', 'Desc' => 'Replacing components or software flashing.', 'Icon' => 'tabler-tool'],
                        'quality_check' => ['Title' => 'Quality Check', 'Desc' => 'Testing screen, cameras, and batteries.', 'Icon' => 'tabler-shield-check'],
                        'completed' => ['Title' => 'Completed (Ready)', 'Desc' => 'Job finished. Ready for collection.', 'Icon' => 'tabler-checkbox'],
                        'delivered' => ['Title' => 'Delivered', 'Desc' => 'Payment settled. Device collected.', 'Icon' => 'tabler-archive']
                    ];

                    $statusOrder = ['pending', 'diagnosing', 'waiting_for_approval', 'repairing', 'quality_check', 'completed', 'delivered'];
                    $currentIndex = array_search($status, $statusOrder);
                    
                    if ($status == 'cancelled') {
                        $steps['cancelled'] = ['Title' => 'Cancelled', 'Desc' => 'Repair ticket cancelled.', 'Icon' => 'tabler-square-x'];
                        $statusOrder = ['pending', 'cancelled'];
                        $currentIndex = 1;
                    }
                @endphp

                <div class="position-relative ps-4" style="border-left: 2px dashed #cbd5e1; margin-left: 15px;">
                    @foreach($statusOrder as $index => $stepKey)
                        @php
                            $step = $steps[$stepKey];
                            $isPassed = $currentIndex >= $index && $status != 'cancelled';
                            $isActive = $currentIndex === $index;
                            $dotColor = $isActive ? '#7367f0' : ($isPassed ? '#28c76f' : '#82868b');
                        @endphp
                        <div class="mb-5 position-relative">
                            <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="left: -32px; top: 0px; width: 30px; height: 30px; {{ $isActive ? 'box-shadow: 0 0 0 5px rgba(115, 103, 240, 0.25);' : '' }} background-color: {{ $dotColor }};">
                                <i class="ti {{ $step['Icon'] }} fs-6"></i>
                            </div>
                            <div class="ps-2">
                                <h6 class="fw-bold mb-1 {{ $isActive ? 'text-primary' : ($isPassed ? 'text-success' : 'text-muted') }}">
                                    {{ $step['Title'] }}
                                </h6>
                                <p class="text-muted mb-0 small">{{ $step['Desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const patternPathInput = document.getElementById('pattern_lock_path');
        const patternHolder = document.getElementById('pattern-holder');
        const patternSvg = document.getElementById('pattern-svg');

        function getDotCenter(dot, container) {
            const rect = dot.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            return {
                x: (rect.left + rect.width / 2) - containerRect.left,
                y: (rect.top + rect.height / 2) - containerRect.top
            };
        }

        function drawLines(activePattern) {
            if (!patternSvg || !patternHolder) return;
            patternSvg.innerHTML = '';
            if (activePattern.length === 0) return;

            let pathData = '';
            activePattern.forEach((dotIndex, idx) => {
                const dot = document.querySelector(`.pattern-dot[data-index="${dotIndex}"]`);
                if (dot) {
                    const center = getDotCenter(dot, patternHolder);
                    if (idx === 0) {
                        pathData += `M ${center.x} ${center.y}`;
                    } else {
                        pathData += ` L ${center.x} ${center.y}`;
                    }
                }
            });

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('d', pathData);
            path.setAttribute('stroke', '#7367f0');
            path.setAttribute('stroke-width', '4');
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            patternSvg.appendChild(path);
        }

        if (patternPathInput && patternPathInput.value && patternHolder) {
            const activePattern = patternPathInput.value.split('-').map(Number);
            activePattern.forEach(dotIndex => {
                const dot = document.querySelector(`.pattern-dot[data-index="${dotIndex}"]`);
                if (dot) {
                    dot.style.background = '#7367f0';
                    dot.style.transform = 'scale(1.2)';
                }
            });
            setTimeout(function() {
                drawLines(activePattern);
            }, 300);
        }
    });
</script>
@endsection
