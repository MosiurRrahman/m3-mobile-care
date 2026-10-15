<!DOCTYPE html>
<html lang="bn">
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="description" content="M3 Mobile Care – Trusted Mobile Repair & Accessories Shop in Ranisankail, Thakurgaon. আপনার ফোনের যেকোনো সমস্যার নির্ভরযোগ্য সমাধান ও প্রিমিয়াম গ্যাজেট অ্যাক্সেসরিজ শপ।">
	<meta name="keywords" content="M3 Mobile Care, Trusted Mobile Repair & Accessories Shop, Mobile Repair Ranisankail, Phone Repair Thakurgaon, Display Repair, Battery Replacement, Motherboard IC Repair">
	<meta name="author" content="M3 Mobile Care">
	
	<!-- Page Title -->
    <title>M3 Mobile Care – Trusted Mobile Repair & Accessories Shop</title>
	
	<!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('mobikart/images/favicon.png') }}">
	
    <!-- Custom Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('mobikart/css/fonts.css') }}" rel="stylesheet" media="screen">
	<link href="{{ asset('mobikart/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<link href="{{ asset('mobikart/css/slicknav.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('mobikart/css/swiper-bundle.min.css') }}">
	<link href="{{ asset('mobikart/css/all.min.css') }}" rel="stylesheet" media="screen">
	<link href="{{ asset('mobikart/css/animate.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('mobikart/css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('mobikart/css/mousecursor.css') }}">
	<link href="{{ asset('mobikart/css/custom.css') }}" rel="stylesheet" media="screen">

    <style>
        :root {
            --brand-orange: #f97316;
            --brand-orange-hover: #ea580c;
            --brand-dark: #0f172a;
            --brand-body: #475569;
            --brand-muted: #94a3b8;
            --surface-white: #ffffff;
            --surface-subtle: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Outfit', 'Hind Siliguri', sans-serif !important;
            background-color: var(--surface-subtle);
            color: var(--brand-body);
            line-height: 1.65;
            overflow-x: clip;
        }

        /* Clean Minimal Button Styling */
        .btn-default:not(.btn-border),
        a.btn-default:not(.btn-border),
        button.btn-default:not(.btn-border) {
            background: var(--brand-orange) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.25) !important;
            border: none !important;
            font-weight: 600 !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-size: 15px !important;
            transition: all 0.25s ease !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-default:not(.btn-border):hover {
            background: var(--brand-orange-hover) !important;
            box-shadow: 0 6px 18px rgba(249, 115, 22, 0.35) !important;
            transform: translateY(-1px) !important;
            color: #ffffff !important;
        }

        .btn-outline-minimal {
            background: transparent !important;
            color: var(--brand-dark) !important;
            border: 1px solid var(--border-color) !important;
            font-weight: 600 !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-size: 15px !important;
            transition: all 0.25s ease !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-outline-minimal:hover {
            background: #ffffff !important;
            border-color: var(--brand-dark) !important;
            color: var(--brand-dark) !important;
            transform: translateY(-1px) !important;
        }

        /* Hero Action Buttons & Book Repair Highlight */
        .hero-action-buttons-wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }
        .btn-book-repair-highlight {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 18px rgba(249, 115, 22, 0.4) !important;
            border: none !important;
            font-weight: 700 !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-size: 15px !important;
            transition: all 0.25s ease !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-book-repair-highlight:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
            box-shadow: 0 6px 22px rgba(249, 115, 22, 0.5) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }
        .hero-secondary-buttons {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        /* Mobile Sticky Floating Book Repair Button */
        .mobile-floating-book-btn {
            position: fixed;
            bottom: 20px;
            right: 18px;
            z-index: 1050;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13.5px;
            padding: 10px 18px;
            border-radius: 50px;
            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.45);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            border: 2px solid #ffffff;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .mobile-floating-book-btn:hover,
        .mobile-floating-book-btn:active {
            transform: scale(1.05);
            color: #ffffff !important;
            box-shadow: 0 10px 28px rgba(249, 115, 22, 0.6);
        }

        /* Responsive Mobile Layout for Hero Buttons & Placeholders */
        @media (max-width: 767px) {
            .hero-action-buttons-wrap {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
                gap: 10px;
            }
            .btn-book-repair-highlight {
                width: 100% !important;
                padding: 13px 20px !important;
                font-size: 16px !important;
                justify-content: center;
                box-shadow: 0 6px 20px rgba(249, 115, 22, 0.45) !important;
            }
            .hero-secondary-buttons {
                display: flex;
                width: 100%;
                gap: 10px;
            }
            .hero-secondary-buttons a {
                flex: 1;
                justify-content: center;
                padding: 10px 12px !important;
                font-size: 13px !important;
                white-space: nowrap;
            }
        }

        @media (max-width: 576px) {
            .clean-search-box {
                padding: 4px 6px 4px 12px !important;
            }
            .clean-search-box input {
                font-size: 13px !important;
            }
            .clean-search-box button {
                padding: 7px 12px !important;
                font-size: 12.5px !important;
            }
        }

        /* Logo Sizing */
        .navbar-brand img {
            max-width: 240px !important;
            max-height: 50px !important;
            height: auto !important;
            width: auto !important;
        }
        .about-footer img {
            max-width: 240px !important;
            max-height: 50px !important;
            height: auto !important;
            width: auto !important;
        }

        /* Mega-Menu Clean Dropdown */
        .main-menu { position: relative !important; }
        .main-menu ul li.mega-menu { position: static !important; }
        .main-menu .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            background: #ffffff !important;
            border-radius: 0 0 12px 12px !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid var(--border-color) !important;
            border-top: none !important;
            padding: 35px 0 !important;
            margin: 0 !important;
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: opacity 0.2s ease, transform 0.2s ease !important;
            transform: translateY(6px) !important;
            z-index: 9999 !important;
        }
        .main-menu ul li.mega-menu:hover > .dropdown-menu {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }
        .main-menu .mega-menu-link h2 {
            color: var(--brand-dark) !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding-bottom: 8px !important;
            margin-bottom: 12px !important;
        }
        .main-menu .mega-menu-link ul li a {
            color: var(--brand-body) !important;
            font-size: 14.5px !important;
            font-weight: 400 !important;
            display: block !important;
            padding: 5px 0 !important;
            transition: color 0.2s ease !important;
        }
        .main-menu .mega-menu-link ul li a:hover {
            color: var(--brand-orange) !important;
        }

        /* Clean Hero */
        .clean-hero-stage {
            background-color: var(--surface-white);
            padding: 60px 0 55px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .minimal-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-subtle);
            border: 1px solid var(--border-color);
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--brand-dark);
            margin-bottom: 18px;
        }
        .minimal-badge i {
            color: var(--brand-orange);
        }

        .hero-title {
            font-size: clamp(30px, 4vw, 48px);
            font-weight: 800;
            color: var(--brand-dark);
            line-height: 1.25;
            margin-bottom: 16px;
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            letter-spacing: -0.5px;
        }
        .hero-title span {
            color: var(--brand-orange);
        }

        .hero-desc {
            font-size: 16.5px;
            color: var(--brand-body);
            line-height: 1.7;
            max-width: 540px;
            margin-bottom: 25px;
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
        }

        .clean-search-box {
            background: var(--surface-white);
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 6px 8px 6px 16px;
            max-width: 480px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            display: flex;
            align-items: center;
        }
        .clean-search-box input {
            border: none !important;
            padding: 8px 0 !important;
            font-size: 14.5px !important;
            color: var(--brand-dark) !important;
            outline: none !important;
            box-shadow: none !important;
            flex: 1;
            min-width: 0;
            width: 100%;
            text-overflow: ellipsis;
        }

        /* Clean Cards */
        .minimal-card {
            background: var(--surface-white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.25s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .minimal-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            transform: translateY(-2px);
        }

        .icon-box-minimal {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: var(--surface-subtle);
            border: 1px solid var(--border-color);
            color: var(--brand-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
            transition: all 0.25s ease;
        }
        .minimal-card:hover .icon-box-minimal {
            background: var(--brand-dark);
            color: #ffffff;
            border-color: var(--brand-dark);
        }

        .section-header-minimal {
            text-align: center;
            max-width: 620px;
            margin: 0 auto 45px auto;
        }
        .section-header-minimal .tagline {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--brand-orange);
            margin-bottom: 8px;
            display: block;
        }
        .section-header-minimal h2 {
            font-size: clamp(24px, 3vw, 34px);
            font-weight: 800;
            color: var(--brand-dark);
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            margin-bottom: 10px;
        }
        .section-header-minimal p {
            color: var(--brand-body);
            font-size: 15.5px;
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            margin: 0;
        }

        /* Minimal Product Card */
        .clean-product-box {
            background: var(--surface-white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.25s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .clean-product-box:hover {
            border-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            transform: translateY(-2px);
        }
        .clean-product-box .img-holder {
            background: #fafafa;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }
        .clean-product-box .img-holder img {
            max-height: 150px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .clean-product-box:hover .img-holder img {
            transform: scale(1.04);
        }
        .clean-product-box .details {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
    </style>
</head>
<body>

    <!-- Preloader Start -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('mobikart/images/loader.svg') }}" alt="M3 Mobile Care"></div>
		</div>
	</div>
	<!-- Preloader End -->

    <!-- Clean Top Info Bar -->
    <div style="background-color: #0f172a;" class="text-white py-2 px-3 fs-7 fw-medium d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3" style="font-size: 13px; color: #cbd5e1;">
                <span><i class="fa-solid fa-location-dot text-warning me-1"></i> (বিগ বাজার) আব্দুল গফফার মার্কেট, রাণীশংকৈল, ঠাকুরগাঁও</span>
                <span class="opacity-25">|</span>
                <span><i class="fa-regular fa-clock text-info me-1"></i> প্রতিদিন সকাল ৯:০০ - রাত ৯:৩০</span>
            </div>
            <div class="d-flex align-items-center gap-3" style="font-size: 13px;">
                <a href="tel:+8801353106967" class="text-white text-decoration-none"><i class="fa-solid fa-phone text-success me-1"></i> +8801353106967</a>
                <span class="opacity-25">|</span>
                <a href="https://wa.me/8801353106967" target="_blank" class="text-white text-decoration-none"><i class="fa-brands fa-whatsapp text-success me-1"></i> WhatsApp</a>
            </div>
        </div>
    </div>

    <!-- Header Start -->
	<header class="main-header">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
                <!-- Header Action Box Start -->
                <div class="header-action-box">
                    <!-- Logo Start -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('mobikart/images/logo.svg') }}" alt="M3 Mobile Care">
                    </a>
                    <!-- Logo End -->
                    
                    <!-- Header Search Form Box Start -->
                    <div class="header-search-form-box">
                        <form class="header-search-form" id="headerForm" action="{{ route('products') }}" method="GET">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search products, repairs..." value="{{ request('search') }}" required>
                                <button type="submit" class="header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- Header Search Form Box End -->
                    
                    <!-- Header Action Details Start -->
                    <div class="header-action-details mobile-hide">
                        <ul>
                            <li><a href="{{ route('track.form') }}" title="Track Job"><i class="fa-solid fa-screwdriver-wrench text-dark me-1"></i> Track Job</a></li>
                            <li><a href="https://wa.me/8801353106967" target="_blank" title="WhatsApp Order"><i class="fa-brands fa-whatsapp text-success fs-5 me-1"></i> WhatsApp</a></li>
                        </ul>
                    </div>
                    <!-- Header Action Details End -->
                </div>
                <!-- Header Action Box End -->

                <!-- Main Menu Start -->
                <div class="main-menu">
                    <div class="collapse navbar-collapse">
                        <div class="popular-categories-box">
                            <button class="popular-categories-btn">
                                <i class="fa-solid fa-bars"></i>Shop by Categories
                            </button>
                            <ul class="popular-categories-list">
                                <li><a href="{{ route('products') }}">Phone Cases</a></li>
                                <li><a href="{{ route('products') }}">Headphones</a></li>
                                <li><a href="{{ route('products') }}">Power Banks</a></li>
                                <li><a href="{{ route('products') }}">Smartwatches</a></li>
                                <li><a href="{{ route('products') }}">Chargers</a></li>
                                <li><a href="{{ route('products') }}">Earbuds</a></li>
                            </ul>
                        </div>
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item mega-menu submenu position-static">
                                    <a class="nav-link" href="{{ route('products') }}">Shop</a>
                                    <!-- Dropdown Menu Start -->
                                    <ul class="dropdown-menu">
                                        <li class="mega-menu-box">
                                            <div class="mega-menu-links-box">
                                                <div class="mega-menu-link">
                                                    <h2>Shop By Collection</h2>
                                                    <ul>
                                                        <li><a href="{{ route('products') }}">Phone Cases</a></li>
                                                        <li><a href="{{ route('products') }}">Headphones</a></li>
                                                        <li><a href="{{ route('products') }}">Power Banks</a></li>
                                                        <li><a href="{{ route('products') }}">Smartwatches</a></li>
                                                        <li><a href="{{ route('products') }}">Chargers</a></li>
                                                        <li><a href="{{ route('products') }}">Earbuds</a></li>
                                                    </ul>
                                                </div>
                                                <div class="mega-menu-link">
                                                    <h2>Shop Features</h2>
                                                    <ul>
                                                        <li><a href="{{ route('track.form') }}">Track Job (ERT)</a></li>
                                                        <li><a href="{{ route('services') }}">Repair Services</a></li>
                                                        <li><a href="{{ route('about') }}">About Us</a></li>
                                                        <li><a href="{{ route('contact') }}">Contact Support</a></li>
                                                        <li><a href="{{ route('products') }}">All Store Products</a></li>
                                                        <li><a href="{{ route('portal') }}">Staff Portal</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="mega-menu-items-list">
                                                <div class="mega-menu-item">
                                                    <div class="mega-menu-item-image">
                                                        <a href="{{ route('products') }}">
                                                            <figure class="image-anime">
                                                                <img src="{{ asset('mobikart/images/mega-menu-item-image-1.jpg') }}" alt="">
                                                            </figure>
                                                        </a>
                                                    </div>
                                                    <div class="mega-menu-item-content">
                                                        <h2><a href="{{ route('products') }}">Watch Collection</a></h2>
                                                        <p>Modern smartwatches with health tracking</p>
                                                    </div>
                                                </div>

                                                <div class="mega-menu-item">
                                                    <div class="mega-menu-item-image">
                                                        <a href="{{ route('products') }}">
                                                            <figure class="image-anime">
                                                                <img src="{{ asset('mobikart/images/mega-menu-item-image-2.jpg') }}" alt="">
                                                            </figure>
                                                        </a>
                                                    </div>
                                                    <div class="mega-menu-item-content">
                                                        <h2><a href="{{ route('products') }}">Audio Collection</a></h2>
                                                        <p>Wireless headphones &amp; earbuds</p>
                                                    </div>
                                                </div>

                                                <div class="mega-menu-item big-offer-box">
                                                    <div class="mega-menu-item-image">
                                                        <figure>
                                                            <img src="{{ asset('mobikart/images/mega-menu-item-image-3.jpg') }}" alt="">
                                                        </figure>
                                                    </div>
                                                    <div class="mega-menu-item-content">
                                                        <span>-special offer-</span>
                                                        <h2>Big Sale</h2>
                                                        <h3>50% Off</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('track.form') }}">Track Job</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" href="{{ route('book.form') }}" style="color: #f97316 !important;">
                                        <i class="fa-solid fa-calendar-check text-warning me-1"></i> Book Repair
                                        <span class="badge bg-warning text-dark rounded-pill ms-1 px-2 py-0.5" style="font-size: 10px;">ONLINE</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Header Action Details Start -->
                        <div class="header-action-details">
                            <ul>
                                <li><a href="{{ route('book.form') }}" class="btn btn-sm btn-light text-dark fw-bold px-3 py-2 rounded-2 shadow-sm" style="font-size: 13px;"><i class="fa-solid fa-calendar-check text-warning me-1"></i> Book Repair</a></li>
                            </ul>
                        </div>
                        <!-- Header Action Details End -->
                    </div>
					<div class="navbar-toggle"></div>
				</div>
                <!-- Main Menu End -->
			</nav>
            <div class="responsive-menu"></div>
		</div>
	</header>
	<!-- Header End -->

    <!-- ============================================================= -->
    <!-- 01. CLEAN & MINIMAL HERO SECTION                              -->
    <!-- ============================================================= -->
    <section class="clean-hero-stage">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 wow fadeInLeft">
                    <div class="minimal-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Certified Mobile Repair Center &amp; Accessories Shop</span>
                    </div>

                    <h1 class="hero-title">
                        আপনার ফোনের যেকোনো সমস্যার <br>
                        <span>বিশ্বস্ত ও দ্রুত সমাধান</span>
                    </h1>

                    <p class="hero-desc">
                        ডিসপ্লে, ব্যাটারি, মাদারবোর্ড আইসি রিপেয়ার থেকে শুরু করে অরিজিনাল মোবাইল গ্যাজেট ও এক্সেসরিজ কালেকশন — রানিংশংকৈলে ১০০% নির্ভরযোগ্য সেবা।
                    </p>

                    <!-- Clean Minimal Track Search Box -->
                    <div class="clean-search-box">
                        <form action="{{ route('track.search') }}" method="POST" class="d-flex align-items-center justify-content-between w-100">
                            @csrf
                            <input type="text" name="ticket_id" placeholder="Ticket ID / Mobile No..." required>
                            <button type="submit" class="btn-default py-2 px-3 text-nowrap" style="font-size: 13.5px;">
                                Track ERT <i class="fa-solid fa-arrow-right ms-1"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Clean Action Buttons with Book Repair Highlighted -->
                    <div class="hero-action-buttons-wrap mb-4">
                        <a href="{{ route('book.form') }}" class="btn-book-repair-highlight">
                            <i class="fa-solid fa-calendar-check text-warning fs-5"></i>
                            <span>Book Repair</span>
                            <span class="badge bg-white text-dark ms-1 px-2 py-0.5 rounded-pill fw-bold" style="font-size: 11px;">Fast Service</span>
                        </a>
                        <div class="hero-secondary-buttons">
                            <a href="{{ route('products') }}" class="btn-outline-minimal">
                                <i class="fa-solid fa-bag-shopping"></i> Explore Shop
                            </a>
                            <a href="https://wa.me/8801353106967" target="_blank" class="btn-outline-minimal">
                                <i class="fa-brands fa-whatsapp text-success fs-5"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Trust Stats Row -->
                    <div class="d-flex flex-wrap align-items-center gap-4 text-muted pt-1" style="font-size: 13.5px; font-weight: 500;">
                        <span><i class="fa-solid fa-check text-dark me-1"></i> 100% Genuine Spares</span>
                        <span><i class="fa-solid fa-bolt text-dark me-1"></i> 30-Min Quick Fix</span>
                        <span><i class="fa-solid fa-award text-dark me-1"></i> 30-90 Days Warranty</span>
                    </div>
                </div>

                <div class="col-lg-6 wow fadeInRight">
                    <div class="p-3 bg-white border rounded-4 shadow-sm">
                        <div class="swiper hero-showcase-slider" style="border-radius: 10px; overflow: hidden;">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('mobikart/images/hero-image.png') }}" alt="M3 Mobile Care" class="img-fluid w-100 rounded-3" style="object-fit: cover; max-height: 360px;">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('mobikart/images/mega-deal-item-image-1.jpg') }}" alt="Fast Accessories" class="img-fluid w-100 rounded-3" style="object-fit: cover; max-height: 360px;">
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mt-2 text-center">
                            <div class="col-4">
                                <div class="py-2 px-1 border rounded-3 bg-light">
                                    <div class="fw-bold fs-5 text-dark">4.9★</div>
                                    <div class="text-muted fs-8">Google Rating</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="py-2 px-1 border rounded-3 bg-light">
                                    <div class="fw-bold fs-5" style="color: var(--brand-orange);">10k+</div>
                                    <div class="text-muted fs-8">Phones Repaired</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="py-2 px-1 border rounded-3 bg-light">
                                    <div class="fw-bold fs-5 text-dark">100%</div>
                                    <div class="text-muted fs-8">Live Repairing</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================= -->
    <!-- 02. CLEAN REPAIR SOLUTIONS                                    -->
    <!-- ============================================================= -->
    <section class="py-5" style="background-color: var(--surface-white);">
        <div class="container py-3">
            <div class="section-header-minimal wow fadeInUp">
                <span class="tagline">Repair Services</span>
                <h2>সার্টিফাইড রিপেয়ার সার্ভিস</h2>
                <p>সব ব্র্যান্ডের ফোনের জটিল হার্ডওয়্যার ও সফটওয়্যারের নিখুঁত ডায়াগনসিস ও দ্রুত সমাধান।</p>
            </div>

            <div class="row g-4">
                <!-- Service 1 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp">
                    <div class="minimal-card">
                        <div class="icon-box-minimal">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="font-size: 18px; color: var(--brand-dark);">ডিসপ্লে ও টাচ গ্লাস</h4>
                        <p class="text-muted fs-6 mb-3 flex-grow-1" style="font-family: 'Hind Siliguri'; font-size: 14.5px;">ভাঙা গ্লাস পরিবর্তন, অরিজিনাল OLED/LCD ডিসপ্লে রিপ্লেসমেন্ট ও OCA লেমিনেশন।</p>
                        <a href="{{ route('services') }}" class="fw-bold text-decoration-none" style="color: var(--brand-orange); font-size: 14px;">View Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="minimal-card">
                        <div class="icon-box-minimal">
                            <i class="fa-solid fa-battery-half"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="font-size: 18px; color: var(--brand-dark);">ব্যাটারি ও ব্যাকআপ</h4>
                        <p class="text-muted fs-6 mb-3 flex-grow-1" style="font-family: 'Hind Siliguri'; font-size: 14.5px;">দ্রুত চার্জ ড্রেন, ফুলে যাওয়া ব্যাটারি পরিবর্তন ও ১০০% হেলথ অরিজিনাল ব্যাটারি।</p>
                        <a href="{{ route('services') }}" class="fw-bold text-decoration-none" style="color: var(--brand-orange); font-size: 14px;">View Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="minimal-card">
                        <div class="icon-box-minimal">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="font-size: 18px; color: var(--brand-dark);">মাদারবোর্ড ও আইসি</h4>
                        <p class="text-muted fs-6 mb-3 flex-grow-1" style="font-family: 'Hind Siliguri'; font-size: 14.5px;">ডেড ফোন রিকভারি, শর্ট সার্কিট, পাওয়ার আইসি, অডিও আইসি ও সিপিইউ রিবলিং।</p>
                        <a href="{{ route('services') }}" class="fw-bold text-decoration-none" style="color: var(--brand-orange); font-size: 14px;">View Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="minimal-card">
                        <div class="icon-box-minimal">
                            <i class="fa-solid fa-plug-circle-bolt"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="font-size: 18px; color: var(--brand-dark);">চার্জিং পোর্ট ও ওয়াটার ড্যামেজ</h4>
                        <p class="text-muted fs-6 mb-3 flex-grow-1" style="font-family: 'Hind Siliguri'; font-size: 14.5px;">চার্জ না নেওয়া, পানিতে পড়া ফোনের আল্ট্রাসনিক ক্লিন ও স্পিকার/মাইক রিপ্লেসমেন্ট।</p>
                        <a href="{{ route('services') }}" class="fw-bold text-decoration-none" style="color: var(--brand-orange); font-size: 14px;">View Details <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================= -->
    <!-- 03. CLEAN FEATURED ACCESSORIES                                -->
    <!-- ============================================================= -->
    <section class="py-5" style="background-color: var(--surface-subtle); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="container py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
                <div>
                    <span class="text-uppercase fw-bold fs-8" style="color: var(--brand-orange); letter-spacing: 0.8px;">Storefront Spotlight</span>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 28px; font-family: 'Hind Siliguri', sans-serif;">জনপ্রিয় গ্যাজেট ও অ্যাক্সেসরিজ</h2>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('products') }}" class="btn-outline-minimal py-2 px-3" style="font-size: 13.5px;">
                        All Store Products <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                @if(isset($inventoryProducts) && count($inventoryProducts) > 0)
                    @foreach($inventoryProducts->take(4) as $item)
                        <div class="col-sm-6 col-lg-3 wow fadeInUp">
                            <div class="clean-product-box">
                                <div class="img-holder position-relative">
                                    <a href="{{ route('product.single', $item->id) }}">
                                        @if(!empty($item->images) && is_array($item->images) && count($item->images) > 0)
                                            <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->name }}" class="img-fluid" onerror="this.onerror=null;this.src='{{ asset('mobikart/images/product-placeholder.png') }}';">
                                        @else
                                            <img src="{{ asset('mobikart/images/product-placeholder.png') }}" alt="{{ $item->name }}" class="img-fluid">
                                        @endif
                                    </a>
                                </div>
                                <div class="details">
                                    <span class="text-muted fs-8 mb-1">{{ $item->category ?? 'Accessories' }}</span>
                                    <h5 class="fw-bold mb-2 text-truncate" style="font-size: 16px;"><a href="{{ route('product.single', $item->id) }}" class="text-dark text-decoration-none">{{ $item->name }}</a></h5>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                        <h4 class="fw-bold mb-0 text-dark" style="font-size: 18px;">৳{{ number_format($item->sale_price, 2) }}</h4>
                                        <a href="https://wa.me/8801353106967?text={{ urlencode('Hi M3 Mobile Care, I want to buy: ' . $item->name . ' (Price: ৳' . $item->sale_price . ')') }}" target="_blank" class="btn btn-sm btn-dark rounded-2 px-3 py-1.5 fw-semibold" title="Order on WhatsApp">
                                            <i class="fa-brands fa-whatsapp text-success me-1"></i> Buy
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback 4 Default Store Products -->
                    <div class="col-sm-6 col-lg-3 wow fadeInUp">
                        <div class="clean-product-box">
                            <div class="img-holder">
                                <a href="{{ route('product.single.view') }}"><img src="{{ asset('mobikart/images/product-image-1.png') }}" alt="Wireless Earbuds Pro" class="img-fluid"></a>
                            </div>
                            <div class="details">
                                <span class="text-muted fs-8 mb-1">Audio &amp; Earbuds</span>
                                <h5 class="fw-bold mb-2 text-truncate" style="font-size: 16px;"><a href="{{ route('product.single.view') }}" class="text-dark text-decoration-none">Wireless Earbuds Pro</a></h5>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <h4 class="fw-bold mb-0 text-dark" style="font-size: 18px;">৳899.00</h4>
                                    <a href="{{ route('product.single.view') }}" class="btn btn-sm btn-outline-dark rounded-2 px-3 py-1.5">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="clean-product-box">
                            <div class="img-holder">
                                <a href="{{ route('product.single.view') }}"><img src="{{ asset('mobikart/images/product-image-2.png') }}" alt="Magnetic Charging Stand" class="img-fluid"></a>
                            </div>
                            <div class="details">
                                <span class="text-muted fs-8 mb-1">Fast Chargers</span>
                                <h5 class="fw-bold mb-2 text-truncate" style="font-size: 16px;"><a href="{{ route('product.single.view') }}" class="text-dark text-decoration-none">Magnetic Fast Charger</a></h5>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <h4 class="fw-bold mb-0 text-dark" style="font-size: 18px;">৳499.00</h4>
                                    <a href="{{ route('product.single.view') }}" class="btn btn-sm btn-outline-dark rounded-2 px-3 py-1.5">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="clean-product-box">
                            <div class="img-holder">
                                <a href="{{ route('product.single.view') }}"><img src="{{ asset('mobikart/images/product-image-3.png') }}" alt="SmartSync Cable" class="img-fluid"></a>
                            </div>
                            <div class="details">
                                <span class="text-muted fs-8 mb-1">Cables &amp; Adapters</span>
                                <h5 class="fw-bold mb-2 text-truncate" style="font-size: 16px;"><a href="{{ route('product.single.view') }}" class="text-dark text-decoration-none">SmartSync Type-C Cable</a></h5>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <h4 class="fw-bold mb-0 text-dark" style="font-size: 18px;">৳49.00</h4>
                                    <a href="{{ route('product.single.view') }}" class="btn btn-sm btn-outline-dark rounded-2 px-3 py-1.5">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="clean-product-box">
                            <div class="img-holder">
                                <a href="{{ route('product.single.view') }}"><img src="{{ asset('mobikart/images/product-image-4.png') }}" alt="Mini Smart Speaker" class="img-fluid"></a>
                            </div>
                            <div class="details">
                                <span class="text-muted fs-8 mb-1">Speakers</span>
                                <h5 class="fw-bold mb-2 text-truncate" style="font-size: 16px;"><a href="{{ route('product.single.view') }}" class="text-dark text-decoration-none">Mini Bluetooth Speaker</a></h5>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <h4 class="fw-bold mb-0 text-dark" style="font-size: 18px;">৳4899.00</h4>
                                    <a href="{{ route('product.single.view') }}" class="btn btn-sm btn-outline-dark rounded-2 px-3 py-1.5">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ============================================================= -->
    <!-- 04. WHY CHOOSE M3 MOBILE CARE                                 -->
    <!-- ============================================================= -->
    <section class="py-5" style="background-color: var(--surface-white);">
        <div class="container py-3">
            <div class="section-header-minimal wow fadeInUp">
                <span class="tagline">Quality Assurance</span>
                <h2>আমাদের সার্ভিসের নিশ্চয়তা</h2>
                <p>আমরা গ্রাহকের আস্থা ও পারফেক্ট কাজের কোয়ালিটিকে সর্বোচ্চ অগ্রাধিকার দিই।</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3 wow fadeInUp">
                    <div class="minimal-card text-center">
                        <div class="icon-box-minimal mx-auto">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-size: 17px;">সরাসরি চোখের সামনে মেরামত</h5>
                        <p class="text-muted fs-6 mb-0" style="font-family: 'Hind Siliguri'; font-size: 14px;">আপনার ফোন ও পার্সোনাল ডেটার নিরাপত্তার জন্য সম্পূর্ণ স্বচ্ছ প্রক্রিয়ায় সার্ভিস।</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="minimal-card text-center">
                        <div class="icon-box-minimal mx-auto">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-size: 17px;">অরিজিনাল ও টেস্টেড পার্টস</h5>
                        <p class="text-muted fs-6 mb-0" style="font-family: 'Hind Siliguri'; font-size: 14px;">সর্বোচ্চ কোয়ালিটির গ্রেড-A এবং অরিজিনাল স্পেয়ার পার্টস ব্যবহারের নিশ্চয়তা।</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="minimal-card text-center">
                        <div class="icon-box-minimal mx-auto">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-size: 17px;">অনলাইন লাইভ ট্র্যাকিং</h5>
                        <p class="text-muted fs-6 mb-0" style="font-family: 'Hind Siliguri'; font-size: 14px;">ঘরে বসেই ওয়েবসাইট থেকে আপনার রিপেয়ার জবের রিয়েল-টাইম স্ট্যাটাস চেক করুন।</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="minimal-card text-center">
                        <div class="icon-box-minimal mx-auto">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-size: 17px;">সার্ভিস ওয়ারেন্টি সাপোর্ট</h5>
                        <p class="text-muted fs-6 mb-0" style="font-family: 'Hind Siliguri'; font-size: 14px;">কাজের ধরন অনুযায়ী ৩০ থেকে ৯০ দিনের লিখিত সার্ভিস ওয়ারেন্টি ও আফটার সাপোর্ট।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================= -->
    <!-- 05. LOCATION & APPOINTMENT                                    -->
    <!-- ============================================================= -->
    <section class="py-5" style="background-color: var(--surface-subtle); border-top: 1px solid var(--border-color);">
        <div class="container py-3">
            <div class="row align-items-stretch g-4">
                <div class="col-lg-6 wow fadeInLeft">
                    <div class="p-4 p-md-5 rounded-3 bg-white border h-100">
                        <span class="text-uppercase fw-bold fs-8" style="color: var(--brand-orange); letter-spacing: 0.8px;">Quick Message</span>
                        <h3 class="fw-bold mb-2 text-dark" style="font-size: 24px; font-family: 'Hind Siliguri', sans-serif;">রিপেয়ার পরামর্শ বা মেসেজ পাঠান</h3>
                        <p class="text-muted mb-4" style="font-family: 'Hind Siliguri'; font-size: 14.5px;">আপনার ফোনের মডেল ও সমস্যার বিবরণ দিলে আমাদের টিম দ্রুত সহায়তা করবে।</p>
                        
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control py-2 px-3 rounded-2" placeholder="আপনার নাম" required style="font-size: 14.5px;">
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control py-2 px-3 rounded-2" placeholder="মোবাইল নম্বর" required style="font-size: 14.5px;">
                            </div>
                            <div class="mb-3">
                                <textarea name="message" rows="3" class="form-control py-2 px-3 rounded-2" placeholder="ফোনের মডেল ও সমস্যা (যেমন: Redmi Note 10 চার্জ নিচ্ছে না)..." required style="font-size: 14.5px;"></textarea>
                            </div>
                            <button type="submit" class="btn-default w-100 py-2.5">
                                <i class="fa-solid fa-paper-plane"></i> মেসেজ পাঠান (Send Message)
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 wow fadeInRight">
                    <div class="p-4 p-md-5 rounded-3 text-white h-100 d-flex flex-column justify-content-between" style="background: #0f172a;">
                        <div>
                            <div class="mb-4">
                                <img src="{{ asset('mobikart/images/logo-white.svg') }}" alt="M3 Mobile Care" style="max-height: 44px;">
                            </div>
                            
                            <h5 class="fw-bold text-white mb-4" style="font-family: 'Hind Siliguri';">শপ লোকেশন ও সাপোর্ট হটলাইন</h5>
                            
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <i class="fa-solid fa-location-dot text-warning fs-5 mt-1"></i>
                                <div>
                                    <div class="text-white fw-bold mb-1" style="font-size: 14.5px;">আমাদের ঠিকানা</div>
                                    <p class="text-white-50 mb-0" style="font-family: 'Hind Siliguri'; font-size: 14px;">(বিগ বাজার) আব্দুল গফফার মার্কেট, রাণীশংকৈল, ঠাকুরগাঁও</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3 mb-3">
                                <i class="fa-solid fa-phone text-success fs-5 mt-1"></i>
                                <div>
                                    <div class="text-white fw-bold mb-1" style="font-size: 14.5px;">হটলাইন ও হোয়াটসঅ্যাপ</div>
                                    <p class="text-white-50 mb-0" style="font-size: 14px;">+8801353106967 / +8801353106966</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i class="fa-regular fa-clock text-info fs-5 mt-1"></i>
                                <div>
                                    <div class="text-white fw-bold mb-1" style="font-size: 14.5px;">সার্ভিস সময়সূচি</div>
                                    <p class="text-white-50 mb-0" style="font-family: 'Hind Siliguri'; font-size: 14px;">প্রতিদিন সকাল ৯:০০ টা থেকে রাত ৯:৩০ টা (সপ্তাহের ৭ দিন খোলা)</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-top border-secondary">
                            <a href="https://wa.me/8801353106967" target="_blank" class="btn btn-outline-light w-100 py-2.5 rounded-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 14.5px;">
                                <i class="fa-brands fa-whatsapp text-success fs-5"></i> সরাসরি হোয়াটসঅ্যাপে চ্যাট করুন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================= -->
    <!-- 06. CLEAN FOOTER                                              -->
    <!-- ============================================================= -->
    <footer class="main-footer" style="background-color: #0b0f19;">
        <div class="container">
            <div class="row">
                <div class="col-xl-4">
                    <div class="about-footer">
                        <div class="footer-logo">
                            <img src="{{ asset('mobikart/images/logo-white.svg') }}" alt="M3 Mobile Care">
                        </div>
                        <div class="about-footer-content">
                            <p>Discover premium mobile accessories designed for style, performance, and convenience in Ranisankail, Thakurgaon. From fast chargers to wireless gadgets and repair spares.</p>
                        </div>
                        <div class="footer-social-links">
                            <ul>
                                <li><a href="https://wa.me/8801353106967" target="_blank" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a></li>
                                <li><a href="https://facebook.com" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="tel:+8801353106967" title="Call Us"><i class="fa-solid fa-phone"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="footer-links-box">
                        <div class="footer-links">
                            <h2>Quick Links</h2>
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('products') }}">Shop Store</a></li>
                                <li><a href="{{ route('services') }}">Services</a></li>
                                <li><a href="{{ route('track.form') }}">Track Job (ERT)</a></li>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>

                        <div class="footer-links">
                            <h2>Our Categories</h2>
                            <ul>
                                <li><a href="{{ route('products') }}">Phone Cases</a></li>
                                <li><a href="{{ route('products') }}">Wireless Earbuds</a></li>
                                <li><a href="{{ route('products') }}">Power Banks</a></li>
                                <li><a href="{{ route('products') }}">Smart Watches</a></li>
                                <li><a href="{{ route('products') }}">Fast Chargers</a></li>
                                <li><a href="{{ route('products') }}">Display Spares</a></li>
                            </ul>
                        </div>

                        <div class="footer-links footer-newsletter-form">
                            <h2>Location &amp; Hotline</h2>
                            <p class="text-white mb-2"><i class="fa-solid fa-location-dot text-warning me-2"></i> (বিগ বাজার) আব্দুল গফফার মার্কেট, রাণীশংকৈল, ঠাকুরগাঁও</p>
                            <p class="text-white mb-2"><i class="fa-solid fa-phone text-success me-2"></i> +8801353106967 / +8801353106966</p>
                            <p style="color: #94a3b8; font-size: 14px;">খোলা: প্রতিদিন সকাল ৯:০০ টা - রাত ৯:৩০ টা</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="footer-copyright">
                        <div class="footer-copyright-text">
                            <p>Copyright © {{ date('Y') }} <b>M3 Mobile Care</b>. All Rights Reserved.</p>
                        </div>
                        <div class="footer-privacy-policy">
                            <ul>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                <li><a href="{{ route('portal') }}">Staff Portal</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Jquery Library File -->
    <script src="{{ asset('mobikart/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js file -->
    <script src="{{ asset('mobikart/js/bootstrap.min.js') }}"></script>
    <!-- Validator js file -->
    <script src="{{ asset('mobikart/js/validator.min.js') }}"></script>
    <!-- SlickNav js file -->
    <script src="{{ asset('mobikart/js/jquery.slicknav.js') }}"></script>
    <!-- Swiper js file -->
    <script src="{{ asset('mobikart/js/swiper-bundle.min.js') }}"></script>
    <!-- Counter js file -->
    <script src="{{ asset('mobikart/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('mobikart/js/jquery.counterup.min.js') }}"></script>
    <!-- Magnific js file -->
    <script src="{{ asset('mobikart/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- SmoothScroll -->
    <script src="{{ asset('mobikart/js/SmoothScroll.js') }}"></script>
    <!-- Parallax js -->
    <script src="{{ asset('mobikart/js/parallaxie.js') }}"></script>
    <!-- MagicCursor js file -->
    <script src="{{ asset('mobikart/js/gsap.min.js') }}"></script>
    <script src="{{ asset('mobikart/js/magiccursor.js') }}"></script>
    <!-- SplitText js file -->
    <script src="{{ asset('mobikart/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('mobikart/js/ScrollTrigger.min.js') }}"></script>
    <!-- Wow js file -->
    <script src="{{ asset('mobikart/js/wow.min.js') }}"></script>
    <!-- Main Custom js file -->
    <script src="{{ asset('mobikart/js/function.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.hero-showcase-slider', {
                    loop: true,
                    autoplay: {
                        delay: 3500,
                        disableOnInteraction: false,
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                });
            }

            // Dynamically adjust placeholder texts on responsive screens to prevent overflow
            function updateResponsivePlaceholders() {
                const searchInput = document.querySelector('.header-search-form input[name="search"]');
                const trackInput = document.querySelector('.clean-search-box input[name="ticket_id"]');
                
                if (window.innerWidth <= 480) {
                    if (searchInput) searchInput.placeholder = "Search products...";
                    if (trackInput) trackInput.placeholder = "Ticket ID / Mobile...";
                } else if (window.innerWidth <= 768) {
                    if (searchInput) searchInput.placeholder = "Search products, repairs...";
                    if (trackInput) trackInput.placeholder = "Ticket ID / Mobile No...";
                } else {
                    if (searchInput) searchInput.placeholder = "Search products, repairs...";
                    if (trackInput) trackInput.placeholder = "Ticket ID / Mobile No...";
                }
            }
            updateResponsivePlaceholders();
            window.addEventListener('resize', updateResponsivePlaceholders);
        });
    </script>

    <!-- Mobile Floating Sticky Book Repair Button (Visible on mobile/tablet screens) -->
    <a href="{{ route('book.form') }}" class="mobile-floating-book-btn d-lg-none" title="Book Repair Online">
        <i class="fa-solid fa-calendar-check text-warning"></i>
        <span>Book Repair</span>
    </a>
</body>
</html>
