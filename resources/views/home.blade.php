@extends('layouts/blankLayout')

@section('title', ($shopSettings['shop_name'] ?? 'M3 Mobile Care') . ' – আপনার ফোনের যেকোনো সমস্যার নির্ভরযোগ্য সমাধান')
@section('meta_description', 'M3 Mobile Care - আপনার প্রিয় স্মার্টফোনের নির্ভরযোগ্য সমাধান। দ্রুত সার্ভিস, দক্ষ টেকনিশিয়ান, স্বচ্ছ সমাধান ও সার্ভিসের নিশ্চয়তা।')
@section('meta_keywords', 'M3 Mobile Care, Mobile Repair Ranisankail, Phone Repair Thakurgaon, Display Repair, Battery Replacement, Motherboard IC Repair')

@section('head_extra')
<!-- Premium Fonts & Swiper Slider CDN -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@section('content')
<style>
    /* -------------------------------------------------------------
       HIGH-PRECISION LUXURY BENGALI UI/UX DESIGN SYSTEM
    ------------------------------------------------------------- */
    :root {
        --brand-blue: #0284c7;
        --brand-orange: #f97316;
        --brand-orange-hover: #ea580c;
        --dark-heading: #0f172a;
        --body-text: #334155;
        --muted-text: #64748b;
        --surface-light: #f8fafc;
        --surface-card: #ffffff;
        --border-subtle: #e2e8f0;
        --shadow-sm: 0 4px 12px rgba(15, 23, 42, 0.04);
        --shadow-md: 0 12px 32px rgba(15, 23, 42, 0.07);
        --shadow-hover: 0 20px 40px rgba(249, 115, 22, 0.15);
        --radius-xl: 24px;
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-pill: 9999px;
    }

    body {
        font-family: 'Outfit', 'Hind Siliguri', sans-serif !important;
        background-color: var(--surface-light) !important;
        color: var(--body-text) !important;
        line-height: 1.7;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    /* Hide admin template customizer button on public layout */
    .template-customizer-open-btn,
    .layout-customizer-open-btn {
        display: none !important;
    }

    /* Ambient Hero Stage */
    .hero-stage-container {
        position: relative;
        background: radial-gradient(circle at 85% -10%, rgba(249, 115, 22, 0.12) 0%, transparent 50%),
                    radial-gradient(circle at 10% 90%, rgba(2, 132, 199, 0.08) 0%, transparent 45%),
                    linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        padding: clamp(55px, 8vw, 90px) 0 clamp(45px, 6vw, 75px) 0;
    }

    /* UX Badge Pills */
    .ux-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        padding: 9px 20px;
        border-radius: var(--radius-pill);
        font-size: clamp(0.85rem, 2.5vw, 0.92rem);
        font-weight: 700;
        color: var(--dark-heading);
        box-shadow: var(--shadow-sm);
    }
    .ux-pulse-indicator {
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseDot 2s infinite;
    }
    @keyframes pulseDot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Hero Responsive Heading */
    .ux-hero-heading {
        font-size: clamp(2.3rem, 4.5vw, 3.4rem);
        font-weight: 800;
        letter-spacing: normal;
        color: var(--dark-heading);
        line-height: 1.35;
        font-family: 'Hind Siliguri', 'Outfit', sans-serif;
    }

    .ux-gradient-text {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .ux-hero-subtext {
        font-size: clamp(1.05rem, 2.5vw, 1.18rem);
        color: #475569;
        max-width: 650px;
        line-height: 1.75;
    }

    /* Buttons System */
    .btn-ux-primary {
        background-color: var(--brand-orange) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 16px 36px !important;
        border-radius: var(--radius-md) !important;
        font-weight: 700 !important;
        font-size: 1.05rem !important;
        box-shadow: 0 8px 24px rgba(249, 115, 22, 0.32) !important;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
    }
    .btn-ux-primary:hover {
        background-color: var(--brand-orange-hover) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 12px 32px rgba(249, 115, 22, 0.42) !important;
    }

    .btn-ux-whatsapp {
        background-color: #10b981 !important;
        color: #ffffff !important;
        border: none !important;
        padding: 16px 32px !important;
        border-radius: var(--radius-md) !important;
        font-weight: 700 !important;
        font-size: 1.05rem !important;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.28) !important;
        transition: all 0.3s ease !important;
    }
    .btn-ux-whatsapp:hover {
        background-color: #059669 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 12px 30px rgba(16, 185, 129, 0.38) !important;
    }

    .ux-quote-card {
        background: #ffffff;
        border-left: 4px solid var(--brand-orange);
        border-radius: var(--radius-md);
        padding: 18px 22px;
        box-shadow: var(--shadow-sm);
        border-top: 1px solid var(--border-subtle);
        border-right: 1px solid var(--border-subtle);
        border-bottom: 1px solid var(--border-subtle);
    }
    .ux-quote-card p {
        font-size: 1rem;
        color: #334155;
        line-height: 1.65;
    }

    /* ZERO BACKGROUND FOR SWIPER WRAPPERS */
    .rightHeroSwiper,
    .rightHeroSwiper .swiper,
    .rightHeroSwiper .swiper-wrapper,
    .rightHeroSwiper .swiper-slide {
        background: none !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .rightHeroSwiper {
        padding-bottom: 36px !important;
        position: relative;
    }

    .right-hero-pagination {
        bottom: 0 !important;
    }

    /* Clean Hero Showcase Card */
    .ux-hero-showcase-card {
        background: #ffffff !important;
        border: 1px solid var(--border-subtle) !important;
        border-radius: var(--radius-xl) !important;
        padding: 18px !important;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08) !important;
        transition: all 0.3s ease;
    }

    /* Section Typography */
    .ux-section-title {
        font-size: clamp(1.8rem, 3vw, 2.4rem);
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--dark-heading);
        margin-bottom: 8px;
    }
    .ux-section-subtitle {
        color: var(--muted-text);
        font-size: clamp(0.98rem, 2vw, 1.1rem);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Rich Informative Feature Cards */
    .why-info-card {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .why-info-card:hover {
        border-color: var(--brand-orange);
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
    }
    .why-info-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    /* Problem Cards */
    .ux-problem-card {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-xl);
        padding: 26px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .ux-problem-card:hover {
        border-color: var(--brand-orange);
        box-shadow: var(--shadow-hover);
        transform: translateY(-4px);
    }

    /* Service Cards */
    .ux-service-card {
        background: var(--surface-card);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-xl);
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: var(--shadow-sm);
    }
    .ux-service-card:hover {
        border-color: var(--brand-orange);
        box-shadow: var(--shadow-hover);
        transform: translateY(-6px);
    }
    .ux-service-img-container {
        height: 210px;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }
    .ux-service-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .ux-service-card:hover .ux-service-img-container img {
        transform: scale(1.06);
    }

    /* Marquee Infinite Scrolling Styles */
    .ux-marquee-wrapper {
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
        position: relative;
    }
    .ux-marquee-wrapper::before,
    .ux-marquee-wrapper::after {
        content: "";
        position: absolute;
        top: 0;
        width: 60px;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }
    .ux-marquee-wrapper::before {
        left: 0;
        background: linear-gradient(to right, #ffffff, transparent);
    }
    .ux-marquee-wrapper::after {
        right: 0;
        background: linear-gradient(to left, #ffffff, transparent);
    }
    .ux-marquee-track {
        display: inline-flex;
        animation: marqueeAnimation 35s linear infinite;
    }
    .ux-marquee-track:hover {
        animation-play-state: paused;
    }
    .ux-marquee-content {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        padding-right: 1rem;
    }
    .ux-brand-chip {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid var(--border-subtle);
        padding: 10px 22px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--dark-heading);
        transition: all 0.25s ease;
    }
    .ux-brand-chip:hover {
        border-color: var(--brand-orange);
        background: #ffffff;
        transform: translateY(-2px);
    }
    @keyframes marqueeAnimation {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* Process Step Card */
    .ux-process-card {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-xl);
        padding: 30px 24px;
        position: relative;
        height: 100%;
        transition: all 0.3s ease;
    }
    .ux-process-card:hover {
        border-color: var(--brand-orange);
        box-shadow: var(--shadow-md);
        transform: translateY(-4px);
    }
    .ux-process-step-num {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--brand-orange);
        margin-bottom: 8px;
        line-height: 1;
    }

    /* Comparison Table */
    .ux-compare-table {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .ux-compare-table th {
        padding: 18px 24px;
        font-weight: 800;
        font-size: 1.05rem;
    }
    .ux-compare-table td {
        padding: 16px 24px;
        font-size: 0.98rem;
    }

    /* Review Card */
    .ux-review-card {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-xl);
        padding: 30px;
        box-shadow: var(--shadow-sm);
        height: 100%;
    }

    /* FAQ Accordion */
    .ux-faq-accordion .accordion-item {
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-md) !important;
        margin-bottom: 12px;
        overflow: hidden;
    }
    .ux-faq-accordion .accordion-button {
        font-weight: 700;
        color: var(--dark-heading);
        background: #ffffff;
        padding: 20px 24px;
        box-shadow: none !important;
    }
    .ux-faq-accordion .accordion-button:not(.collapsed) {
        background: rgba(249, 115, 22, 0.06);
        color: var(--brand-orange);
    }

    /* Location Dark Stage */
    .ux-location-stage {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: var(--radius-xl);
        padding: clamp(32px, 5vw, 54px) clamp(22px, 4vw, 44px);
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.2);
    }

    /* Standalone ERT Track Section */
    .ux-ert-section {
        background: #ffffff;
        padding: 38px 0;
    }
    .ux-ert-box {
        background: #ffffff;
        border: 2px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 26px;
        box-shadow: var(--shadow-sm);
    }

    .swiper-pagination-bullet-active {
        background: var(--brand-orange) !important;
        width: 26px !important;
        border-radius: 8px !important;
    }
