@extends('layouts/contentNavbarLayout')

@section('title', 'Special Order #' . $order->order_number . ' - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Special Order: <span class="text-primary">{{ $order->order_number }}</span></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.special-orders.index') }}">Special Orders</a></li>
                    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickStatusModal">
                <i class="ti tabler-refresh me-1"></i>Change Status
            </button>
            <a href="{{ route('admin.special-orders.print', $order->id) }}" target="_blank" class="btn btn-outline-secondary">
                <i class="ti tabler-printer me-1"></i>Print Slip
            </a>
            <a href="{{ route('admin.special-orders.edit', $order->id) }}" class="btn btn-primary">
                <i class="ti tabler-edit me-1"></i>Edit Order
            </a>
        </div>
    </div>

    <!-- Main Content Left Column -->
    <div class="col-lg-8">
        <!-- Requested Item Details -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="ti tabler-box me-2"></i>Requested Item & Sourcing Details</h5>
                    @php
                        $statusBadges = [
                            'pending' => 'bg-secondary',
                            'ordered_from_dhaka' => 'bg-warning text-dark',
                            'received_in_shop' => 'bg-info',
                            'delivered' => 'bg-success',
                            'cancelled' => 'bg-danger'
                        ];
                        $statusTitles = [
                            'pending' => 'অর্ডার গৃহীত (Pending)',
                            'ordered_from_dhaka' => 'ঢাকা থেকে আসার পথে (In Transit)',
                            'received_in_shop' => 'দোকানে পৌঁছেছে (Received)',
                            'delivered' => 'ডেলিভারি সম্পন্ন (Delivered)',
                            'cancelled' => 'বাতিল (Cancelled)'
                        ];
                    @endphp
                    <span class="badge {{ $statusBadges[$order->status] ?? 'bg-secondary' }} fs-6">
                        {{ $statusTitles[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Product / Part Name</label>
                        <h5 class="fw-bold text-dark mb-0">{{ $order->item_name }}</h5>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Device Brand & Model</label>
                        <span class="fw-bold text-dark">{{ trim(($order->brand ?? '') . ' ' . ($order->device_model ?? '')) ?: 'Not specified' }}</span>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Source / Sourcing Supplier</label>
                        <span class="badge bg-label-info"><i class="ti tabler-truck-delivery me-1"></i>{{ $order->source_supplier ?: 'Dhaka Motaleb Plaza' }}</span>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="small text-muted d-block mb-1">Expected Delivery Date</label>
                        <span class="fw-bold text-dark">{{ $order->expected_delivery_date ? $order->expected_delivery_date->format('d M, Y (l)') : 'Not Set' }}</span>
                    </div>
                    @if($order->notes)
                    <div class="col-12 mb-2">
                        <label class="small text-muted d-block mb-1">Notes & Specifications</label>
                        <p class="text-dark leading-relaxed p-3 bg-light rounded-3 mb-0">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Financial Breakdown Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-report-money me-2"></i>Financial & Profit Summary</h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="small text-muted d-block mb-1">Customer Price</span>
                            <h4 class="fw-bold text-dark mb-0">৳{{ number_format($order->selling_price, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="small text-muted d-block mb-1">Dhaka Buying Cost</span>
                            <h4 class="fw-bold text-danger mb-0">৳{{ number_format($order->estimated_cost, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="small text-muted d-block mb-1">Courier / Transport</span>
                            <h4 class="fw-bold text-warning text-dark mb-0">৳{{ number_format($order->courier_cost, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-label-success rounded-3">
                            <span class="small text-success d-block mb-1 fw-bold">Shop Net Profit</span>
                            <h4 class="fw-bold text-success mb-0">৳{{ number_format($order->estimated_profit, 2) }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Box -->
                <div class="p-4 rounded-3" style="background: {{ $order->due_amount > 0 ? 'linear-gradient(135deg, rgba(243, 156, 18, 0.08) 0%, rgba(230, 126, 34, 0.03) 100%)' : 'linear-gradient(135deg, rgba(46, 204, 113, 0.08) 0%, rgba(39, 174, 96, 0.03) 100%)' }}; border: 1px solid {{ $order->due_amount > 0 ? 'rgba(243, 156, 18, 0.25)' : 'rgba(46, 204, 113, 0.25)' }};">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <span class="small text-muted fw-bold text-uppercase">Payment Status</span>
                            <h5 class="fw-bold text-dark mb-1">
                                {{ $order->due_amount > 0 ? 'Advance Paid (Balance Due)' : 'Fully Paid & Settled' }}
                            </h5>
                            <div class="small text-muted">
                                Advance Deposit: <strong class="text-success">৳{{ number_format($order->advance_paid, 2) }}</strong> (via {{ $order->advance_payment_method ?? 'Cash' }})
                                @if($order->due_amount > 0)
                                    | Remaining Due: <strong class="text-danger">৳{{ number_format($order->due_amount, 2) }}</strong>
                                @endif
                            </div>
                        </div>
                        @if($order->due_amount > 0)
                        <button type="button" class="btn btn-warning fw-bold px-3" data-bs-toggle="modal" data-bs-target="#payDueModal">
                            <i class="ti tabler-cash me-1"></i>Collect Due ৳{{ number_format($order->due_amount, 0) }}
                        </button>
                        @else
                        <span class="badge bg-success px-3 py-2 fs-6"><i class="ti tabler-circle-check me-1"></i>Paid in Full</span>
                        @endif
                    </div>
                </div>

                <!-- Payment Logs -->
                @if($paymentLogs->count() > 0)
                <div class="mt-4 border-top pt-3">
                    <h6 class="fw-bold text-dark mb-2">Payment History Logs</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Type</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M, Y h:i A') }}</td>
                                    <td>{{ $log->payment_method }}</td>
                                    <td><span class="badge bg-label-info">{{ ucfirst(str_replace('_', ' ', $log->transaction_type)) }}</span></td>
                                    <td class="text-end fw-bold text-dark">৳{{ number_format($log->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Sidebar Column -->
    <div class="col-lg-4">
        <!-- Customer Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3"><i class="ti tabler-user me-2"></i>Customer Info</h5>
                <div class="mb-3">
                    <label class="small text-muted d-block mb-1">Customer Name</label>
                    <h6 class="fw-bold text-dark mb-0">{{ $order->customer_name }}</h6>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block mb-1">Phone Number</label>
                    <a href="tel:{{ $order->customer_phone }}" class="fw-bold text-primary text-decoration-none">
                        <i class="ti tabler-phone me-1"></i>{{ $order->customer_phone }}
                    </a>
                </div>
                <div>
                    <label class="small text-muted d-block mb-1">Booked By / Staff</label>
                    <span class="text-dark">{{ $order->creator ? $order->creator->name : 'Admin' }} ({{ $order->created_at->format('d M, Y h:i A') }})</span>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-git-commit me-2"></i>Order Lifecycle</h5>

                <div class="position-relative ps-4" style="border-left: 2px dashed #cbd5e1; margin-left: 15px;">
                    <!-- Step 1: Order Placed -->
                    <div class="mb-4 position-relative">
                        <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white bg-success" 
                             style="left: -32px; top: 0; width: 30px; height: 30px;">
                            <i class="ti tabler-shopping-cart fs-6"></i>
                        </div>
                        <div class="ps-2">
                            <h6 class="fw-bold mb-0 text-success">অর্ডার গ্রহণ করা হয়েছে</h6>
                            <small class="text-muted">{{ $order->created_at->format('d M, Y h:i A') }}</small>
                        </div>
                    </div>

                    <!-- Step 2: Ordered from Dhaka -->
                    @php $isDhaka = in_array($order->status, ['ordered_from_dhaka', 'received_in_shop', 'delivered']); @endphp
                    <div class="mb-4 position-relative">
                        <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white {{ $isDhaka ? 'bg-primary' : 'bg-secondary' }}" 
                             style="left: -32px; top: 0; width: 30px; height: 30px;">
                            <i class="ti tabler-truck-delivery fs-6"></i>
                        </div>
                        <div class="ps-2">
                            <h6 class="fw-bold mb-0 {{ $isDhaka ? 'text-primary' : 'text-muted' }}">ঢাকা থেকে পাঠানো হয়েছে</h6>
                            <small class="text-muted">কুরিয়ার বা মহাজন থেকে পার্টস বুকড</small>
                        </div>
                    </div>

                    <!-- Step 3: Received in Shop -->
                    @php $isReceived = in_array($order->status, ['received_in_shop', 'delivered']); @endphp
                    <div class="mb-4 position-relative">
                        <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white {{ $isReceived ? 'bg-info' : 'bg-secondary' }}" 
                             style="left: -32px; top: 0; width: 30px; height: 30px;">
                            <i class="ti tabler-building-store fs-6"></i>
                        </div>
                        <div class="ps-2">
                            <h6 class="fw-bold mb-0 {{ $isReceived ? 'text-info' : 'text-muted' }}">দোকানে পৌঁছেছে</h6>
                            <small class="text-muted">{{ $order->received_at ? $order->received_at->format('d M, Y h:i A') : 'অপেক্ষমান' }}</small>
                        </div>
                    </div>

                    <!-- Step 4: Delivered -->
                    @php $isDelivered = ($order->status === 'delivered'); @endphp
                    <div class="mb-2 position-relative">
                        <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white {{ $isDelivered ? 'bg-success' : 'bg-secondary' }}" 
                             style="left: -32px; top: 0; width: 30px; height: 30px;">
                            <i class="ti tabler-circle-check fs-6"></i>
                        </div>
                        <div class="ps-2">
                            <h6 class="fw-bold mb-0 {{ $isDelivered ? 'text-success' : 'text-muted' }}">কাস্টমারকে ডেলিভারি সম্পন্ন</h6>
                            <small class="text-muted">{{ $order->delivered_at ? $order->delivered_at->format('d M, Y h:i A') : 'ডেলিভারি বাকি' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pay Due Modal -->
@if($order->due_amount > 0)
<div class="modal fade" id="payDueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.special-orders.pay-due', $order->id) }}">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="ti tabler-cash text-success me-2"></i>Collect Customer Due Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="alert alert-info mb-3">
                        Collecting remaining balance for order: <strong>{{ $order->order_number }}</strong> ({{ $order->item_name }})
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Outstanding Due</label>
                        <input type="text" class="form-control bg-light" readonly value="৳{{ number_format($order->due_amount, 2) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="amount_paid">Amount to Collect (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="amount_paid" id="amount_paid" class="form-control" step="0.01" min="0.01" max="{{ $order->due_amount }}" value="{{ $order->due_amount }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="payment_method">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="Cash">Cash (নগদ)</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="ti tabler-check me-1"></i>Confirm & Save Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Quick Status Modal -->
<div class="modal fade" id="quickStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.special-orders.quick-status', $order->id) }}">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold text-dark"><i class="ti tabler-refresh text-primary me-2"></i>Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="qs_status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="qs_status" class="form-select fw-bold" required onchange="toggleFinalPayment(this.value)">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>১. অর্ডার গৃহীত (Pending)</option>
                            <option value="ordered_from_dhaka" {{ $order->status == 'ordered_from_dhaka' ? 'selected' : '' }}>২. ঢাকা থেকে পাঠানো হয়েছে (In Transit)</option>
                            <option value="received_in_shop" {{ $order->status == 'received_in_shop' ? 'selected' : '' }}>৩. দোকানে এসে পৌঁছেছে (Received in Shop - Auto SMS to customer)</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>৪. কাস্টমারকে ডেলিভারি সম্পন্ন (Delivered)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>বাতিল (Cancelled)</option>
                        </select>
                    </div>

                    <div id="final_payment_wrapper" class="mb-3" style="display: {{ $order->status === 'delivered' ? 'block' : 'none' }};">
                        <label class="form-label fw-semibold" for="delivery_payment_method">Final Delivery Payment Method</label>
                        <select name="delivery_payment_method" id="delivery_payment_method" class="form-select">
                            <option value="Cash">Cash (নগদ)</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="qs_notes">Status Note / Update</label>
                        <textarea name="notes" id="qs_notes" class="form-control" rows="3" placeholder="যেমন: সুন্দরবন কুরিয়ার ট্র্যাকিং #123456..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="ti tabler-check me-1"></i>Save Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleFinalPayment(val) {
    const wrapper = document.getElementById('final_payment_wrapper');
    if (wrapper) {
        wrapper.style.display = (val === 'delivered') ? 'block' : 'none';
    }
}
</script>
@endsection
