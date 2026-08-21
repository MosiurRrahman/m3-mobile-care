@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Special Order #' . $order->order_number . ' - M3 Mobile Care')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Edit Special Order: <span class="text-primary">{{ $order->order_number }}</span></h4>
                <span class="text-muted">অর্ডার তথ্য, সাপ্লায়ার খরচ ও পেমেন্ট আপডেট</span>
            </div>
            <a href="{{ route('admin.special-orders.show', $order->id) }}" class="btn btn-outline-secondary">
                <i class="ti tabler-arrow-left me-1"></i>Back to Order
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.special-orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- 1. Customer Information -->
                    <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-user me-2"></i>1. Customer Information (গ্রাহক বিবরণ)</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="customer_phone">Customer Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti tabler-phone"></i></span>
                                <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{ old('customer_phone', $order->customer_phone) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="customer_name">Customer Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}" required>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- 2. Requested Product / Part Details -->
                    <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-box me-2"></i>2. Requested Product / Spare Part (পার্টস ও প্রোডাক্ট বিবরণ)</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="item_name">Product / Part Name <span class="text-danger">*</span></label>
                            <input type="text" name="item_name" id="item_name" class="form-control" value="{{ old('item_name', $order->item_name) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold" for="brand">Device Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $order->brand) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold" for="device_model">Model / Specs</label>
                            <input type="text" name="device_model" id="device_model" class="form-control" value="{{ old('device_model', $order->device_model) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="source_supplier">Source / Sourcing Supplier (পার্টসের উৎস)</label>
                            <input type="text" name="source_supplier" id="source_supplier" class="form-control" value="{{ old('source_supplier', $order->source_supplier) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" for="expected_delivery_date">Expected Delivery Date (সম্ভাব্য ডেলিভারি)</label>
                            <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date', $order->expected_delivery_date ? $order->expected_delivery_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- 3. Financials, Advance & Profit Breakdown -->
                    <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-report-money me-2"></i>3. Costs, Customer Price & Profit (হিসাব ও প্রফিট)</h5>
                    <div class="row mb-3">
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="estimated_cost">Dhaka Buying Cost (৳) <span class="text-danger">*</span></label>
                            <input type="number" name="estimated_cost" id="estimated_cost" class="form-control text-end calc-input" step="0.01" min="0" value="{{ old('estimated_cost', $order->estimated_cost) }}" required>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="courier_cost">Courier / Transport (৳)</label>
                            <input type="number" name="courier_cost" id="courier_cost" class="form-control text-end calc-input" step="0.01" min="0" value="{{ old('courier_cost', $order->courier_cost) }}">
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="selling_price">Customer Selling Price (৳) <span class="text-danger">*</span></label>
                            <input type="number" name="selling_price" id="selling_price" class="form-control text-end calc-input fw-bold text-dark" step="0.01" min="0" value="{{ old('selling_price', $order->selling_price) }}" required>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <label class="form-label fw-semibold" for="advance_paid">Advance Deposit (৳)</label>
                            <input type="number" name="advance_paid" id="advance_paid" class="form-control text-end calc-input" step="0.01" min="0" value="{{ old('advance_paid', $order->advance_paid) }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold" for="status">Order Status</label>
                            <select name="status" id="status" class="form-select fw-bold border-primary text-primary">
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>১. অর্ডার গৃহীত (Pending)</option>
                                <option value="ordered_from_dhaka" {{ old('status', $order->status) == 'ordered_from_dhaka' ? 'selected' : '' }}>২. ঢাকা থেকে আসার পথে (In Transit)</option>
                                <option value="received_in_shop" {{ old('status', $order->status) == 'received_in_shop' ? 'selected' : '' }}>৩. দোকানে এসে পৌঁছেছে (Received)</option>
                                <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>৪. কাস্টমারকে ডেলিভারি সম্পন্ন (Delivered)</option>
                                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>বাতিল (Cancelled)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold" for="advance_payment_method">Advance Method</label>
                            <select name="advance_payment_method" id="advance_payment_method" class="form-select">
                                <option value="Cash" {{ old('advance_payment_method', $order->advance_payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bKash" {{ old('advance_payment_method', $order->advance_payment_method) == 'bKash' ? 'selected' : '' }}>bKash</option>
                                <option value="Nagad" {{ old('advance_payment_method', $order->advance_payment_method) == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                <option value="Rocket" {{ old('advance_payment_method', $order->advance_payment_method) == 'Rocket' ? 'selected' : '' }}>Rocket</option>
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
                        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.special-orders.show', $order->id) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti tabler-device-floppy me-1"></i>Save Changes
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
});
</script>
@endsection
