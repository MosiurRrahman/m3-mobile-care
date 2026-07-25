@extends('layouts.frontend')

@section('title', 'About Us - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">About us</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">About us</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- ABOUT COVER AREA START -->
<div class="ul-container">
    <div class="ul-about-cover-img">
        <img src="{{ asset('frontend/img/about-cover-img.jpg') }}" alt="Cover Image">
    </div>
</div>
<!-- ABOUT COVER AREA END -->

<!-- ABOUT SECTION START -->
<div class="ul-inner-page-container my-0">
    <section class="ul-about">
        <div class="row row-cols-md-2 row-cols-1 align-items-center ul-bs-row">
            <!-- txt -->
            <div class="col">
                <div class="ul-about-txt">
                    <span class="ul-section-sub-title">About us</span>
                    <h2 class="ul-section-title">Your Trusted Mobile Accessories & Repair Partner</h2>
                    <p>At M3 Mobile Care, we provide genuine smartphone chargers, fast-charging cables, durable back covers, 9H tempered glass, and high-fidelity earphones. Along with premium gadgets, our certified technicians offer quick repair services with transparent ticket tracking.</p>
                </div>
            </div>

            <!-- img -->
            <div class="col">
                <div class="ul-about-img"><img src="{{ asset('frontend/img/about-img-1.jpg') }}" alt="About Image"></div>
            </div>
        </div>
    </section>
</div>
<!-- ABOUT SECTION END -->

<!-- ABOUT SECTION START -->
<div class="ul-inner-page-container my-0">
    <section class="ul-about">
        <div class="row row-cols-md-2 row-cols-1 align-items-center ul-bs-row">
            <!-- img -->
            <div class="col">
                <div class="ul-about-img"><img src="{{ asset('frontend/img/about-img-2.jpg') }}" alt="About Image"></div>
            </div>

            <!-- txt -->
            <div class="col">
                <div class="ul-about-txt">
                    <span class="ul-section-sub-title">our commitment</span>
                    <h2 class="ul-section-title">Quality & Authenticity Guaranteed</h2>
                    <p>We source original mobile accessories from authentic manufacturers and test every repair job card thoroughly. Customer satisfaction and device safety are our top priorities.</p>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- ABOUT SECTION END -->

<!-- MORE ABOUT US SECTION START -->
<div class="ul-inner-page-container mb-0">
    <div class="ul-more-about">
        <div class="ul-more-about-heading">
            <h2 class="ul-section-title">Quality is our priority</h2>
            <p class="ul-more-about-heading-descr">Discover our wide collection of original smartphone accessories and expert device repair solutions.</p>
        </div>

        <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 ul-more-about-row">
            <div class="col">
                <div class="ul-more-about-point">
                    <h3 class="ul-more-about-point-title">Original Products</h3>
                    <p class="ul-more-about-point-descr">Authentic accessories tested for high durability and optimal charging speeds.</p>
                </div>
            </div>

            <div class="col">
                <div class="ul-more-about-point">
                    <h3 class="ul-more-about-point-title">Fast Delivery</h3>
                    <p class="ul-more-about-point-descr">Quick processing and delivery for all your mobile accessory orders.</p>
                </div>
            </div>

            <div class="col">
                <div class="ul-more-about-point">
                    <h3 class="ul-more-about-point-title">Expert Technicians</h3>
                    <p class="ul-more-about-point-descr">Certified repair specialists equipped with advanced diagnostics equipment.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MORE ABOUT US SECTION END -->
@endsection
