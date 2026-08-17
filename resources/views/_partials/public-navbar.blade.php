<!-- Top Announcement & Hotline Bar -->
<div style="background-color: #0f172a;" class="text-white py-2 px-3 fs-7 fw-medium d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span><i class="ti tabler-map-pin text-warning me-1"></i> (Big Bazar) Abdul Goffar Market, Ranisankail, Thakurgaon</span>
            <span class="opacity-25">|</span>
            <span><i class="ti tabler-clock text-info me-1"></i> Open Daily: 9:00 AM - 9:30 PM</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="tel:+8801353106967" class="text-white text-decoration-none hover-text-warning"><i class="ti tabler-phone-call text-success me-1"></i> +8801353106967</a>
            <span class="opacity-25">|</span>
            <a href="https://wa.me/8801353106967" target="_blank" class="text-white text-decoration-none hover-text-success"><i class="ti tabler-brand-whatsapp text-success me-1"></i> WhatsApp</a>
        </div>
    </div>
</div>

<!-- Main Clean Customer Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3 shadow-sm border-bottom" aria-label="Main Navigation">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" aria-label="M3 Mobile Care Homepage">
            <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care Logo" width="40" height="40" style="height: 40px; width: auto; object-fit: contain;" class="me-2.5">
            <div class="d-flex flex-column">
                <span class="fs-4 fw-extrabold text-dark lh-1" style="font-family: 'Outfit', sans-serif;">M3 <span style="color: #f37021;">MOBILE CARE</span></span>
                <span class="text-muted fs-8 fw-medium">Trusted Mobile Repair Center</span>
            </div>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links (English Only) -->
        <div class="collapse navbar-collapse" id="publicNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 text-dark {{ request()->routeIs('home') ? 'active-nav-link text-orange' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 text-dark {{ request()->routeIs('services') ? 'active-nav-link text-orange' : '' }}" href="{{ route('services') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 {{ request()->routeIs('track.form') || request()->routeIs('ert') ? 'active-nav-link text-orange' : '' }}" href="{{ route('track.form') }}">
                        <span class="badge bg-danger text-white rounded-pill me-1 px-2 py-0.5 fs-8">LIVE</span>
                        ERT Tracking
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 text-dark {{ request()->routeIs('about') ? 'active-nav-link text-orange' : '' }}" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 text-dark {{ request()->routeIs('contact') ? 'active-nav-link text-orange' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                </li>
                
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a href="{{ route('book.form') }}" class="btn btn-brand-cta text-white rounded-3 px-4 py-2 fw-bold d-flex align-items-center shadow-sm">
                        <i class="ti tabler-calendar-plus me-1.5"></i> Book Repair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .text-orange { color: #f37021 !important; }
    .active-nav-link {
        color: #f37021 !important;
        font-weight: 700 !important;
        border-bottom: 2px solid #f37021;
    }
    .btn-brand-cta {
        background-color: #f37021 !important;
        border: none !important;
        transition: all 0.25s ease;
    }
    .btn-brand-cta:hover {
        background-color: #e05e0e !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(243, 112, 33, 0.3) !important;
    }
</style>
