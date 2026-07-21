@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Job Card - M3 Mobile Care')

@section('content')
<!-- Tom Select CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
/* Styles to adjust Tom Select control padding and height in repair list rows */
.ts-wrapper.form-select-sm .ts-control {
    padding: 4px 8px !important;
    font-size: 0.85rem !important;
}
</style>

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
                                    <td class="text-muted fw-semibold">Unlock Credentials</td>
                                    <td class="text-warning fw-bold">{{ $repair->password_pattern ?? 'None' }}</td>
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
                                    <option value="repairing" {{ old('status', $repair->status) == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                    <option value="quality_check" {{ old('status', $repair->status) == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                                    <option value="completed" {{ old('status', $repair->status) == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                                    <option value="delivered" {{ old('status', $repair->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ old('status', $repair->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <!-- USED PARTS SECTION (Technician Workflow) -->
                        <div class="mb-4 p-3 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-dark"><i class="ti tabler-box me-1 text-primary"></i>Installed Spare Parts & Pricing</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="btn-add-part"><i class="ti tabler-plus me-1"></i>Add Installed Part</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light small fw-bold">
                                        <tr>
                                            <th>Select Inventory Item / Enter Name</th>
                                            <th style="width: 150px;">Buying Price (BDT)</th>
                                            <th style="width: 100px;">Quantity</th>
                                            <th style="width: 70px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="parts-container">
                                        @php
                                            $usedParts = $repair->used_parts ?? [];
                                        @endphp
                                        @foreach($usedParts as $index => $part)
                                            <tr class="part-row">
                                                <td>
                                                    <select class="form-select form-select-sm select-part-item mb-1" name="used_parts[{{ $index }}][inventory_id]">
                                                        <option value="">-- Custom Part (Type Below) --</option>
                                                        @foreach($inventoryItems as $item)
                                                            <option value="{{ $item->id }}" 
                                                                data-name="{{ $item->name }}" 
                                                                data-price="{{ $item->purchase_price }}"
                                                                {{ isset($part['inventory_id']) && $part['inventory_id'] == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }} (Qty: {{ $item->quantity }}, Cost: {{ $item->purchase_price }} BDT)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="used_parts[{{ $index }}][name]" class="form-control form-control-sm input-part-name" value="{{ $part['name'] }}" placeholder="Enter part name manually" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="used_parts[{{ $index }}][buying_price]" class="form-control form-control-sm input-buying-price text-end" value="{{ $part['buying_price'] }}" step="0.01" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="used_parts[{{ $index }}][quantity]" class="form-control form-control-sm input-quantity text-center" value="{{ $part['quantity'] }}" min="1" required>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-remove-part"><i class="ti tabler-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="technician_notes">Technician Diagnostic Logs & Notes <span class="text-danger">*</span></label>
                                <textarea name="technician_notes" id="technician_notes" rows="4" class="form-control" placeholder="Describe operations done, parts replaced, current condition..." required>{{ old('technician_notes', $repair->technician_notes) }}</textarea>
                            </div>
                        </div>
                    @else
                        <!-- SUPER ADMIN FULL UPDATE WORKFLOW -->
                        <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-user me-2"></i>1. Customer Assignment</h5>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" for="customer_id">Select Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" id="customer_id" class="form-select" required>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-device-mobile me-2"></i>2. Device Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="device_brand">Brand <span class="text-danger">*</span></label>
                                <input type="text" name="device_brand" id="device_brand" class="form-control" value="{{ old('device_brand', $repair->device_brand) }}" required>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="device_model">Model <span class="text-danger">*</span></label>
                                <input type="text" name="device_model" id="device_model" class="form-control" value="{{ old('device_model', $repair->device_model) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" for="serial_imei">IMEI / Serial Number</label>
                                <input type="text" name="serial_imei" id="serial_imei" class="form-control" value="{{ old('serial_imei', $repair->serial_imei) }}">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="password_pattern">Screen Lock Credentials / Unlocking Pattern</label>
                                <input type="text" name="password_pattern" id="password_pattern" class="form-control" value="{{ old('password_pattern', $repair->password_pattern) }}">
                                <div class="form-text small">e.g. Pin: 1234. Needed to verify repairs.</div>
                                
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <button type="button" id="btn-toggle-pattern" class="btn btn-sm btn-outline-primary"><i class="ti tabler-grid me-1"></i>Draw Pattern Lock</button>
                                </div>
                                
                                <div id="pattern-lock-wrapper" class="mt-2 card p-2 border" style="display: none; width: fit-content; background: #f8f9fa;">
                                    <div id="pattern-holder" style="width: 180px; height: 180px; position: relative; background: #eef1f6; border-radius: 8px; touch-action: none; overflow: hidden;">
                                        <svg id="pattern-svg" style="width:100%; height:100%; position:absolute; top:0; left:0; pointer-events:none;"></svg>
                                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(3, 1fr); height: 100%; width: 100%; padding: 10px; box-sizing: border-box;">
                                            @for($i = 1; $i <= 9; $i++)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="pattern-dot" data-index="{{ $i }}" style="width: 14px; height: 14px; border-radius: 50%; background: #a1b0cb; cursor: pointer; z-index: 10; transition: all 0.2s ease;"></div>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2" style="width: 180px;">
                                        <span class="small text-muted" id="pattern-path-label">Path: {{ $repair->pattern_lock_path ?? 'None' }}</span>
                                        <button type="button" id="btn-clear-pattern" class="btn btn-xs btn-outline-danger py-0 px-1" style="font-size:0.75rem;">Clear</button>
                                    </div>
                                    <input type="hidden" name="pattern_lock_path" id="pattern_lock_path" value="{{ old('pattern_lock_path', $repair->pattern_lock_path) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="issue_description">Issue Description <span class="text-danger">*</span></label>
                                <textarea name="issue_description" id="issue_description" rows="3" class="form-control" required>{{ old('issue_description', $repair->issue_description) }}</textarea>
                            </div>
                        </div>

                        <!-- SECTION 2.5: Physical Checklist & Photos -->
                        <hr class="my-4 text-muted opacity-25">
                        <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-clipboard-check me-2"></i>2.5 Device Condition Checklist & Photos</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold d-block mb-3 text-dark">Pre-Repair Physical Diagnostics</label>
                                
                                @php
                                    $checklist = $repair->device_checklist ?? [];
                                @endphp
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="device_checklist[scratches]" id="chk_scratches" value="yes" {{ isset($checklist['scratches']) && $checklist['scratches'] == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="chk_scratches">Body Scratches / Dents</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="device_checklist[display_ok]" id="chk_display" value="yes" {{ !isset($checklist['display_ok']) || $checklist['display_ok'] == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="chk_display">Display Functional</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="device_checklist[touch_ok]" id="chk_touch" value="yes" {{ !isset($checklist['touch_ok']) || $checklist['touch_ok'] == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="chk_touch">Touch Screen Working</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="device_checklist[camera_ok]" id="chk_camera" value="yes" {{ !isset($checklist['camera_ok']) || $checklist['camera_ok'] == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="chk_camera">Cameras Working</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="device_checklist[audio_ok]" id="chk_audio" value="yes" {{ !isset($checklist['audio_ok']) || $checklist['audio_ok'] == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="chk_audio">Speakers & Audio Working</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="device_checklist[buttons_ok]" id="chk_buttons" value="yes" {{ !isset($checklist['buttons_ok']) || $checklist['buttons_ok'] == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="chk_buttons">Physical Buttons OK</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="device_photos">Upload Device Photos <span class="text-muted">(Will append to currently uploaded photos)</span></label>
                                <input type="file" name="device_photos[]" id="device_photos" class="form-control mb-3" accept="image/*" multiple>
                                
                                @if($repair->device_photos && count($repair->device_photos) > 0)
                                    <label class="form-label d-block fw-semibold mb-2 text-muted">Currently Uploaded Photos:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($repair->device_photos as $photo)
                                            <div class="position-relative rounded overflow-hidden border" style="width: 80px; height: 80px;">
                                                <img src="{{ asset('storage/' . $photo) }}" class="w-100 h-100 object-fit-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-tool me-2"></i>3. Technical Operations & Costs</h5>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="status">Job Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending" {{ old('status', $repair->status) == 'pending' ? 'selected' : '' }}>Pending confirmation</option>
                                    <option value="diagnosing" {{ old('status', $repair->status) == 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                                    <option value="waiting_for_approval" {{ old('status', $repair->status) == 'waiting_for_approval' ? 'selected' : '' }}>Waiting Approval</option>
                                    <option value="repairing" {{ old('status', $repair->status) == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                    <option value="quality_check" {{ old('status', $repair->status) == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                                    <option value="completed" {{ old('status', $repair->status) == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                                    <option value="delivered" {{ old('status', $repair->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ old('status', $repair->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="assigned_technician_id">Assign Technician</label>
                                <select name="assigned_technician_id" id="assigned_technician_id" class="form-select">
                                    <option value="">Unassigned</option>
                                    @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}" {{ old('assigned_technician_id', $repair->assigned_technician_id) == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" for="expected_delivery_date">Expected Delivery Date</label>
                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date', $repair->expected_delivery_date) }}">
                            </div>
                        </div>

                        @if(auth()->user()->isSuperAdmin())
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="commission_type">Technician Commission Type</label>
                                <select name="commission_type" id="commission_type" class="form-select">
                                    <option value="" {{ empty($repair->commission_type) ? 'selected' : '' }}>No Commission / Salary-based</option>
                                    <option value="percentage" {{ old('commission_type', $repair->commission_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="flat" {{ old('commission_type', $repair->commission_type) == 'flat' ? 'selected' : '' }}>Flat Amount (BDT)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="commission_rate">Commission Value</label>
                                <input type="number" name="commission_rate" id="commission_rate" step="0.01" min="0" class="form-control" value="{{ old('commission_rate', $repair->commission_rate) }}">
                                <div class="form-text small">e.g. 15 for 15% of actual repair charge, or 250 for a flat 250 BDT commission.</div>
                            </div>
                        </div>
                        @endif

                        <!-- Initial Estimates & Advance Payment Row -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="repair_charge">Repair Charge / Service Fee (BDT)</label>
                                <input type="number" name="repair_charge" id="repair_charge" step="0.01" min="0" class="form-control" value="{{ old('repair_charge', $repair->repair_charge) }}">
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="estimated_cost">Estimated Cost (BDT)</label>
                                <input type="number" name="estimated_cost" id="estimated_cost" step="0.01" min="0" class="form-control bg-light" value="{{ old('estimated_cost', $repair->estimated_cost) }}" readonly>
                                <div class="form-text small">Auto-calculated (Charge + Parts)</div>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="advance_payment">Advance Paid (BDT)</label>
                                <input type="number" name="advance_payment" id="advance_payment" step="0.01" min="0" class="form-control" value="{{ old('advance_payment', $repair->advance_payment) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold" for="advance_payment_method">Advance Payment Method</label>
                                <select name="advance_payment_method" id="advance_payment_method" class="form-select">
                                    <option value="">-- Select Method --</option>
                                    <option value="Cash" {{ old('advance_payment_method', $repair->advance_payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bKash" {{ old('advance_payment_method', $repair->advance_payment_method) == 'bKash' ? 'selected' : '' }}>bKash</option>
                                    <option value="Nagad" {{ old('advance_payment_method', $repair->advance_payment_method) == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                    <option value="Rocket" {{ old('advance_payment_method', $repair->advance_payment_method) == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" for="warranty_days">Warranty Period (Days)</label>
                                <input type="number" name="warranty_days" id="warranty_days" min="0" class="form-control" value="{{ old('warranty_days', $repair->warranty_days ?? 0) }}" placeholder="e.g. 90">
                                <div class="form-text small">Number of days parts/labor warranty. Starts upon completion.</div>
                            </div>
                            <div class="col-md-8 d-flex align-items-center mt-md-3">
                                <div class="form-check form-switch card p-2 px-3 border w-100 bg-label-warning border-warning d-flex align-items-center flex-row gap-2">
                                    <input class="form-check-input ms-0" type="checkbox" name="data_loss_consent" id="data_loss_consent" value="1" {{ old('data_loss_consent', $repair->data_loss_consent) ? 'checked' : '' }} required>
                                    <div class="ms-2">
                                        <label class="form-check-label fw-bold text-warning" for="data_loss_consent">
                                            Data Loss Consent Verified <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-text text-warning small opacity-75 mt-0" style="font-size: 0.75rem;">Customer acknowledges they backed up data and M3 Mobile Care is not liable for data loss during repair.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Final Settlement (At Delivery) Row -->
                        <div class="row mb-4 p-3 bg-light rounded border mx-0">
                            <div class="col-12 mb-3">
                                <h6 class="fw-bold mb-0 text-primary"><i class="ti tabler-cash me-1"></i>Final Settlement & Checkout (স্প্লিট পেমেন্ট)</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold" for="actual_cost">Actual / Final Cost (Total Bill) (BDT)</label>
                                <input type="number" name="actual_cost" id="actual_cost" step="0.01" min="0" class="form-control fw-bold text-dark" value="{{ old('actual_cost', $repair->actual_cost) }}" placeholder="Fill total bill at delivery">
                                <div class="form-text small text-info mt-1" style="font-size: 0.75rem;">
                                    Counter Due: <strong id="val-final-due">0.00</strong> BDT (excluding {{ number_format($repair->advance_payment, 2) }} BDT advance)
                                </div>
                            </div>
                            
                            <!-- Split delivery payments -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted mb-2">Delivery Payment Methods (ডেলিভারি পেমেন্ট)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white small px-1.5" style="font-size: 0.75rem;"><i class="ti tabler-cash text-success"></i> Cash</span>
                                            @php
                                                $oldCashDelivery = old('cash_delivery');
                                                if (is_null($oldCashDelivery) && $repair->status === 'delivered') {
                                                    $oldCashDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'Cash')->sum('amount');
                                                }
                                            @endphp
                                            <input type="number" name="cash_delivery" id="cash_delivery" step="0.01" min="0" class="form-control text-end fw-bold text-dark" value="{{ $oldCashDelivery ?? 0 }}" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white small px-1.5" style="font-size: 0.75rem;"><i class="ti tabler-wallet text-pink" style="color: #d81b60 !important;"></i> bKash</span>
                                            @php
                                                $oldBkashDelivery = old('bkash_delivery');
                                                if (is_null($oldBkashDelivery) && $repair->status === 'delivered') {
                                                    $oldBkashDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'bKash')->sum('amount');
                                                }
                                            @endphp
                                            <input type="number" name="bkash_delivery" id="bkash_delivery" step="0.01" min="0" class="form-control text-end fw-bold text-dark" value="{{ $oldBkashDelivery ?? 0 }}" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white small px-1.5" style="font-size: 0.75rem;"><i class="ti tabler-wallet text-warning"></i> Nagad</span>
                                            @php
                                                $oldNagadDelivery = old('nagad_delivery');
                                                if (is_null($oldNagadDelivery) && $repair->status === 'delivered') {
                                                    $oldNagadDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'Nagad')->sum('amount');
                                                }
                                            @endphp
                                            <input type="number" name="nagad_delivery" id="nagad_delivery" step="0.01" min="0" class="form-control text-end fw-bold text-dark" value="{{ $oldNagadDelivery ?? 0 }}" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white small px-1.5" style="font-size: 0.75rem;"><i class="ti tabler-wallet text-purple" style="color: #8e44ad !important;"></i> Rocket</span>
                                            @php
                                                $oldRocketDelivery = old('rocket_delivery');
                                                if (is_null($oldRocketDelivery) && $repair->status === 'delivered') {
                                                    $oldRocketDelivery = $repair->payments->where('transaction_type', 'delivery')->where('payment_method', 'Rocket')->sum('amount');
                                                }
                                            @endphp
                                            <input type="number" name="rocket_delivery" id="rocket_delivery" step="0.01" min="0" class="form-control text-end fw-bold text-dark" value="{{ $oldRocketDelivery ?? 0 }}" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold text-danger" for="remaining_due">Remaining Due (BDT)</label>
                                <input type="number" id="remaining_due" step="0.01" class="form-control bg-light text-danger fw-bold" value="{{ old('due_amount', $repair->due_amount) }}" readonly>
                            </div>

                            <!-- Cash Given & Change Return -->
                            <div class="col-md-3 mb-3" id="cash_received_container" style="display: none;">
                                <label class="form-label fw-semibold text-dark" for="cash_received">Cash Received (BDT)</label>
                                <input type="number" name="cash_received" id="cash_received" step="0.01" min="0" class="form-control text-dark fw-bold" value="{{ old('cash_received', $repair->cash_received) }}">
                            </div>
                            <div class="col-md-3 mb-3" id="change_returned_container" style="display: none;">
                                <label class="form-label fw-semibold text-success" for="change_returned">Change Returned (BDT)</label>
                                <input type="number" name="change_returned" id="change_returned" step="0.01" min="0" class="form-control bg-light text-success fw-bold" value="{{ old('change_returned', $repair->change_returned) }}" readonly>
                            </div>
                        </div>

                        <!-- USED PARTS SECTION (Admin Workflow) -->
                        <div class="mb-4 p-3 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-dark"><i class="ti tabler-box me-1 text-primary"></i>Installed Spare Parts & Pricing</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="btn-add-part"><i class="ti tabler-plus me-1"></i>Add Installed Part</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light small fw-bold">
                                        <tr>
                                            <th>Select Inventory Item / Enter Name</th>
                                            <th style="width: 150px;">Buying Price (BDT)</th>
                                            <th style="width: 100px;">Quantity</th>
                                            <th style="width: 70px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="parts-container">
                                        @php
                                            $usedParts = $repair->used_parts ?? [];
                                        @endphp
                                        @foreach($usedParts as $index => $part)
                                            <tr class="part-row">
                                                <td>
                                                    <select class="form-select form-select-sm select-part-item mb-1" name="used_parts[{{ $index }}][inventory_id]">
                                                        <option value="">-- Custom Part (Type Below) --</option>
                                                        @foreach($inventoryItems as $item)
                                                            <option value="{{ $item->id }}" 
                                                                data-name="{{ $item->name }}" 
                                                                data-price="{{ $item->purchase_price }}"
                                                                {{ isset($part['inventory_id']) && $part['inventory_id'] == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }} (Qty: {{ $item->quantity }}, Cost: {{ $item->purchase_price }} BDT)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="used_parts[{{ $index }}][name]" class="form-control form-control-sm input-part-name" value="{{ $part['name'] }}" placeholder="Enter part name manually" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="used_parts[{{ $index }}][buying_price]" class="form-control form-control-sm input-buying-price text-end" value="{{ $part['buying_price'] }}" step="0.01" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="used_parts[{{ $index }}][quantity]" class="form-control form-control-sm input-quantity text-center" value="{{ $part['quantity'] }}" min="1" required>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-remove-part"><i class="ti tabler-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="technician_notes">Technician Notes</label>
                                <textarea name="technician_notes" id="technician_notes" rows="4" class="form-control" placeholder="Write logs, diagnose details, or parts replaced...">{{ old('technician_notes', $repair->technician_notes) }}</textarea>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('admin.repairs.show', $repair->id) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="ti tabler-device-floppy me-1"></i>Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const partsContainers = document.querySelectorAll('#parts-container');
    const btnAddParts = document.querySelectorAll('#btn-add-part');
    const inventoryItems = @json($inventoryItems);
    let partIndex = {{ count($repair->used_parts ?? []) }};

    function updateCommissionPreview() {
        const commissionTypeSelect = document.getElementById('commission_type');
        const commissionRateInput = document.getElementById('commission_rate');
        const actualCostInput = document.getElementById('actual_cost');
        const estimatedCostInput = document.getElementById('estimated_cost');
        const repairChargeInput = document.getElementById('repair_charge');

        // Sum up parts cost
        let totalPartsCost = 0;
        document.querySelectorAll('.part-row').forEach(row => {
            const price = parseFloat(row.querySelector('.input-buying-price').value) || 0;
            const qty = parseInt(row.querySelector('.input-quantity').value) || 1;
            totalPartsCost += price * qty;
        });

        // Update Estimated Cost field dynamically (Service Charge + Parts Cost)
        let repairChargeVal = repairChargeInput ? parseFloat(repairChargeInput.value) || 0 : 0;
        let estimatedCostVal = repairChargeVal + totalPartsCost;
        if (estimatedCostInput) {
            estimatedCostInput.value = estimatedCostVal.toFixed(2);
        }

        if (!commissionTypeSelect || !commissionRateInput) return;

        const commissionType = commissionTypeSelect.value;
        const commissionRate = parseFloat(commissionRateInput.value) || 0;
        
        let actualCostVal = actualCostInput ? parseFloat(actualCostInput.value) : NaN;

        let commissionBase = 0;
        if (!isNaN(actualCostVal)) {
            // If actual cost is set, commission is calculated based on net actual cost: actual_cost - totalPartsCost
            commissionBase = Math.max(0, actualCostVal - totalPartsCost);
        } else {
            // Otherwise based on repair_charge (the net service fee estimate)
            commissionBase = Math.max(0, repairChargeVal);
        }

        let calculatedCommission = 0;

        if (commissionType === 'flat') {
            calculatedCommission = commissionRate;
        } else if (commissionType === 'percentage') {
            calculatedCommission = commissionBase * (commissionRate / 100);
        }

        // Display results
        let previewHtml = `
            <div class="alert alert-info border-0 shadow-sm p-3 mt-3 d-flex flex-column gap-1 small">
                <div class="d-flex justify-content-between">
                    <span class="text-muted fw-semibold">Net Service Charge (excluding parts cost):</span>
                    <span class="fw-bold text-dark">${commissionBase.toFixed(2)} BDT</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted fw-semibold">Total Parts Buying Cost:</span>
                    <span class="fw-bold text-danger">${totalPartsCost.toFixed(2)} BDT</span>
                </div>
                <hr class="my-1">
                <div class="d-flex justify-content-between fs-6">
                    <span class="text-primary fw-bold">Calculated Commission:</span>
                    <span class="fw-bold text-success">${calculatedCommission.toFixed(2)} BDT</span>
                </div>
            </div>
        `;

        let previewContainer = document.getElementById('commission-preview-container');
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.id = 'commission-preview-container';
            commissionRateInput.closest('.row').appendChild(previewContainer);
        }
        previewContainer.innerHTML = previewHtml;
    }

    // Helper to initialize Tom Select with bindings
    function initTomSelect(el, row) {
        if (!el) return;
        const ts = new TomSelect(el, {
            create: false,
            placeholder: "Search spare parts...",
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
        
        ts.on('change', function(value) {
            const nameInput = row.querySelector('.input-part-name');
            const priceInput = row.querySelector('.input-buying-price');
            if (value) {
                const opt = el.options[el.selectedIndex];
                if (opt) {
                    nameInput.value = opt.getAttribute('data-name') || '';
                    priceInput.value = opt.getAttribute('data-price') || '0.00';
                }
            } else {
                nameInput.value = '';
                priceInput.value = '0.00';
            }
            updateCommissionPreview();
        });
    }

    // Initialize Tom Select on pre-existing part rows
    document.querySelectorAll('.part-row').forEach(row => {
        const select = row.querySelector('.select-part-item');
        if (select) {
            initTomSelect(select, row);
        }
    });

    // Add row button binding
    btnAddParts.forEach(btn => {
        btn.addEventListener('click', function() {
            // Find the container corresponding to the active view
            const activeContainer = this.closest('.card-body').querySelector('#parts-container');
            if (!activeContainer) return;

            const selectOptions = inventoryItems.map(item => `
                <option value="${item.id}" data-name="${item.name}" data-price="${item.purchase_price}">
                    ${item.name} (Qty: ${item.quantity}, Cost: ${item.purchase_price} BDT)
                </option>
            `).join('');

            const newRow = document.createElement('tr');
            newRow.className = 'part-row';
            newRow.innerHTML = `
                <td>
                    <select class="form-select form-select-sm select-part-item mb-1" name="used_parts[${partIndex}][inventory_id]">
                        <option value="">-- Custom Part (Type Below) --</option>
                        ${selectOptions}
                    </select>
                    <input type="text" name="used_parts[${partIndex}][name]" class="form-control form-control-sm input-part-name" placeholder="Enter part name manually" required>
                </td>
                <td>
                    <input type="number" name="used_parts[${partIndex}][buying_price]" class="form-control form-control-sm input-buying-price text-end" value="0.00" step="0.01" min="0" required>
                </td>
                <td>
                    <input type="number" name="used_parts[${partIndex}][quantity]" class="form-control form-control-sm input-quantity text-center" value="1" min="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-remove-part"><i class="ti tabler-trash"></i></button>
                </td>
            `;

            activeContainer.appendChild(newRow);
            
            // Initialize Tom Select on the new row select dropdown
            const selectEl = newRow.querySelector('.select-part-item');
            if (selectEl) {
                initTomSelect(selectEl, newRow);
            }

            partIndex++;
            updateCommissionPreview();
        });
    });

    // Delegated events for parts list
    partsContainers.forEach(container => {
        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('select-part-item')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const row = e.target.closest('tr');
                const nameInput = row.querySelector('.input-part-name');
                const priceInput = row.querySelector('.input-buying-price');

                if (selectedOption.value) {
                    nameInput.value = selectedOption.dataset.name;
                    priceInput.value = selectedOption.dataset.price;
                } else {
                    nameInput.value = '';
                    priceInput.value = '0.00';
                }
                updateCommissionPreview();
            }

            if (e.target.classList.contains('input-buying-price') || e.target.classList.contains('input-quantity')) {
                updateCommissionPreview();
            }
        });

        container.addEventListener('click', function(e) {
            const btnRemove = e.target.closest('.btn-remove-part');
            if (btnRemove) {
                const row = btnRemove.closest('tr');
                row.remove();
                updateCommissionPreview();
            }
        });
    });

    // Live commission preview updates
    const commTypeEl = document.getElementById('commission_type');
    const commRateEl = document.getElementById('commission_rate');
    const actualCostEl = document.getElementById('actual_cost');
    const estimatedCostEl = document.getElementById('estimated_cost');
    const repairChargeEl = document.getElementById('repair_charge');

    if (commTypeEl) commTypeEl.addEventListener('change', updateCommissionPreview);
    if (commRateEl) commRateEl.addEventListener('input', updateCommissionPreview);
    if (actualCostEl) actualCostEl.addEventListener('input', updateCommissionPreview);
    if (estimatedCostEl) estimatedCostEl.addEventListener('input', updateCommissionPreview);
    if (repairChargeEl) repairChargeEl.addEventListener('input', updateCommissionPreview);

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

    // Run preview once on load
    updateCommissionPreview();
    updateFinancials();

    // ==========================================
    // Visual Pattern Lock Drawing Logic
    // ==========================================
    const btnTogglePattern = document.getElementById('btn-toggle-pattern');
    const patternWrapper = document.getElementById('pattern-lock-wrapper');
    const patternHolder = document.getElementById('pattern-holder');
    const patternSvg = document.getElementById('pattern-svg');
    const patternDots = document.querySelectorAll('.pattern-dot');
    const patternPathInput = document.getElementById('pattern_lock_path');
    const patternPathLabel = document.getElementById('pattern-path-label');
    const btnClearPattern = document.getElementById('btn-clear-pattern');
    const passwordPatternInput = document.getElementById('password_pattern');

    let isDrawing = false;
    let activePattern = [];

    if (btnTogglePattern && patternWrapper) {
        btnTogglePattern.addEventListener('click', function() {
            if (patternWrapper.style.display === 'none') {
                patternWrapper.style.display = 'block';
                btnTogglePattern.innerHTML = '<i class="ti tabler-grid me-1"></i>Hide Pattern Drawer';
            } else {
                patternWrapper.style.display = 'none';
                btnTogglePattern.innerHTML = '<i class="ti tabler-grid me-1"></i>Draw Pattern Lock';
            }
        });
    }

    function getMouseOrTouchCoords(e, container) {
        const rect = container.getBoundingClientRect();
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    }

    function getDotCenter(dot, container) {
        const rect = dot.getBoundingClientRect();
        const containerRect = container.getBoundingClientRect();
        return {
            x: (rect.left + rect.width / 2) - containerRect.left,
            y: (rect.top + rect.height / 2) - containerRect.top
        };
    }

    function drawLines(tempCoords = null) {
        if (!patternSvg) return;
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

        if (tempCoords && activePattern.length > 0) {
            pathData += ` L ${tempCoords.x} ${tempCoords.y}`;
        }

        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        path.setAttribute('d', pathData);
        path.setAttribute('stroke', '#7367f0');
        path.setAttribute('stroke-width', '4');
        path.setAttribute('fill', 'none');
        path.setAttribute('stroke-linecap', 'round');
        path.setAttribute('stroke-linejoin', 'round');
        patternSvg.appendChild(path);
    }

    function clearPattern() {
        activePattern = [];
        patternDots.forEach(dot => {
            dot.style.background = '#a1b0cb';
            dot.style.transform = 'scale(1)';
        });
        if (patternSvg) patternSvg.innerHTML = '';
        if (patternPathInput) patternPathInput.value = '';
        if (patternPathLabel) patternPathLabel.textContent = 'Path: None';
    }

    if (patternHolder) {
        const startDrawing = (e) => {
            isDrawing = true;
            clearPattern();
            handleMove(e);
        };

        const handleMove = (e) => {
            if (!isDrawing) return;
            e.preventDefault();
            const coords = getMouseOrTouchCoords(e, patternHolder);

            patternDots.forEach(dot => {
                const dotCenter = getDotCenter(dot, patternHolder);
                const dist = Math.hypot(coords.x - dotCenter.x, coords.y - dotCenter.y);

                if (dist < 22) { // Detection radius
                    const dotIndex = parseInt(dot.getAttribute('data-index'));
                    if (!activePattern.includes(dotIndex)) {
                        activePattern.push(dotIndex);
                        dot.style.background = '#7367f0';
                        dot.style.transform = 'scale(1.3)';
                    }
                }
            });

            drawLines(coords);
        };

        const endDrawing = () => {
            if (!isDrawing) return;
            isDrawing = false;
            drawLines();
            if (activePattern.length > 0) {
                const patternStr = activePattern.join('-');
                patternPathInput.value = patternStr;
                patternPathLabel.textContent = 'Path: ' + patternStr;
                if (passwordPatternInput && !passwordPatternInput.value) {
                    passwordPatternInput.value = '[Pattern Lock]';
                }
            }
        };

        patternHolder.addEventListener('mousedown', startDrawing);
        patternHolder.addEventListener('mousemove', handleMove);
        window.addEventListener('mouseup', endDrawing);

        patternHolder.addEventListener('touchstart', startDrawing, { passive: false });
        patternHolder.addEventListener('touchmove', handleMove, { passive: false });
        window.addEventListener('touchend', endDrawing);
    }

    if (btnClearPattern) {
        btnClearPattern.addEventListener('click', function(e) {
            e.preventDefault();
            clearPattern();
            if (passwordPatternInput && passwordPatternInput.value === '[Pattern Lock]') {
                passwordPatternInput.value = '';
            }
        });
    }

    // Auto-draw existing pattern lock on load
    if (patternPathInput && patternPathInput.value) {
        activePattern = patternPathInput.value.split('-').map(Number);
        activePattern.forEach(dotIndex => {
            const dot = document.querySelector(`.pattern-dot[data-index="${dotIndex}"]`);
            if (dot) {
                dot.style.background = '#7367f0';
                dot.style.transform = 'scale(1.3)';
            }
        });
        setTimeout(function() {
            drawLines();
        }, 300);
    }
});
</script>
@endsection
