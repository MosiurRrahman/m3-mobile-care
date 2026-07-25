@extends('layouts/contentNavbarLayout')

@section('title', 'Order #' . $order->invoice_no . ' - Admin Panel')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Order #{{ $order->invoice_no }}</h4>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('d F Y, h:i A') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary me-2"><i class="ti tabler-arrow-left me-1"></i>Back to Orders</a>
            <button onclick="window.print();" class="btn btn-primary"><i class="ti tabler-printer me-1"></i>Print Invoice</button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="ti tabler-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Order details column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Ordered Accessories Items</h5>
                    <span class="badge bg-label-primary fs-6">{{ $order->details->count() }} Item(s)</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $detail->item ? $detail->item->image_url : asset('frontend/img/product-img-1.jpg') }}" alt="item" class="rounded border" style="width: 45px; height: 45px; object-fit: contain;">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $detail->item->name ?? 'Accessory Item' }}</div>
                                                <small class="text-muted">SKU: {{ $detail->item->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="fw-bold fs-6">{{ $detail->quantity }}</span></td>
                                    <td class="text-end">৳{{ number_format($detail->sale_price, 2) }}</td>
                                    <td class="text-end fw-bold text-dark">৳{{ number_format($detail->sale_price * $detail->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                <td class="text-end fw-bold">৳{{ number_format($order->total_amount - 60, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Shipping Charge:</td>
                                <td class="text-end fw-bold">৳60.00</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-5 text-dark">Total Amount Payable:</td>
                                <td class="text-end fw-bold fs-5 text-success">৳{{ number_format($order->payable_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer & Order Status column -->
        <div class="col-lg-4">
            <!-- Order status card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Update Order Status</h5>
                </div>
                <div class="card-body py-4">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Delivery Fulfillment Status</label>
                            <select name="status" id="status" class="form-select form-select-lg">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing / Dispatched</option>
                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="ti tabler-refresh me-1"></i>Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Customer details card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Customer & Shipping Details</h5>
                </div>
                <div class="card-body py-4">
                    <div class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-semibold">Customer Name</small>
                        <span class="fw-bold text-dark fs-6">{{ $order->customer->name ?? 'Guest' }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-semibold">Phone Number</small>
                        <span class="fw-bold text-primary fs-6">{{ $order->customer->phone ?? 'N/A' }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-semibold">Email Address</small>
                        <span>{{ $order->customer->email ?? 'N/A' }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-semibold">Delivery Address</small>
                        <p class="mb-0 text-dark">{{ $order->customer->address ?? 'N/A' }}, {{ $order->customer->district ?? '' }}</p>
                    </div>

                    <div class="mb-0 pt-3 border-top">
                        <small class="text-muted d-block text-uppercase fw-semibold">Payment Method</small>
                        <span class="badge bg-label-success fs-6 text-uppercase">{{ $order->payment_method ?? 'COD' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
