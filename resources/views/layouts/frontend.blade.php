<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'M3 Mobile Care - Accessories & Gadgets Shop')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Libraries CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/icon/flaticon_glamer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/splide/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/slim-select/slimselect.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/animate-wow/animate.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    
    @php
        $primaryColor = \App\Models\Setting::get('primary_color', '#f37021');
    @endphp
    <style>
        :root {
            --ul-primary: {{ $primaryColor }};
        }
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: {{ $primaryColor }};
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }
        .logo-text span {
            color: #111;
        }
        .ul-btn,
        .ul-product-price,
        .ul-product-title a:hover,
        .ul-banner-slide-price .price,
        .ul-banner-slide-sub-title,
        .ul-breadcrumb-nav a:hover,
        .ul-header-nav a:hover,
        .ul-header-nav a.active {
            color: {{ $primaryColor }};
        }
        .ul-btn {
            border-color: {{ $primaryColor }};
        }
        .ul-btn:hover {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Header Section -->
    @include('frontend.partials.header')

    <!-- Main Content Section -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Section -->
    @include('frontend.partials.footer')

    <!-- Libraries JS -->
    <script src="{{ asset('frontend/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/splide/splide.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/splide/splide-extension-auto-scroll.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/slim-select/slimselect.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animate-wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/splittype/index.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/mixitup/mixitup.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/fslightbox/fslightbox.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
