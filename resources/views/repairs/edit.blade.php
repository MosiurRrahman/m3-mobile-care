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
                                    <option value="waiting_for_parts" {{ old('status', $repair->status) == 'waiting_for_parts' ? 'selected' : '' }}>📦 Waiting for Parts (ঢাকা থেকে পার্টস আসার অপেক্ষায়)</option>
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
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><i class="ti tabler-box me-1 text-primary"></i>Installed Spare Parts & Outsourced Sourcing</h6>
                                    <span class="text-muted small">দোকানের স্টক অথবা ঢাকা/লোকাল সাপ্লায়ার থেকে কেনা পার্টস ও কুরিয়ার খরচ</span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="btn-add-part"><i class="ti tabler-plus me-1"></i>Add Spare Part</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light small fw-bold">
                                        <tr>
                                            <th style="min-width: 220px;">Part Item / Manual Name</th>
                                            <th style="width: 160px;">Source (উৎস)</th>
                                            <th style="width: 160px;">Supplier / Shop</th>
                                            <th style="width: 120px;">Buying Price</th>
                                            <th style="width: 100px;">Courier (৳)</th>
                                            <th style="width: 70px;">Qty</th>
                                            <th style="width: 50px;" class="text-center">Action</th>
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
                                                        <option value="">-- Custom / Sourced Part --</option>
                                                        @foreach($inventoryItems as $item)
                                                            <option value="{{ $item->id }}" 
                                                                data-name="{{ $item->name }}" 
                                                                data-price="{{ $item->purchase_price }}"
                                                                {{ isset($part['inventory_id']) && $part['inventory_id'] == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }} (Qty: {{ $item->quantity }}, Cost: {{ $item->purchase_price }} BDT)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="used_parts[{{ $index }}][name]" class="form-control form-control-sm input-part-name" value="{{ $part['name'] }}" placeholder="Enter part name (e.g. Backshell Blue)" required>
                                                </td>
                                                <td>
                                                    @php $pSource = $part['source'] ?? (isset($part['inventory_id']) && $part['inventory_id'] ? 'in_house' : 'dhaka_supplier'); @endphp
                                                    <select name="used_parts[{{ $index }}][source]" class="form-select form-select-sm select-part-source">
                                                        <option value="in_house" {{ $pSource == 'in_house' ? 'selected' : '' }}>দোকানের স্টক</option>
                                                        <option value="dhaka_supplier" {{ $pSource == 'dhaka_supplier' ? 'selected' : '' }}>ঢাকা সাপ্লায়ার</option>
                                                        <option value="local_shop" {{ $pSource == 'local_shop' ? 'selected' : '' }}>লোকাল দোকান</option>
                                                        <option value="other" {{ $pSource == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="used_parts[{{ $index }}][supplier_name]" class="form-control form-control-sm" value="{{ $part['supplier_name'] ?? '' }}" placeholder="যেমন: মোতালেব প্লাজা">
                                                </td>
                                                <td>
                                                    <input type="number" name="used_parts[{{ $index }}][buying_price]" class="form-control form-control-sm input-buying-price text-end" value="{{ $part['buying_price'] }}" step="0.01" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="used_parts[{{ $index }}][courier_cost]" class="form-control form-control-sm input-courier-cost text-end" value="{{ $part['courier_cost'] ?? '0.00' }}" step="0.01" min="0" placeholder="0.00">
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
                                            <label class="form-label fw-semibold" for="customer_id">Select Customer <span class="text-danger">*</span></label>
                                            <select name="customer_id" id="customer_id" class="form-select" required>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold" for="device_brand">Brand <span class="text-danger">*</span></label>
                                                <input type="text" name="device_brand" id="device_brand" class="form-control form-control-sm" value="{{ old('device_brand', $repair->device_brand) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold" for="device_model">Model <span class="text-danger">*</span></label>
                                                <input type="text" name="device_model" id="device_model" class="form-control form-control-sm" value="{{ old('device_model', $repair->device_model) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold" for="serial_imei">IMEI / Serial</label>
                                                <input type="text" name="serial_imei" id="serial_imei" class="form-control form-control-sm" value="{{ old('serial_imei', $repair->serial_imei) }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="password_pattern">Screen Lock Credentials / Unlocking Pattern</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="password_pattern" id="password_pattern" class="form-control" value="{{ old('password_pattern', $repair->password_pattern) }}" placeholder="e.g. Pin: 1234">
                                                <button type="button" id="btn-toggle-pattern" class="btn btn-outline-primary"><i class="ti tabler-grid me-1"></i>Draw Pattern</button>
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

                                        <div>
                                            <label class="form-label fw-semibold" for="issue_description">Issue Description <span class="text-danger">*</span></label>
                                            <textarea name="issue_description" id="issue_description" rows="2" class="form-control form-control-sm" required>{{ old('issue_description', $repair->issue_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Pre-Repair Physical Checklist & Photos Card (Dynamic Custom Fields Only) -->
                                <div class="card border mb-4 shadow-none">
                                    <div class="card-header bg-light py-3 border-bottom d-flex align-items-center justify-content-between">
                                        <h6 class="fw-bold text-primary mb-0"><i class="ti tabler-clipboard-check me-2"></i>2. Condition Checklist & Photos</h6>
                                        <button type="button" class="btn btn-xs btn-outline-primary fw-bold" id="btn-add-custom-checklist"><i class="ti tabler-plus me-1"></i>Add Custom Condition Item</button>
                                    </div>
                                    <div class="card-body p-4">
                                        <!-- Container for Dynamic Custom Checklist Items Only -->
                                        <div id="custom-checklist-container" class="mb-3">
                                            @php
                                                $checklist = $repair->device_checklist ?? [];
                                                $customItems = isset($checklist['custom']) && is_array($checklist['custom']) ? $checklist['custom'] : [];

                                                // Legacy keys converted to dynamic rows if present
                                                $legacyLabels = [
                                                    'scratches' => 'Body Scratches',
                                                    'display_ok' => 'Display Condition',
                                                    'touch_ok' => 'Touch Screen',
                                                    'camera_ok' => 'Cameras',
                                                    'audio_ok' => 'Speakers & Audio',
                                                    'buttons_ok' => 'Physical Buttons',
                                                ];
                                                foreach ($legacyLabels as $lKey => $lTitle) {
                                                    if (isset($checklist[$lKey]) && !empty($checklist[$lKey])) {
                                                        $val = $checklist[$lKey];
                                                        $strVal = is_string($val) ? $val : ($val === 'yes' ? 'OK / Good' : 'Issue');
                                                        $exists = false;
                                                        foreach ($customItems as $ci) {
                                                            if (($ci['label'] ?? '') === $lTitle) { $exists = true; break; }
                                                        }
                                                        if (!$exists) {
                                                            $customItems[] = ['label' => $lTitle, 'value' => $strVal];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach($customItems as $cIdx => $cItem)
                                                <div class="row g-2 mb-2 custom-checklist-row align-items-center">
                                                    <div class="col-5">
                                                        <input type="text" name="device_checklist[custom][{{ $cIdx }}][label]" class="form-control form-control-sm" value="{{ $cItem['label'] ?? '' }}" placeholder="Condition Label (e.g. Body Scratches, Face ID)" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" name="device_checklist[custom][{{ $cIdx }}][value]" class="form-control form-control-sm" value="{{ $cItem['value'] ?? '' }}" placeholder="Details (e.g. Scratched / Working / 85% Health)" required>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <button type="button" class="btn btn-xs btn-icon btn-outline-danger btn-remove-custom-checklist"><i class="ti tabler-trash"></i></button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

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

                                <!-- 3. Diagnostics & Spare Parts Card -->
                                <div class="card border mb-4 shadow-none">
                                    <div class="card-header bg-light py-3 border-bottom d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-primary mb-0"><i class="ti tabler-box me-2"></i>3. Technical Diagnostics & Installed Spare Parts</h6>
                                            <span class="text-muted small">দোকানের স্টক অথবা ঢাকা/লোকাল সাপ্লায়ার থেকে কেনা পার্টস ও কুরিয়ার খরচ</span>
                                        </div>
                                        <button type="button" class="btn btn-xs btn-outline-primary fw-bold" id="btn-add-part"><i class="ti tabler-plus me-1"></i>Add Part</button>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold" for="technician_notes">
                                                Technician Diagnostic Notes & Lab Update
                                                <small class="text-muted d-block fw-normal">(এই ডেসক্রিপশনটি গ্রাহক ERT লাইভ ট্র্যাকিং টাইমলাইনে দেখতে পাবেন)</small>
                                            </label>
                                            <textarea name="technician_notes" id="technician_notes" rows="3" class="form-control form-control-sm" placeholder="যেমন: নতুন অরিজিনাল ডিসপ্লে লাগানো হচ্ছে / মাদারবোর্ড আইসি ডায়াগনসিস সম্পন্ন...">{{ old('technician_notes', $repair->technician_notes) }}</textarea>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered align-middle mb-0">
                                                <thead class="table-light small fw-bold">
                                                    <tr>
                                                        <th style="min-width: 200px;">Part Item / Manual Name</th>
                                                        <th style="width: 140px;">Source (উৎস)</th>
                                                        <th style="width: 140px;">Supplier / Shop</th>
                                                        <th style="width: 110px;">Buying Price</th>
                                                        <th style="width: 90px;">Courier (৳)</th>
                                                        <th style="width: 65px;">Qty</th>
                                                        <th style="width: 45px;" class="text-center">Action</th>
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
                                                                    <option value="">-- Custom / Sourced Part --</option>
                                                                    @foreach($inventoryItems as $item)
                                                                        <option value="{{ $item->id }}" 
                                                                            data-name="{{ $item->name }}" 
                                                                            data-price="{{ $item->purchase_price }}"
                                                                            {{ isset($part['inventory_id']) && $part['inventory_id'] == $item->id ? 'selected' : '' }}>
                                                                            {{ $item->name }} (Qty: {{ $item->quantity }}, Cost: {{ $item->purchase_price }} BDT)
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="text" name="used_parts[{{ $index }}][name]" class="form-control form-control-sm input-part-name" value="{{ $part['name'] }}" placeholder="Enter part name (e.g. Backshell Blue)" required>
                                                            </td>
                                                            <td>
                                                                @php $pSource = $part['source'] ?? (isset($part['inventory_id']) && $part['inventory_id'] ? 'in_house' : 'dhaka_supplier'); @endphp
                                                                <select name="used_parts[{{ $index }}][source]" class="form-select form-select-sm select-part-source">
                                                                    <option value="in_house" {{ $pSource == 'in_house' ? 'selected' : '' }}>দোকানের স্টক</option>
                                                                    <option value="dhaka_supplier" {{ $pSource == 'dhaka_supplier' ? 'selected' : '' }}>ঢাকা সাপ্লায়ার</option>
                                                                    <option value="local_shop" {{ $pSource == 'local_shop' ? 'selected' : '' }}>লোকাল দোকান</option>
                                                                    <option value="other" {{ $pSource == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="used_parts[{{ $index }}][supplier_name]" class="form-control form-control-sm" value="{{ $part['supplier_name'] ?? '' }}" placeholder="যেমন: মোতালেব প্লাজা">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="used_parts[{{ $index }}][buying_price]" class="form-control form-control-sm input-buying-price text-end" value="{{ $part['buying_price'] }}" step="0.01" min="0" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="used_parts[{{ $index }}][courier_cost]" class="form-control form-control-sm input-courier-cost text-end" value="{{ $part['courier_cost'] ?? '0.00' }}" step="0.01" min="0" placeholder="0.00">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="used_parts[{{ $index }}][quantity]" class="form-control form-control-sm input-quantity text-center" value="{{ $part['quantity'] }}" min="1" required>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-xs btn-icon btn-outline-danger btn-remove-part"><i class="ti tabler-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                                                <option value="waiting_for_parts" {{ old('status', $repair->status) == 'waiting_for_parts' ? 'selected' : '' }}>📦 Waiting for Parts (ঢাকা থেকে পার্টস আসার অপেক্ষায়)</option>
                                                <option value="repairing" {{ old('status', $repair->status) == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                                <option value="quality_check" {{ old('status', $repair->status) == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                                                <option value="completed" {{ old('status', $repair->status) == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                                                <option value="delivered" {{ old('status', $repair->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ old('status', $repair->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
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
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="expected_delivery_date">Delivery Date</label>
                                                <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control form-control-sm" value="{{ old('expected_delivery_date', $repair->expected_delivery_date) }}">
                                            </div>
                                        </div>

                                        @if(auth()->user()->isSuperAdmin())
                                        <div class="row g-3 mb-4 bg-light p-3 rounded border">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="commission_type">Commission Type</label>
                                                <select name="commission_type" id="commission_type" class="form-select form-select-sm">
                                                    <option value="" {{ empty($repair->commission_type) ? 'selected' : '' }}>No Commission</option>
                                                    <option value="percentage" {{ old('commission_type', $repair->commission_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                                    <option value="flat" {{ old('commission_type', $repair->commission_type) == 'flat' ? 'selected' : '' }}>Flat Amount (BDT)</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="commission_rate">Commission Value</label>
                                                <input type="number" name="commission_rate" id="commission_rate" step="0.01" min="0" class="form-control form-control-sm" value="{{ old('commission_rate', $repair->commission_rate) }}">
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Estimates & Advance -->
                                        <div class="row g-3 mb-4">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="repair_charge">Service Charge (BDT)</label>
                                                <input type="number" name="repair_charge" id="repair_charge" step="0.01" min="0" class="form-control form-control-sm" value="{{ old('repair_charge', $repair->repair_charge) }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small text-muted mb-1" for="estimated_cost">Estimated Cost</label>
                                                <input type="number" name="estimated_cost" id="estimated_cost" step="0.01" min="0" class="form-control form-control-sm bg-light fw-bold" value="{{ old('estimated_cost', $repair->estimated_cost) }}" readonly>
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

                                        <div class="row g-3 mb-4">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold small mb-1" for="warranty_days">Warranty (Days)</label>
                                                <input type="number" name="warranty_days" id="warranty_days" min="0" class="form-control form-control-sm" value="{{ old('warranty_days', $repair->warranty_days ?? 0) }}" placeholder="e.g. 90">
                                            </div>
                                            <div class="col-6 d-flex align-items-end">
                                                <div class="form-check form-switch small w-100 p-3 border rounded bg-light">
                                                    <input class="form-check-input ms-0 me-1" type="checkbox" name="data_loss_consent" id="data_loss_consent" value="1" {{ old('data_loss_consent', $repair->data_loss_consent) ? 'checked' : '' }} required>
                                                    <label class="form-check-label fw-bold text-dark ms-1" for="data_loss_consent" style="font-size:0.75rem;">Data Consent Verified *</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Final Settlement (At Delivery) Spacious Card -->
                                        <div class="p-4 rounded-3 bg-light border border-info border-opacity-25 mb-4">
                                            <h6 class="fw-bold mb-3 text-primary"><i class="ti tabler-cash me-2"></i>Final Checkout (স্প্লিট পেমেন্ট)</h6>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small mb-1" for="actual_cost">Actual / Final Cost (Total Bill)</label>
                                                <input type="number" name="actual_cost" id="actual_cost" step="0.01" min="0" class="form-control fw-bold text-dark" value="{{ old('actual_cost', $repair->actual_cost) }}" placeholder="Fill total bill at delivery">
                                                <div class="form-text small text-info mt-2">
                                                    Counter Due: <strong id="val-final-due">0.00</strong> BDT
                                                </div>
                                            </div>

                                            <label class="form-label fw-semibold text-dark small mb-2 d-block border-top pt-2">Delivery Payment Methods (ডেলিভারি পেমেন্ট)</label>
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

        // Sum up parts cost and courier
        let totalPartsCost = 0;
        let totalCourierCost = 0;
        document.querySelectorAll('.part-row').forEach(row => {
            const price = parseFloat(row.querySelector('.input-buying-price')?.value) || 0;
            const courier = parseFloat(row.querySelector('.input-courier-cost')?.value) || 0;
            const qty = parseInt(row.querySelector('.input-quantity')?.value) || 1;
            totalPartsCost += (price * qty);
            totalCourierCost += courier;
        });

        // Update Estimated Cost field dynamically (Service Charge + Parts Cost + Courier)
        let repairChargeVal = repairChargeInput ? parseFloat(repairChargeInput.value) || 0 : 0;
        let estimatedCostVal = repairChargeVal + totalPartsCost + totalCourierCost;
        if (estimatedCostInput) {
            estimatedCostInput.value = estimatedCostVal.toFixed(2);
        }

        if (!commissionTypeSelect || !commissionRateInput) return;

        const commissionType = commissionTypeSelect.value;
        const commissionRate = parseFloat(commissionRateInput.value) || 0;
        
        let actualCostVal = actualCostInput ? parseFloat(actualCostInput.value) : NaN;

        let commissionBase = 0;
        if (!isNaN(actualCostVal)) {
            // If actual cost is set, commission is calculated based on net actual cost: actual_cost - (totalPartsCost + totalCourierCost)
            commissionBase = Math.max(0, actualCostVal - (totalPartsCost + totalCourierCost));
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

        const netProfit = Math.max(0, estimatedCostVal - (totalPartsCost + totalCourierCost + calculatedCommission));

        // Display results
        let previewHtml = `
            <div class="alert alert-info border-0 shadow-sm p-3 mt-3 d-flex flex-column gap-1 small">
                <div class="d-flex justify-content-between">
                    <span class="text-muted fw-semibold">Net Service Fee (কাস্টমার সার্ভিস ফি):</span>
                    <span class="fw-bold text-dark">${commissionBase.toFixed(2)} BDT</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted fw-semibold">Total Parts Buying Cost (পার্টস খরচ):</span>
                    <span class="fw-bold text-danger">${totalPartsCost.toFixed(2)} BDT</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted fw-semibold">Total Courier / Transport (কুরিয়ার):</span>
                    <span class="fw-bold text-warning text-dark">${totalCourierCost.toFixed(2)} BDT</span>
                </div>
                <hr class="my-1">
                <div class="d-flex justify-content-between fs-6">
                    <span class="text-primary fw-bold">Shop Net Profit (দোকানের নিট লাভ):</span>
                    <span class="fw-bold text-success">${netProfit.toFixed(2)} BDT</span>
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
            placeholder: "Search shop inventory...",
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
        
        ts.on('change', function(value) {
            const nameInput = row.querySelector('.input-part-name');
            const priceInput = row.querySelector('.input-buying-price');
            const sourceSelect = row.querySelector('.select-part-source');
            if (value) {
                const opt = el.options[el.selectedIndex];
                if (opt) {
                    nameInput.value = opt.getAttribute('data-name') || '';
                    priceInput.value = opt.getAttribute('data-price') || '0.00';
                    if (sourceSelect) sourceSelect.value = 'in_house';
                }
            } else {
                if (sourceSelect) sourceSelect.value = 'dhaka_supplier';
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
                        <option value="">-- Custom / Sourced Part --</option>
                        ${selectOptions}
                    </select>
                    <input type="text" name="used_parts[${partIndex}][name]" class="form-control form-control-sm input-part-name" placeholder="Enter part name (e.g. Backshell Blue)" required>
                </td>
                <td>
                    <select name="used_parts[${partIndex}][source]" class="form-select form-select-sm select-part-source">
                        <option value="in_house">দোকানের স্টক</option>
                        <option value="dhaka_supplier" selected>ঢাকা সাপ্লায়ার</option>
                        <option value="local_shop">লোকাল দোকান</option>
                        <option value="other">অন্যান্য</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="used_parts[${partIndex}][supplier_name]" class="form-control form-control-sm" placeholder="যেমন: মোতালেব প্লাজা">
                </td>
                <td>
                    <input type="number" name="used_parts[${partIndex}][buying_price]" class="form-control form-control-sm input-buying-price text-end" value="0.00" step="0.01" min="0" required>
                </td>
                <td>
                    <input type="number" name="used_parts[${partIndex}][courier_cost]" class="form-control form-control-sm input-courier-cost text-end" value="0.00" step="0.01" min="0" placeholder="0.00">
                </td>
                <td>
                    <input type="number" name="used_parts[${partIndex}][quantity]" class="form-control form-control-sm input-quantity text-center" value="1" min="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-xs btn-icon btn-outline-danger btn-remove-part"><i class="ti tabler-trash"></i></button>
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

    // Dynamic Custom Condition Checklist JS
    const btnAddCustomChecklist = document.getElementById('btn-add-custom-checklist');
    const customChecklistContainer = document.getElementById('custom-checklist-container');
    let customChecklistIndex = document.querySelectorAll('.custom-checklist-row').length;

    if (btnAddCustomChecklist && customChecklistContainer) {
        btnAddCustomChecklist.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 custom-checklist-row align-items-center';
            row.innerHTML = `
                <div class="col-5">
                    <input type="text" name="device_checklist[custom][${customChecklistIndex}][label]" class="form-control form-control-sm" placeholder="Condition Label (e.g. Face ID)" required>
                </div>
                <div class="col-6">
                    <input type="text" name="device_checklist[custom][${customChecklistIndex}][value]" class="form-control form-control-sm" placeholder="Details (e.g. Working / 85% Health)" required>
                </div>
                <div class="col-1 text-center">
                    <button type="button" class="btn btn-xs btn-icon btn-outline-danger btn-remove-custom-checklist"><i class="ti tabler-trash"></i></button>
                </div>
            `;
            customChecklistContainer.appendChild(row);
            customChecklistIndex++;
        });

        customChecklistContainer.addEventListener('click', function(e) {
            const btnRemove = e.target.closest('.btn-remove-custom-checklist');
            if (btnRemove) {
                btnRemove.closest('.custom-checklist-row').remove();
            }
        });
    }

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

            if (e.target.classList.contains('input-buying-price') || e.target.classList.contains('input-courier-cost') || e.target.classList.contains('input-quantity')) {
                updateCommissionPreview();
            }
        });

        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('input-buying-price') || e.target.classList.contains('input-courier-cost') || e.target.classList.contains('input-quantity')) {
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
