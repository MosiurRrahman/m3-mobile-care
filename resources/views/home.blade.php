@extends('layouts/blankLayout')

@section('title', 'M3 Mobile Care - Professional Smartphone Repair & Servicing')

@section('content')
<!-- Import Premium Google Fonts & Stylesheets -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: #060913 !important;
        color: #e2e8f0 !important;
        overflow-x: hidden;
    }
    .grid-bg {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
        background-size: 50px 50px;
        background-position: center top;
        pointer-events: none;
        z-index: 0;
    }
    .orb-orange {
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(243, 112, 33, 0.14) 0%, rgba(243, 112, 33, 0) 70%);
        top: -180px;
        right: -100px;
        filter: blur(80px);
        animation: floatOrb 12s infinite alternate;
        pointer-events: none;
        z-index: 1;
    }
    .orb-cyan {
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(0, 207, 232, 0.1) 0%, rgba(0, 207, 232, 0) 70%);
        bottom: -150px;
        left: -100px;
        filter: blur(70px);
        animation: floatOrb 16s infinite alternate-reverse;
        pointer-events: none;
        z-index: 1;
    }
    @keyframes floatOrb {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(60px, 40px) scale(1.15); }
    }

    h1, h2, h3, h4, h5, h6 {
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    p, .text-slate-400 {
        color: #cbd5e1 !important;
    }

    .glass-card {
        background: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        position: relative;
        overflow: hidden;
        transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .glass-card:hover {
        border-color: #f37021 !important;
        box-shadow: 0 24px 50px rgba(243, 112, 33, 0.25) !important;
        transform: translateY(-6px);
    }
    .glass-nav {
        background: linear-gradient(90deg, #090e1a 0%, #0d1527 100%) !important;
        backdrop-filter: blur(20px);
        border-bottom: 2px solid #f37021 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }
    .gradient-text {
        background: linear-gradient(135deg, #ffb366 0%, #f37021 50%, #e05300 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #ff7a00 0%, #f37021 100%) !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 8px 20px rgba(243, 112, 33, 0.3) !important;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, #ff8c1a 0%, #f47d33 100%) !important;
        color: #fff !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 12px 24px rgba(243, 112, 33, 0.45) !important;
    }
    .service-icon-box {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(243, 112, 33, 0.15) 0%, rgba(243, 112, 33, 0.05) 100%);
        border: 1px solid rgba(243, 112, 33, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f37021;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .table {
        color: #cbd5e1 !important;
    }
    .table th, .table td {
        border-color: rgba(255, 255, 255, 0.08) !important;
        color: #cbd5e1 !important;
    }
    .table thead th {
        color: #94a3b8 !important;
        font-weight: 600 !important;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    .badge {
        font-weight: 600 !important;
    }
    .bg-label-primary { background-color: rgba(243, 112, 33, 0.16) !important; color: #ff944d !important; }
    .bg-label-success { background-color: rgba(40, 199, 111, 0.16) !important; color: #34d399 !important; }
    .bg-label-warning { background-color: rgba(255, 159, 67, 0.16) !important; color: #fbbf24 !important; }
    .bg-label-info { background-color: rgba(0, 207, 232, 0.16) !important; color: #22d3ee !important; }
    .bg-label-secondary { background-color: rgba(148, 163, 184, 0.16) !important; color: #cbd5e1 !important; }
    .bg-label-danger { background-color: rgba(239, 68, 68, 0.16) !important; color: #f87171 !important; }

    .input-glow {
        background-color: #080c14 !important;
        border: 1.5px solid rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        transition: all 0.3s ease;
    }
    .input-glow::placeholder {
        color: #94a3b8 !important;
        opacity: 1 !important;
    }
    .input-glow:focus {
        background-color: #060913 !important;
        border-color: #f37021 !important;
        box-shadow: 0 0 25px rgba(243, 112, 33, 0.35) !important;
    }
    .btn-outline-track {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
        transition: all 0.3s ease;
    }
    .btn-outline-track:hover {
        background: #ffffff !important;
        color: #060913 !important;
        border-color: #ffffff !important;
    }
</style>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark glass-nav sticky-top py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Logo" style="height: 38px; width: auto; object-fit: contain;" class="me-2.5">
            <span class="fs-4 fw-extrabold text-white" style="font-family: 'Outfit', sans-serif;">M3 <span style="color: #f37021;">MOBILE CARE</span></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#hero">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#services">Our Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#equipment-lab">Lab Equipment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#why-different">Why Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#mission-vision">Mission & Vision</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-slate-400 hover-text-white mx-2" href="#track">Track Status</a>
                </li>
                @auth
                    <li class="nav-item ms-2">
                        <a class="btn btn-gradient px-4 py-2 rounded-pill" href="{{ route('dashboard') }}"><i class="ti tabler-smart-home me-1"></i>Dashboard</a>
                    </li>
                @else
                    <li class="nav-item ms-2">
                        <a class="btn btn-gradient px-4 py-2 rounded-pill" href="{{ route('login') }}"><i class="ti tabler-lock-open me-1"></i>Staff Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- 1. HERO SECTION -->
<div id="hero" class="position-relative overflow-hidden py-5 bg-slate-950">
    <div class="grid-bg"></div>
    <div class="orb-orange"></div>
    <div class="orb-cyan"></div>
    
    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 px-3.5 py-2 rounded-pill mb-4" style="background: rgba(243, 112, 33, 0.15); border: 1px solid rgba(243, 112, 33, 0.35);">
                    <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                    <span class="text-white fs-7 fw-bold" style="letter-spacing: 0.3px;">Certified Smartphone & Device Servicing Center</span>
                </div>
                
                <h1 class="display-4 fw-black text-white mb-3 leading-tight">
                    Professional Repair & <br><span class="gradient-text">Care For Your Mobile</span>
                </h1>
                
                <p class="text-slate-400 fs-5 mb-4 max-w-2xl me-lg-auto">
                    Experienced Technicians, 100% Genuine Spare Parts, Transparent Pricing, and Real-Time Ticket Tracking for All Major Brands.
                </p>

                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-3 mb-4">
                    <a href="{{ route('book.form') }}" class="btn btn-gradient btn-lg px-4 py-3 rounded-pill fw-bold fs-6">
                        <i class="ti tabler-tools me-2"></i> Book Repair Service
                    </a>
                    <a href="#track" class="btn btn-outline-track btn-lg px-4 py-3 rounded-pill fw-bold fs-6">
                        <i class="ti tabler-search me-2"></i> Track Repair Ticket
                    </a>
                </div>
            </div>

            <!-- Hero Quick Actions Box Right -->
            <div class="col-lg-5">
                <div class="glass-card p-4 text-start">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-white border-opacity-10">
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning fs-3">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white">Quick Repair Booking</h5>
                            <span class="text-slate-400 fs-7">Submit your device servicing request online</span>
                        </div>
                    </div>

                    <a href="{{ route('book.form') }}" class="btn btn-gradient w-100 py-3 rounded-3 fw-bold fs-6 mb-3 text-center d-block">
                        <i class="bi bi-calendar-check me-2"></i> Book a Repair Appointment
                    </a>

                    <div class="p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10">
                        <label class="form-label text-white fs-7 fw-semibold mb-2">Track Existing Repair Ticket:</label>
                        <form action="{{ route('track.search') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="ticket_id" class="form-control input-glow rounded-start-3 fs-7" placeholder="Ticket ID (e.g. M3-202607-XXXX)" required>
                                <button class="btn btn-warning fw-bold px-3 fs-7" type="submit">Track</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. OUR SERVICES SECTION -->
<div id="services" class="py-5 bg-slate-900">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fs-7 fw-bold text-uppercase">What We Do</span>
            <h2 class="display-6 fw-bold mt-2">Our Specialized Services</h2>
            <p class="text-slate-400 max-w-xl mx-auto fs-6">Comprehensive mobile device troubleshooting and repair solutions backed by expert technicians.</p>
        </div>

        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="service-icon-box">
                        <i class="bi bi-phone"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Display & Touch Replacement</h5>
                    <p class="text-slate-400 fs-6 mb-0">Original AMOLED, OLED, and LCD display assembly replacements for cracked screens with touch glass restoration.</p>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="service-icon-box" style="color: #22c55e; border-color: rgba(34, 197, 94, 0.25); background: rgba(34, 197, 94, 0.1);">
                        <i class="bi bi-battery-charging"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Battery Health & Replacement</h5>
                    <p class="text-slate-400 fs-6 mb-0">Original high-capacity battery installation for fast draining, swollen, or non-charging smartphones with battery health calibration.</p>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="service-icon-box" style="color: #06b6d4; border-color: rgba(6, 182, 212, 0.25); background: rgba(6, 182, 212, 0.1);">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Water Damage & IC Repair</h5>
                    <p class="text-slate-400 fs-6 mb-0">Advanced chip-level micro soldering, liquid corrosion cleanup, short circuit fixing, and motherboard IC replacement.</p>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="service-icon-box" style="color: #a855f7; border-color: rgba(168, 85, 247, 0.25); background: rgba(168, 85, 247, 0.1);">
                        <i class="bi bi-plug"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Charging Port & Audio Fix</h5>
                    <p class="text-slate-400 fs-6 mb-0">Type-C & Lightning charging port replacement, speaker noise cleanup, earpiece repair, and microphone replacement.</p>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="service-icon-box" style="color: #eab308; border-color: rgba(234, 179, 8, 0.25); background: rgba(234, 179, 8, 0.1);">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Software Flash & Unlocking</h5>
                    <p class="text-slate-400 fs-6 mb-0">Official OS firmware updates, stuck-on-logo bootloop fixes, FRP lock removal, network unlocking, and data backup.</p>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100">
                    <div class="service-icon-box" style="color: #f43f5e; border-color: rgba(244, 63, 94, 0.25); background: rgba(244, 63, 94, 0.1);">
                        <i class="bi bi-camera"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Camera & Housing Repair</h5>
                    <p class="text-slate-400 fs-6 mb-0">Rear & front camera lens replacement, blurry focus troubleshooting, back glass replacement, and body frame restoration.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADVANCED EQUIPMENT & LAB SETUP SECTION -->
<div id="equipment-lab" class="py-5 bg-slate-900">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-7 fw-bold text-uppercase">Modern Repair Lab</span>
            <h2 class="display-6 fw-bold mt-2">Advanced Repair Equipment & Technology</h2>
            <p class="text-slate-400 max-w-xl mx-auto fs-6">We invest in professional, high-precision laboratory tools to deliver accurate diagnostics, chip-level micro soldering, and safe device servicing.</p>
        </div>

        <div class="row g-4">
            <!-- Equipment Item 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/microscope.jpg') }}" alt="SOPTOP Microscope" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-warning text-dark align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">Micro-Soldering</span>
                    <h5 class="fw-bold mb-2 text-white">Trinocular Stereo Microscope</h5>
                    <p class="text-slate-400 fs-7 mb-0">High-magnification HD optical microscope used for precise IC chip inspection, motherboard trace repairing, and micro-soldering.</p>
                </div>
            </div>

            <!-- Equipment Item 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/dc-power.jpg') }}" alt="SUGON DC Power Supply" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-info text-white align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">Diagnostic Lab</span>
                    <h5 class="fw-bold mb-2 text-white">Precision DC Power Supply</h5>
                    <p class="text-slate-400 fs-7 mb-0">Digital 30V/5A power supply & current analyzer used for short circuit detection, current consumption diagnosis, and boot testing.</p>
                </div>
            </div>

            <!-- Equipment Item 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/hot-air-station.jpg') }}" alt="SUGON Hot Air Rework Station" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-success text-white align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">Chipset Rework</span>
                    <h5 class="fw-bold mb-2 text-white">Digital Hot Air Rework Station</h5>
                    <p class="text-slate-400 fs-7 mb-0">Microprocessor-controlled high-flow heat station for CPU, RAM, and power IC desoldering with thermal-controlled safety.</p>
                </div>
            </div>

            <!-- Equipment Item 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/soldering-station.jpg') }}" alt="Soldering Station" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-primary text-white align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">Precision Welding</span>
                    <h5 class="fw-bold mb-2 text-white">Dual-Channel Soldering Station</h5>
                    <p class="text-slate-400 fs-7 mb-0">Rapid-heating dual iron station for ultra-fine jumper wiring, FPC connector soldering, and delicate motherboard repair.</p>
                </div>
            </div>

            <!-- Equipment Item 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/pcb-holder.jpg') }}" alt="Universal PCB Holder" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-warning text-dark align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">Motherboard Fixture</span>
                    <h5 class="fw-bold mb-2 text-white">Universal Steel PCB Fixture Holder</h5>
                    <p class="text-slate-400 fs-7 mb-0">High-temperature resistant steel fixture clamp used for locking phone motherboards securely during IC removal and micro-soldering.</p>
                </div>
            </div>

            <!-- Equipment Item 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/logic-board-clamp.jpg') }}" alt="XZZ Logic Board Clamp" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-info text-white align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">High-Precision IC Clamp</span>
                    <h5 class="fw-bold mb-2 text-white">XZZ High-Precision Logic Board Fixture</h5>
                    <p class="text-slate-400 fs-7 mb-0">Precision synthetic stone & steel clamp specially designed for dual-layer iPhone & flagship Android logic board reballing & repair.</p>
                </div>
            </div>

            <!-- Equipment Item 7 -->
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-3 h-100 d-flex flex-column">
                    <div class="bg-white rounded-4 p-3 mb-3 text-center border border-white border-opacity-10" style="height: 220px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/img/equipment/fume-extractor.jpg') }}" alt="YIHUA Fume Extractor" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                    <span class="badge bg-success text-white align-self-start mb-2 px-2.5 py-1 rounded-pill fs-8">Clean Air Lab</span>
                    <h5 class="fw-bold mb-2 text-white">YIHUA Fume Extractor & Soldering Unit</h5>
                    <p class="text-slate-400 fs-7 mb-0">ESD-safe active carbon smoke absorber & soldering station ensuring a clean, dust-free lab environment for delicate repairs.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. WHY WE ARE DIFFERENT SECTION -->
<div id="why-different" class="py-5 bg-slate-950">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fs-7 fw-bold text-uppercase">Why Choose Us</span>
            <h2 class="display-6 fw-bold mt-2">Why M3 Mobile Care Is Different</h2>
            <p class="text-slate-400 max-w-xl mx-auto fs-6">Here is how we stand out from ordinary repair shops to deliver peace of mind for your valuable devices.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 border-start border-4 border-warning">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning fs-4">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-white">100% Genuine Parts</h5>
                    </div>
                    <p class="text-slate-400 fs-6 mb-0">We never compromise with low-grade components. All displays, batteries, and ICs are sourced directly from certified original vendors.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 border-start border-4 border-info">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-info bg-opacity-10 text-info fs-4">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-white">Real-Time Ticket Tracking</h5>
                    </div>
                    <p class="text-slate-400 fs-6 mb-0">No endless phone calls or guessing. Track your device repair status 24/7 online using your unique Ticket ID from any phone or PC.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 border-start border-4 border-success">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success fs-4">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-white">Expert Micro-Soldering Techs</h5>
                    </div>
                    <p class="text-slate-400 fs-6 mb-0">Our engineers specialize in advanced chip-level motherboard IC repair, liquid corrosion treatment, and complex circuit soldering.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 border-start border-4 border-primary">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary fs-4">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-white">Transparent & Upfront Pricing</h5>
                    </div>
                    <p class="text-slate-400 fs-6 mb-0">We provide clear diagnostic estimates before starting any repair work. No hidden fees, extra labor costs, or surprise bills.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 border-start border-4 border-danger">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-danger bg-opacity-10 text-danger fs-4">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-white">Service Warranty Coverage</h5>
                    </div>
                    <p class="text-slate-400 fs-6 mb-0">Every screen, battery, and major repair comes backed by an official M3 warranty coverage for total post-service peace of mind.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="glass-card p-4 h-100 border-start border-4 border-warning">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning fs-4">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-white">Express Turnaround Time</h5>
                    </div>
                    <p class="text-slate-400 fs-6 mb-0">We understand your smartphone is vital. Most battery swaps, display fittings, and basic repairs are completed in express fast turnaround time.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. MISSION & VISION SECTION -->
<div id="mission-vision" class="py-5 bg-slate-950">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fs-7 fw-bold text-uppercase">Who We Are</span>
            <h2 class="display-6 fw-bold mt-2">Our Mission & Vision</h2>
            <p class="text-slate-400 max-w-xl mx-auto fs-6">Driving technical excellence and customer confidence through transparent servicing standards.</p>
        </div>

        <div class="row g-4">
            <!-- Mission Card -->
            <div class="col-lg-6">
                <div class="glass-card p-5 h-100 border-start border-4 border-warning">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-3 bg-warning bg-opacity-10 text-warning fs-3">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h3 class="fw-bold mb-0">Our Mission</h3>
                    </div>
                    <p class="text-slate-300 fs-5 leading-relaxed">
                        To provide transparent, high-speed, and ultra-reliable mobile device repair services using authentic components, certified engineering expertise, and state-of-the-art diagnostic technology. We aim to eliminate service anxiety by offering real-time repair tracking and honest pricing.
                    </p>
                </div>
            </div>

            <!-- Vision Card -->
            <div class="col-lg-6">
                <div class="glass-card p-5 h-100 border-start border-4 border-info">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-3 bg-info bg-opacity-10 text-info fs-3">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3 class="fw-bold mb-0">Our Vision</h3>
                    </div>
                    <p class="text-slate-300 fs-5 leading-relaxed">
                        To redefine mobile care excellence in Bangladesh by establishing an interconnected, customer-first servicing ecosystem driven by trust, technical perfection, and unmatched convenience for smartphone users across the country.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. LIVE TRACKING SECTION -->
<div id="track" class="py-5 bg-slate-900">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fs-7 fw-bold text-uppercase">Live Tracking</span>
                <h2 class="display-6 fw-bold mt-2">Track Your Repair Ticket</h2>
                <p class="text-slate-400 fs-6 mb-4">Enter your Ticket ID below to check live repair progress, estimated cost, and status updates.</p>

                <div class="glass-card p-4 p-md-5">
                    <form action="{{ route('track.search') }}" method="POST" class="row g-3 align-items-center">
                        @csrf
                        <div class="col-md-8">
                            <input type="text" name="ticket_id" class="form-control form-control-lg input-glow rounded-pill px-4" placeholder="Enter Ticket ID (e.g. M3-202607-XXXX)" value="{{ request('ticket_id') }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill fw-bold">
                                <i class="ti tabler-search me-1"></i> Track Now
                            </button>
                        </div>
                    </form>

                    <!-- Ticket Search Details Result -->
                    @if(isset($searched) && $searched)
                        <div class="mt-4 pt-4 border-top border-white border-opacity-10 text-start">
                            @if(isset($repair) && $repair)
                                <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-white rounded-4 p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0 text-success">Ticket Found: {{ $repair->ticket_id }}</h5>
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill text-uppercase">{{ $repair->status }}</span>
                                    </div>
                                    <div class="row g-2 small">
                                        <div class="col-6"><strong>Device:</strong> {{ $repair->device_brand }} {{ $repair->device_model }}</div>
                                        <div class="col-6"><strong>Estimated Cost:</strong> ৳{{ number_format($repair->estimated_cost, 2) }}</div>
                                        <div class="col-12"><strong>Issue Description:</strong> {{ $repair->issue_description }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-white rounded-4 p-3 text-center">
                                    <i class="bi bi-exclamation-triangle me-2"></i> No repair ticket found matching "{{ request('ticket_id') }}". Please check your Ticket ID.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-slate-950 text-slate-400 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <h4 class="text-white fw-bold mb-3">M3 Mobile Care</h4>
                <p class="fs-6 text-slate-400 mb-4">Certified mobile repair and device servicing center in Bangladesh. Offering genuine spare parts, expert micro-soldering, and instant status tracking.</p>
                <div class="d-flex gap-3 fs-5 text-slate-300">
                    <a href="#" class="text-slate-400 hover-text-white"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-slate-400 hover-text-white"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="text-slate-400 hover-text-white"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <div class="col-md-3">
                <h6 class="text-white fw-bold mb-3 text-uppercase fs-7">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#services" class="text-slate-400 text-decoration-none">Our Services</a></li>
                    <li class="mb-2"><a href="#mission-vision" class="text-slate-400 text-decoration-none">Mission & Vision</a></li>
                    <li class="mb-2"><a href="#track" class="text-slate-400 text-decoration-none">Track Repair Status</a></li>
                    <li class="mb-2"><a href="{{ route('book.form') }}" class="text-slate-400 text-decoration-none">Book a Repair</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3 text-uppercase fs-7">Contact Information</h6>
                <p class="mb-2"><i class="bi bi-geo-alt text-warning me-2"></i> M3 Mobile Care Center, Main Road, Bangladesh</p>
                <p class="mb-2"><i class="bi bi-telephone text-warning me-2"></i> Helpline: +880 1700-000000</p>
                <p class="mb-0"><i class="bi bi-clock text-warning me-2"></i> Service Hours: 10:00 AM - 9:00 PM</p>
            </div>
        </div>

        <div class="border-top border-white border-opacity-5 mt-5 pt-4 text-center fs-7 text-slate-500">
            &copy; {{ date('Y') }} M3 Mobile Care. All Rights Reserved.
        </div>
    </div>
</footer>
@endsection
