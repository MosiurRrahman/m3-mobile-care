@extends('layouts/blankLayout')

@section('title', 'Book a Mobile Repair Request - M3 Mobile Care')

@section('content')
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <span class="fs-4 fw-bold text-primary">M3</span>
            <span class="fs-4 fw-bold text-white ms-1">Mobile Care</span>
        </a>
        <a class="btn btn-outline-light btn-sm ms-auto" href="{{ route('home') }}"><i class="ti tabler-arrow-left me-1"></i>Back to Home</a>
    </div>
</nav>

<div class="py-5 bg-light" style="min-height: 90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <span class="badge bg-label-primary px-3 py-1 mb-2">Booking Request</span>
                    <h2 class="fw-bold">Online Repair Booking</h2>
                    <p class="text-muted">Fill out the details below to book your repair appointment. We will contact you immediately.</p>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('book.store') }}" method="POST">
                            @csrf

                            <!-- Section 1: Customer Info -->
                            <h4 class="fw-bold mb-4 text-primary"><i class="ti tabler-user me-2"></i>1. Customer Information</h4>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="customer_name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="e.g. Rahim Ali" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="customer_phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="e.g. 01712345678" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label fw-semibold" for="customer_email">Email Address <span class="text-muted">(Optional)</span></label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="e.g. rahim@example.com">
                                    <div class="form-text">We'll use this to send repair updates and tracking credentials.</div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- Section 2: Device Info -->
                            <h4 class="fw-bold mb-4 text-primary"><i class="ti tabler-device-mobile me-2"></i>2. Device & Issue Information</h4>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="device_brand">Device Brand <span class="text-danger">*</span></label>
                                    <select name="device_brand" id="device_brand" class="form-select" required>
                                        <option value="" disabled selected>Select Brand</option>
                                        <option value="Apple">Apple (iPhone/iPad)</option>
                                        <option value="Samsung">Samsung</option>
                                        <option value="Xiaomi">Xiaomi / Redmi</option>
                                        <option value="Realme">Realme</option>
                                        <option value="Oppo">Oppo</option>
                                        <option value="Vivo">Vivo</option>
                                        <option value="OnePlus">OnePlus</option>
                                        <option value="Google">Google Pixel</option>
                                        <option value="Other">Other Brand</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="device_model">Device Model <span class="text-danger">*</span></label>
                                    <input type="text" name="device_model" id="device_model" class="form-control" placeholder="e.g. iPhone 13 Pro Max, Galaxy S21" required value="{{ request('model') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="service_type">Select Core Repair Service <span class="text-muted">(Optional)</span></label>
                                    <select name="service_type" id="service_type" class="form-select">
                                        <option value="" selected>Custom / Unlisted Service</option>
                                        @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }} ({{ number_format($service->price, 0) }} BDT)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="serial_imei">IMEI or Serial Number <span class="text-muted">(Optional)</span></label>
                                    <input type="text" name="serial_imei" id="serial_imei" class="form-control" placeholder="Enter IMEI to speed up service">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label fw-semibold" for="issue_description">Describe the Issue <span class="text-danger">*</span></label>
                                    <textarea name="issue_description" id="issue_description" rows="4" class="form-control" placeholder="Tell us what is wrong with the device (e.g., Cracked screen, screen has lines, touch is unresponsive, battery drains within 2 hours, charging port loose)." required></textarea>
                                </div>
                            </div>

                            <div class="p-3 bg-light rounded-3 mb-4 d-none" id="price_estimate_box">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-muted">Estimated Repair Price:</span>
                                    <span class="fs-4 fw-bold text-success" id="estimated_price_label">0.00 BDT</span>
                                </div>
                                <input type="hidden" name="estimated_cost" id="estimated_cost" value="0">
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3"><i class="ti tabler-check me-2"></i>Submit Booking Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_type');
        const priceBox = document.getElementById('price_estimate_box');
        const priceLabel = document.getElementById('estimated_price_label');
        const priceInput = document.getElementById('estimated_cost');

        // Initial setup for service if parameter passed
        const modelInput = document.getElementById('device_model').value;
        if(modelInput) {
            // Find option in select that matches
            for (let i = 0; i < serviceSelect.options.length; i++) {
                if (serviceSelect.options[i].text.includes(modelInput)) {
                    serviceSelect.selectedIndex = i;
                    updatePrice();
                    break;
                }
            }
        }

        serviceSelect.addEventListener('change', updatePrice);

        function updatePrice() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            if(price) {
                priceBox.classList.remove('d-none');
                const formattedPrice = parseFloat(price).toLocaleString('en-US') + ' BDT';
                priceLabel.innerText = formattedPrice;
                priceInput.value = price;
            } else {
                priceBox.classList.add('d-none');
                priceInput.value = 0;
            }
        }
    });
</script>
@endsection
