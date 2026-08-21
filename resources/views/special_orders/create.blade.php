@extends('layouts/contentNavbarLayout')

@section('title', 'New Customer Special Order - M3 Mobile Care')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">📦 New Customer Special Order (প্রি-অর্ডার বুকিং)</h4>
                <span class="text-muted">কাস্টমারের কাঙ্ক্ষিত পার্টস বা প্রোডাক্ট ঢাকা থেকে আনার জন্য এন্ট্রি</span>
            </div>
            <a href="{{ route('admin.special-orders.index') }}" class="btn btn-outline-secondary">
                <i class="ti tabler-arrow-left me-1"></i>Back to List
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.special-orders.store') }}" method="POST">
                    @csrf

                    <!-- 1. Customer Information -->
                    <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-user me-2"></i>1. Customer Information (গ্রাহক বিবরণ)</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="customer_phone">Customer Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti tabler-phone"></i></span>
                                <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="e.g. 01712345678" value="{{ old('customer_phone') }}" required autocomplete="off">
                            </div>
                            <div class="form-text small">মোবাইল নম্বর লিখলে পূর্বের কাস্টমার স্বয়ংক্রিয়ভাবে লোড হবে।</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="customer_name">Customer Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="e.g. Sakib Al Hasan" value="{{ old('customer_name') }}" required>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- 2. Requested Product / Part Details -->
                    <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-box me-2"></i>2. Requested Product / Spare Part (পার্টস ও প্রোডাক্ট বিবরণ)</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="item_name">Product / Part Name <span class="text-danger">*</span></label>
                            <input type="text" name="item_name" id="item_name" class="form-control" placeholder="যেমন: iPhone 13 Pro Max Original Backshell Blue / Samsung S21 OLED" value="{{ old('item_name') }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold" for="brand">Device Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control" placeholder="যেমন: Apple, Samsung, Xiaomi" value="{{ old('brand') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold" for="device_model">Model / Specs</label>
                            <input type="text" name="device_model" id="device_model" class="form-control" placeholder="যেমন: 13 Pro Max / Note 11" value="{{ old('device_model') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="source_supplier">Source / Sourcing Supplier (পার্টসের উৎস)</label>
                            <input type="text" name="source_supplier" id="source_supplier" class="form-control" placeholder="যেমন: ঢাকা মোতালেব প্লাজা / রাসেল টেলিকম / সুন্দরবন কুরিয়ার" value="{{ old('source_supplier', 'ঢাকা মোতালেব প্লাজা') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="expected_delivery_date">Expected Delivery Date (সম্ভাব্য ডেলিভারি তারিখ)</label>
                            <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date', date('Y-m-d', strtotime('+3 days'))) }}">
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- 3. Financials, Advance & Profit Breakdown -->
                    <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-report-money me-2"></i>3. Costs, Customer Price & Profit (হিসাব ও প্রফিট)</h5>
                    <div class="row mb-3">
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="estimated_cost">Dhaka Buying Cost (৳) <span class="text-danger">*</span></label>
                            <input type="number" name="estimated_cost" id="estimated_cost" class="form-control text-end calc-input" step="0.01" min="0" placeholder="0.00" value="{{ old('estimated_cost', 0) }}" required>
                            <div class="form-text small">ঢাকা থেকে কেনার খরচ</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="courier_cost">Courier / Transport (৳)</label>
                            <input type="number" name="courier_cost" id="courier_cost" class="form-control text-end calc-input" step="0.01" min="0" placeholder="0.00" value="{{ old('courier_cost', 100) }}">
                            <div class="form-text small">কুরিয়ার বা যাতায়াত চার্জ</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="selling_price">Customer Selling Price (৳) <span class="text-danger">*</span></label>
                            <input type="number" name="selling_price" id="selling_price" class="form-control text-end calc-input fw-bold text-dark" step="0.01" min="0" placeholder="0.00" value="{{ old('selling_price', 0) }}" required>
                            <div class="form-text small">কাস্টমারের মোট বিক্রয়মূল্য</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="advance_paid">Advance Deposit (৳)</label>
                            <input type="number" name="advance_paid" id="advance_paid" class="form-control text-end calc-input" step="0.01" min="0" placeholder="0.00" value="{{ old('advance_paid', 0) }}">
                            <div class="form-text small">কাস্টমার অগ্রিম জমা</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold" for="advance_payment_method">Advance Payment Method</label>
                            <select name="advance_payment_method" id="advance_payment_method" class="form-select">
                                <option value="Cash">Cash (নগদ)</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold" for="status">Initial Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" selected>১. অর্ডার গৃহীত (Pending)</option>
                                <option value="ordered_from_dhaka">২. ঢাকা থেকে আসার পথে (In Transit)</option>
                                <option value="received_in_shop">৩. দোকানে এসে পৌঁছেছে (Received)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Calculated Due Amount</label>
                            <input type="text" id="preview_due" class="form-control bg-light text-danger fw-bold text-end" value="0.00 BDT" readonly>
                        </div>
                    </div>

                    <!-- Live Profit Card -->
                    <div class="p-3 bg-label-success rounded-3 d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="fw-bold text-success d-block"><i class="ti tabler-sparkles me-1"></i>Expected Shop Net Profit (আনুমানিক নিট লাভ)</span>
                            <small class="text-muted">বিক্রয় মূল্য - (ঢাকা কেনার খরচ + কুরিয়ার)</small>
                        </div>
                        <h3 class="fw-bold text-success mb-0" id="preview_profit">৳0.00</h3>
                    </div>

                    <!-- 4. Notes -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="notes">Special Order Notes & Requirements</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="যেমন: কাস্টমার বলেছে অরিজিনাল কালার হতে হবে, কপি হলে নিবে না...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.special-orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti tabler-check me-1"></i>Save & Create Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const costInput = document.getElementById('estimated_cost');
    const courierInput = document.getElementById('courier_cost');
    const sellingInput = document.getElementById('selling_price');
    const advanceInput = document.getElementById('advance_paid');
    const previewDue = document.getElementById('preview_due');
    const previewProfit = document.getElementById('preview_profit');

    function calculateFinancials() {
        const cost = parseFloat(costInput.value) || 0;
        const courier = parseFloat(courierInput.value) || 0;
        const selling = parseFloat(sellingInput.value) || 0;
        const advance = parseFloat(advanceInput.value) || 0;

        const due = Math.max(0, selling - advance);
        const profit = Math.max(0, selling - (cost + courier));

        previewDue.value = due.toFixed(2) + ' BDT';
        previewProfit.innerText = '৳' + profit.toFixed(2);
    }

    document.querySelectorAll('.calc-input').forEach(input => {
        input.addEventListener('input', calculateFinancials);
    });

    calculateFinancials();

    // Customer auto-lookup by mobile number
    const phoneInput = document.getElementById('customer_phone');
    const nameInput = document.getElementById('customer_name');

    if (phoneInput && nameInput) {
        phoneInput.addEventListener('blur', function() {
            const phone = this.value.trim();
            if (phone.length >= 11) {
                fetch(`/admin/customers/lookup?phone=${encodeURIComponent(phone)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.name) {
                            nameInput.value = data.name;
                        }
                    })
                    .catch(() => {});
            }
        });
    }
});
</script>
@endsection
