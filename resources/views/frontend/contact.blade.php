@extends('layouts.frontend')

@section('title', 'Contact Us - M3 Mobile Care')

@section('content')
@php
    $shopAddress = \App\Models\Setting::get('address', 'Goffar Market, Ranisankail, Thakurgaon');
    $shopEmail = \App\Models\Setting::get('email', 'info@m3mobilecare.com');
@endphp

<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Contact Us</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Contact Us</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- CONTACT INFO SECTION START -->
<section class="ul-contact-infos">
    <div class="ul-contact-info">
        <div class="icon"><i class="flaticon-location"></i></div>
        <div class="txt">
            <h6 class="title">Our Address</h6>
            <p class="descr mb-0">{{ $shopAddress }}</p>
        </div>
    </div>

    <div class="ul-contact-info">
        <div class="icon"><i class="flaticon-email"></i></div>
        <div class="txt">
            <h6 class="title">Email & Phone</h6>
            <p class="descr mb-0">
                <a href="mailto:{{ $shopEmail }}">{{ $shopEmail }}</a><br>
                <a href="tel:01353106967">01353106967</a>, <a href="tel:01353106966">01353106966</a>
            </p>
        </div>
    </div>

    <div class="ul-contact-info">
        <div class="icon"><i class="flaticon-stop-watch-1"></i></div>
        <div class="txt">
            <h6 class="title">Hours of Operation</h6>
            <p class="descr mb-0">
                <span>Sat - Thu: 9:00 AM – 9:00 PM</span><br>
                <span>Friday: 2:30 PM – 9:00 PM</span>
            </p>
        </div>
    </div>
</section>
<!-- CONTACT INFO SECTION END -->

<!-- MAP AREA START -->
<div class="ul-contact-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14337.8974516315!2d88.2721!3d25.8893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e4e69b00000001%3A0x0!2zUmFuaXNhbmthaWwsIFRoYWt1cmdhb24!5e0!3m2!1sen!2sbd!4v1730028096808!5m2!1sen!2sbd" allowfullscreen loading="lazy"></iframe>
</div>
<!-- MAP AREA END -->

<div class="ul-contact-from-section">
    <div class="ul-contact-form-container">
        <h3 class="ul-contact-form-container__title">Get in Touch</h3>
        <form action="#" class="ul-contact-form" onsubmit="event.preventDefault(); alert('Thank you for contacting M3 Mobile Care! We will call you shortly.');">
            <div class="grid">
                <div class="form-group">
                    <div class="position-relative">
                        <input type="text" name="firstname" id="firstname" placeholder="First Name" required>
                        <span class="field-icon"><i class="flaticon-user"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="position-relative">
                        <input type="text" name="lastname" id="lastname" placeholder="Last Name">
                        <span class="field-icon"><i class="flaticon-user"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="position-relative">
                        <input type="tel" name="phone-number" id="phone-number" placeholder="Phone Number" required>
                        <span class="field-icon"><i class="flaticon-user"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="position-relative">
                        <input type="email" name="email" id="email" placeholder="Enter Email Address">
                        <span class="field-icon"><i class="flaticon-email"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="position-relative">
                        <textarea name="message" id="message" placeholder="Write Message..." required></textarea>
                        <span class="field-icon"><i class="flaticon-edit"></i></span>
                    </div>
                </div>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </div>
</div>
@endsection
