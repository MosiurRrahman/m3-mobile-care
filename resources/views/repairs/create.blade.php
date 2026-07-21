@extends('layouts/contentNavbarLayout')

@section('title', 'Create Job Card - M3 Mobile Care')

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
        <h4 class="fw-bold mb-0">Create Repair Job Card</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.repairs.index') }}">Repairs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">


                <form action="{{ route('admin.repairs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- SECTION 1: Customer Details -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-primary mb-0"><i class="ti tabler-user me-2"></i>1. Customer Information</h5>
                        <small class="text-muted"><i class="ti tabler-info-circle me-1"></i>Enter phone number to auto-fill existing customer info</small>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0 position-relative">
                            <label class="form-label fw-semibold" for="customer_phone">Mobile Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="e.g. 01712345678" required autocomplete="off">
                                <span class="input-group-text d-none" id="customer-lookup-spinner" style="background: transparent;">
                                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="customer_name">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="customer_address">Address</label>
                            <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ old('customer_address') }}" placeholder="e.g. Dhaka, Bangladesh">
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- SECTION 2: Device Details -->
                    <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-device-mobile me-2"></i>2. Device Information</h5>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="device_brand">Brand <span class="text-danger">*</span></label>
                            <select name="device_brand" id="device_brand" class="form-select" required>
                                <option value="" disabled selected>Select Brand</option>
                                <option value="Apple" {{ old('device_brand') == 'Apple' ? 'selected' : '' }}>Apple (iPhone/iPad)</option>
                                <option value="Samsung" {{ old('device_brand') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                <option value="Xiaomi" {{ old('device_brand') == 'Xiaomi' ? 'selected' : '' }}>Xiaomi / Redmi</option>
                                <option value="Realme" {{ old('device_brand') == 'Realme' ? 'selected' : '' }}>Realme</option>
                                <option value="Oppo" {{ old('device_brand') == 'Oppo' ? 'selected' : '' }}>Oppo</option>
                                <option value="Vivo" {{ old('device_brand') == 'Vivo' ? 'selected' : '' }}>Vivo</option>
                                <option value="OnePlus" {{ old('device_brand') == 'OnePlus' ? 'selected' : '' }}>OnePlus</option>
                                <option value="Google" {{ old('device_brand') == 'Google' ? 'selected' : '' }}>Google Pixel</option>
                                <option value="Other" {{ old('device_brand') == 'Other' ? 'selected' : '' }}>Other Brand</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="device_model">Model Name / Number <span class="text-danger">*</span></label>
                            <input type="text" name="device_model" id="device_model" class="form-control" value="{{ old('device_model') }}" placeholder="e.g. iPhone 13 Pro Max" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="serial_imei">IMEI / Serial Number</label>
                            <input type="text" name="serial_imei" id="serial_imei" class="form-control" value="{{ old('serial_imei') }}" placeholder="e.g. 357283920193847">
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="service_id">Catalog Services <span class="text-muted">(Optional price lookup)</span></label>
                            <select name="service_id" id="service_id" class="form-select">
                                <option value="">Custom / Unlisted Service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }} ({{ number_format($service->price, 0) }} BDT)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="password_pattern">Screen Lock Credentials / Unlocking Pattern</label>
                            <input type="text" name="password_pattern" id="password_pattern" class="form-control" value="{{ old('password_pattern') }}" placeholder="Pattern code, PIN or Password">
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
                                    <span class="small text-muted" id="pattern-path-label">Path: None</span>
                                    <button type="button" id="btn-clear-pattern" class="btn btn-xs btn-outline-danger py-0 px-1" style="font-size:0.75rem;">Clear</button>
                                </div>
                                <input type="hidden" name="pattern_lock_path" id="pattern_lock_path" value="{{ old('pattern_lock_path') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="issue_description">Issue Description & Remarks <span class="text-danger">*</span></label>
                            <textarea name="issue_description" id="issue_description" rows="3" class="form-control" placeholder="Describe faults (e.g. Glass cracked, touch dead, microphone sound low)..." required>{{ old('issue_description') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- SECTION 2.5: Physical Checklist & Photos -->
                    <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-clipboard-check me-2"></i>2.5 Device Condition Checklist & Photos</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-bold d-block mb-3 text-dark">Pre-Repair Physical Diagnostics</label>
                            
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="device_checklist[scratches]" id="chk_scratches" value="yes">
                                        <label class="form-check-label fw-semibold" for="chk_scratches">Body Scratches / Dents</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="device_checklist[display_ok]" id="chk_display" value="yes" checked>
                                        <label class="form-check-label fw-semibold" for="chk_display">Display Functional</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="device_checklist[touch_ok]" id="chk_touch" value="yes" checked>
                                        <label class="form-check-label fw-semibold" for="chk_touch">Touch Screen Working</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="device_checklist[camera_ok]" id="chk_camera" value="yes" checked>
                                        <label class="form-check-label fw-semibold" for="chk_camera">Cameras Working</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="device_checklist[audio_ok]" id="chk_audio" value="yes" checked>
                                        <label class="form-check-label fw-semibold" for="chk_audio">Speakers & Audio Working</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="device_checklist[buttons_ok]" id="chk_buttons" value="yes" checked>
                                        <label class="form-check-label fw-semibold" for="chk_buttons">Physical Buttons OK</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="device_photos">Upload Device Photos <span class="text-muted">(Photos of scratches, cracks, or condition)</span></label>
                            <input type="file" name="device_photos[]" id="device_photos" class="form-control" accept="image/*" multiple>
                            <div class="form-text small">You can upload multiple files. JPG, PNG, GIF format. Max 2MB/file.</div>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- SECTION 3: Operations & Pricing -->
                    <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-tool me-2"></i>3. Technical Operations & Costs</h5>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="status">Job Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending confirmation</option>
                                <option value="diagnosing" {{ old('status') == 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                                <option value="waiting_for_approval" {{ old('status') == 'waiting_for_approval' ? 'selected' : '' }}>Waiting Approval</option>
                                <option value="repairing" {{ old('status') == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                <option value="quality_check" {{ old('status') == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                                <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="assigned_technician_id">Assign Technician</label>
                            <select name="assigned_technician_id" id="assigned_technician_id" class="form-select">
                                <option value="">Unassigned</option>
                                @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ old('assigned_technician_id') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="expected_delivery_date">Expected Delivery Date</label>
                            <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date', date('Y-m-d', strtotime('+3 days'))) }}">
                        </div>
                    </div>

                    @if(auth()->user()->isSuperAdmin())
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="commission_type">Technician Commission Type</label>
                            <select name="commission_type" id="commission_type" class="form-select">
                                <option value="">No Commission / Salary-based</option>
                                <option value="percentage" {{ old('commission_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="flat" {{ old('commission_type') == 'flat' ? 'selected' : '' }}>Flat Amount (BDT)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="commission_rate">Commission Value</label>
                            <input type="number" name="commission_rate" id="commission_rate" step="0.01" min="0" class="form-control" value="{{ old('commission_rate', 0) }}">
                            <div class="form-text small">e.g. 15 for 15% of actual repair charge, or 250 for a flat 250 BDT commission.</div>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="repair_charge">Repair Charge / Service Fee (BDT)</label>
                            <input type="number" name="repair_charge" id="repair_charge" step="0.01" min="0" class="form-control" value="{{ old('repair_charge', 0) }}">
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="estimated_cost">Estimated Cost (BDT)</label>
                            <input type="number" name="estimated_cost" id="estimated_cost" step="0.01" min="0" class="form-control bg-light" value="{{ old('estimated_cost', 0) }}" readonly>
                            <div class="form-text small">Auto-calculated (Service Fee + Parts)</div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="advance_payment">Advance Deposit Paid (BDT)</label>
                            <input type="number" name="advance_payment" id="advance_payment" step="0.01" min="0" class="form-control" value="{{ old('advance_payment', 0) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="advance_payment_method">Advance Payment Method</label>
                            <select name="advance_payment_method" id="advance_payment_method" class="form-select">
                                <option value="">-- Select Method --</option>
                                <option value="Cash" {{ old('advance_payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bKash" {{ old('advance_payment_method') == 'bKash' ? 'selected' : '' }}>bKash</option>
                                <option value="Nagad" {{ old('advance_payment_method') == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                <option value="Rocket" {{ old('advance_payment_method') == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="warranty_days">Warranty Period (Days)</label>
                            <input type="number" name="warranty_days" id="warranty_days" min="0" class="form-control" value="{{ old('warranty_days', 0) }}" placeholder="e.g. 90">
                            <div class="form-text small">Number of days parts/labor warranty. Starts upon completion.</div>
                        </div>
                        <div class="col-md-8 d-flex align-items-center mt-md-3">
                            <div class="form-check form-switch card p-2 px-3 border w-100 bg-label-warning border-warning d-flex align-items-center flex-row gap-2">
                                <input class="form-check-input ms-0" type="checkbox" name="data_loss_consent" id="data_loss_consent" value="1" {{ old('data_loss_consent') ? 'checked' : '' }} required>
                                <div class="ms-2">
                                    <label class="form-check-label fw-bold text-warning" for="data_loss_consent">
                                        Data Loss Consent Verified <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-text text-warning small opacity-75 mt-0" style="font-size: 0.75rem;">Customer acknowledges they backed up data and M3 Mobile Care is not liable for data loss during repair.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- USED PARTS SECTION (Create workflow) -->
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
                                    {{-- Will be populated by JS row builder --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="technician_notes">Technician Notes</label>
                            <textarea name="technician_notes" id="technician_notes" rows="3" class="form-control" placeholder="Write initial diagnostics notes here...">{{ old('technician_notes') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="ti tabler-plus me-1"></i>Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const repairChargeInput = document.getElementById('repair_charge');

        if (serviceSelect && repairChargeInput) {
            serviceSelect.addEventListener('change', function() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const price = selectedOption.getAttribute('data-price');

                if(price) {
                    repairChargeInput.value = parseFloat(price);
                    updateCommissionPreview();
                }
            });
        }

        // Customer auto-lookup by mobile number
        const phoneInput = document.getElementById('customer_phone');
        const nameInput = document.getElementById('customer_name');
        const addressInput = document.getElementById('customer_address');

        if (phoneInput) {
            let timeout = null;
            phoneInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const phone = phoneInput.value.trim();
                if (phone.length < 5) return;

                const spinner = document.getElementById('customer-lookup-spinner');
                if (spinner) spinner.classList.remove('d-none');

                timeout = setTimeout(() => {
                    fetch(`/admin/customers/lookup?phone=${encodeURIComponent(phone)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (spinner) spinner.classList.add('d-none');
                            if (data.found && data.customer) {
                                nameInput.value = data.customer.name || '';
                                addressInput.value = data.customer.address || '';
                                
                                // Visual feedback
                                nameInput.classList.add('is-valid');
                                addressInput.classList.add('is-valid');
                                setTimeout(() => {
                                    nameInput.classList.remove('is-valid');
                                    addressInput.classList.remove('is-valid');
                                }, 2000);
                            }
                        })
                        .catch(() => {
                            if (spinner) spinner.classList.add('d-none');
                        });
                }, 400);
            });
        }

        // Used parts row builder & dynamic commission calculator
        const partsContainer = document.getElementById('parts-container');
        const btnAddPart = document.getElementById('btn-add-part');
        const inventoryItems = @json($inventoryItems);
        let partIndex = 0;

        function updateCommissionPreview() {
            const commissionTypeSelect = document.getElementById('commission_type');
            const commissionRateInput = document.getElementById('commission_rate');
            const estimatedCostInput = document.getElementById('estimated_cost');
            const repairChargeInput = document.getElementById('repair_charge');

            const repairCharge = parseFloat(repairChargeInput ? repairChargeInput.value : 0) || 0;

            // Sum up parts cost
            let totalPartsCost = 0;
            document.querySelectorAll('.part-row').forEach(row => {
                const price = parseFloat(row.querySelector('.input-buying-price').value) || 0;
                const qty = parseInt(row.querySelector('.input-quantity').value) || 1;
                totalPartsCost += price * qty;
            });

            // Estimated Cost = Service Fee / Charge + Total Parts Cost
            const estimatedCost = repairCharge + totalPartsCost;
            if (estimatedCostInput) {
                estimatedCostInput.value = estimatedCost.toFixed(2);
            }

            // Commission base is exactly the Repair Charge (Service Charge)
            const commissionBase = repairCharge;

            if (!commissionTypeSelect || !commissionRateInput) return;

            const commissionType = commissionTypeSelect.value;
            const commissionRate = parseFloat(commissionRateInput.value) || 0;

            let calculatedCommission = 0;

            if (commissionType === 'flat') {
                calculatedCommission = commissionRate;
            } else if (commissionType === 'percentage') {
                calculatedCommission = commissionBase * (commissionRate / 100);
            }

            // Display results
            let previewHtml = `
                <div class="alert alert-info border-0 shadow-sm p-3 mt-3 d-flex flex-column gap-1 small col-12">
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

        // Add row
        if (btnAddPart) {
            btnAddPart.addEventListener('click', function() {
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

                partsContainer.appendChild(newRow);
                
                // Initialize Tom Select on the newly created select element
                const selectEl = newRow.querySelector('.select-part-item');
                if (selectEl) {
                    const ts = new TomSelect(selectEl, {
                        create: false,
                        placeholder: "Search spare parts...",
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });
                    
                    ts.on('change', function(value) {
                        const nameInput = newRow.querySelector('.input-part-name');
                        const priceInput = newRow.querySelector('.input-buying-price');
                        if (value) {
                            const opt = selectEl.options[selectEl.selectedIndex];
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

                partIndex++;
                updateCommissionPreview();
            });
        }

        // Listen to changes in the parts table
        if (partsContainer) {
            partsContainer.addEventListener('change', function(e) {
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

            partsContainer.addEventListener('click', function(e) {
                const btnRemove = e.target.closest('.btn-remove-part');
                if (btnRemove) {
                    const row = btnRemove.closest('tr');
                    row.remove();
                    updateCommissionPreview();
                }
            });
        }

        // Bind events for live calculation
        const commTypeEl = document.getElementById('commission_type');
        const commRateEl = document.getElementById('commission_rate');
        const estimatedCostEl = document.getElementById('estimated_cost');

        if (commTypeEl) commTypeEl.addEventListener('change', updateCommissionPreview);
        if (commRateEl) commRateEl.addEventListener('input', updateCommissionPreview);
        if (estimatedCostEl) estimatedCostEl.addEventListener('input', updateCommissionPreview);

        // Run preview once on load
        updateCommissionPreview();

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
            patternSvg.innerHTML = '';
            if (activePattern.length === 0) return;

            let pathData = '';
            activePattern.forEach((dotIndex, idx) => {
                const dot = document.querySelector(`.pattern-dot[data-index="${dotIndex}"]`);
                const center = getDotCenter(dot, patternHolder);
                if (idx === 0) {
                    pathData += `M ${center.x} ${center.y}`;
                } else {
                    pathData += ` L ${center.x} ${center.y}`;
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
            patternSvg.innerHTML = '';
            patternPathInput.value = '';
            patternPathLabel.textContent = 'Path: None';
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
    });
</script>
@endsection
