@extends('layouts.frontend')

@section('title', 'Order Confirmation - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Order Confirmed!</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Order Success</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-inner-page-container">
    <div class="ul-container">
        <div class="text-center py-4 mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle mb-3" style="width: 80px; height: 80px;">
                <i class="flaticon-check-mark display-4"></i>
            </div>
            <h2 class="fw-bold text-success">Thank You For Your Order!</h2>
            <p class="text-muted">Your order has been placed successfully. Below is your invoice summary.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 max-w-700 mx-auto" style="max-width: 750px; margin: 0 auto; background: #ffffff;">
            <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                <div>
                    <h5 class="fw-bold mb-0">Invoice #{{ $sale->invoice_no }}</h5>
                    <span class="text-muted small">Date: {{ $sale->created_at->format('d M, Y h:i A') }}</span>
                </div>
                <span class="badge bg-success px-3 py-2 fs-6">Status: Pending Delivery</span>
            </div>

            <!-- Customer details -->
            <div class="mb-4 bg-light p-3 rounded-3">
                <h6 class="fw-bold text-dark mb-2">Customer & Delivery Info</h6>
                <p class="mb-1"><strong>Name:</strong> {{ $sale->customer->name ?? 'Guest Customer' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $sale->customer->phone ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Delivery Address:</strong> {{ $sale->customer->address ?? '' }}, {{ $sale->customer->district ?? '' }}</p>
                <p class="mb-0"><strong>Payment Method:</strong> {{ strtoupper($sale->payment_method) }}</p>
            </div>

            <!-- Items table -->
            <h6 class="fw-bold text-dark mb-2">Ordered Accessories</h6>
            <div class="table-responsive mb-3">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->details as $detail)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $detail->item ? $detail->item->image_url : asset('frontend/img/product-img-1.jpg') }}" alt="item" style="width: 40px; height: 40px; object-fit: contain;">
                                        <span class="fw-semibold">{{ $detail->item->name ?? 'Accessory Item' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-end">৳{{ number_format($detail->sale_price, 2) }}</td>
                                <td class="text-end fw-bold">৳{{ number_format($detail->sale_price * $detail->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between pt-3 border-top fw-bold fs-5 text-dark">
                <span>Total Amount Payable:</span>
                <span class="text-primary">৳{{ number_format($sale->payable_amount, 2) }}</span>
            </div>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ route('shop.catalog') }}" class="ul-btn">Continue Shopping <i class="flaticon-up-right-arrow"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection
