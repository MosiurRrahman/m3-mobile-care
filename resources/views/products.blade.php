<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="description" content="M3 Mobile Care – Trusted Mobile Repair & Accessories Shop in Ranisankail, Thakurgaon. Discover premium mobile accessories, fast chargers, earbuds, smartwatches, power banks & certified repair solutions.">
	<meta name="keywords" content="M3 Mobile Care, Mobile Repair, Accessories Shop, Ranisankail, Thakurgaon, Mobile Accessories, Phone Repair">
	<meta name="author" content="M3 Mobile Care">
	<!-- Page Title -->
    <title>M3 Mobile Care – Trusted Mobile Repair & Accessories Shop</title>
	<!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('mobikart/images/favicon.png') }}">
    <!-- Custom Fonts Css-->
    <link href="{{ asset('mobikart/css/fonts.css') }}" rel="stylesheet" media="screen">
	<!-- Bootstrap Css -->
	<link href="{{ asset('mobikart/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<!-- SlickNav Css -->
	<link href="{{ asset('mobikart/css/slicknav.min.css') }}" rel="stylesheet">
	<!-- Swiper Css -->
	<link rel="stylesheet" href="{{ asset('mobikart/css/swiper-bundle.min.css') }}">
	<!-- Font Awesome Icon Css-->
	<link href="{{ asset('mobikart/css/all.min.css') }}" rel="stylesheet" media="screen">
	<!-- Animated Css -->
	<link href="{{ asset('mobikart/css/animate.css') }}" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
	<link rel="stylesheet" href="{{ asset('mobikart/css/magnific-popup.css') }}">
	<!-- Mouse Cursor Css File -->
	<link rel="stylesheet" href="{{ asset('mobikart/css/mousecursor.css') }}">
	<!-- Main Custom Css -->
	<link href="{{ asset('mobikart/css/custom.css') }}" rel="stylesheet" media="screen">
    <style>
        /* M3 Brand Gradient Overrides */
        .btn-default:not(.btn-border),
        a.btn-default:not(.btn-border),
        button.btn-default:not(.btn-border),
        .hero-btn .btn-default,
        .discount-showcase-btn .btn-default,
        .section-btn .btn-default,
        .product-single-content-btn .btn-default,
        .review-form .btn-default {
            background: linear-gradient(135deg, #ff7828 0%, #f97316 45%, #ea580c 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 20px rgba(234, 88, 12, 0.35) !important;
            border: none !important;
            font-weight: 700 !important;
            transition: all 0.35s ease-in-out !important;
        }
        .btn-default:not(.btn-border):hover,
        a.btn-default:not(.btn-border):hover,
        button.btn-default:not(.btn-border):hover,
        .hero-btn .btn-default:hover,
        .discount-showcase-btn .btn-default:hover,
        .section-btn .btn-default:hover,
        .product-single-content-btn .btn-default:hover,
        .review-form .btn-default:hover {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 55%, #ff7828 100%) !important;
            box-shadow: 0 8px 25px rgba(234, 88, 12, 0.5) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }
        .btn-default span,
        a.btn-default span,
        button.btn-default span {
            color: inherit;
        }
        .popular-categories-list {
            background: linear-gradient(135deg, #ff7828 0%, #f97316 45%, #ea580c 100%) !important;
        }
        .readmore-btn:hover {
            color: #f97316 !important;
        }
        .navbar-brand img {
            max-width: 250px !important;
            max-height: 52px !important;
            height: auto !important;
            width: auto !important;
        }
        .about-footer img {
            max-width: 250px !important;
            max-height: 52px !important;
            height: auto !important;
            width: auto !important;
        }
        /* Smooth, Glitch-Free Mega-Menu Dropdown */
        .main-menu {
            position: relative !important;
        }
        .main-menu ul li.mega-menu {
            position: static !important;
        }
        .main-menu .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            background: #ffffff !important;
            border-radius: 0 0 16px 16px !important;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18) !important;
            border: none !important;
            padding: 40px 0 !important;
            margin: 0 !important;
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: opacity 0.25s ease, transform 0.25s ease !important;
            transform: translateY(8px) !important;
            z-index: 9999 !important;
        }
        .main-menu ul li.mega-menu:hover > .dropdown-menu {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }
        .main-menu .mega-menu-link h2 {
            color: #0f172a !important;
            font-weight: 800 !important;
            font-size: 17px !important;
            border-bottom: 2px solid #f37021 !important;
            padding-bottom: 10px !important;
            margin-bottom: 15px !important;
        }
        .main-menu .mega-menu-link ul li a {
            color: #475569 !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            display: block !important;
            padding: 6px 0 !important;
            transition: all 0.2s ease !important;
        }
        .main-menu .mega-menu-link ul li a:hover {
            color: #f37021 !important;
            padding-left: 6px !important;
        }
        .main-menu .mega-menu-item-content h2 a {
            color: #0f172a !important;
            font-weight: 700 !important;
            font-size: 16px !important;
        }
        .main-menu .mega-menu-item-content h2 a:hover {
            color: #f37021 !important;
        }
        .main-menu .mega-menu-item-content p {
            color: #64748b !important;
            font-size: 13px !important;
        }
    </style>
</head>
<body>

    <!-- Preloader Start -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('mobikart/images/loader.svg') }}" alt=""></div>
		</div>
	</div>
	<!-- Preloader End -->

    <!-- Header Start -->
	<header class="main-header">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
                <!-- Header Action Box Start -->
                <div class="header-action-box">
                    <!-- Logo Start -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('mobikart/images/logo.svg') }}" alt="Logo">
                    </a>
                    <!-- Logo End -->
                    
                    <!-- Header Search Form Box Start -->
                    <div class="header-search-form-box">
                        <!-- Header Search Form Start -->
                        <form class="header-search-form" id="headerForm" action="{{ route('products') }}" method="GET">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search products, models, accessories (e.g. Earbuds, Charger, Display)..." value="{{ request('search') }}" required>
                                <button type="submit" class="header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <!-- Header Search Form End -->
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
                                        <!-- Mega Menu Box Start -->
                                        <li class="mega-menu-box">
                                            <div class="mega-menu-links-box">
                                                <!-- Mega Menu Link Start -->
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
                                                <!-- Mega Menu Link End -->
    
                                                <!-- Mega Menu Link Start -->
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
                                                <!-- Mega Menu Link End -->
                                            </div>

                                            <!-- Mega Menu Items List Start -->
                                            <div class="mega-menu-items-list">
                                                <!-- Mega Menu Item Start -->
                                                <div class="mega-menu-item">
                                                    <!-- Mega Menu Item Image Start -->
                                                    <div class="mega-menu-item-image">
                                                        <a href="{{ route('products') }}" data-cursor-text="View">
                                                            <figure class="image-anime">
                                                                <img src="{{ asset('mobikart/images/mega-menu-item-image-1.jpg') }}" alt="">
                                                            </figure>
                                                        </a>
                                                    </div>
                                                    <!-- Mega Menu Item Image End -->

                                                    <!-- Mega Menu Item Content Start -->
                                                    <div class="mega-menu-item-content">
                                                        <h2><a href="{{ route('products') }}">Watch Collection</a></h2>
                                                        <p>Modern smartwatches with fitness tracking and advanced</p>
                                                    </div>
                                                    <!-- Mega Menu Item Content End -->
                                                </div>
                                                <!-- Mega Menu Item End -->

                                                <!-- Mega Menu Item Start -->
                                                <div class="mega-menu-item">
                                                    <!-- Mega Menu Item Image Start -->
                                                    <div class="mega-menu-item-image">
                                                        <a href="{{ route('products') }}" data-cursor-text="View">
                                                            <figure class="image-anime">
                                                                <img src="{{ asset('mobikart/images/mega-menu-item-image-2.jpg') }}" alt="">
                                                            </figure>
                                                        </a>
                                                    </div>
                                                    <!-- Mega Menu Item Image End -->

                                                    <!-- Mega Menu Item Content Start -->
                                                    <div class="mega-menu-item-content">
                                                        <h2><a href="{{ route('products') }}">Audio Collection</a></h2>
                                                        <p>Wireless headphones and speakers designed</p>
                                                    </div>
                                                    <!-- Mega Menu Item Content End -->
                                                </div>
                                                <!-- Mega Menu Item End -->

                                                <!-- Mega Menu Item Start -->
                                                <div class="mega-menu-item big-offer-box">
                                                    <!-- Mega Menu Item Image Start -->
                                                    <div class="mega-menu-item-image">
                                                        <figure>
                                                            <img src="{{ asset('mobikart/images/mega-menu-item-image-3.jpg') }}" alt="">
                                                        </figure>
                                                    </div>
                                                    <!-- Mega Menu Item Image End -->

                                                    <!-- Mega Menu Item Content Start -->
                                                    <div class="mega-menu-item-content">
                                                        <span>-special offer-</span>
                                                        <h2>Big Sale</h2>
                                                        <h3>50% Off</h3>
                                                    </div>
                                                    <!-- Mega Menu Item Content End -->
                                                </div>
                                                <!-- Mega Menu Item End -->
                                            </div>
                                            <!-- Mega Menu Items List End -->
                                        </li>
                                        <!-- Mega Menu Box End -->
                                    </ul>
                                    <!-- Dropdown Menu End -->
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('track.form') }}">Track Job</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>
                        
                        <!-- Header Action Details Start -->
                        <div class="header-action-details">
                            <ul>
                                <li><a href="{{ route('portal') }}"><i class="fa-regular fa-circle-user"></i>Account / Portal</a></li>
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

    <!-- Hero Section Start -->
    <div class="hero light-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <!-- Hero Content Start -->
                    <div class="hero-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Stay Connected In Style</span>
                            <h1 class="text-anime-style-3" data-cursor="-opaque">Premium Accessories For Every Device</h1>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Discover high-quality mobile accessories designed to enhance your digital lifestyle. From fast chargers and power banks to stylish cases.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Hero COntent List Start -->
                        <div class="hero-content-list wow fadeInUp" data-wow-delay="0.4s">
                            <ul>
                                <li>Premium Quality Accessories</li>
                                <li>Trusted Brands And Products</li>
                            </ul>
                        </div>
                        <!-- Hero COntent List End -->

                        <!-- Hero Content Footer Start -->
                        <div class="hero-content-footer wow fadeInUp" data-wow-delay="0.6s">
                            <!-- Hero Button Start -->
                            <div class="hero-btn">
                                <a href="{{ route('products') }}" class="btn-default"><span>Shop Now</span></a>
                            </div>
                            <!-- Hero Button End -->

                            <!-- Google Rating Box Start -->
                            <div class="google-rating-box">
                                <div class="icon-box">
                                    <img src="{{ asset('mobikart/images/icon-google.svg') }}" alt="">
                                </div>
                                <div class="google-rating-box-content">
                                    <span class="google-rating-star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                    <p>1000 + Our Happy Customer Review </p>
                                </div>
                            </div>
                            <!-- Google Rating Box End -->
                        </div>
                        <!-- Hero Content Footer End -->
                         
                    </div>
                    <!-- Hero Content End -->
                </div>

                <div class="col-xl-6">
                    <!-- Hero Image Start -->
                    <div class="hero-image wow fadeInUp" data-wow-delay="0.2s">
                        <figure>
                            <img src="{{ asset('mobikart/images/hero-image.png') }}" alt="">
                        </figure>
                    </div>
                    <!-- Hero Image End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Our Category Section Start -->
    <div class="our-category">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Shop by category</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Find Accessories for Every Device</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Category Item List Start -->
                    <div class="category-item-list">
                        <!-- Category Item Start -->
                        <div class="category-item wow fadeInUp">
                            <div class="category-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/category-item-image-1.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="category-item-content">
                                <h3><a href="{{ route('products') }}">Phone Cases</a></h3>
                            </div>
                        </div>
                        <!-- Category Item End -->

                        <!-- Category Item Start -->
                        <div class="category-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="category-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/category-item-image-2.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="category-item-content">
                                <h3><a href="{{ route('products') }}">Headphones</a></h3>
                            </div>
                        </div>
                        <!-- Category Item End -->

                        <!-- Category Item Start -->
                        <div class="category-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="category-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/category-item-image-3.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="category-item-content">
                                <h3><a href="{{ route('products') }}">Power Banks</a></h3>
                            </div>
                        </div>
                        <!-- Category Item End -->

                        <!-- Category Item Start -->
                        <div class="category-item wow fadeInUp" data-wow-delay="0.6s">
                            <div class="category-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/category-item-image-4.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="category-item-content">
                                <h3><a href="{{ route('products') }}">Smartwatches</a></h3>
                            </div>
                        </div>
                        <!-- Category Item End -->

                        <!-- Category Item Start -->
                        <div class="category-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="category-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/category-item-image-5.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="category-item-content">
                                <h3><a href="{{ route('products') }}">Chargers</a></h3>
                            </div>
                        </div>
                        <!-- Category Item End -->

                        <!-- Category Item Start -->
                        <div class="category-item wow fadeInUp" data-wow-delay="1s">
                            <div class="category-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/category-item-image-6.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="category-item-content">
                                <h3><a href="{{ route('products') }}">Earbuds</a></h3>
                            </div>
                        </div>
                        <!-- Category Item End -->
                    </div>
                    <!-- Category Item List End -->

                    <!-- Mega Deal Item List Start -->
                    <div class="mega-deal-item-list">
                        <!-- Mega Deal Item Start -->
                        <div class="mega-deal-item wow fadeInUp">
                            <div class="mega-deal-item-content-box">
                                <div class="mega-deal-item-content-header">
                                    <div class="mega-deal-item-content">
                                        <span>Up to 35% OFF</span>
                                        <h3><a href="{{ route('products') }}">Premium Accessories Mega Deal</a></h3>
                                    </div>
                                    <div class="mega-deal-countdown">
                                        <div class="countdown" data-date="2027-06-24 23:59:59">
                                            <div class="counter-box"><span class="days">00</span><p>Days</p></div>
                                            <div class="counter-box"><span class="hours">00</span><p>Hours</p></div>
                                            <div class="counter-box"><span class="minutes">00</span><p>Minutes</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mega-deal-item-btn">
                                    <a href="{{ route('products') }}" class="btn-default btn-border"><span>View Products</span></a>
                                </div>
                            </div>
                            <div class="mega-deal-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/mega-deal-item-image-1.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Mega Deal Item End -->

                        <!-- Mega Deal Item Start -->
                        <div class="mega-deal-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="mega-deal-item-content-box">
                                <div class="mega-deal-item-content-header">
                                    <div class="mega-deal-item-content">
                                        <span>Up to 50% OFF</span>
                                        <h3><a href="{{ route('products') }}">Premium Accessories Mega Deal</a></h3>
                                    </div>
                                    <div class="mega-deal-countdown">
                                        <div class="countdown" data-date="2027-06-24 23:59:59">
                                            <div class="counter-box"><span class="days">00</span> <p>Days</p></div>
                                            <div class="counter-box"><span class="hours">00</span> <p>Hours</p></div>
                                            <div class="counter-box"><span class="minutes">00</span> <p>Minutes</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mega-deal-item-btn">
                                    <a href="{{ route('products') }}" class="btn-default btn-border"><span>View Products</span></a>
                                </div>
                            </div>
                            <div class="mega-deal-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/mega-deal-item-image-2.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Mega Deal Item End -->
                    </div>
                    <!-- Mega Deal Item List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Category Section End -->

    <!-- Our Product Section Start -->
    <div class="our-products">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">shop by Product</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Our Best Selling Tech Products</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Product Item List Start -->
                    <div class="product-item-list">
                        <!-- Product Item Start -->
                        <div class="product-item wow fadeInUp">
                            <div class="product-item-header">
                                <div class="product-item-image">
                                    <a href="{{ route('product.single.view') }}">
                                        <figure>
                                            <img src="{{ asset('mobikart/images/product-image-1.png') }}" alt="">
                                        </figure>
                                    </a>
                                </div>
                                <div class="product-item-action">
                                    <ul>
                                        <li><a href="account-wishlist.html"><img src="{{ asset('mobikart/images/icon-wishlist-primary.svg') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ asset('mobikart/images/icon-compare-primary.svg') }}" alt=""></a></li>
                                        <li><a href="cart.html"><img src="{{ asset('mobikart/images/icon-cart-primary.svg') }}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-item-body">
                                <div class="product-item-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="product-item-content">
                                    <h2><a href="{{ route('product.single.view') }}">Wireless Earbuds Pro</a></h2>
                                    <h3>৳899.00 <span>৳999.00</span></h3>
                                </div>
                            </div>
                        </div>
                        <!-- Product Item End -->

                        <!-- Product Item Start -->
                        <div class="product-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="product-item-header">
                                <div class="product-item-image">
                                    <a href="{{ route('product.single.view') }}">
                                        <figure>
                                            <img src="{{ asset('mobikart/images/product-image-2.png') }}" alt="">
                                        </figure>
                                    </a>
                                </div>
                                <div class="product-item-action">
                                    <ul>
                                        <li><a href="account-wishlist.html"><img src="{{ asset('mobikart/images/icon-wishlist-primary.svg') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ asset('mobikart/images/icon-compare-primary.svg') }}" alt=""></a></li>
                                        <li><a href="cart.html"><img src="{{ asset('mobikart/images/icon-cart-primary.svg') }}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-item-body">
                                <div class="product-item-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="product-item-content">
                                    <h2><a href="{{ route('product.single.view') }}">Magnetic Charging</a></h2>
                                    <h3>৳499.00 <span>৳750.00</span></h3>
                                </div>
                            </div>
                        </div>
                        <!-- Product Item End -->

                        <!-- Product Item Start -->
                        <div class="product-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item-header">
                                <div class="product-item-image">
                                    <a href="{{ route('product.single.view') }}">
                                        <figure>
                                            <img src="{{ asset('mobikart/images/product-image-3.png') }}" alt="">
                                        </figure>
                                    </a>
                                </div>
                                <div class="product-item-action">
                                    <ul>
                                        <li><a href="account-wishlist.html"><img src="{{ asset('mobikart/images/icon-wishlist-primary.svg') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ asset('mobikart/images/icon-compare-primary.svg') }}" alt=""></a></li>
                                        <li><a href="cart.html"><img src="{{ asset('mobikart/images/icon-cart-primary.svg') }}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-item-body">
                                <div class="product-item-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="product-item-content">
                                    <h2><a href="{{ route('product.single.view') }}">SmartSync Cable</a></h2>
                                    <h3>৳49.00 <span>৳69.00</span></h3>
                                </div>
                            </div>
                        </div>
                        <!-- Product Item End -->

                        <!-- Product Item Start -->
                        <div class="product-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="product-item-header">
                                <div class="product-item-image">
                                    <a href="{{ route('product.single.view') }}">
                                        <figure>
                                            <img src="{{ asset('mobikart/images/product-image-4.png') }}" alt="">
                                        </figure>
                                    </a>
                                </div>
                                <div class="product-item-action">
                                    <ul>
                                        <li><a href="account-wishlist.html"><img src="{{ asset('mobikart/images/icon-wishlist-primary.svg') }}" alt=""></a></li>
                                        <li><a href="#"><img src="{{ asset('mobikart/images/icon-compare-primary.svg') }}" alt=""></a></li>
                                        <li><a href="cart.html"><img src="{{ asset('mobikart/images/icon-cart-primary.svg') }}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-item-body">
                                <div class="product-item-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div class="product-item-content">
                                    <h2><a href="{{ route('product.single.view') }}">Mini Smart Speaker</a></h2>
                                    <h3>৳4899.00 <span>৳6999.00</span></h3>
                                </div>
                            </div>
                        </div>
                        <!-- Product Item End -->
                    </div>
                    <!-- Product Item List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Product Section End -->

    <!-- Our Benefits Section Start -->
    <div class="our-benefits">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Benefits</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Quality Service and Value Deserve</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Benefit Items List Start -->
                    <div class="benefit-items-list">
                        <!-- Benefit Item Start -->
                        <div class="benefit-item wow fadeInUp">
                            <!-- Benefit Item Header Start -->
                            <div class="benefit-item-header">
                                <!-- Benefit Item Content Start -->
                                <div class="benefit-item-content">
                                    <span>Crafted For Performance</span>
                                    <h3>Where Innovation Powers Every Moment</h3>
                                </div>
                                <!-- Benefit Item Content End -->

                                <!-- Benefit Item Button Start -->
                                <div class="benefit-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                                <!-- Benefit Item Button End -->
                            </div>
                            <!-- Benefit Item Header End -->

                            <!-- Benefit Item Image Start -->
                            <div class="benefit-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/benefit-item-image-1.jpg') }}" alt="">
                                </figure>
                            </div>
                            <!-- Benefit Item Image End -->
                        </div>
                        <!-- Benefit Item End -->

                        <!-- Benefit Item Start -->
                        <div class="benefit-item wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Benefit Item Header Start -->
                            <div class="benefit-item-header">
                                <!-- Benefit Item Content Start -->
                                <div class="benefit-item-content">
                                    <span>Designed Pure Sound</span>
                                    <h3>Where Audio Feels Truly Limitless</h3>
                                </div>
                                <!-- Benefit Item Content End -->

                                <!-- Benefit Item Button Start -->
                                <div class="benefit-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                                <!-- Benefit Item Button End -->
                            </div>
                            <!-- Benefit Item Header End -->

                            <!-- Benefit Item Image Start -->
                            <div class="benefit-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/benefit-item-image-2.jpg') }}" alt="">
                                </figure>
                            </div>
                            <!-- Benefit Item Image End -->
                        </div>
                        <!-- Benefit Item End -->

                        <!-- Benefit Item Start -->
                        <div class="benefit-item wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Benefit Item Header Start -->
                            <div class="benefit-item-header">
                                <!-- Benefit Item Content Start -->
                                <div class="benefit-item-content">
                                    <span>Smart Technology</span>
                                    <h3>Where Technology Meets Perfect Balance</h3>
                                </div>
                                <!-- Benefit Item Content End -->

                                <!-- Benefit Item Button Start -->
                                <div class="benefit-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                                <!-- Benefit Item Button End -->
                            </div>
                            <!-- Benefit Item Header End -->

                            <!-- Benefit Item Image Start -->
                            <div class="benefit-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/benefit-item-image-3.jpg') }}" alt="">
                                </figure>
                            </div>
                            <!-- Benefit Item Image End -->
                        </div>
                        <!-- Benefit Item End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Benefits Section End -->

    <!-- Super Deals Section Start -->
    <div class="super-deals">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Super Deals</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Upgrade Your Mobile Experience</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Super Deals Items List Start -->
                    <div class="super-deals-items-list wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Super Deals Item Start -->
                        <div class="super-deals-item">
                            <div class="super-deals-item-header">
                                <p>Save up to</p>
                                <h2><span class="counter">35</span><sub>%<b>Off</b></sub></h2>
                            </div>
                            <div class="super-deals-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/super-deals-item-image-1.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="super-deals-item-content">
                                <h3><a href="{{ route('products') }}">Headphones</a></h3>
                                <p>Experience sound headphone built comfort.</p>
                            </div>
                        </div>
                        <!-- Super Deals Item End -->

                        <!-- Super Deals Item Start -->
                        <div class="super-deals-item">
                            <div class="super-deals-item-header">
                                <p>Save up to</p>
                                <h2><span class="counter">25</span><sub>%<b>Off</b></sub></h2>
                            </div>
                            <div class="super-deals-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/super-deals-item-image-2.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="super-deals-item-content">
                                <h3><a href="{{ route('products') }}">Chargers</a></h3>
                                <p>Experience Fast Chargers built for comfort.</p>
                            </div>
                        </div>
                        <!-- Super Deals Item End -->

                        <!-- Super Deals Item Start -->
                        <div class="super-deals-item">
                            <div class="super-deals-item-header">
                                <p>Save up to</p>
                                <h2><span class="counter">15</span><sub>%<b>Off</b></sub></h2>
                            </div>
                            <div class="super-deals-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/super-deals-item-image-3.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="super-deals-item-content">
                                <h3><a href="{{ route('products') }}">Phone Cases</a></h3>
                                <p>Experience Phone Cases built for comfort.</p>
                            </div>
                        </div>
                        <!-- Super Deals Item End -->

                        <!-- Super Deals Item Start -->
                        <div class="super-deals-item">
                            <div class="super-deals-item-header">
                                <p>Save up to</p>
                                <h2><span class="counter">20</span><sub>%<b>Off</b></sub></h2>
                            </div>
                            <div class="super-deals-item-image">
                                <a href="{{ route('products') }}">
                                    <figure>
                                        <img src="{{ asset('mobikart/images/super-deals-item-image-4.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="super-deals-item-content">
                                <h3><a href="{{ route('products') }}">Smart Watches</a></h3>
                                <p>Experience Smart Watches built for comfort.</p>
                            </div>
                        </div>
                        <!-- Super Deals Item End -->
                    </div>
                    <!-- Super Deals Items List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Super Deals Section End -->

    <!-- New Arrivals Section Start -->
    <div class="new-arrivals">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-xl-8">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <span class="section-sub-title wow fadeInUp">New Arrivals</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Our Best Selling Tech Products</h2>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-xl-4">
                    <!-- Section Button Start -->
                    <div class="section-btn wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ route('products') }}" class="btn-default"><span>Explore Collection</span></a>
                    </div>
                    <!-- Section Button End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- New Arrivals Items List Start -->
                    <div class="new-arrivals-items-list">
                        <!-- New Arrivals Item Start -->
                        <div class="new-arrivals-item wow fadeInUp">
                            <div class="new-arrivals-item-content-box">
                                <div class="new-arrivals-item-content-header">
                                    <div class="new-arrivals-item-content">
                                        <span>Up to 35% OFF</span>
                                        <h3>I Phone 16pro Max Love The Price</h3>
                                    </div>
                                    <div class="new-arrivals-item-price">
                                        <p>From ৳180.00</p>
                                    </div>
                                </div>
                                <div class="new-arrivals-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                            </div>
                            <div class="new-arrivals-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/new-arrivals-item-image-1.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- New Arrivals Item End -->

                        <!-- New Arrivals Item Start -->
                        <div class="new-arrivals-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="new-arrivals-item-content-box">
                                <div class="new-arrivals-item-content-header">
                                    <div class="new-arrivals-item-content">
                                        <span>15% OFF</span>
                                        <h3>5th Generation Best Airbirds</h3>
                                    </div>
                                    <div class="new-arrivals-item-price">
                                        <p>From ৳129.00</p>
                                    </div>
                                </div>
                                <div class="new-arrivals-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                            </div>
                            <div class="new-arrivals-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/new-arrivals-item-image-2.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- New Arrivals Item End -->

                        <!-- New Arrivals Item Start -->
                        <div class="new-arrivals-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="new-arrivals-item-content-box">
                                <div class="new-arrivals-item-content-header">
                                    <div class="new-arrivals-item-content">
                                        <span>Up to 35% OFF</span>
                                        <h3>MacBook Pro New Arrivals </h3>
                                    </div>
                                    <div class="new-arrivals-item-price">
                                        <p>From ৳599.00</p>
                                    </div>
                                </div>
                                <div class="new-arrivals-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                            </div>
                            <div class="new-arrivals-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/new-arrivals-item-image-3.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- New Arrivals Item End -->

                        <!-- New Arrivals Item Start -->
                        <div class="new-arrivals-item wow fadeInUp" data-wow-delay="0.6s">
                            <div class="new-arrivals-item-content-box">
                                <div class="new-arrivals-item-content-header">
                                    <div class="new-arrivals-item-content">
                                        <span>Big Sale</span>
                                        <h3>Premium Smart Watch Light on Price</h3>
                                    </div>
                                    <div class="new-arrivals-item-price">
                                        <p>From ৳300.00</p>
                                    </div>
                                </div>
                                <div class="new-arrivals-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                            </div>
                            <div class="new-arrivals-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/new-arrivals-item-image-4.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- New Arrivals Item End -->

                        <!-- New Arrivals Item Start -->
                        <div class="new-arrivals-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="new-arrivals-item-content-box">
                                <div class="new-arrivals-item-content-header">
                                    <div class="new-arrivals-item-content">
                                        <span>Best Price</span>
                                        <h3>Headset Max 3rd Generation</h3>
                                    </div>
                                    <div class="new-arrivals-item-price">
                                        <p>From ৳230.00</p>
                                    </div>
                                </div>
                                <div class="new-arrivals-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                            </div>
                            <div class="new-arrivals-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/new-arrivals-item-image-5.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- New Arrivals Item End -->

                        <!-- New Arrivals Item Start -->
                        <div class="new-arrivals-item wow fadeInUp" data-wow-delay="1s">
                            <div class="new-arrivals-item-content-box">
                                <div class="new-arrivals-item-content-header">
                                    <div class="new-arrivals-item-content">
                                        <span>Best Saving</span>
                                        <h3>I Phone 16pro Max Love The Price</h3>
                                    </div>
                                    <div class="new-arrivals-item-price">
                                        <p>From ৳350.00</p>
                                    </div>
                                </div>
                                <div class="new-arrivals-item-btn">
                                    <a href="{{ route('products') }}" class="readmore-btn">Shop Now</a>
                                </div>
                            </div>
                            <div class="new-arrivals-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/new-arrivals-item-image-6.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- New Arrivals Item End -->
                    </div>
                    <!-- New Arrivals Items List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- New Arrivals Section End -->

    <!-- Discount Showcase Section Start -->
    <div class="discount-showcase light-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8">
                    <!-- Discount Showcase Content Start -->
                    <div class="discount-showcase-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">Buy 2 Get 1 Free</span>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Save Up To 50% OFF</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Discover premium mobile accessories designed to enhance your everyday experience. Shop wireless earbuds, smartwatches, chargers, power banks.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Discount Showcase Items List Start -->
                        <div class="discount-showcase-items-list">
                            <!-- Discount Showcase Item Start -->
                            <div class="discount-showcase-item wow fadeInUp" data-wow-delay="0.4s">
                                <div class="icon-box">
                                    <img src="{{ asset('mobikart/images/icon-discount-showcase-item-1.svg') }}" alt="">
                                </div>
                                <div class="discount-showcase-item-content">
                                    <h3>Premium Product Quality</h3>
                                    <p>Crafted with high-quality materials for exceptional durability, performance.</p>
                                </div>
                            </div>
                            <!-- Discount Showcase Item End -->

                            <!-- Discount Showcase Item Start -->
                            <div class="discount-showcase-item wow fadeInUp" data-wow-delay="0.6s">
                                <div class="icon-box">
                                    <img src="{{ asset('mobikart/images/icon-discount-showcase-item-2.svg') }}" alt="">
                                </div>
                                <div class="discount-showcase-item-content">
                                    <h3>100% Genuine Products</h3>
                                    <p>Crafted with high-quality materials for exceptional durability, performance.</p>
                                </div>
                            </div>
                            <!-- Discount Showcase Item End -->
                        </div>
                        <!-- Discount Showcase Items List End -->
                        
                        <!-- Discount Showcase Content Footer Start -->
                        <div class="discount-showcase-content-footer wow fadeInUp" data-wow-delay="0.8s">
                            <!-- Discount Showcase Button Start -->
                            <div class="discount-showcase-btn">
                                <a href="{{ route('products') }}" class="btn-default"><span>Claim Offer</span></a>
                            </div>
                            <!-- Discount Showcase Button End -->

                            <!-- Satisfy Client Box Start -->
                            <div class="satisfy-client-box">
                                <!-- Satisfy Client Images Start -->
                                <div class="satisfy-client-images">
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('mobikart/images/author-1.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('mobikart/images/author-2.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                </div>
                                <!-- Satisfy Client Images End -->

                                <!-- Impact Satisfy Client Content Start -->
                                <div class="satisfy-client-box-content">
                                    <p>Trusted By <b>25,000+</b> Happy Customers</p>
                                </div>
                                <!-- Impact Satisfy Client Content End -->
                            </div>
                            <!-- Satisfy Client Box End -->
                        </div>
                        <!-- Discount Showcase Content Footer End -->
                    </div>
                    <!-- Discount Showcase Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Discount Showcase Section End -->

    <!-- Our Features Section Start -->
    <div class="our-features">
        <div class="container">
            <div class="row section-row">
                <div class="col-xl-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Powerful features</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Explore Powerful Product Features</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Features Items List Start -->
                    <div class="features-items-list">
                        <!-- Feature Item Start -->
                        <div class="feature-item wow fadeInUp">
                            <div class="features-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/feature-item-image-1.png') }}" alt="">
                                </figure>
                            </div>
                            <div class="features-item-content">
                                <span>Magnetic Alignment</span>
                                <h3>The Perfect Fit For Effortless Wireless Charging</h3>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="feature-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="features-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/feature-item-image-2.png') }}" alt="">
                                </figure>
                            </div>
                            <div class="features-item-content">
                                <span>10+ Brands</span>
                                <h3>Premium Smartphones At Unbeatable Prices</h3>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="feature-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="features-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/feature-item-image-3.png') }}" alt="">
                                </figure>
                            </div>
                            <div class="features-item-content">
                                <span>5000mAh Battery</span>
                                <h3>Power Through Your Day With Confidence</h3>
                            </div>
                        </div>
                        <!-- Feature Item End -->

                        <!-- Feature Item Start -->
                        <div class="feature-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="features-item-image">
                                <figure>
                                    <img src="{{ asset('mobikart/images/feature-item-image-4.png') }}" alt="">
                                </figure>
                            </div>
                            <div class="features-item-content">
                                <span>Customize Button</span>
                                <h3>Customize Silent, Vibrate, And Ring Modes</h3>
                            </div>
                        </div>
                        <!-- Feature Item End -->
                    </div>
                    <!-- Features Items List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Features Section End -->

    <!-- Our Brands Section Start -->
    <div class="our-brands">
        <div class="container">
            <div class="row section-row">
                <div class="col-xl-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Shop by brands</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Shop Top Mobile Accessory Brands</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Our brand Items List Start -->
                    <div class="our-brand-items-list">
                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-1.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">iPhone</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->

                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-2.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">Galaxy</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->

                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-3.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">Pixel</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->

                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-4.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">Oppo</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->

                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp" data-wow-delay="0.8s">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-5.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">Xiomi</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->

                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp" data-wow-delay="1s">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-6.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">Vivo</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->

                        <!-- Our brand Item Start -->
                        <div class="our-brand-item wow fadeInUp" data-wow-delay="1.2s">
                            <div class="icon-box">
                                <a href="{{ route('products') }}">
                                    <img src="{{ asset('mobikart/images/our-brands-icon-7.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="our-brand-item-content">
                                <h3><a href="{{ route('products') }}">Motorola</a></h3>
                            </div>
                        </div>
                        <!-- Our brand Item End -->
                    </div>
                    <!-- Our brand List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Brands Section End --> 

    <!-- Our Testimonials Section Start -->
    <div class="our-testimonials">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Customer says</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Stories From Our Valued Customers</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Testimonial Slider Start -->
                    <div class="testimonial-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper" data-cursor-text="Drag">
                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <!-- Testimonial Item Start -->
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-header">
                                            <div class="testimonial-item-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>The customer service team was very helpful in choosing the accessories for my phone. I loved the packaging and the build quality.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-author">
                                                <div class="testimonial-author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('mobikart/images/author-1.jpg') }}" alt="">
                                                    </figure>
                                                </div>
                                                <div class="testimonial-author-content">
                                                    <h2>Aarav Mehta</h2>
                                                    <p>Mobile Specialist</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-item-quote">
                                                <img src="{{ asset('mobikart/images/testimonial-item-quote.svg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Item End -->
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <!-- Testimonial Item Start -->
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-header">
                                            <div class="testimonial-item-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>The customer service team was very helpful in choosing the accessories for my phone. I loved the packaging and the build quality.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-author">
                                                <div class="testimonial-author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('mobikart/images/author-2.jpg') }}" alt="">
                                                    </figure>
                                                </div>
                                                <div class="testimonial-author-content">
                                                    <h2>Priya Sharma</h2>
                                                    <p>Product Design Expert</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-item-quote">
                                                <img src="{{ asset('mobikart/images/testimonial-item-quote.svg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Item End -->
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <!-- Testimonial Item Start -->
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-header">
                                            <div class="testimonial-item-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>The customer service team was very helpful in choosing the accessories for my phone. I loved the packaging and the build quality.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-author">
                                                <div class="testimonial-author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('mobikart/images/author-3.jpg') }}" alt="">
                                                    </figure>
                                                </div>
                                                <div class="testimonial-author-content">
                                                    <h2>Rohan Patel</h2>
                                                    <p>E-commerce Manager</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-item-quote">
                                                <img src="{{ asset('mobikart/images/testimonial-item-quote.svg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Item End -->
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <!-- Testimonial Item Start -->
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-header">
                                            <div class="testimonial-item-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>The customer service team was very helpful in choosing the accessories for my phone. I loved the packaging and the build quality.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-author">
                                                <div class="testimonial-author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('mobikart/images/author-4.jpg') }}" alt="">
                                                    </figure>
                                                </div>
                                                <div class="testimonial-author-content">
                                                    <h2>Neha Verma</h2>
                                                    <p>Accessories Head</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-item-quote">
                                                <img src="{{ asset('mobikart/images/testimonial-item-quote.svg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Item End -->
                                </div>
                                <!-- Testimonial Slide End -->

                                <!-- Testimonial Slide Start -->
                                <div class="swiper-slide">
                                    <!-- Testimonial Item Start -->
                                    <div class="testimonial-item">
                                        <div class="testimonial-item-header">
                                            <div class="testimonial-item-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="testimonial-item-content">
                                                <p>The customer service team was very helpful in choosing the accessories for my phone. I loved the packaging and the build quality.</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-item-body">
                                            <div class="testimonial-item-author">
                                                <div class="testimonial-author-image">
                                                    <figure class="image-anime">
                                                        <img src="{{ asset('mobikart/images/author-5.jpg') }}" alt="">
                                                    </figure>
                                                </div>
                                                <div class="testimonial-author-content">
                                                    <h2>Vikram Singh</h2>
                                                    <p>Supply Chain Manager</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-item-quote">
                                                <img src="{{ asset('mobikart/images/testimonial-item-quote.svg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Item End -->
                                </div>
                                <!-- Testimonial Slide End -->
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial Slider End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Testimonials Section End -->

    <!-- Our FAQs Section Start -->
    <div class="our-faqs light-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <!-- Our FAQs Content Start -->
                    <div class="our-faqs-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <span class="section-sub-title wow fadeInUp">FAQ's</span>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Answers To Your Most Common Questions</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Find answers to common questions about orders, shipping, compatibility, payments, and mobile accessories support.</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- FAQs Content Body Start -->
                        <div class="faqs-content-body wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Satisfy Client Box Start -->
                            <div class="satisfy-client-box">
                                <!-- Satisfy Client Images Start -->
                                <div class="satisfy-client-images">
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('mobikart/images/author-1.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('mobikart/images/author-2.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('mobikart/images/author-3.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                    <div class="satisfy-client-image">
                                        <figure class="image-anime">
                                            <img src="{{ asset('mobikart/images/author-4.jpg') }}" alt="">
                                        </figure>
                                    </div>
                                </div>
                                <!-- Satisfy Client Images End -->

                                <!-- Impact Satisfy Client Content Start -->
                                <div class="satisfy-client-box-content">
                                    <h3>Premium Tech Support Available Every Single Day — 9AM to 10PM</h3>
                                    <p>Average answer time: 24hrs</p>
                                </div>
                                <!-- Impact Satisfy Client Content End -->
                            </div>
                            <!-- Satisfy Client Box End -->
                        </div>
                        <!-- FAQs Content Body End -->
                    </div>
                    <!-- Our FAQs Content End -->
                </div>

                <div class="col-xl-6">
                    <!-- FAQ Accordion Start -->
                    <div class="faq-accordion" id="accordion">
                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    1. Do you offer fast delivery?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" role="region" aria-labelledby="heading1" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we provide fast and reliable delivery service to ensure your mobile accessories arrive safely and on time at your doorstep.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    2. Are your products compatible with all devices?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" role="region" aria-labelledby="heading2" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we provide fast and reliable delivery service to ensure your mobile accessories arrive safely and on time at your doorstep.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.4s">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    3. Do your products include warranty coverage?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" role="region" aria-labelledby="heading3" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we provide fast and reliable delivery service to ensure your mobile accessories arrive safely and on time at your doorstep.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->

                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.6s">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    4. Can I return or exchange products?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" role="region" aria-labelledby="heading4" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we provide fast and reliable delivery service to ensure your mobile accessories arrive safely and on time at your doorstep.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->
                         
                        <!-- FAQ Item Start -->
                        <div class="accordion-item wow fadeInUp" data-wow-delay="0.8s">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    5. Are your wireless headphones Bluetooth compatible?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" role="region" aria-labelledby="heading5" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Yes, we provide fast and reliable delivery service to ensure your mobile accessories arrive safely and on time at your doorstep.</p>
                                </div>
                            </div>
                        </div>
                        <!-- FAQ Item End -->
                    </div>
                    <!-- FAQ Accordion End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our FAQs Section End -->

    <!-- Our Blog Section Start -->
    <div class="our-blog">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Latest Blog</span>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Read Our Newest Articles & Guides</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Post Item List Start -->
                    <div class="post-item-list">
                        <!-- Post Item Start -->
                        <div class="post-item wow fadeInUp">
                            <div class="post-item-image">
                                <a href="blog-single.html" data-cursor-text="View">
                                    <figure class="image-anime">
                                        <img src="{{ asset('mobikart/images/post-1.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="post-item-body">                           
                                <div class="post-item-content">
                                    <h2><a href="blog-single.html">How To Select The Perfect Fast Charger For Your Mobile Device</a></h2>
                                </div>
                                <div class="post-item-btn">
                                    <a href="blog-single.html" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                        <!-- Post Item End -->

                        <!-- Post Item Start -->
                        <div class="post-item wow fadeInUp" data-wow-delay="0.2s">
                            <div class="post-item-image">
                                <a href="blog-single.html" data-cursor-text="View">
                                    <figure class="image-anime">
                                        <img src="{{ asset('mobikart/images/post-2.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="post-item-body">                        
                                <div class="post-item-content">
                                    <h2><a href="blog-single.html">The Complete Guide To Wireless Earbuds And Bluetooth Audio Devices</a></h2>
                                </div>
                                <div class="post-item-btn">
                                    <a href="blog-single.html" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                        <!-- Post Item End -->

                        <!-- Post Item Start -->
                        <div class="post-item wow fadeInUp" data-wow-delay="0.4s">
                            <div class="post-item-image">
                                <a href="blog-single.html" data-cursor-text="View">
                                    <figure class="image-anime">
                                        <img src="{{ asset('mobikart/images/post-3.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="post-item-body">
                                <div class="post-item-content">
                                    <h2><a href="blog-single.html">How To Extend Smartphone Battery Life With Smart Charging Habits</a></h2>
                                </div>
                                <div class="post-item-btn">
                                    <a href="blog-single.html" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                        <!-- Post Item End -->
                    </div>
                    <!-- Post Item List End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Our Blog Section End -->

    <!-- Main Footer Start -->
    <footer class="main-footer">
        <!-- Customer Benefits Start -->
        <div class="customer-benefits">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Customer Benefits Item List Start -->
                        <div class="customer-benefits-item-list">
                            <!-- Customer Benefits Item Start -->
                            <div class="customer-benefits-item">
                                <div class="icon-box">
                                    <img src="{{ asset('mobikart/images/icon-customer-benefits-1.svg') }}" alt="">
                                </div>
                                <div class="customer-benefits-item-content">
                                    <h2><a href="delivery-policy.html">Fast Nationwide Delivery</a></h2>
                                    <p>Quick and reliable shipping service</p>
                                </div>
                            </div>
                            <!-- Customer Benefits Item End -->
                            
                            <!-- Customer Benefits Item Start -->
                            <div class="customer-benefits-item">
                                <div class="icon-box">
                                    <img src="{{ asset('mobikart/images/icon-customer-benefits-2.svg') }}" alt="">
                                </div>
                                <div class="customer-benefits-item-content">
                                    <h2><a href="term-condition.html">Secure Payment Methods</a></h2>
                                    <p>Safe and trusted payment options</p>
                                </div>
                            </div>
                            <!-- Customer Benefits Item End -->
                            
                            <!-- Customer Benefits Item Start -->
                            <div class="customer-benefits-item">
                                <div class="icon-box">
                                    <img src="{{ asset('mobikart/images/icon-customer-benefits-3.svg') }}" alt="">
                                </div>
                                <div class="customer-benefits-item-content">
                                    <h2><a href="refund-return.html">Return Process</a></h2>
                                    <p>Contact our support team 7 days</p>
                                </div>
                            </div>
                            <!-- Customer Benefits Item End -->
                        </div>
                        <!-- Customer Benefits Item List End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Customer Benefits End -->

        <!-- Footer Box Start -->
        <div class="footer-box dark-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                    <!-- About Footer Start -->
		            <div class="about-footer">
                        <!-- Footer Logo Start -->
                        <div class="footer-logo">
                            <img src="{{ asset('mobikart/images/logo-white.svg') }}" alt="">
                        </div>
                        <!-- Footer Logo End -->

                        <!-- About Footer Content Start -->
                        <div class="about-footer-content">
                            <p>Discover premium mobile accessories designed for style, performance, and convenience in Ranisankail, Thakurgaon. From fast chargers to wireless gadgets and repair spares.</p>
                        </div>
                        <!-- About Footer Content End -->

                        <!-- Footer Socials Links Start -->
                        <div class="footer-social-links">
                            <ul>
                                <li><a href="https://wa.me/8801353106967" target="_blank" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a></li>
                                <li><a href="https://facebook.com" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="tel:+8801353106967" title="Call Us"><i class="fa-solid fa-phone"></i></a></li>
                            </ul>
                        </div>
                        <!-- Footer Socials Links End -->
                    </div>
                    <!-- About Footer End -->
                </div>

                <div class="col-xl-8">
                    <!-- Footer Links Box Start -->
                    <div class="footer-links-box">
                        <!-- Footer Links Start -->
                        <div class="footer-links">
                            <h2>Quick Links</h2>
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('products') }}">Shop Store</a></li>
                                <li><a href="{{ route('services') }}">Services</a></li>
                                <li><a href="{{ route('track.form') }}">Track Job</a></li>
                                <li><a href="{{ route('about') }}">About us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>
                        <!-- Footer Links End -->

                        <!-- Footer Links Start -->
                        <div class="footer-links">
                            <h2>Our Categories</h2>
                            <ul>
                                <li><a href="{{ route('products') }}">Phone Cases</a></li>
                                <li><a href="{{ route('products') }}">Wireless Earbuds</a></li>
                                <li><a href="{{ route('products') }}">Power Banks</a></li>
                                <li><a href="{{ route('products') }}">Smart Watches</a></li>
                                <li><a href="{{ route('products') }}">Chargers & Adapters</a></li>
                                <li><a href="{{ route('products') }}">Display Spares</a></li>
                            </ul>
                        </div>
                        <!-- Footer Links End -->

                        <!-- Footer Links Start -->
                        <div class="footer-links footer-newsletter-form">
                            <h2>Location & Hotline</h2>
                            <p class="text-white mb-2"><i class="fa-solid fa-location-dot text-warning me-2"></i> (বিগ বাজার) আব্দুল গফফার মার্কেট, রাণীশংকৈল, ঠাকুরগাঁও</p>
                            <p class="text-white mb-2"><i class="fa-solid fa-phone text-success me-2"></i> +8801353106967 / +8801353106966</p>
                            <p style="color: #94a3b8; font-size: 14px;">খোলা: প্রতিদিন সকাল ৯:০০ টা - রাত ৯:৩০ টা</p>
                        </div>
                        <!-- Footer Links End -->
                    </div>
                    <!-- Footer Links Box End -->
                </div>

                <div class="col-lg-12">
                    <!-- Footer Copyright Start -->
                    <div class="footer-copyright">
                        <!-- Footer Copyright Text Start -->
                        <div class="footer-copyright-text">
                            <p>Copyright © {{ date('Y') }} <b>M3 Mobile Care</b>. All Rights Reserved.</p>
                        </div>
                        <!-- Footer Copyright Text End -->

                        <!-- Footer Privacy Policy Start -->
                        <div class="footer-privacy-policy">
                            <ul>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                <li><a href="{{ route('portal') }}">Staff Portal</a></li>
                            </ul>
                        </div>
                        <!-- Footer Privacy Policy End -->
                    </div>
                    <!-- Footer Copyright End -->
                </div>
                </div>
            </div>
        </div>
        <!-- Footer Box End -->
    </footer>
    <!-- Main Footer End -->

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
    <!-- Text Effect js file -->
    <script src="{{ asset('mobikart/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('mobikart/js/ScrollTrigger.min.js') }}"></script>
    <!-- YTPlayer js File -->
    <script src="{{ asset('mobikart/js/jquery.mb.YTPlayer.min.js') }}"></script>
    <!-- Wow js file -->
    <script src="{{ asset('mobikart/js/wow.min.js') }}"></script>
    <!-- Main Custom js file -->
    <script src="{{ asset('mobikart/js/function.js') }}"></script>
	
</body>
</html>

