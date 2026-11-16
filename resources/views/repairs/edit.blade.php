@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Job Card - M3 Mobile Care')

@section('content')


<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">Update Job Card: <span class="text-primary">{{ $repair->ticket_id }}</span></h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.repairs.index') }}">Repairs</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.repairs.show', $repair->id) }}">{{ $repair->ticket_id }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">


                <form action="{{ route('admin.repairs.update', $repair->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if(auth()->user()->isTechnician())
                        <!-- TECHNICIAN UPDATE WORKFLOW (Assigned job update only) -->
                        <div class="p-3 bg-light rounded-3 mb-4">
                            <h6 class="fw-bold text-dark mb-1">Assigned Job Details (Readonly)</h6>
                            <table class="table table-sm table-borderless mb-0 small">
                                <tr>
                                    <td class="text-muted fw-semibold" style="width: 150px;">Customer Name</td>
                                    <td>{{ $repair->customer ? $repair->customer->name : 'Walk-in' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Device Model</td>
                                    <td class="fw-bold text-primary">{{ $repair->device_brand }} {{ $repair->device_model }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Issue Description</td>
                                    <td>{{ $repair->issue_description }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Estimated Cost</td>
                                    <td>{{ number_format($repair->estimated_cost, 0) }} BDT</td>
                                </tr>
                            </table>
                        </div>

                        <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-tool me-2"></i>Update Status & Logs</h5>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" for="status">Job Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending" {{ old('status', $repair->status) == 'pending' ? 'selected' : '' }}>Pending confirmation</option>
                                    <option value="diagnosing" {{ old('status', $repair->status) == 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                                    <option value="waiting_for_approval" {{ old('status', $repair->status) == 'waiting_for_approval' ? 'selected' : '' }}>Waiting Approval</option>
                                    <option value="waiting_for_parts" {{ old('status', $repair->status) == 'waiting_for_parts' ? 'selected' : '' }}> Waiting for Parts (পার্টস আসার অপেক্ষায়)</option>
                                    <option value="repairing" {{ old('status', $repair->status) == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                    <option value="quality_check" {{ old('status', $repair->status) == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                                    <option value="completed" {{ old('status', $repair->status) == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                                    <option value="delivered" {{ old('status', $repair->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ old('status', $repair->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                    <i class="ti tabler-clock-edit me-1 text-info"></i>Status updated: {{ ($repair->status_updated_at ?? $repair->created_at)->format('d M, Y h:i A') }}
                                </div>
                            </div>
                        </div>



                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="technician_notes">
                                    Technician Diagnostic Logs & Notes <span class="text-danger">*</span>
                                    <small class="text-muted d-block fw-normal">(এই ডেসক্রিপশনটি গ্রাহক ERT লাইভ ট্র্যাকিং টাইমলাইনে দেখতে পাবেন)</small>
                                </label>
                                <textarea name="technician_notes" id="technician_notes" rows="4" class="form-control" placeholder="যেমন: নতুন অরিজিনাল ডিসপ্লে লাগানো হচ্ছে / মাদারবোর্ড আইসি ডায়াগনসিস সম্পন্ন..." required>{{ old('technician_notes', $repair->technician_notes) }}</textarea>
                            </div>
                        </div>
                    @else
                        <!-- SUPER ADMIN FULL UPDATE WORKFLOW (Compact 2-Column Dashboard Layout) -->
                        <div class="row g-4">
                            <!-- LEFT COLUMN: Customer, Device Info & Diagnostics -->
                            <div class="col-lg-7">
                                <!-- 1. Customer & Device Information Card -->
                                <div class="card border mb-4 shadow-none">
                                    <div class="card-header bg-light py-3 border-bottom d-flex align-items-center">
                                        <h6 class="fw-bold text-primary mb-0"><i class="ti tabler-device-mobile me-2"></i>1. Customer & Device Information</h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label fw-semibold mb-0" for="customer_id">Select Existing Customer <span class="text-muted small fw-normal">(Optional)</span></label>
                                                @if(!$repair->customer)
                                                    <span class="badge bg-label-secondary" style="font-size: 0.72rem;"><i class="ti tabler-user me-1"></i>Currently Walk-in</span>
                                                @endif
                                            </div>
                                            <select name="customer_id" id="customer_id" class="form-select form-select-sm">
                                                <option value="" {{ empty(old('customer_id', $repair->customer_id)) ? 'selected' : '' }}>-- Walk-in / Unregistered Customer --</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" data-phone="{{ $customer->phone }}" data-address="{{ $customer->address }}" {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone ?? 'No Phone' }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold" for="customer_name">Customer Name</label>
                                                <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" value="{{ old('customer_name', $repair->customer ? $repair->customer->name : 'Walk-in Customer') }}" placeholder="e.g. John Doe / Walk-in Customer">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold" for="customer_phone">Customer Phone Number</label>
                                                <input type="text" name="customer_phone" id="customer_phone" class="form-control form-control-sm" value="{{ old('customer_phone', $repair->customer ? $repair->customer->phone : '') }}" placeholder="e.g. 01712345678 (ঐচ্ছিক)">
                                            </div>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold" for="device_brand">Brand <span class="text-danger">*</span></label>
                                                <input type="text" name="device_brand" id="device_brand" class="form-control form-control-sm" value="{{ old('device_brand', $repair->device_brand) }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold" for="device_model">Model <span class="text-danger">*</span></label>
                                                <input type="text" name="device_model" id="device_model" class="form-control form-control-sm" value="{{ old('device_model', $repair->device_model) }}" required>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="form-label fw-semibold" for="issue_description">Issue Description <span class="text-danger">*</span></label>
                                            <textarea name="issue_description" id="issue_description" rows="2" class="form-control form-control-sm" required>{{ old('issue_description', $repair->issue_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Device Photos Card -->
                                <div class="card border mb-4 shadow-none">
                                    <div class="card-header bg-light py-3 border-bottom d-flex align-items-center">
                                        <h6 class="fw-bold text-primary mb-0"><i class="ti tabler-camera me-2"></i>2. Device Photos</h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div>
                                            <label class="form-label fw-semibold small" for="device_photos">Upload Device Photos</label>
                                            <input type="file" name="device_photos[]" id="device_photos" class="form-control form-control-sm mb-2" accept="image/*" multiple>
                                            @if($repair->device_photos && count($repair->device_photos) > 0)
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($repair->device_photos as $photo)
                                                        <div class="position-relative rounded overflow-hidden border" style="width: 50px; height: 50px;">
                                                            <img src="{{ asset('storage/' . $photo) }}" class="w-100 h-100 object-fit-cover">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Technical Diagnostics & Notes Card -->
                                <div class="card border mb-4 shadow-none">
                                    <div class="card-header bg-light py-3 border-bottom d-flex align-items-center">
                                        <h6 class="fw-bold text-primary mb-0"><i class="ti tabler-notes me-2"></i>3. Technical Diagnostics & Notes</h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div>
                                            <label class="form-label fw-semibold" for="technician_notes">
                                                Technician Diagnostic Notes & Lab Update
                                            </label>
                                            <textarea name="technician_notes" id="technician_notes" rows="3" class="form-control form-control-sm" placeholder="যেমন: নতুন অরিজিনাল ডিসপ্লে লাগানো হচ্ছে / মাদারবোর্ড আইসি ডায়াগনসিস সম্পন্ন...">{{ old('technician_notes', $repair->technician_notes) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN: Technical Operations, Costs & Settlement (sob sese / ডানের প্যানেল) -->
                            <div class="col-lg-5">
                                <div class="card border border-primary border-opacity-25 shadow-sm sticky-top" style="top: 20px;">
                                    <div class="card-header bg-primary bg-opacity-10 py-3 border-bottom d-flex align-items-center">
                                        <h6 class="fw-bold text-primary mb-0"><i class="ti tabler-tool me-2"></i>4. Technical Operations & Costs (sob sese)</h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <!-- Status & Assignment -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-dark mb-1" for="status">Job Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-select fw-bold border-primary text-primary" required>
                                                <option value="pending" {{ old('status', $repair->status) == 'pending' ? 'selected' : '' }}>Pending confirmation</option>
                                                <option value="diagnosing" {{ old('status', $repair->status) == 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                                                <option value="waiting_for_approval" {{ old('status', $repair->status) == 'waiting_for_approval' ? 'selected' : '' }}>Waiting Approval</option>
                                                <option value="waiting_for_parts" {{ old('status', $repair->status) == 'waiting_for_parts' ? 'selected' : '' }}>Waiting for Parts (পার্টস আসার অপেক্ষায়)</option>
                                                <option value="repairing" {{ old('status', $repair->status) == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                                <option value="quality_check" {{ old('status', $repair->status) == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                                                <option value="completed" {{ old('status', $repair->status) == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                                                <option value="delivered" {{ old('status', $repair->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ old('status', $repair->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                                <i class="ti tabler-clock-edit me-1 text-info"></i>Status updated: {{ ($repair->status_updated_at ?? $repair->created_at)->format('d M, Y h:i A') }}
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-4">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="assigned_technician_id">Assign Tech</label>
                                                <select name="assigned_technician_id" id="assigned_technician_id" class="form-select form-select-sm">
                                                    <option value="">Unassigned</option>
                                                    @foreach($technicians as $tech)
                                                    <option value="{{ $tech->id }}" {{ old('assigned_technician_id', $repair->assigned_technician_id) == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($repair->assigned_technician_id)
                                                <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                                                    <i class="ti tabler-calendar-check me-1 text-success"></i>Assigned: {{ ($repair->assigned_at ?? $repair->created_at)->format('d M, Y') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="expected_delivery_date">Delivery Date</label>
                                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control form-control-sm" value="{{ old('expected_delivery_date', $repair->expected_delivery_date) }}">
                                            </div>
                                        </div>

                                        <!-- Estimates & Advance -->
                                        <div class="row g-3 mb-4">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="repair_charge">Service Charge (BDT)</label>
                                                <input type="number" name="repair_charge" id="repair_charge" step="0.01" min="0" class="form-control form-control-sm" value="{{ old('repair_charge', $repair->repair_charge) }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small text-muted mb-1" for="estimated_cost">Estimated Cost</label>
                                                <input type="number" name="estimated_cost" id="estimated_cost" step="0.01" min="0" class="form-control form-control-sm bg-light fw-bold" value="{{ old('estimated_cost', $repair->estimated_cost) }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="advance_payment">Advance Paid</label>
                                                <input type="number" name="advance_payment" id="advance_payment" step="0.01" min="0" class="form-control form-control-sm text-success fw-bold" value="{{ old('advance_payment', $repair->advance_payment) }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="advance_payment_method">Advance Method</label>
                                                <select name="advance_payment_method" id="advance_payment_method" class="form-select form-select-sm">
                                                    <option value="">-- Method --</option>
                                                    <option value="Cash" {{ old('advance_payment_method', $repair->advance_payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="bKash" {{ old('advance_payment_method', $repair->advance_payment_method) == 'bKash' ? 'selected' : '' }}>bKash</option>
                                                    <option value="Nagad" {{ old('advance_payment_method', $repair->advance_payment_method) == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                                    <option value="Rocket" {{ old('advance_payment_method', $repair->advance_payment_method) == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" name="data_loss_consent" value="1">
                                        <div class="row g-3 mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small mb-1" for="warranty_days">Warranty (Days)</label>
                                                <input type="number" name="warranty_days" id="warranty_days" min="0" class="form-control form-control-sm" value="{{ old('warranty_days', $repair->warranty_days ?? 0) }}" placeholder="e.g. 90">
                                            </div>
                                        </div>

                                        <!-- Final Settlement (At Delivery) Spacious Card -->
                                        <div class="p-4 rounded-3 bg-light border border-info border-opacity-25 mb-4">
                                            <h6 class="fw-bold mb-3 text-primary"><i class="ti tabler-cash me-2"></i>Final Checkout</h6>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small mb-1" for="actual_cost">Actual / Final Cost (Total Bill)</label>
                                                <input type="number" name="actual_cost" id="actual_cost" step="0.01" min="0" class="form-control fw-bold text-dark" value="{{ old('actual_cost', $repair->actual_cost) }}" placeholder="Fill total bill at delivery">
                                                <div class="form-text small text-info mt-2">
                                                    Counter Due: <strong id="val-final-due">0.00</strong> BDT
                                                </div>
                                            </div>

                                            <label class="form-label fw-semibold text-dark small mb-2 d-block border-top pt-2">Delivery Payment Methods</label>
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-white fw-semibold small text-success px-2"><i class="ti tabler-cash me-1"></i>Cash</span>
                                                        @php
                                                            $oldCashDelivery = old('cash_delivery');
                                                            if (is_null($oldCashDelivery) && $repair->status === 'delivered') {
                                                                $oldCashDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'Cash')->sum('amount');
                                                            }
                                                        @endphp
                                                        <input type="number" name="cash_delivery" id="cash_delivery" step="0.01" min="0" class="form-control text-end fw-bold" value="{{ $oldCashDelivery ?? 0 }}" placeholder="0">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-white fw-semibold small px-2" style="color:#d81b60!important;"><i class="ti tabler-wallet me-1"></i>bKash</span>
                                                        @php
                                                            $oldBkashDelivery = old('bkash_delivery');
                                                            if (is_null($oldBkashDelivery) && $repair->status === 'delivered') {
                                                                $oldBkashDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'bKash')->sum('amount');
                                                            }
                                                        @endphp
                                                        <input type="number" name="bkash_delivery" id="bkash_delivery" step="0.01" min="0" class="form-control text-end fw-bold" value="{{ $oldBkashDelivery ?? 0 }}" placeholder="0">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-white fw-semibold small text-warning px-2"><i class="ti tabler-wallet me-1"></i>Nagad</span>
                                                        @php
                                                            $oldNagadDelivery = old('nagad_delivery');
                                                            if (is_null($oldNagadDelivery) && $repair->status === 'delivered') {
                                                                $oldNagadDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'Nagad')->sum('amount');
                                                            }
                                                        @endphp
                                                        <input type="number" name="nagad_delivery" id="nagad_delivery" step="0.01" min="0" class="form-control text-end fw-bold" value="{{ $oldNagadDelivery ?? 0 }}" placeholder="0">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-white fw-semibold small px-2" style="color:#8e44ad!important;"><i class="ti tabler-wallet me-1"></i>Rocket</span>
                                                        @php
                                                            $oldRocketDelivery = old('rocket_delivery');
                                                            if (is_null($oldRocketDelivery) && $repair->status === 'delivered') {
                                                                $oldRocketDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'Rocket')->sum('amount');
                                                            }
                                                        @endphp
                                                        <input type="number" name="rocket_delivery" id="rocket_delivery" step="0.01" min="0" class="form-control text-end fw-bold" value="{{ $oldRocketDelivery ?? 0 }}" placeholder="0">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-3 rounded bg-danger bg-opacity-10 border border-danger border-opacity-20 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label fw-bold text-danger mb-0 small" for="remaining_due">Remaining Due (BDT)</label>
                                                    <input type="number" id="remaining_due" step="0.01" class="form-control form-control-sm border-0 bg-transparent text-end text-danger fw-bold fs-6 p-0" style="width:120px;" value="{{ old('due_amount', $repair->due_amount) }}" readonly>
                                                </div>
                                            </div>

                                            <div class="mt-3" id="cash_received_container" style="display: none;">
                                                <label class="form-label fw-semibold text-dark small mb-1" for="cash_received">Cash Received (BDT)</label>
                                                <input type="number" name="cash_received" id="cash_received" step="0.01" min="0" class="form-control text-dark fw-bold" value="{{ old('cash_received', $repair->cash_received) }}">
                                            </div>
                                            <div class="mt-2" id="change_returned_container" style="display: none;">
                                                <label class="form-label fw-semibold text-success small mb-1" for="change_returned">Change Returned (BDT)</label>
                                                <input type="number" name="change_returned" id="change_returned" step="0.01" min="0" class="form-control bg-white text-success fw-bold" value="{{ old('change_returned', $repair->change_returned) }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3"><i class="ti tabler-device-floppy me-2"></i>Save Changes</button>
                                            <a href="{{ route('admin.repairs.show', $repair->id) }}" class="btn btn-outline-secondary text-center">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-sync Service Charge to Estimated Cost if user adjusts repair charge
    const repairChargeEl = document.getElementById('repair_charge');
    const estimatedCostEl = document.getElementById('estimated_cost');

    if (repairChargeEl && estimatedCostEl) {
        repairChargeEl.addEventListener('input', function() {
            estimatedCostEl.value = (parseFloat(repairChargeEl.value) || 0).toFixed(2);
        });
    }

    // Cash Reconciliation & Payment Method Toggle Logic
    const cashDeliveryInput = document.getElementById('cash_delivery');
    const bkashDeliveryInput = document.getElementById('bkash_delivery');
    const nagadDeliveryInput = document.getElementById('nagad_delivery');
    const rocketDeliveryInput = document.getElementById('rocket_delivery');

    const cashReceivedContainer = document.getElementById('cash_received_container');
    const changeReturnedContainer = document.getElementById('change_returned_container');
    const cashReceivedInput = document.getElementById('cash_received');
    const changeReturnedInput = document.getElementById('change_returned');
    const advancePaymentInput = document.getElementById('advance_payment');
    const remainingDueInput = document.getElementById('remaining_due');
    const actualCostHelperVal = document.getElementById('val-final-due');

    function updateFinancials() {
        const actualCost = parseFloat(actualCostEl ? actualCostEl.value : 0) || 0;
        const advancePaid = parseFloat(advancePaymentInput ? advancePaymentInput.value : 0) || 0;
        const remainingBalance = Math.max(0, actualCost - advancePaid);

        // Update Counter Due helper text label if it exists
        if (actualCostHelperVal) {
            actualCostHelperVal.textContent = remainingBalance.toFixed(2);
        }

        const cashDelivery = parseFloat(cashDeliveryInput ? cashDeliveryInput.value : 0) || 0;
        const bkashDelivery = parseFloat(bkashDeliveryInput ? bkashDeliveryInput.value : 0) || 0;
        const nagadDelivery = parseFloat(nagadDeliveryInput ? nagadDeliveryInput.value : 0) || 0;
        const rocketDelivery = parseFloat(rocketDeliveryInput ? rocketDeliveryInput.value : 0) || 0;

        let deliveryPayment = cashDelivery + bkashDelivery + nagadDelivery + rocketDelivery;

        if (deliveryPayment > remainingBalance) {
            // Capping is handled server-side, but let's calculate remaining due safely
        }

        const remainingDue = Math.max(0, remainingBalance - deliveryPayment);
        if (remainingDueInput) remainingDueInput.value = remainingDue.toFixed(2);

        // Toggle Cash Given fields based on Cash Payment
        if (cashDelivery > 0) {
            if (cashReceivedContainer) cashReceivedContainer.style.display = 'block';
            if (changeReturnedContainer) changeReturnedContainer.style.display = 'block';

            const cashReceived = parseFloat(cashReceivedInput.value) || 0;
            const changeReturned = Math.max(0, cashReceived - cashDelivery);
            if (changeReturnedInput) changeReturnedInput.value = changeReturned.toFixed(2);
        } else {
            if (cashReceivedContainer) cashReceivedContainer.style.display = 'none';
            if (changeReturnedContainer) changeReturnedContainer.style.display = 'none';
            if (cashReceivedInput) cashReceivedInput.value = '';
            if (changeReturnedInput) changeReturnedInput.value = '';
        }
    }

    [cashDeliveryInput, bkashDeliveryInput, nagadDeliveryInput, rocketDeliveryInput].forEach(input => {
        if (input) input.addEventListener('input', updateFinancials);
    });

    if (cashReceivedInput) cashReceivedInput.addEventListener('input', updateFinancials);

    if (actualCostEl) {
        actualCostEl.addEventListener('input', function() {
            const actualCost = parseFloat(actualCostEl.value) || 0;
            const advancePaid = parseFloat(advancePaymentInput ? advancePaymentInput.value : 0) || 0;
            if (cashDeliveryInput) cashDeliveryInput.value = Math.max(0, actualCost - advancePaid).toFixed(2);
            if (bkashDeliveryInput) bkashDeliveryInput.value = 0;
            if (nagadDeliveryInput) nagadDeliveryInput.value = 0;
            if (rocketDeliveryInput) rocketDeliveryInput.value = 0;
            updateFinancials();
        });
    }

    if (advancePaymentInput) {
        advancePaymentInput.addEventListener('input', function() {
            const actualCost = parseFloat(actualCostEl ? actualCostEl.value : 0) || 0;
            const advancePaid = parseFloat(advancePaymentInput.value) || 0;
            if (cashDeliveryInput) cashDeliveryInput.value = Math.max(0, actualCost - advancePaid).toFixed(2);
            if (bkashDeliveryInput) bkashDeliveryInput.value = 0;
            if (nagadDeliveryInput) nagadDeliveryInput.value = 0;
            if (rocketDeliveryInput) rocketDeliveryInput.value = 0;
            updateFinancials();
        });
    }

    // Run calculations once on load
    updateFinancials();

    // Customer Select dropdown change listener in edit form
    const customerSelectEl = document.getElementById('customer_id');
    const customerNameInput = document.getElementById('customer_name');
    const customerPhoneInput = document.getElementById('customer_phone');

    if (customerSelectEl) {
        customerSelectEl.addEventListener('change', function() {
            const selectedOpt = customerSelectEl.options[customerSelectEl.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                if (customerNameInput) customerNameInput.value = selectedOpt.getAttribute('data-name') || '';
                if (customerPhoneInput) customerPhoneInput.value = selectedOpt.getAttribute('data-phone') || '';
            } else {
                if (customerNameInput) customerNameInput.value = 'Walk-in Customer';
                if (customerPhoneInput) customerPhoneInput.value = '';
            }
        });
    }
});
</script>
@endsection
