@php
    $cartCount = count(session('cart', []));
    $wishlistCount = count(session('wishlist', []));
@endphp

<!-- SIDEBAR SECTION START -->
<div class="ul-sidebar">
    <!-- header -->
    <div class="ul-sidebar-header">
        <div class="ul-sidebar-header-logo">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="logo" class="logo" style="max-height: 40px; width: auto; object-fit: contain;">
                <span class="ms-2 fw-bold fs-5" style="color: var(--ul-primary); letter-spacing: -0.5px;">M3 Mobile Care</span>
            </a>
        </div>
        <!-- sidebar closer -->
        <button class="ul-sidebar-closer"><i class="flaticon-close"></i></button>
    </div>

    <div class="ul-sidebar-header-nav-wrapper d-block d-lg-none"></div>

    <div class="ul-sidebar-about d-none d-lg-block">
        <span class="title">About M3 Mobile Care</span>
        <p class="mb-0">Your trusted destination for premium mobile accessories, chargers, back covers, tempered glass, headphones, and smart gadgets.</p>
    </div>

    <!-- sidebar footer -->
    <div class="ul-sidebar-footer">
        <span class="ul-sidebar-footer-title">Follow us</span>
        <div class="ul-sidebar-footer-social">
            <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
            <a href="#"><i class="flaticon-twitter"></i></a>
            <a href="#"><i class="flaticon-instagram"></i></a>
            <a href="#"><i class="flaticon-youtube"></i></a>
        </div>
    </div>
</div>
<!-- SIDEBAR SECTION END -->

<!-- HEADER SECTION START -->
<header class="ul-header">
    <!-- header top -->
    <div class="ul-header-top">
        <div class="ul-header-top-slider splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide"><p class="ul-header-top-slider-item"><i class="flaticon-sparkle"></i> Genuine Accessories Offer</p></li>
                    <li class="splide__slide"><p class="ul-header-top-slider-item"><i class="flaticon-sparkle"></i> Fast Delivery Nationwide</p></li>
                    <li class="splide__slide"><p class="ul-header-top-slider-item"><i class="flaticon-sparkle"></i> Best Quality Chargers & Glass</p></li>
                    <li class="splide__slide"><p class="ul-header-top-slider-item"><i class="flaticon-sparkle"></i> Smartphone Gadgets & Accessories Hub</p></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- header bottom -->
    <div class="ul-header-bottom">
        <div class="ul-container">
            <div class="ul-header-bottom-wrapper">
                <!-- header left -->
                <div class="header-bottom-left">
                    <div class="logo-container">
                        <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-decoration-none">
                            <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care" class="logo me-2" style="max-height: 42px; width: auto; object-fit: contain;">
                            <span class="fw-extrabold fs-4 text-dark" style="letter-spacing: -0.5px;">M3 <span style="color: var(--ul-primary);">Mobile Care</span></span>
                        </a>
                    </div>

                    <!-- search form -->
                    <div class="ul-header-search-form-wrapper flex-grow-1 flex-shrink-0">
                        <form action="{{ route('shop.catalog') }}" method="GET" class="ul-header-search-form">
                            <div class="ul-header-search-form-right border-0 w-100">
                                <input type="search" name="search" id="ul-header-search" placeholder="Search Accessories (Charger, Cover, Glass...)" value="{{ request('search') }}">
                                <button type="submit"><span class="icon"><i class="flaticon-search-interface-symbol"></i></span></button>
                            </div>
                        </form>
                        <button class="ul-header-mobile-search-closer d-xxl-none"><i class="flaticon-close"></i></button>
                    </div>
                </div>

                <!-- header nav -->
                <div class="ul-header-nav-wrapper">
                    <div class="to-go-to-sidebar-in-mobile">
                        <nav class="ul-header-nav">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                            <a href="{{ route('shop.catalog') }}" class="{{ request()->routeIs('shop.catalog') ? 'active' : '' }}">Shop</a>
                            
                            <div class="has-sub-menu">
                                <a role="button">Pages</a>
                                <div class="ul-header-submenu">
                                    <ul>
                                        <li><a href="{{ route('shop.about') }}">About Us</a></li>
                                        <li><a href="{{ route('shop.faq') }}">FAQ</a></li>
                                        <li><a href="{{ route('shop.contact') }}">Contact</a></li>
                                        <li><a href="{{ route('customer.login') }}">Customer Login</a></li>
                                        <li><a href="{{ route('customer.register') }}">Customer Sign Up</a></li>
                                    </ul>
                                </div>
                            </div>

                            <a href="{{ route('shop.about') }}">About</a>
                            <a href="{{ route('shop.contact') }}">Contact</a>
                        </nav>
                    </div>
                </div>

                <!-- actions -->
                <div class="ul-header-actions">
                    <button class="ul-header-mobile-search-opener d-xxl-none"><i class="flaticon-search-interface-symbol"></i></button>
                    @if(auth()->check())
                        <div class="dropdown d-inline-block">
                            <a href="#" class="dropdown-toggle text-dark text-decoration-none fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="flaticon-user me-1" style="color: var(--ul-primary);"></i> {{ \Illuminate\Support\Str::words(auth()->user()->name, 1, '') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </li>
                                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->role === 'salesman')
                                    <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="flaticon-home me-2"></i>Admin Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item py-2 text-danger" href="{{ route('customer.logout') }}"><i class="flaticon-close me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('customer.login') }}" title="Login / Register"><i class="flaticon-user"></i></a>
                    @endif
                    <a href="{{ route('shop.wishlist') }}" class="position-relative">
                        <i class="flaticon-heart"></i>
                        @if($wishlistCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.4em;">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('shop.cart') }}" class="position-relative">
                        <i class="flaticon-shopping-bag"></i>
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.4em;">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>

                <!-- sidebar opener -->
                <div class="d-inline-flex">
                    <button class="ul-header-sidebar-opener"><i class="flaticon-hamburger"></i></button>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER SECTION END -->