</style>

@include('_partials.public-navbar')

<main>
    <!-- HERO SECTION -->
    <section class="hero-stage-container">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <!-- Left Column: OFFICIAL HERO COPY & CTAS -->
                <div class="col-lg-7">
                    <div class="ux-badge-pill mb-3.5">
                        <span class="ux-pulse-indicator"></span>
                        <span>দ্রুত সার্ভিস • দক্ষ টেকনিশিয়ান • স্বচ্ছ মূল্য • সার্ভিসের নিশ্চয়তা</span>
                    </div>

                    <h1 class="ux-hero-heading mb-3.5">
                        আপনার ফোনের যেকোনো সমস্যার <br class="d-none d-md-block">
                        <span class="ux-gradient-text">নির্ভরযোগ্য সমাধান</span>
                    </h1>

                    <p class="ux-hero-subtext mb-4">
                        আপনার প্রিয় স্মার্টফোনে ডিসপ্লে, ব্যাটারি, চার্জিং, সফটওয়্যার, নেটওয়ার্ক, পানি লাগা বা অন্য যেকোনো সমস্যা হলে চিন্তার কিছু নেই। <strong>M3 Mobile Care</strong>-এ অভিজ্ঞ টেকনিশিয়ানের মাধ্যমে আপনার ফোনের সমস্যার সঠিক কারণ নির্ণয় করে মানসম্মত রিপেয়ার সার্ভিস দেওয়া হয়।
                    </p>

                    <!-- Clean Inline Brand Chips -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                        <span class="fw-bold text-dark fs-7 me-1"><i class="ti tabler-device-mobile text-orange me-1"></i> সমর্থিত ব্র্যান্ড:</span>
                        <span class="badge bg-white text-dark border px-3 py-1.5 rounded-pill fs-8 fw-semibold shadow-sm"><i class="ti tabler-brand-apple text-dark me-1"></i> Apple</span>
                        <span class="badge bg-white text-dark border px-3 py-1.5 rounded-pill fs-8 fw-semibold shadow-sm"><i class="ti tabler-device-mobile text-primary me-1"></i> Samsung</span>
                        <span class="badge bg-white text-dark border px-3 py-1.5 rounded-pill fs-8 fw-semibold shadow-sm"><i class="ti tabler-device-mobile text-danger me-1"></i> Xiaomi / Redmi</span>
                        <span class="badge bg-white text-dark border px-3 py-1.5 rounded-pill fs-8 fw-semibold shadow-sm"><i class="ti tabler-device-mobile text-warning me-1"></i> Realme</span>
                        <span class="badge bg-white text-dark border px-3 py-1.5 rounded-pill fs-8 fw-semibold shadow-sm"><i class="ti tabler-device-mobile text-success me-1"></i> Vivo / Oppo / OnePlus</span>
                    </div>

                    <!-- Primary CTAs -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <a href="{{ route('contact') }}" class="btn btn-ux-primary d-inline-flex align-items-center">
                            <i class="ti tabler-phone-call me-2 fs-5"></i> সার্ভিস নিতে যোগাযোগ করুন
                        </a>
                        <a href="https://wa.me/8801353106967" target="_blank" class="btn btn-ux-whatsapp d-inline-flex align-items-center">
                            <i class="ti tabler-brand-whatsapp me-2 fs-5"></i> WhatsApp-এ কথা বলুন
                        </a>
                    </div>

                    <!-- Quote Block -->
                    <div class="ux-quote-card">
                        <p class="mb-0">
                            "আপনার ফোন আমাদের কাছে শুধু একটি ডিভাইস নয়—এটি আপনার গুরুত্বপূর্ণ যোগাযোগ ও ব্যক্তিগত জীবনের অংশ। তাই আমরা প্রতিটি ফোন যত্নসহকারে সার্ভিস করি।"
                        </p>
                    </div>
                </div>

                <!-- Right Column: DYNAMIC AUTO-SLIDING INFORMATION CAROUSEL -->
                <div class="col-lg-5">
                    <div class="swiper rightHeroSwiper">
                        <div class="swiper-wrapper">

                            <!-- Slide 1: Display Repair Showcase -->
                            <div class="swiper-slide">
                                <div class="ux-hero-showcase-card">
                                    <div class="position-relative overflow-hidden rounded-4 mb-3">
                                        <img src="{{ asset('assets/img/services/display_repair.jpg') }}" alt="Display Replacement" class="img-fluid w-100" style="height: 270px; object-fit: cover; border-radius: 16px;">
                                        <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8 shadow-sm">EXPRESS FIX</span>
                                    </div>
                                    <div class="text-start px-2 pb-1">
                                        <h5 class="fw-bold text-dark mb-1">Display & Touch Repair</h5>
                                        <p class="text-muted fs-7 mb-0">ভাঙা বা ক্ষতিগ্রস্ত ডিসপ্লে ও টাচ সমস্যার নির্ভরযোগ্য সমাধান।</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2: Motherboard Micro-soldering -->
                            <div class="swiper-slide">
                                <div class="ux-hero-showcase-card">
                                    <div class="position-relative overflow-hidden rounded-4 mb-3">
                                        <img src="{{ asset('assets/img/services/motherboard_repair.jpg') }}" alt="Motherboard Soldering" class="img-fluid w-100" style="height: 270px; object-fit: cover; border-radius: 16px;">
                                        <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8 shadow-sm">SPECIALIST</span>
                                    </div>
                                    <div class="text-start px-2 pb-1">
                                        <h5 class="fw-bold text-dark mb-1">Motherboard & IC Repair</h5>
                                        <p class="text-muted fs-7 mb-0">জটিল হার্ডওয়্যার ও মাদারবোর্ডের জন্য Micro-Soldering সার্ভিস।</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3: Battery Replacement -->
                            <div class="swiper-slide">
                                <div class="ux-hero-showcase-card">
                                    <div class="position-relative overflow-hidden rounded-4 mb-3">
                                        <img src="{{ asset('assets/img/services/battery_replacement.jpg') }}" alt="Battery Replacement" class="img-fluid w-100" style="height: 270px; object-fit: cover; border-radius: 16px;">
                                        <span class="badge bg-success text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8 shadow-sm">WARRANTY</span>
                                    </div>
                                    <div class="text-start px-2 pb-1">
                                        <h5 class="fw-bold text-dark mb-1">Battery Replacement</h5>
                                        <p class="text-muted fs-7 mb-0">দ্রুত চার্জ শেষ হওয়া বা ব্যাটারি দুর্বলতার নিরাপদ সলিউশন।</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 4: Water Damage Recovery -->
                            <div class="swiper-slide">
                                <div class="ux-hero-showcase-card">
                                    <div class="position-relative overflow-hidden rounded-4 mb-3">
                                        <img src="{{ asset('assets/img/services/water_damage_repair.jpg') }}" alt="Water Damage Repair" class="img-fluid w-100" style="height: 270px; object-fit: cover; border-radius: 16px;">
                                        <span class="badge bg-info text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8 shadow-sm">DATA SAFE</span>
                                    </div>
                                    <div class="text-start px-2 pb-1">
                                        <h5 class="fw-bold text-dark mb-1">Water Damage Repair</h5>
                                        <p class="text-muted fs-7 mb-0">পানিতে পড়া ফোনের দ্রুত Inspection, Cleaning & Board Repair।</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="swiper-pagination right-hero-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTINUOUS INFINITE MARQUEE BRAND & PHONE LIST SECTION (PLACED DIRECTLY BELOW HERO) -->
    <section class="py-4 bg-white overflow-hidden border-bottom">
        <div class="container-fluid px-0">
            <div class="text-center mb-3">
                <span class="text-muted fs-8 fw-bold text-uppercase tracking-wider">আমরা যেসব ব্র্যান্ডের ফোন সার্ভিস দিই</span>
            </div>
            <div class="ux-marquee-wrapper">
                <div class="ux-marquee-track">
                    <div class="ux-marquee-content">
                        <span class="ux-brand-chip"><i class="ti tabler-brand-apple text-dark me-1.5"></i> Apple</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-primary me-1.5"></i> Samsung</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-danger me-1.5"></i> Xiaomi</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-warning me-1.5"></i> Redmi</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-warning me-1.5"></i> Realme</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-success me-1.5"></i> Vivo</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-info me-1.5"></i> Oppo</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-danger me-1.5"></i> OnePlus</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-secondary me-1.5"></i> Google Pixel</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-dark me-1.5"></i> Huawei</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-primary me-1.5"></i> Motorola</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-info me-1.5"></i> Nokia</span>
                    </div>
                    <div class="ux-marquee-content" aria-hidden="true">
                        <span class="ux-brand-chip"><i class="ti tabler-brand-apple text-dark me-1.5"></i> Apple</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-primary me-1.5"></i> Samsung</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-danger me-1.5"></i> Xiaomi</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-warning me-1.5"></i> Redmi</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-warning me-1.5"></i> Realme</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-success me-1.5"></i> Vivo</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-info me-1.5"></i> Oppo</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-danger me-1.5"></i> OnePlus</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-secondary me-1.5"></i> Google Pixel</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-dark me-1.5"></i> Huawei</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-primary me-1.5"></i> Motorola</span>
                        <span class="ux-brand-chip"><i class="ti tabler-device-mobile text-info me-1.5"></i> Nokia</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <p class="text-muted fs-7 mb-0">
                    <i class="ti tabler-info-circle me-1"></i> আপনার ফোনের মডেল তালিকায় না থাকলেও আমাদের সাথে যোগাযোগ করুন। আপনার ডিভাইসের জন্য সার্ভিস সুবিধা আছে কি না আমরা জানিয়ে দেব।
                </p>
            </div>
        </div>
    </section>



    <!-- WHY M3 MOBILE CARE? RICH FEATURE CARDS SECTION -->
    <section class="py-5 bg-white">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-2">WHY CHOOSE US</span>
                <h2 class="ux-section-title">কেন M3 Mobile Care?</h2>
                <p class="ux-section-subtitle">শুধু রিপেয়ার নয়, সমস্যার সঠিক সমাধান</p>
            </div>

            <div class="row g-4 max-w-5xl mx-auto">
                <!-- Card 1 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-user-check"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">অভিজ্ঞ ও দক্ষ টেকনিশিয়ান</h5>
                            <p class="text-muted fs-7 mb-0">১০+ বছরের অভিজ্ঞতা সম্পন্ন চিপ-লেভেল ইঞ্জিনিয়ার দ্বারা সুনির্দিষ্ট ডায়াগনসিস ও মেরামত।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-tools"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">আধুনিক ডায়াগনস্টিক ও রিপেয়ার টুলস</h5>
                            <p class="text-muted fs-7 mb-0">হাই-প্রিসিশন অপটিক্যাল মাইক্রোস্কোপ, আল্ট্রাসনিক কেমিক্যাল ওয়াশ ও ডিজিটাল লেমিনেটর ল্যাব।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-file-text"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">কাজ শুরুর আগে সমস্যার বিস্তারিত জানানো হয়</h5>
                            <p class="text-muted fs-7 mb-0">কোনো হিডেন চার্জ ছাড়াই প্রথমে সমস্যা ও সম্ভাব্য খরচ বুঝিয়ে আপনার অনুমতি নেওয়া হয়।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-receipt-tax"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">স্বচ্ছ ও যুক্তিসঙ্গত চার্জ</h5>
                            <p class="text-muted fs-7 mb-0">অপ্রয়োজনীয় পার্টস চেঞ্জ না করে সৎ ও সঠিক মূল্যে নির্ভরযোগ্য মোবাইল সার্ভিস প্রদান।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-shield-check"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">প্রয়োজন অনুযায়ী মানসম্মত পার্টস</h5>
                            <p class="text-muted fs-7 mb-0">১০০% টেস্টেড অরিজিনাল ডিসপ্লে, অরিজিনাল ব্যাটারি ও ব্র্যান্ডেড আইসি কম্পোনেন্ট।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-award"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">নির্দিষ্ট সার্ভিসে Warranty সুবিধা</h5>
                            <p class="text-muted fs-7 mb-0">প্রতিটি রিপেয়ারে লিখিত মেমো সহ ৩০ থেকে ৯০ দিনের অফিশিয়াল ওয়ারেন্টির নিশ্চয়তা।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 7 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-shield-lock"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">গ্রাহকের ডেটা ও প্রাইভেসির প্রতি সর্বোচ্চ গুরুত্ব</h5>
                            <p class="text-muted fs-7 mb-0">ফোনের ছবি, মেসেজ, পার্সোনাল গ্যালারি ও ফাইলস ১০০% অক্ষত ও নিরাপদ রাখা হয়।</p>
                        </div>
                    </div>
                </div>

                <!-- Card 8 -->
                <div class="col-md-6">
                    <div class="why-info-card">
                        <div class="why-info-icon-box">
                            <i class="ti tabler-circle-check"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">কাজ শেষে ফোন পরীক্ষা করে হস্তান্তর</h5>
                            <p class="text-muted fs-7 mb-0">স্পিকার, টাচ, চার্জিং ও কলিং সকল ফাংশন চূড়ান্ত টেস্ট করেই গ্রাহকের হাতে তুলে দেওয়া হয়।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK DIAGNOSIS SELECTOR -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold mb-2">QUICK DIAGNOSIS</span>
                <h2 class="ux-section-title">আপনার ফোনে কী সমস্যা হচ্ছে?</h2>
                <p class="ux-section-subtitle">আমরা আপনার সমস্যার সমাধান করতে পারি</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="ux-problem-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-success-subtle text-success p-3 rounded-circle fs-3">🔋</span>
                            <h5 class="fw-bold text-dark mb-0">ব্যাটারি দ্রুত শেষ হয়ে যাচ্ছে?</h5>
                        </div>
                        <p class="text-muted fs-7 flex-grow-1">
                            ব্যাটারি দুর্বল, ফুলে যাওয়া বা চার্জ ধরে না রাখার সমস্যা হলে ব্যাটারি চেক ও রিপ্লেসমেন্ট সার্ভিস।
                        </p>
                        <a href="{{ route('book.form') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 mt-2 w-100 fw-semibold">ব্যাটারি চেক করুন</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="ux-problem-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-warning-subtle text-warning p-3 rounded-circle fs-3">🔌</span>
                            <h5 class="fw-bold text-dark mb-0">চার্জ হচ্ছে না?</h5>
                        </div>
                        <p class="text-muted fs-7 flex-grow-1">
                            চার্জিং পোর্ট, কানেক্টর, IC বা চার্জিং সার্কিটের সমস্যা নির্ণয় করে প্রয়োজনীয় রিপেয়ার।
                        </p>
                        <a href="{{ route('book.form') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 mt-2 w-100 fw-semibold">পোর্ট চেক করুন</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="ux-problem-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-danger-subtle text-danger p-3 rounded-circle fs-3">📱</span>
                            <h5 class="fw-bold text-dark mb-0">ডিসপ্লে ভেঙে গেছে?</h5>
                        </div>
                        <p class="text-muted fs-7 flex-grow-1">
                            ভাঙা/ফাটা ডিসপ্লে, টাচ কাজ না করা বা স্ক্রিনে লাইন/দাগের সমস্যার সমাধান।
                        </p>
                        <a href="{{ route('book.form') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 mt-2 w-100 fw-semibold">ডিসপ্লে ফিক্স</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="ux-problem-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-info-subtle text-info p-3 rounded-circle fs-3">💧</span>
                            <h5 class="fw-bold text-dark mb-0">ফোনে পানি ঢুকেছে?</h5>
                        </div>
                        <p class="text-muted fs-7 flex-grow-1">
                            পানি বা তরল পদার্থে ক্ষতিগ্রস্ত ফোন দ্রুত ডায়াগনস্টিক ও প্রয়োজনীয় বোর্ড রিপেয়ার।
                        </p>
                        <a href="{{ route('book.form') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 mt-2 w-100 fw-semibold">ওয়াশ রিপেয়ার</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="ux-problem-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-primary-subtle text-primary p-3 rounded-circle fs-3">📶</span>
                            <h5 class="fw-bold text-dark mb-0">নেটওয়ার্ক বা সিগন্যাল সমস্যা?</h5>
                        </div>
                        <p class="text-muted fs-7 flex-grow-1">
                            সিম, নেটওয়ার্ক, Wi-Fi, Bluetooth ও অন্যান্য কানেক্টিভিটি সমস্যার নির্ণয় ও সমাধান।
                        </p>
                        <a href="{{ route('book.form') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 mt-2 w-100 fw-semibold">সিগন্যাল ফিক্স</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="ux-problem-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-secondary-subtle text-dark p-3 rounded-circle fs-3">⚙️</span>
                            <h5 class="fw-bold text-dark mb-0">সফটওয়্যার সমস্যা?</h5>
                        </div>
                        <p class="text-muted fs-7 flex-grow-1">
                            ফোন হ্যাং, Boot Loop, Software Error, Update সমস্যা বা অন্যান্য সফটওয়্যার-সংক্রান্ত সমস্যায় সহায়তা।
                        </p>
                        <a href="{{ route('book.form') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 mt-2 w-100 fw-semibold">সফটওয়্যার আপডেট</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SPECIALIZED SERVICES SHOWCASE SECTION -->
    <section class="py-5 bg-white">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-dark text-white px-3 py-1.5 rounded-pill fw-bold mb-2">SPECIALIZED SERVICES</span>
                <h2 class="ux-section-title">আমাদের বিশেষায়িত সার্ভিসসমূহ</h2>
                <p class="ux-section-subtitle">Professional Mobile Repair Services</p>
            </div>

            <div class="row g-4">
                <!-- Service 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-card h-100 d-flex flex-column">
                        <div class="ux-service-img-container">
                            <img src="{{ asset('assets/img/services/display_repair.jpg') }}" alt="Display & Touch Repair">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">Display & Touch Repair</h4>
                            <p class="text-muted fs-7 flex-grow-1 mb-4">
                                ফাটা বা ক্ষতিগ্রস্ত ডিসপ্লে, টাচ সমস্যা এবং স্ক্রিন-সংক্রান্ত বিভিন্ন সমস্যার সমাধান।
                            </p>
                            <div class="pt-3 border-top text-end">
                                <a href="{{ route('book.form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-semibold">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-card h-100 d-flex flex-column">
                        <div class="ux-service-img-container">
                            <img src="{{ asset('assets/img/services/battery_replacement.jpg') }}" alt="Battery Replacement">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">Battery Replacement</h4>
                            <p class="text-muted fs-7 flex-grow-1 mb-4">
                                দ্রুত ব্যাটারি ড্রেন, চার্জ ধরে না রাখা বা পুরোনো ব্যাটারির জন্য নিরাপদ ব্যাটারি রিপ্লেসমেন্ট।
                            </p>
                            <div class="pt-3 border-top text-end">
                                <a href="{{ route('book.form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-semibold">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-card h-100 d-flex flex-column">
                        <div class="ux-service-img-container">
                            <img src="{{ asset('assets/img/services/camera_repair.jpg') }}" alt="Charging & Power Repair">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">Charging & Power Repair</h4>
                            <p class="text-muted fs-7 flex-grow-1 mb-4">
                                চার্জিং পোর্ট, চার্জিং IC, Power IC এবং ফোনের পাওয়ার-সংক্রান্ত সমস্যার ডায়াগনস্টিক ও রিপেয়ার।
                            </p>
                            <div class="pt-3 border-top text-end">
                                <a href="{{ route('book.form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-semibold">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-card h-100 d-flex flex-column">
                        <div class="ux-service-img-container">
                            <img src="{{ asset('assets/img/services/water_damage_repair.jpg') }}" alt="Water Damage Repair">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">Water Damage Repair</h4>
                            <p class="text-muted fs-7 flex-grow-1 mb-4">
                                পানি বা তরল পদার্থে ক্ষতিগ্রস্ত ফোনের দ্রুত Inspection, Cleaning এবং প্রয়োজনীয় Board Repair।
                            </p>
                            <div class="pt-3 border-top text-end">
                                <a href="{{ route('book.form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-semibold">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-card h-100 d-flex flex-column">
                        <div class="ux-service-img-container">
                            <img src="{{ asset('assets/img/services/software_flashing.jpg') }}" alt="Software & System Service">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">Software & System Service</h4>
                            <p class="text-muted fs-7 flex-grow-1 mb-4">
                                Software Error, Boot Loop, System Crash, Update সমস্যা এবং অন্যান্য সফটওয়্যার সমস্যার সমাধান।
                            </p>
                            <div class="pt-3 border-top text-end">
                                <a href="{{ route('book.form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-semibold">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-card h-100 d-flex flex-column">
                        <div class="ux-service-img-container">
                            <img src="{{ asset('assets/img/services/motherboard_repair.jpg') }}" alt="Motherboard & IC Repair">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">Motherboard & IC Repair</h4>
                            <p class="text-muted fs-7 flex-grow-1 mb-4">
                                ফোনের জটিল Hardware ও Motherboard সমস্যার জন্য অভিজ্ঞ টেকনিশিয়ান দ্বারা Micro-Soldering ও IC-Level Repair।
                            </p>
                            <div class="pt-3 border-top text-end">
                                <a href="{{ route('book.form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-semibold">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- OUR 6-STEP WORKFLOW SECTION (UPDATED COPY) -->
    <section class="py-5 bg-white">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-info text-white px-3 py-1.5 rounded-pill fw-bold mb-2">WORKFLOW</span>
                <h2 class="ux-section-title">আমাদের সার্ভিস প্রক্রিয়া</h2>
                <p class="ux-section-subtitle">নির্ভরযোগ্য সেবা, প্রতিটি ধাপে স্বচ্ছতা</p>
            </div>

            <div class="row g-4">
                <!-- Step 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-process-card">
                        <div class="ux-process-step-num">০১</div>
                        <h5 class="fw-bold text-dark mb-2">প্রাথমিক মূল্যায়ন</h5>
                        <p class="text-muted fs-7 mb-0">আপনার ফোনের সমস্যা ও বর্তমান অবস্থা যাচাই করে প্রয়োজনীয় তথ্য সংগ্রহ করা হয়।</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-process-card">
                        <div class="ux-process-step-num">০২</div>
                        <h5 class="fw-bold text-dark mb-2">ডায়াগনস্টিক</h5>
                        <p class="text-muted fs-7 mb-0">আধুনিক যন্ত্রপাতি ও অভিজ্ঞ টেকনিশিয়ানের মাধ্যমে সমস্যার মূল কারণ শনাক্ত করা হয়।</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-process-card">
                        <div class="ux-process-step-num">০৩</div>
                        <h5 class="fw-bold text-dark mb-2">সার্ভিস কনফার্মেশন</h5>
                        <p class="text-muted fs-7 mb-0">প্রয়োজনীয় কাজ, ব্যবহৃত পার্টস এবং সম্ভাব্য খরচ সম্পর্কে বিস্তারিত জানানো হয়।</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-process-card">
                        <div class="ux-process-step-num">০৪</div>
                        <h5 class="fw-bold text-dark mb-2">প্রফেশনাল রিপেয়ার</h5>
                        <p class="text-muted fs-7 mb-0">আপনার সম্মতি অনুযায়ী দক্ষ টেকনিশিয়ানের মাধ্যমে প্রয়োজনীয় মেরামতের কাজ সম্পন্ন করা হয়।</p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-process-card">
                        <div class="ux-process-step-num">০৫</div>
                        <h5 class="fw-bold text-dark mb-2">কোয়ালিটি কন্ট্রোল</h5>
                        <p class="text-muted fs-7 mb-0">রিপেয়ারের পর ফোনের প্রয়োজনীয় ফাংশন ও পারফরম্যান্স পরীক্ষা করে সার্ভিসের মান নিশ্চিত করা হয়।</p>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-process-card">
                        <div class="ux-process-step-num">০৬</div>
                        <h5 class="fw-bold text-dark mb-2">ফাইনাল ডেলিভারি</h5>
                        <p class="text-muted fs-7 mb-0">সকল পরীক্ষা সম্পন্ন হওয়ার পর ফোনটি নিরাপদভাবে হস্তান্তর করা হয় এবং প্রযোজ্য ক্ষেত্রে সার্ভিস Warranty জানানো হয়।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPARISON TABLE SECTION -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-dark text-white px-3 py-1.5 rounded-pill fw-bold mb-2">COMPARISON</span>
                <h2 class="ux-section-title">কেন সাধারণ দোকানের বদলে M3 Mobile Care?</h2>
                <p class="ux-section-subtitle">আমাদের স্বচ্ছতা ও প্রফেশনাল মানই আপনাকে দেবে শতভাগ স্বস্তি</p>
            </div>

            <div class="table-responsive max-w-4xl mx-auto">
                <table class="table table-bordered align-middle ux-compare-table mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>বিষয়</th>
                            <th class="text-danger">সাধারণ দোকান</th>
                            <th class="text-warning bg-slate-800">M3 Mobile Care</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">সমস্যার কারণ নির্ণয়</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> অনুমানের ভিত্তিতে</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> Proper Diagnostic</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">চার্জ</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> আগে থেকেই অস্পষ্ট হতে পারে</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> কাজের আগে জানানো হয়</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">রিপেয়ার</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> সাধারণ রিপেয়ার</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> প্রয়োজন অনুযায়ী Professional Repair</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">জটিল Board Repair</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> সীমিত</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> IC-Level / Board Repair</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Quality Check</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> সবসময় নয়</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> রিপেয়ারের পর পরীক্ষা</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Warranty</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> অনিশ্চিত</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> প্রযোজ্য সার্ভিসে Warranty</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Customer Support</td>
                            <td class="text-muted"><i class="ti tabler-x text-danger me-1"></i> সীমিত</td>
                            <td class="fw-bold text-success"><i class="ti tabler-check text-success me-1"></i> সার্ভিস-পরবর্তী সহায়তা</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- OUR COMMITMENT SECTION -->
    <section class="py-5 bg-white">
        <div class="container text-center py-3">
            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-2">OUR COMMITMENT</span>
            <h2 class="ux-section-title">আমাদের প্রতিশ্রুতি</h2>
            <h5 class="text-orange fw-bold mb-4">আপনার ফোন, আমাদের দায়িত্ব</h5>

            <div class="p-4 bg-light rounded-4 border max-w-3xl mx-auto text-start">
                <p class="fs-6 text-dark mb-3">
                    আমরা অপ্রয়োজনীয় পার্টস পরিবর্তন বা অযথা খরচ করানোর চেষ্টা করি না। প্রথমে সমস্যাটি শনাক্ত করি, তারপর প্রয়োজনীয় সমাধান ও সম্ভাব্য খরচ আপনাকে জানাই।
                </p>
                <div class="p-3 bg-white border-start border-4 border-warning rounded shadow-sm">
                    <strong class="text-dark fs-6">আপনি জানবেন কী সমস্যা, কী কাজ হবে এবং কেন কাজটি প্রয়োজন।</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- CUSTOMER REVIEWS SECTION -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold mb-2">CUSTOMER REVIEWS</span>
                <h2 class="ux-section-title">আমাদের গ্রাহকরাই আমাদের পরিচয়</h2>
                <p class="ux-section-subtitle">আমাদের রিয়েল গ্রাহকদের অভিজ্ঞতা</p>
            </div>

            <div class="swiper reviewSwiper pb-5">
                <div class="swiper-wrapper">
                    <!-- Review 1 -->
                    <div class="swiper-slide">
                        <div class="ux-review-card">
                            <div class="d-flex align-items-center gap-1 text-warning mb-3">
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                            </div>
                            <p class="text-secondary fs-7 lh-base mb-4">
                                “ফোনের চার্জিং সমস্যা নিয়ে গিয়েছিলাম। সমস্যাটা দ্রুত চেক করে সমাধান করে দিয়েছে। সার্ভিস ও ব্যবহার দুটোই ভালো লেগেছে।”
                            </p>
                            <div class="d-flex align-items-center gap-3 pt-3 border-top">
                                <div class="avatar avatar-md bg-warning-subtle text-warning fw-bold rounded-circle d-flex align-items-center justify-content-center">স</div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">সন্তুষ্ট গ্রাহক</h6>
                                    <small class="text-muted">চার্জিং সার্ভিস</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="swiper-slide">
                        <div class="ux-review-card">
                            <div class="d-flex align-items-center gap-1 text-warning mb-3">
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                            </div>
                            <p class="text-secondary fs-7 lh-base mb-4">
                                “ডিসপ্লে নিয়ে অনেক চিন্তায় ছিলাম। কাজ করার আগে পুরো বিষয়টি বুঝিয়ে দিয়েছে এবং ফোনটাও খুব ভালোভাবে ডেলিভারি পেয়েছি।”
                            </p>
                            <div class="d-flex align-items-center gap-3 pt-3 border-top">
                                <div class="avatar avatar-md bg-info-subtle text-info fw-bold rounded-circle d-flex align-items-center justify-content-center">স</div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">সন্তুষ্ট গ্রাহক</h6>
                                    <small class="text-muted">ডিসপ্লে রিপ্লেসমেন্ট</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="swiper-slide">
                        <div class="ux-review-card">
                            <div class="d-flex align-items-center gap-1 text-warning mb-3">
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                                <i class="ti tabler-star-filled"></i>
                            </div>
                            <p class="text-secondary fs-7 lh-base mb-4">
                                “জটিল বোর্ডের সমস্যা ছিল। অন্য জায়গায় সমাধান হয়নি, এখানে ডায়াগনস্টিক করে রিপেয়ার করেছে। এখন ফোন ভালোভাবে চলছে।”
                            </p>
                            <div class="d-flex align-items-center gap-3 pt-3 border-top">
                                <div class="avatar avatar-md bg-danger-subtle text-danger fw-bold rounded-circle d-flex align-items-center justify-content-center">স</div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">সন্তুষ্ট গ্রাহক</h6>
                                    <small class="text-muted">মাদারবোর্ড রিপেয়ার</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination review-pagination"></div>
            </div>
        </div>
    </section>

    <!-- FREQUENTLY ASKED QUESTIONS -->
    <section class="py-5 bg-white">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill fw-bold mb-2">FAQ & ANSWERS</span>
                <h2 class="ux-section-title">Frequently Asked Questions</h2>
                <p class="ux-section-subtitle">আমাদের সেবাসমূহ সম্পর্কিত সাধারণ প্রশ্ন ও উত্তর</p>
            </div>

            <div class="max-w-3xl mx-auto">
                <div class="accordion ux-faq-accordion" id="officialFaqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="officialFaq1Header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#officialFaq1" aria-expanded="true" aria-controls="officialFaq1">
                                <i class="ti tabler-help text-orange me-2 fs-5"></i> রিপেয়ার করার আগে কি খরচ জানানো হয়?
                            </button>
                        </h2>
                        <div id="officialFaq1" class="accordion-collapse collapse show" aria-labelledby="officialFaq1Header" data-bs-parent="#officialFaqAccordion">
                            <div class="accordion-body text-secondary fs-7 lh-base">
                                হ্যাঁ। ফোন পরীক্ষা করার পর প্রয়োজনীয় কাজ এবং সম্ভাব্য খরচ আপনাকে জানানো হবে। আপনার অনুমতি ছাড়া বড় কোনো কাজ করা হবে না।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="officialFaq2Header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#officialFaq2" aria-expanded="false" aria-controls="officialFaq2">
                                <i class="ti tabler-clock text-orange me-2 fs-5"></i> রিপেয়ারে কত সময় লাগে?
                            </button>
                        </h2>
                        <div id="officialFaq2" class="accordion-collapse collapse" aria-labelledby="officialFaq2Header" data-bs-parent="#officialFaqAccordion">
                            <div class="accordion-body text-secondary fs-7 lh-base">
                                সমস্যা ও প্রয়োজনীয় পার্টসের উপর সময় নির্ভর করে। সাধারণ সমস্যাগুলো দ্রুত সমাধান করা সম্ভব হলেও জটিল Motherboard বা IC-Level Repair-এ বেশি সময় লাগতে পারে।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="officialFaq3Header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#officialFaq3" aria-expanded="false" aria-controls="officialFaq3">
                                <i class="ti tabler-shield-lock text-orange me-2 fs-5"></i> আমার ফোনের ডেটা কি নিরাপদ থাকবে?
                            </button>
                        </h2>
                        <div id="officialFaq3" class="accordion-collapse collapse" aria-labelledby="officialFaq3Header" data-bs-parent="#officialFaqAccordion">
                            <div class="accordion-body text-secondary fs-7 lh-base">
                                আমরা আপনার ব্যক্তিগত ডেটা ও প্রাইভেসিকে গুরুত্ব দিই। প্রয়োজন ছাড়া ফোনের ব্যক্তিগত তথ্য অ্যাক্সেস করা হয় না।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="officialFaq4Header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#officialFaq4" aria-expanded="false" aria-controls="officialFaq4">
                                <i class="ti tabler-device-mobile text-orange me-2 fs-5"></i> সব ধরনের মোবাইল কি রিপেয়ার করেন?
                            </button>
                        </h2>
                        <div id="officialFaq4" class="accordion-collapse collapse" aria-labelledby="officialFaq4Header" data-bs-parent="#officialFaqAccordion">
                            <div class="accordion-body text-secondary fs-7 lh-base">
                                আমরা বিভিন্ন জনপ্রিয় ব্র্যান্ড ও মডেলের সার্ভিস দিয়ে থাকি। আপনার ফোনের মডেল জানালে সার্ভিস সুবিধা সম্পর্কে নিশ্চিতভাবে জানাতে পারব।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="officialFaq5Header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#officialFaq5" aria-expanded="false" aria-controls="officialFaq5">
                                <i class="ti tabler-award text-orange me-2 fs-5"></i> রিপেয়ারের উপর কি Warranty আছে?
                            </button>
                        </h2>
                        <div id="officialFaq5" class="accordion-collapse collapse" aria-labelledby="officialFaq5Header" data-bs-parent="#officialFaqAccordion">
                            <div class="accordion-body text-secondary fs-7 lh-base">
                                নির্দিষ্ট সার্ভিস ও পার্টসের ক্ষেত্রে Warranty সুবিধা প্রযোজ্য হতে পারে। কাজের আগে Warranty terms আপনাকে জানিয়ে দেওয়া হবে।
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VISIT OUR STORE & FINAL CTA -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="ux-location-stage">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill mb-3">VISIT OUR STORE</span>
                        <h2 class="text-white fw-extrabold mb-3">আপনার ফোনের সমস্যা নিয়ে আর দেরি করবেন না</h2>
                        <p class="text-slate-300 fs-6 mb-4">
                            ফোনে ছোট সমস্যা দেখা দিলে অবহেলা করলে অনেক সময় সেটি বড় Hardware সমস্যায় পরিণত হতে পারে। <strong>আজই M3 Mobile Care-এ নিয়ে আসুন।</strong>
                            <br><br>
                            📍 <strong>ঠিকানা:</strong> (বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও
                            <br>
                            📞 <strong>Call:</strong> +8801353106967 / +8801353106966
                            <br>
                            💬 <strong>WhatsApp:</strong> +8801353106967
                            <br>
                            🕐 <strong>সময়:</strong> প্রতিদিন সকাল ৯:০০ টা - রাত ৯:৩০ টা
                        </p>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="tel:+8801353106967" class="btn btn-warning fw-bold px-4 py-3 rounded-3">
                                <i class="ti tabler-phone-call me-1.5"></i> এখনই কল করুন
                            </a>
                            <a href="https://wa.me/8801353106967" target="_blank" class="btn btn-success fw-bold px-4 py-3 rounded-3">
                                <i class="ti tabler-brand-whatsapp me-1.5"></i> WhatsApp-এ যোগাযোগ
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-5 text-center border-start border-slate-700 ps-lg-4">
                        <i class="ti tabler-shield-check text-warning display-2 d-block mb-2"></i>
                        <h4 class="text-white fw-bold mb-2">ফোনের সমস্যা? সমাধান আছে।</h4>
                        <p class="text-slate-400 fs-7 mb-4">
                            <strong>সঠিক Diagnosis → Professional Repair → Quality Check → Hassle-Free Service</strong>
                        </p>
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold fs-7">
                            M3 Mobile Care — আপনার ফোনের বিশ্বস্ত Repair Partner।
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('_partials.public-footer')

<!-- Swiper JS Script Initialization -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Right Column Hero Swiper Initialization
        new Swiper('.rightHeroSwiper', {
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.rightHeroSwiper .swiper-pagination',
                clickable: true,
            },
            speed: 750
        });

        // Review Swiper Initialization
        new Swiper('.reviewSwiper', {
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            slidesPerView: 1,
            spaceBetween: 24,
            pagination: {
                el: '.reviewSwiper .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            },
            speed: 700
        });
    });
</script>
@endsection
