@extends('layouts.frontend')

@section('title', 'Checkout - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Checkout</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Checkout</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- CHECKOUT SECTION START -->
<div class="ul-cart-container">
    @if(session('error'))
        <div class="alert alert-danger mb-4 rounded-3 p-3">
            {{ session('error') }}
        </div>
    @endif

    <h3 class="ul-checkout-title">Billing & Delivery Details</h3>
    <form action="{{ route('checkout.process') }}" method="POST" class="ul-checkout-form">
        @csrf
        <div class="row ul-bs-row row-cols-2 row-cols-xxs-1">
            <!-- left side / billing form -->
            <div class="col">
                <div class="row row-cols-lg-2 row-cols-1 ul-bs-row">
                    <!-- full name -->
                    <div class="form-group col-lg-12">
                        <label for="fullname">Full Name*</label>
                        <input type="text" name="fullname" id="fullname" placeholder="Enter Your Full Name" value="{{ old('fullname') }}" required>
                    </div>

                    <!-- phone -->
                    <div class="form-group">
                        <label for="phone">Phone Number*</label>
                        <input type="text" name="phone" id="phone" placeholder="01700-000000" value="{{ old('phone') }}" required>
                    </div>

                    <!-- email -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="customer@example.com" value="{{ old('email') }}">
                    </div>

                    <!-- city -->
                    <div class="form-group">
                        <label for="city">District / City*</label>
                        <input type="text" name="city" id="city" placeholder="e.g. Dhaka, Chittagong..." value="{{ old('city') }}" required>
                    </div>

                    <!-- area -->
                    <div class="form-group">
                        <label for="state">Area / Thana*</label>
                        <input type="text" name="state" id="state" placeholder="e.g. Dhanmondi, Mirpur..." value="{{ old('state') }}" required>
                    </div>

                    <!-- full address -->
                    <div class="form-group col-lg-12">
                        <label for="address1">Delivery Address*</label>
                        <input type="text" name="address1" id="address1" placeholder="House No, Road No, Area Details..." value="{{ old('address1') }}" required>
                    </div>
                </div>
            </div>

            <!-- right side / payment & notes -->
            <div class="col">
                <div class="form-group">
                    <label for="ul-checkout-different-address-field">Order Notes (Optional)</label>
                    <textarea name="different-address" id="ul-checkout-different-address-field" placeholder="Special delivery instructions, timing or preferences..."></textarea>
                </div>

                <!-- payment options -->
                <div class="ul-checkout-payment-methods mt-4">
                    <div class="form-group">
                        <label for="payment-option-1" class="d-flex align-items-center gap-2 cursor-pointer">
                            <input type="radio" name="payment_methods" id="payment-option-1" value="COD" checked>
                            <span class="title fw-bold">Cash on Delivery (COD)</span>
                        </label>
                        <p class="text-muted small mt-1 ms-4">Pay with cash upon receiving your accessories nationwide.</p>
                    </div>

                    <div class="form-group mt-3">
                        <label for="payment-option-2" class="d-flex align-items-center gap-2 cursor-pointer">
                            <input type="radio" name="payment_methods" id="payment-option-2" value="bKash">
                            <span class="title fw-bold">bKash / Nagad / Rocket (MFS)</span>
                        </label>
                        <p class="text-muted small mt-1 ms-4">Send payment to our official merchant wallet number.</p>
                    </div>
                </div>

                <button type="submit" class="ul-btn w-100 text-center justify-content-center mt-4">PLACE ORDER NOW <i class="flaticon-up-right-arrow"></i></button>
            </div>
        </div>
    </form>
</div>
<!-- CHECKOUT SECTION END -->
@endsection
