@extends('layouts/blankLayout')

@section('title', ($shopSettings['shop_name'] ?? 'M3 Mobile Care') . ' – Trusted Mobile Repair & Accessories Shop')
@section('meta_description', ($shopSettings['shop_name'] ?? 'M3 Mobile Care') . ' – Trusted Mobile Repair & Accessories Shop. Address: ' . ($shopSettings['address'] ?? '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও') . '. Website: www.m3mobilecares.com | Email: ' . ($shopSettings['email'] ?? 'support@m3mobilecares.com') . ' | Mobile: ' . ($shopSettings['phone'] ?? '+8801353106967 / +8801353106966'))
@section('meta_keywords', 'M3 Mobile Care, Mobile Repair Ranisankail, Phone Accessories Thakurgaon, Display Replacement, Battery Replacement, Ranisankail Mobile Shop, Abdul Goffar Market Mobile Care, www.m3mobilecares.com')

@section('head_extra')
<!-- Import Premium Google Fonts & Stylesheets -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Structured Data / JSON-LD for SEO -->
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'MobilePhoneRepairStore',
      '@id' => url('/') . '#store',
      'name' => $shopSettings['shop_name'] ?? 'M3 Mobile Care',
      'image' => asset('assets/img/branding/logo-light-icon.png'),
      'logo' => asset('assets/img/branding/logo-light-icon.png'),
      'url' => 'https://www.m3mobilecares.com',
      'telephone' => $shopSettings['phone'] ?? '+8801353106967',
      'email' => $shopSettings['email'] ?? 'support@m3mobilecares.com',
      'priceRange' => '৳৳',
      'description' => ($shopSettings['shop_name'] ?? 'M3 Mobile Care') . ' – Trusted Mobile Repair & Accessories Shop at (বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও.',
      'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $shopSettings['address'] ?? '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও',
        'addressLocality' => 'Ranisankail, Thakurgaon',
        'addressCountry' => 'BD'
      ],
      'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => 25.8858,
        'longitude' => 88.2678
      ],
      'openingHoursSpecification' => [
        [
          '@type' => 'OpeningHoursSpecification',
          'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
          'opens' => '09:00',
          'closes' => '21:30'
        ]
      ],
      'sameAs' => ['https://www.facebook.com/m3mobilecare']
    ],
    [
      '@type' => 'WebSite',
      '@id' => url('/') . '#website',
      'url' => url('/'),
      'name' => ($shopSettings['shop_name'] ?? 'M3 Mobile Care') . ' Store',
      'description' => 'Smartphone Accessories E-Commerce & Live Service Tracking Portal',
      'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => [
          '@type' => 'EntryPoint',
          'urlTemplate' => url('/track') . '?ticket_id={search_term_string}'
        ],
        'query-input' => 'required name=search_term_string'
      ]
    ],
    [
      '@type' => 'FAQPage',
      '@id' => url('/') . '#faq',
      'mainEntity' => [
        [
          '@type' => 'Question',
          'name' => 'Are all mobile accessories and parts original?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Yes, M3 Mobile Care provides 100% tested, high-grade original displays, batteries, fast chargers, and accessories with official warranty.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'How can I track my repair ticket status live?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Enter your unique Ticket ID (e.g. M3-202608-XXXX) in the tracking search bar on our homepage to view real-time diagnostic notes, technician stage, and estimated cost.'
          ]
        ],
        [
          '@type' => 'Question',
          'name' => 'What smartphone brands do you repair and supply parts for?',
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'We supply parts and repair services for Apple iPhone, Samsung Galaxy, Xiaomi / Redmi, Realme, Oppo, Vivo, OnePlus, and Google Pixel.'
          ]
        ]
      ]
    ]
  ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<style>
    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: #f8fafc !important;
        color: #1e293b !important;
        overflow-x: hidden;
    }
    
    /* Background Ambient Mesh & Orbs */
    .hero-wrapper {
        position: relative;
        background: radial-gradient(circle at 80% -20%, rgba(243, 112, 33, 0.12) 0%, rgba(255, 255, 255, 0) 55%),
                    radial-gradient(circle at 10% 90%, rgba(14, 165, 233, 0.08) 0%, rgba(255, 255, 255, 0) 50%),
                    linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    }
    
    .grid-pattern {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(15, 23, 42, 0.05) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
        opacity: 0.6;
    }
    
    /* Typography Overrides */
    h1, h2, h3, h4, h5, h6 {
        color: #0f172a !important;
        font-weight: 800 !important;
        letter-spacing: -0.02em;
    }
    
    .gradient-orange-text {
        background: linear-gradient(135deg, #ff7a00 0%, #f37021 50%, #d94800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Glassmorphism White Cards with Luxurious Elevation */
    .premium-glass-card {
        background: rgba(255, 255, 255, 0.88) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.9) !important;
        border-radius: 28px !important;
        box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.06), 0 4px 16px rgba(15, 23, 42, 0.02) !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .premium-glass-card:hover {
        border-color: rgba(243, 112, 33, 0.35) !important;
        box-shadow: 0 30px 60px -12px rgba(243, 112, 33, 0.18), 0 8px 24px rgba(15, 23, 42, 0.04) !important;
        transform: translateY(-6px);
    }
    
    /* Hero Image Container Styling */
    .hero-img-box {
        position: relative;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 30px 60px -15px rgba(243, 112, 33, 0.22), 0 10px 30px rgba(15, 23, 42, 0.08);
        border: 4px solid #ffffff;
    }
    .hero-img-box img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .hero-img-box:hover img {
        transform: scale(1.03);
    }
    
    .floating-glass-badge-top {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(15px);
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.8);
        font-weight: 700;
        font-size: 0.85rem;
        color: #0f172a;
        z-index: 3;
    }

    .floating-glass-badge-bottom {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(15px);
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.8);
        font-weight: 700;
        font-size: 0.85rem;
        color: #f37021;
        z-index: 3;
    }

    /* Buttons */
    .btn-orange-gradient {
        background: linear-gradient(135deg, #ff7a00 0%, #f37021 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 10px 24px rgba(243, 112, 33, 0.32) !important;
        transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-orange-gradient:hover {
        background: linear-gradient(135deg, #ff8c1a 0%, #f47d33 100%) !important;
        color: #ffffff !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 14px 30px rgba(243, 112, 33, 0.45) !important;
    }
    
    .btn-glass-secondary {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1.5px solid #e2e8f0 !important;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04) !important;
        transition: all 0.3s ease;
    }
    .btn-glass-secondary:hover {
        border-color: #f37021 !important;
        color: #f37021 !important;
        transform: translateY(-2px);
    }

    .input-hero-glow {
        background-color: #ffffff !important;
        border: 2px solid #e2e8f0 !important;
        color: #0f172a !important;
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s ease;
    }
    .input-hero-glow:focus {
        background-color: #ffffff !important;
        border-color: #f37021 !important;
        box-shadow: 0 0 25px rgba(243, 112, 33, 0.22) !important;
    }

    /* Live Pulse Indicator */
    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #22c55e;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulseGreen 2s infinite;
    }
    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    
    /* Navigation Bar Light Glass */
    .navbar-light-glass {
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(20px);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03) !important;
        border-bottom: none !important;
    }
    
    /* Product Cards */
    .product-card-premium {
        background: #ffffff !important;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        transition: all 0.35s ease;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.03);
    }
    .product-card-premium:hover {
        border-color: #f37021;
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(243, 112, 33, 0.16);
    }
    
    /* Seamless Section Backgrounds (No Borders) */
    .section-white { background-color: #ffffff !important; border: none !important; }
    .section-slate { background-color: #f8fafc !important; border: none !important; }

    /* Accordion Light Customization */
    .accordion-item {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        margin-bottom: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
    }
    .accordion-button {
        background: #ffffff !important;
        color: #0f172a !important;
        font-weight: 600;
        box-shadow: none !important;
    }
    .accordion-button:not(.collapsed) {
        color: #f37021 !important;
        background: rgba(243, 112, 33, 0.04) !important;
    }

    .table-light-custom th {
        color: #64748b !important;
        font-weight: 600 !important;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-size: 0.75rem;
        border-bottom: 1.5px solid #e2e8f0 !important;
    }
    .table-light-custom td {
        border-bottom: 1px solid #f1f5f9 !important;
        color: #334155 !important;
    }

    .badge { font-weight: 600 !important; letter-spacing: 0.03em; }
    .bg-label-primary { background-color: rgba(243, 112, 33, 0.12) !important; color: #e05300 !important; }
    .bg-label-success { background-color: rgba(34, 197, 94, 0.12) !important; color: #15803d !important; }
    .bg-label-warning { background-color: rgba(245, 158, 11, 0.12) !important; color: #b45309 !important; }
    .bg-label-info { background-color: rgba(14, 165, 233, 0.12) !important; color: #0369a1 !important; }
    .bg-label-secondary { background-color: rgba(100, 116, 139, 0.12) !important; color: #475569 !important; }
</style>

<header>
    <!-- Navigation Bar (Light Theme) -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-light-glass sticky-top py-3" aria-label="Main Navigation">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" aria-label="M3 Mobile Care Homepage">
                <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care Logo" width="40" height="40" style="height: 40px; width: auto; object-fit: contain;" class="me-2.5">
                <span class="fs-4 fw-extrabold text-dark" style="font-family: 'Outfit', sans-serif;">M3 <span style="color: #f37021;">MOBILE CARE</span></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-slate-600 hover-text-dark fw-semibold mx-2" href="#store-details">Shop Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-slate-600 hover-text-dark fw-semibold mx-2" href="#trending">Trending Parts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-slate-600 hover-text-dark fw-semibold mx-2" href="#upcoming">Upcoming Gear</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-slate-600 hover-text-dark fw-semibold mx-2" href="#recent-activity">Service Board</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-slate-600 hover-text-dark fw-semibold mx-2" href="#track">Track Ticket</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-orange-gradient px-4 py-2.5 rounded-pill fw-bold" href="{{ route('book.form') }}"><i class="ti tabler-calendar-plus me-1.5"></i>Book Repair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    <!-- Ultra Premium Hero Section with Image & Content Showcase -->
    <section class="hero-wrapper py-5 position-relative">
        <div class="grid-pattern"></div>
        
        <div class="container py-4 py-md-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-5 mb-5">
                <!-- Hero Left Copy Content -->
                <div class="col-lg-6 text-center text-lg-start">
                    <div class="d-inline-flex align-items-center gap-2 px-3.5 py-2 rounded-pill bg-white border border-slate-200 shadow-sm mb-4">
                        <span class="pulse-dot"></span>
                        <span class="text-slate-700 small fw-bold text-uppercase tracking-wider">Official Smartphone Parts & Lab Diagnostics</span>
                    </div>
                    
                    <h1 class="display-4 fw-black text-dark mb-3" style="line-height: 1.15; font-size: 3.2rem;">
                        Next-Gen Care for Your <br>
                        <span class="gradient-orange-text">Smartphones & Tech</span>
                    </h1>
                    
                    <p class="fs-5 text-slate-600 mb-4 max-w-xl fw-normal" style="line-height: 1.6;">
                        Browse 100% genuine OLED displays, high-health replacement batteries, fast chargers, and premium mobile accessories in {{ $shopSettings['address'] ?? 'Thakurgaon' }}. Track your device repair diagnostics live.
                    </p>
                    
                    <!-- CTAs -->
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4">
                        <a href="#trending" class="btn btn-orange-gradient btn-lg px-4.5 py-3 rounded-pill fw-bold fs-6">
                            <i class="ti tabler-shopping-bag me-2 fs-5"></i>Explore Accessories Store
                        </a>
                        <a href="{{ route('book.form') }}" class="btn btn-glass-secondary btn-lg px-4.5 py-3 rounded-pill fw-bold fs-6">
                            <i class="ti tabler-tools me-2 fs-5"></i>Book Repair Online
                        </a>
                    </div>
                    
                    <!-- Highlights Pills Bar -->
                    <div class="row g-3 max-w-xl justify-content-center justify-content-lg-start">
                        <div class="col-6 col-sm-3 text-start">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar rounded-circle p-2 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="ti tabler-shield-check fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark fs-7">100% Original</span>
                                    <span class="text-slate-500 fs-9">Tested Parts</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 text-start">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar rounded-circle p-2 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="ti tabler-truck-delivery fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark fs-7">Fast Courier</span>
                                    <span class="text-slate-500 fs-9">64 Districts</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 text-start">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar rounded-circle p-2 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="ti tabler-clock-check fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark fs-7">1-Hour Swap</span>
                                    <span class="text-slate-500 fs-9">Quick Service</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 text-start">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar rounded-circle p-2 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="ti tabler-star-filled fs-5"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark fs-7">4.9/5 Rating</span>
                                    <span class="text-slate-500 fs-9">Trusted Shop</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Right Image Showcase Card -->
                <div class="col-lg-6">
                    <div class="hero-img-box">
                        <div class="floating-glass-badge-top">
                            <i class="ti tabler-microscope text-primary me-1.5 fs-5"></i>Micro-Soldering Lab
                        </div>
                        
                        <img src="{{ asset('assets/img/front-pages/hero_showcase.png') }}" alt="M3 Mobile Care Lab & Store Showcase" width="600" height="420" class="img-fluid">
                        
                        <div class="floating-glass-badge-bottom">
                            <i class="ti tabler-circle-check-filled me-1.5 fs-5"></i>100% Tested Stock
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integrated Live Repair Ticket Tracking Glass Bar -->
            <div id="track" class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="premium-glass-card p-4 p-md-4.5" style="border-top: 4px solid #f37021 !important;">
                        <div class="row align-items-center gy-3">
                            <div class="col-md-5 text-center text-md-start">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                    <div class="avatar rounded-circle p-2.5 me-3 d-flex align-items-center justify-content-center" style="background: rgba(243, 112, 33, 0.12); width: 48px; height: 48px;">
                                        <i class="ti tabler-scan text-primary fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="h5 fw-bold text-dark mb-0">Live Repair Ticket Tracker</h3>
                                        <span class="text-slate-500 small">Trace lab notes, diagnostic stage & cost</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-7">
                                <form action="{{ route('track.search') }}" method="POST" class="d-flex flex-column flex-sm-row gap-2">
                                    @csrf
                                    <div class="flex-grow-1">
                                        <label for="ticket_id_input" class="visually-hidden">Tracking Ticket ID Code</label>
                                        <input type="text" id="ticket_id_input" name="ticket_id" aria-label="Enter Ticket ID Code" class="form-control form-control-lg input-hero-glow text-center text-sm-start" placeholder="e.g. M3-202608-XXXX" value="{{ request('ticket_id') }}" required style="border-radius: 14px; height: 52px;">
                                    </div>
                                    <button type="submit" class="btn btn-orange-gradient px-4 py-2.5 rounded-pill fw-bold text-nowrap" style="height: 52px;">
                                        <i class="ti tabler-search me-1.5 fs-5"></i>Trace Ticket
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Feature Cards Bar (4 Glass Showcase Pillars) -->
            <div class="row g-4 mt-4">
                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(243, 112, 33, 0.1); width: 54px; height: 54px;">
                                <i class="ti tabler-device-mobile text-primary fs-2"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold text-dark mb-1">OLED Displays</h3>
                                <span class="text-slate-500 small">Original Assembly</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(34, 197, 94, 0.1); width: 54px; height: 54px;">
                                <i class="ti tabler-battery-charging text-success fs-2"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold text-dark mb-1">100% Batteries</h3>
                                <span class="text-slate-500 small">High-Health Cells</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(245, 158, 11, 0.1); width: 54px; height: 54px;">
                                <i class="ti tabler-plug text-warning fs-2"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold text-dark mb-1">GaN Fast Power</h3>
                                <span class="text-slate-500 small">Multi-Protocol Chargers</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(14, 165, 233, 0.1); width: 54px; height: 54px;">
                                <i class="ti tabler-cpu text-info fs-2"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold text-dark mb-1">Micro-Soldering</h3>
                                <span class="text-slate-500 small">PCB Diagnostic Lab</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop Overview & Feature Highlights Section (Seamless Slate-50 Background) -->
    <section id="store-details" class="py-5 section-slate">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge bg-label-primary mb-2 px-3 py-1.5 fs-7 text-uppercase fw-bold">Welcome to {{ $shopSettings['shop_name'] ?? 'M3 Mobile Care' }}</span>
                <h2 class="fw-bold text-dark mb-2">About Our Store & Diagnostic Lab</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">We combine premium smartphone parts retail with state-of-the-art chip-level repair laboratories under one roof.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #ff7a00 0%, #f37021 100%);">
                            <i class="ti tabler-building-store text-white fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Modern Retail Store</h3>
                        <p class="small text-slate-600 mb-0">Visit our store in {{ $shopSettings['address'] ?? 'Ranisankail, Thakurgaon' }} to browse genuine accessories, test displays live, or get free device diagnostics.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                            <i class="ti tabler-cpu text-white fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Micro-Soldering Lab</h3>
                        <p class="small text-slate-600 mb-0">Equipped with 4K microscopes, laser glass separators, thermal cameras, and BGA reballing stations for motherboard fixes.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                            <i class="ti tabler-certificate text-white fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Tested Genuine Stock</h3>
                        <p class="small text-slate-600 mb-0">Every screen, battery, IC chip, and charger undergoes 12-point quality check before being placed on store shelves.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="ti tabler-truck-delivery text-white fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Nationwide Delivery</h3>
                        <p class="small text-slate-600 mb-0">We package and ship genuine parts and accessories to customers and repair shops across Bangladesh.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trending Products Section (Seamless White Section) -->
    <section id="trending" class="py-5 section-white">
        <div class="container py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
                <div>
                    <span class="badge bg-label-warning mb-2 px-3 py-1.5 fs-7 text-uppercase fw-bold"><i class="ti tabler-flame me-1"></i>Hot In Stock</span>
                    <h2 class="fw-bold text-dark mb-1">Trending Products & Accessories</h2>
                    <p class="text-slate-600 mb-0">Top-selling mobile replacement screens, original batteries, fast chargers, and accessories.</p>
                </div>
                <div>
                    <span class="badge bg-label-primary px-3 py-2 fw-bold"><i class="ti tabler-sparkles me-1"></i>Updated Today</span>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="row g-4">
                @if(isset($inventoryProducts) && count($inventoryProducts) > 0)
                    @foreach($inventoryProducts as $item)
                    <div class="col-md-6 col-lg-3">
                        <div class="product-card-premium p-4 position-relative h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-primary text-white mb-3">In Stock</span>
                                <div class="text-center py-4 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="min-height: 140px;">
                                    <i class="ti tabler-device-mobile text-slate-400 display-4"></i>
                                </div>
                                <span class="text-slate-500 small d-block mb-1">{{ $item->brand ?? 'M3 Original' }}</span>
                                <h3 class="h6 fw-bold text-dark mb-2">{{ $item->name }}</h3>
                                <p class="small text-slate-600 mb-3">{{ \Illuminate\Support\Str::limit($item->description ?? 'Genuine replacement part with official warranty', 60) }}</p>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold text-success">{{ number_format($item->sale_price, 0) }} BDT</span>
                                    <span class="text-slate-500 small"><i class="ti tabler-box me-1"></i>{{ $item->quantity }} Qty</span>
                                </div>
                                <a href="{{ route('book.form', ['model' => $item->name]) }}" class="btn btn-glass-secondary btn-sm w-100 py-2 rounded-pill fw-bold">
                                    <i class="ti tabler-shopping-cart me-1"></i>Order / Inquire
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Curated Fallback Trending Products -->
                    <div class="col-md-6 col-lg-3">
                        <div class="product-card-premium p-4 position-relative h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-primary text-white mb-3">Original OLED</span>
                                <div class="text-center py-4 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="min-height: 140px;">
                                    <i class="ti tabler-device-mobile text-warning display-4"></i>
                                </div>
                                <span class="text-slate-500 small d-block mb-1">Apple iPhone</span>
                                <h3 class="h6 fw-bold text-dark mb-2">iPhone 15 Pro Max Super Retina Display</h3>
                                <p class="small text-slate-600 mb-3">100% Genuine pulled OLED display with 120Hz ProMotion & TruTone support.</p>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold text-success">28,500 BDT</span>
                                    <span class="text-slate-500 small"><i class="ti tabler-star-filled text-warning me-1"></i>4.9</span>
                                </div>
                                <a href="{{ route('book.form', ['model' => 'iPhone 15 Pro Max Screen']) }}" class="btn btn-glass-secondary btn-sm w-100 py-2 rounded-pill fw-bold">
                                    <i class="ti tabler-shopping-cart me-1"></i>Order / Inquire
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="product-card-premium p-4 position-relative h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-info text-white mb-3">Dynamic AMOLED</span>
                                <div class="text-center py-4 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="min-height: 140px;">
                                    <i class="ti tabler-device-mobile-message text-info display-4"></i>
                                </div>
                                <span class="text-slate-500 small d-block mb-1">Samsung Galaxy</span>
                                <h3 class="h6 fw-bold text-dark mb-2">Samsung S24 Ultra Original Display Panel</h3>
                                <p class="small text-slate-600 mb-3">Original frame assembly display panel with S-Pen digitizer integration.</p>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold text-success">31,000 BDT</span>
                                    <span class="text-slate-500 small"><i class="ti tabler-star-filled text-warning me-1"></i>5.0</span>
                                </div>
                                <a href="{{ route('book.form', ['model' => 'Samsung S24 Ultra Display']) }}" class="btn btn-glass-secondary btn-sm w-100 py-2 rounded-pill fw-bold">
                                    <i class="ti tabler-shopping-cart me-1"></i>Order / Inquire
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="product-card-premium p-4 position-relative h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-success text-white mb-3">High Health 100%</span>
                                <div class="text-center py-4 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="min-height: 140px;">
                                    <i class="ti tabler-battery-charging text-success display-4"></i>
                                </div>
                                <span class="text-slate-500 small d-block mb-1">Apple Accessories</span>
                                <h3 class="h6 fw-bold text-dark mb-2">iPhone 13 / 14 Series Original Battery Pack</h3>
                                <p class="small text-slate-600 mb-3">Zero cycle original battery cell with battery health board transfer service.</p>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold text-success">3,800 BDT</span>
                                    <span class="text-slate-500 small"><i class="ti tabler-star-filled text-warning me-1"></i>4.8</span>
                                </div>
                                <a href="{{ route('book.form', ['model' => 'iPhone Battery Replacement']) }}" class="btn btn-glass-secondary btn-sm w-100 py-2 rounded-pill fw-bold">
                                    <i class="ti tabler-shopping-cart me-1"></i>Order / Inquire
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="product-card-premium p-4 position-relative h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-warning text-dark mb-3">GaN Fast Power</span>
                                <div class="text-center py-4 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="min-height: 140px;">
                                    <i class="ti tabler-plug text-warning display-4"></i>
                                </div>
                                <span class="text-slate-500 small d-block mb-1">M3 Power Series</span>
                                <h3 class="h6 fw-bold text-dark mb-2">67W Dual Type-C GaN Fast Power Adapter</h3>
                                <p class="small text-slate-600 mb-3">Compact multi-protocol fast charger for iPhone, Samsung, Xiaomi, and laptops.</p>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fs-5 fw-bold text-success">2,450 BDT</span>
                                    <span class="text-slate-500 small"><i class="ti tabler-star-filled text-warning me-1"></i>4.9</span>
                                </div>
                                <a href="{{ route('book.form', ['model' => '67W Fast Charger']) }}" class="btn btn-glass-secondary btn-sm w-100 py-2 rounded-pill fw-bold">
                                    <i class="ti tabler-shopping-cart me-1"></i>Order / Inquire
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Upcoming Products Section (Seamless Slate Section) -->
    <section id="upcoming" class="py-5 section-slate">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge bg-label-info mb-2 px-3 py-1.5 fs-7 text-uppercase fw-bold"><i class="ti tabler-rocket me-1"></i>Next-Gen Tech</span>
                <h2 class="fw-bold text-dark mb-2">Upcoming Products & Laboratory Gear</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Get a sneak peek at upcoming next-gen mobile screens, smart chargers, and laboratory repair equipment arriving next week.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <span class="badge bg-danger text-white mb-3">Arriving Next Week</span>
                        <div class="text-center py-3 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center">
                            <i class="ti tabler-device-mobile-bolt text-danger display-4"></i>
                        </div>
                        <span class="text-slate-500 small d-block mb-1">Upcoming Screen</span>
                        <h3 class="h6 fw-bold text-dark mb-2">iPhone 16 Pro Max Original Curved OLED Panel</h3>
                        <p class="small text-slate-600 mb-3">Ultra-thin bezel OEM OLED assembly engineered for upcoming iPhone 16 series.</p>
                        <span class="badge bg-slate-100 text-slate-700 w-100 py-2 border border-slate-200">Pre-Order Open</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <span class="badge text-white mb-3" style="background-color: #8b5cf6;">Next-Gen Charging</span>
                        <div class="text-center py-4 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="background: rgba(139, 92, 246, 0.08); min-height: 120px;">
                            <i class="ti tabler-charging-station display-4" style="color: #8b5cf6 !important;"></i>
                        </div>
                        <span class="text-slate-500 small d-block mb-1">M3 Power Station</span>
                        <h3 class="h6 fw-bold text-dark mb-2">140W 4-Port GaN Desktop Fast Charging Dock</h3>
                        <p class="small text-slate-600 mb-3">Smart LCD display monitoring real-time voltage, amperage, and temperature for 4 devices.</p>
                        <span class="badge bg-slate-100 text-slate-700 w-100 py-2 border border-slate-200">Coming Soon</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <span class="badge bg-success text-white mb-3">Lab Equipment</span>
                        <div class="text-center py-3 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center">
                            <i class="ti tabler-camera-selfie text-success display-4"></i>
                        </div>
                        <span class="text-slate-500 small d-block mb-1">Micro Diagnostics</span>
                        <h3 class="h6 fw-bold text-dark mb-2">AI 3D Infrared Thermal Imager for PCB Short Circuit</h3>
                        <p class="small text-slate-600 mb-3">Instant 1-second short circuit detection for smartphone motherboards with thermal imaging.</p>
                        <span class="badge bg-slate-100 text-slate-700 w-100 py-2 border border-slate-200">Special Import</span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="premium-glass-card p-4 h-100">
                        <span class="badge bg-warning text-dark mb-3">Nano Protection</span>
                        <div class="text-center py-3 bg-slate-50 rounded-3 mb-3 d-flex align-items-center justify-content-center">
                            <i class="ti tabler-shield-check-filled text-warning display-4"></i>
                        </div>
                        <span class="text-slate-500 small d-block mb-1">Screen Armor</span>
                        <h3 class="h6 fw-bold text-dark mb-2">Sapphire Crystal 9H Glass Guard for Curved Phones</h3>
                        <p class="small text-slate-600 mb-3">Scratch-resistant liquid sapphire glass protector with anti-fingerprint oleophobic layer.</p>
                        <span class="badge bg-slate-100 text-slate-700 w-100 py-2 border border-slate-200">Stock Arriving Soon</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Repair Operations Board -->
    <section id="recent-activity" class="py-5 section-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge bg-label-primary mb-2 px-3 py-1.5 fs-7 text-uppercase fw-bold">Live Operations</span>
                <h2 class="fw-bold text-dark mb-1">Last 3 Days Service Tracker</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Real-time status updates and activity logs from our device laboratories in the last 72 hours.</p>
            </div>

            <!-- Stat summaries -->
            <div class="row g-4 mb-5">
                <div class="col-6 col-md-3">
                    <div class="premium-glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #ff7a00 0%, #f37021 100%);">
                            <i class="ti tabler-clipboard-list text-white fs-2"></i>
                        </div>
                        <h3 class="text-slate-600 mb-1 fs-6 fw-semibold text-nowrap">Total Logged</h3>
                        <h4 class="fw-extrabold text-dark mb-0 fs-2">{{ $recentRepairs->count() }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="premium-glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="ti tabler-zoom-check text-white fs-2"></i>
                        </div>
                        <h3 class="text-slate-600 mb-1 fs-6 fw-semibold text-nowrap">Diagnosing</h3>
                        <h4 class="fw-extrabold text-dark mb-0 fs-2">{{ $repairsByStatus['diagnosing'] ?? 0 }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="premium-glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                            <i class="ti tabler-tool text-white fs-2"></i>
                        </div>
                        <h3 class="text-slate-600 mb-1 fs-6 fw-semibold text-nowrap">Repairing</h3>
                        <h4 class="fw-extrabold text-dark mb-0 fs-2">{{ $repairsByStatus['repairing'] ?? 0 }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="premium-glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                            <i class="ti tabler-circle-check text-white fs-2"></i>
                        </div>
                        <h3 class="text-slate-600 mb-1 fs-6 fw-semibold text-nowrap">Ready / Delivered</h3>
                        <h4 class="fw-extrabold text-dark mb-0 fs-2">
                            {{ ($repairsByStatus['completed'] ?? 0) + ($repairsByStatus['delivered'] ?? 0) }}
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Recent Job Cards Table -->
            <div class="row">
                <div class="col-12">
                    <div class="premium-glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="h5 fw-bold text-dark mb-0"><i class="ti tabler-list-check text-primary me-2"></i>Recent Job Cards</h3>
                            <span class="badge bg-slate-100 text-slate-700 border border-slate-200">Showing last 10 entries</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 table-light-custom">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3">Ticket ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Device Model</th>
                                        <th scope="col">Assigned Issue</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-end">Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentRepairs as $recent)
                                        <tr>
                                            <td class="py-3.5 fw-bold text-primary">{{ $recent->ticket_id }}</td>
                                            <td>
                                                @if($recent->customer)
                                                    {{ \Illuminate\Support\Str::limit($recent->customer->name, 12) }} 
                                                    <span class="text-slate-400 small d-block">{{ substr($recent->customer->phone, 0, 4) }}****{{ substr($recent->customer->phone, -4) }}</span>
                                                @else
                                                    <span class="text-slate-400">Walk-in</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-dark d-flex align-items-center">
                                                    <i class="ti tabler-device-mobile text-slate-400 me-1.5 small"></i>{{ $recent->device_brand }} {{ $recent->device_model }}
                                                </span>
                                            </td>
                                            <td class="small text-slate-600">{{ \Illuminate\Support\Str::limit($recent->issue_description, 35) }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match($recent->status) {
                                                        'pending' => 'bg-label-secondary',
                                                        'diagnosing' => 'bg-label-warning',
                                                        'waiting_for_approval' => 'bg-label-info',
                                                        'repairing' => 'bg-label-primary',
                                                        'quality_check' => 'bg-label-info',
                                                        'completed' => 'bg-label-success',
                                                        'delivered' => 'bg-label-success',
                                                        default => 'bg-label-danger'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} text-uppercase fs-9 py-1 px-2.5">{{ str_replace('_', ' ', $recent->status) }}</span>
                                            </td>
                                            <td class="text-end small text-slate-500">
                                                {{ $recent->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-slate-400">
                                                <i class="ti tabler-device-mobile-cog fs-1 mb-2"></i>
                                                <p class="mb-0">No job cards registered in the last 3 days.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-5 section-slate">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge bg-label-info mb-2 px-3 py-1.5 fs-7 text-uppercase fw-bold">Help & Support</span>
                <h2 class="fw-bold text-dark mb-2">Frequently Asked Questions</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Instant answers regarding our mobile parts store, warranty policy, and repair tracking.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Are all mobile parts and accessories sold genuine?
                                </button>
                            </h3>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! All OLED displays, batteries, fast chargers, and accessories listed at {{ $shopSettings['shop_name'] ?? 'M3 Mobile Care' }} are 100% genuine and pass strict multi-point laboratory quality testing before dispatch.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How can I track my repair ticket status live?
                                </button>
                            </h3>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Enter your unique Ticket ID (e.g., M3-202608-XXXX) in the search bar on our homepage to view real-time technician diagnostic notes, repair stage, and final bill amount.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Do you deliver accessories and parts across Bangladesh?
                                </button>
                            </h3>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we provide nationwide express courier delivery to all 64 districts in Bangladesh with safe protective packaging.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Tracking Results Modal -->
@if($searched)
<div class="modal fade" id="repairDetailsModal" tabindex="-1" aria-labelledby="repairDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content premium-glass-card p-0 border-0">
            <div class="modal-header border-bottom p-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Logo" width="36" height="36" style="height: 36px; width: auto; object-fit: contain;" class="me-3">
                    <div>
                        <h2 class="modal-title h4 fw-bold text-dark mb-0" id="repairDetailsModalLabel">Your Repair Details</h2>
                        <span class="text-slate-600 small">Traced Code: <strong style="color: #f37021 !important;">{{ request('ticket_id') }}</strong></span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                @include('_partials.track-modal-body')
            </div>

            <div class="modal-footer border-top p-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('repairDetailsModal'));
        myModal.show();
    });
</script>
@endif

<!-- Footer with Real Dynamic Shop Settings & Discreet Staff Login -->
<footer class="bg-white border-top border-slate-200 py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-5">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care Logo" width="36" height="36" class="me-2">
                    <span class="fs-4 fw-bold text-dark">{{ $shopSettings['shop_name'] ?? 'M3 Mobile Care' }}</span>
                </div>
                <p class="text-slate-600 small mb-3 max-w-sm">{{ $shopSettings['shop_slogan'] ?? 'Premium Mobile Repair & Retail' }} — Genuine smartphone parts store & chip-level repair lab.</p>
                <div class="d-flex gap-2">
                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200"><i class="ti tabler-shield-check me-1 text-success"></i>Certified Genuine</span>
                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200"><i class="ti tabler-truck me-1 text-info"></i>Nationwide Courier</span>
                </div>
            </div>
            <div class="col-md-3">
                <h3 class="h6 text-dark fw-bold mb-3 text-uppercase tracking-wider">Quick Navigation</h3>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-slate-600 text-decoration-none hover-text-dark">Home Store</a></li>
                    <li class="mb-2"><a href="#trending" class="text-slate-600 text-decoration-none hover-text-dark">Trending Parts</a></li>
                    <li class="mb-2"><a href="#upcoming" class="text-slate-600 text-decoration-none hover-text-dark">Upcoming Gear</a></li>
                    <li class="mb-2"><a href="{{ route('book.form') }}" class="text-slate-600 text-decoration-none hover-text-dark">Book Repair Appointment</a></li>
                    <li class="mb-2"><a href="{{ url('/sitemap.xml') }}" class="text-slate-600 text-decoration-none hover-text-dark" target="_blank">XML Sitemap</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3 class="h6 text-dark fw-bold mb-3 text-uppercase tracking-wider">Store & Contact Details</h3>
                <p class="text-slate-600 small mb-2"><i class="ti tabler-map-pin me-2 text-primary"></i><strong>Address:</strong> {{ $shopSettings['address'] ?? '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও' }}</p>
                <p class="text-slate-600 small mb-2"><i class="ti tabler-phone me-2 text-primary"></i><strong>Mobile:</strong> {{ $shopSettings['phone'] ?? '+8801353106967 / +8801353106966' }}</p>
                <p class="text-slate-600 small mb-2"><i class="ti tabler-mail me-2 text-primary"></i><strong>Email:</strong> {{ $shopSettings['email'] ?? 'support@m3mobilecares.com' }}</p>
                <p class="text-slate-600 small mb-2"><i class="ti tabler-world me-2 text-primary"></i><strong>Website:</strong> <a href="https://www.m3mobilecares.com" target="_blank" class="text-slate-600 text-decoration-none fw-semibold">www.m3mobilecares.com</a></p>
                <p class="text-slate-600 small mb-0"><i class="ti tabler-clock me-2 text-primary"></i><strong>Working Hours:</strong> Saturday - Thursday: 09:00 AM - 09:30 PM</p>
            </div>
        </div>
        
        <hr class="border-slate-200 my-4">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <p class="text-slate-500 small mb-0">&copy; {{ date('Y') }} {{ $shopSettings['shop_name'] ?? 'M3 Mobile Care' }}. All rights reserved.</p>
            
            <!-- Staff Login Portal Link (Discreetly in Footer) -->
            <div>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1.5 text-slate-600" style="border-color: #cbd5e1; font-size: 0.8rem;">
                    <i class="ti tabler-lock me-1"></i>Staff Login Portal
                </a>
            </div>
        </div>
    </div>
</footer>
@endsection
