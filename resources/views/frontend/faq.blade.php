@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Frequently Asked Questions</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">FAQ</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- FAQ SECTION START -->
<section class="ul-faq">
    <div class="ul-inner-page-container">
        <div class="ul-accordion">
            <div class="ul-single-accordion-item open">
                <div class="ul-single-accordion-item__header">
                    <div class="left">
                        <h3 class="ul-single-accordion-item__title">Are the mobile accessories genuine & original?</h3>
                    </div>
                    <span class="icon"><i class="flaticon-plus"></i></span>
                </div>
                <div class="ul-single-accordion-item__body">
                    <p class="mb-0">Yes! All chargers, fast cables, back covers, and tempered glass at M3 Mobile Care are 100% genuine and quality checked before sale.</p>
                </div>
            </div>

            <div class="ul-single-accordion-item">
                <div class="ul-single-accordion-item__header">
                    <div class="left">
                        <h3 class="ul-single-accordion-item__title">How can I track my phone repair ticket status?</h3>
                    </div>
                    <span class="icon"><i class="flaticon-plus"></i></span>
                </div>
                <div class="ul-single-accordion-item__body">
                    <p class="mb-0">You can enter your Ticket ID (e.g. M3-2026-XXXX) on the "Track Ticket" page or homepage search bar to view real-time technician status.</p>
                </div>
            </div>

            <div class="ul-single-accordion-item">
                <div class="ul-single-accordion-item__header">
                    <div class="left">
                        <h3 class="ul-single-accordion-item__title">What delivery options are available for accessories?</h3>
                    </div>
                    <span class="icon"><i class="flaticon-plus"></i></span>
                </div>
                <div class="ul-single-accordion-item__body">
                    <p class="mb-0">We offer home delivery nationwide with Cash on Delivery (COD) as well as instant store pickup.</p>
                </div>
            </div>

            <div class="ul-single-accordion-item">
                <div class="ul-single-accordion-item__header">
                    <div class="left">
                        <h3 class="ul-single-accordion-item__title">How do I book an online repair service?</h3>
                    </div>
                    <span class="icon"><i class="flaticon-plus"></i></span>
                </div>
                <div class="ul-single-accordion-item__body">
                    <p class="mb-0">Click on "Book Repair" in the navigation bar, fill in your device model and issue description, and our team will contact you with an estimate.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ SECTION END -->
@endsection
