@extends('layouts/contentNavbarLayout')

@section('title', 'Create Job Card - M3 Mobile Care')

@section('content')
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
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold text-primary mb-0"><i class="ti tabler-user me-2"></i>1. Customer Information</h5>
                            {{-- <small class="text-muted"><i class="ti tabler-info-circle me-1"></i>নাম বা মোবাইল নম্বর না থাকলে খালি রেখে সাবমিট করতে পারেন (Walk-in হিসেবে সেভ হবে)</small> --}}
                        </div>
                        <button type="button" id="btn-quick-walkin" class="btn btn-sm btn-outline-secondary">
                            <i class="ti tabler-user-check me-1"></i>Set Walk-in Customer
                        </button>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0 position-relative">
                            <label class="form-label fw-semibold" for="customer_phone">Mobile Number <span class="text-muted small fw-normal">(Optional)</span></label>
                            <div class="input-group">
                                <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="e.g. 01712345678 (ঐচ্ছিক)" autocomplete="off">
                                <span class="input-group-text d-none" id="customer-lookup-spinner" style="background: transparent;">
                                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="customer_name">Customer Name <span class="text-muted small fw-normal">(Optional -: Walk-in)</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="e.g. John Doe / Walk-in">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="customer_address">Address <span class="text-muted small fw-normal">(Optional)</span></label>
                            <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ old('customer_address') }}" placeholder="e.g. Dhaka, Bangladesh">
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- SECTION 2: Device Details -->
                    <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-device-mobile me-2"></i>2. Device Information</h5>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="device_model">Brand & Model Name / Number <span class="text-danger">*</span></label>
                            <input type="text" name="device_model" id="device_model" class="form-control" value="{{ old('device_model') }}" placeholder="e.g. Samsung Galaxy S21 / iPhone 13 Pro Max" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="issue_description">Issue Description & Remarks <span class="text-danger">*</span></label>
                            <textarea name="issue_description" id="issue_description" rows="3" class="form-control" placeholder="Describe faults (e.g. Glass cracked, touch dead, microphone sound low)..." required>{{ old('issue_description') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- SECTION 2.5: Device Photos -->
                    <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-camera me-2"></i>2.5 Device Photos</h5>
                    <div class="row mb-4">
                        <div class="col-12">
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
                                <option value="waiting_for_parts" {{ old('status') == 'waiting_for_parts' ? 'selected' : '' }}>Waiting for Parts</option>
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

                    <div class="row mb-4">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="repair_charge">Repair Charge / Service Fee (BDT)</label>
                            <input type="number" name="repair_charge" id="repair_charge" step="0.01" min="0" class="form-control" value="{{ old('repair_charge') }}" placeholder="0.00">
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="estimated_cost">Estimated Cost (BDT)</label>
                            <input type="number" name="estimated_cost" id="estimated_cost" step="0.01" min="0" class="form-control bg-light" value="{{ old('estimated_cost') }}" placeholder="0.00" readonly>
                            <div class="form-text small">Auto-calculated (Service Fee + Parts)</div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="advance_payment">Advance Deposit Paid (BDT)</label>
                            <input type="number" name="advance_payment" id="advance_payment" step="0.01" min="0" class="form-control" value="{{ old('advance_payment') }}" placeholder="0.00">
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

                    <!-- SECTION: Installed Spare Parts -->
                    <div class="mb-4 p-3 bg-light rounded border">
                        <h6 class="fw-bold mb-3 text-dark"><i class="ti tabler-box me-1 text-primary"></i>Installed Spare Parts & Outsourced Sourcing</h6>
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold" for="used_parts_name">Parts Name <span class="text-muted small fw-normal">(Optional)</span></label>
                                <input type="text" name="used_parts[0][name]" id="used_parts_name" class="form-control" placeholder="e.g. Display / Battery / Charging Port" value="{{ old('used_parts.0.name') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold" for="used_parts_price">Parts Price / Buying Cost (BDT) <span class="text-muted small fw-normal">(Optional)</span></label>
                                <input type="number" name="used_parts[0][buying_price]" id="used_parts_price" step="0.01" min="0" class="form-control" placeholder="0.00" value="{{ old('used_parts.0.buying_price') }}">
                                <input type="hidden" name="used_parts[0][quantity]" value="1">
                                <input type="hidden" name="used_parts[0][source]" value="other">
                            </div>
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
        const repairChargeInput = document.getElementById('repair_charge');

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

        const btnQuickWalkin = document.getElementById('btn-quick-walkin');
        if (btnQuickWalkin) {
            btnQuickWalkin.addEventListener('click', function(e) {
                e.preventDefault();
                if (nameInput) nameInput.value = 'Walk-in Customer';
                if (phoneInput) phoneInput.value = '';
                if (addressInput) addressInput.value = '';
            });
        }

        // Auto calculate estimated cost (Service charge + Parts price)
        const partPriceInput = document.getElementById('used_parts_price');
        const estimatedCostInput = document.getElementById('estimated_cost');

        function updateEstimatedCost() {
            const charge = parseFloat(repairChargeInput ? repairChargeInput.value : 0) || 0;
            const partCost = parseFloat(partPriceInput ? partPriceInput.value : 0) || 0;
            const total = charge + partCost;
            if (estimatedCostInput) {
                estimatedCostInput.value = total > 0 ? total.toFixed(2) : '';
            }
        }

        if (repairChargeInput) {
            repairChargeInput.addEventListener('input', updateEstimatedCost);
        }
        if (partPriceInput) {
            partPriceInput.addEventListener('input', updateEstimatedCost);
        }
        updateEstimatedCost();
    });
</script>
@endsection
