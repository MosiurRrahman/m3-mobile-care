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
    <title>{{ isset($product) ? $product->name . " | " : "" }}M3 Mobile Care – Trusted Mobile Repair & Accessories Shop</title>
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
                            <li><a href="account-wishlist.html"><img src="{{ asset('mobikart/images/icon-wishlist-primary.svg') }}" alt=""></a></li>
                            <li><a href="cart.html"><img src="{{ asset('mobikart/images/icon-cart-primary.svg') }}" alt="">My Cart</a></li>
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
                                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
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
                                                        <li><a href="term-condition.html">Term & Conditions</a></li>
                                                        <li><a href="refund-return.html">Easy Returns</a></li>
                                                        <li><a href="delivery-policy.html">Reliable Delivery</a></li>
                                                        <li><a href="privacy-policy.html">Secure Payment Options</a></li>
                                                        <li><a href="{{ route('products') }}">Shop List</a></li>
                                                        <li><a href="account-dashboard.html">My Account</a></li>
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
                                <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('track.form') }}">Track Job</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>
                        
                        <!-- Header Action Details Start -->
                        <div class="header-action-details">
                            <ul>
                                <li><a href="{{ route('portal') }}"><i class="fa-regular fa-circle-user"></i>Account Log in</a></li>
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

    <!-- Page Product Single Start -->
    <div class="page-product-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Product Single Content Start -->
                    <div class="page-product-single-content">
                        <!-- Product Single Breadcrumb List Start -->
                        <div class="product-single-breadcrumb-list">
                            <nav class="wow fadeInUp">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ isset($product) ? $product->name : 'Wireless Earbuds Pro' }}</li>
                                </ol>
                            </nav>
                        </div>
                        <!-- Product Single Breadcrumb List End -->

                        <!-- Product Single Info Box Start -->
                        <div class="product-single-info-box">
                            <!-- Product Single Image Box Start -->
                            <div class="product-single-image-box wow fadeInUp">
                                <!-- Product Single Image Slider Start -->
                                <div class="swiper product-single-image-slider">
                                    <div class="swiper-wrapper">
                                        @if(isset($product) && !empty($product->images) && is_array($product->images) && count($product->images) > 0)
                                            @foreach($product->images as $img)
                                                <div class="swiper-slide">
                                                    <figure>
                                                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('mobikart/images/product-placeholder.png') }}';">
                                                    </figure>
                                                </div>
                                            @endforeach
                                        @elseif(isset($product))
                                            <div class="swiper-slide">
                                                <figure>
                                                    <img src="{{ asset('mobikart/images/product-placeholder.png') }}" alt="{{ $product->name }}">
                                                </figure>
                                            </div>
                                        @else
                                            <div class="swiper-slide">
                                                <figure>
                                                    <img src="{{ asset('mobikart/images/product-image-1.png') }}" alt="Product Image">
                                                </figure>
                                            </div>
                                            <div class="swiper-slide">
                                                <figure>
                                                    <img src="{{ asset('mobikart/images/product-thumbnail-image-1.png') }}" alt="Product Thumbnail">
                                                </figure>
                                            </div>
                                            <div class="swiper-slide">
                                                <figure>
                                                    <img src="{{ asset('mobikart/images/product-thumbnail-image-2.png') }}" alt="Product Thumbnail">
                                                </figure>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Product Single Image Slider End -->
                                
                                <!-- Product Single Image Item Start -->
                                <div class="swiper product-single-image-item">
                                    <div class="swiper-wrapper">
                                        @if(isset($product) && !empty($product->images) && is_array($product->images) && count($product->images) > 0)
                                            @foreach($product->images as $img)
                                                <div class="swiper-slide">
                                                    <figure class="imgae-anime">
                                                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('mobikart/images/product-placeholder.png') }}';">
                                                    </figure>
                                                </div>
                                            @endforeach
                                        @elseif(isset($product))
                                            <div class="swiper-slide">
                                                <figure class="imgae-anime">
                                                    <img src="{{ asset('mobikart/images/product-placeholder.png') }}" alt="{{ $product->name }}">
                                                </figure>
                                            </div>
                                        @else
                                            <div class="swiper-slide">
                                                <figure class="imgae-anime">
                                                    <img src="{{ asset('mobikart/images/product-image-1.png') }}" alt="Product Image">
                                                </figure>
                                            </div>
                                            <div class="swiper-slide">
                                                <figure class="imgae-anime">
                                                    <img src="{{ asset('mobikart/images/product-thumbnail-image-1.png') }}" alt="Thumbnail">
                                                </figure>
                                            </div>
                                            <div class="swiper-slide">
                                                <figure class="imgae-anime">
                                                    <img src="{{ asset('mobikart/images/product-thumbnail-image-2.png') }}" alt="Thumbnail">
                                                </figure>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Product Single Image Item End -->
                            </div>
                            <!-- Product Single Image Box End -->

                            <!-- Product Single Info Content Start -->
                            <div class="product-single-info-content">
                                <!-- Product Single title Start -->
                                <div class="product-single-title wow fadeInUp">
                                    <h1>{{ isset($product) ? $product->name : 'Wireless Earbuds Pro' }}</h1>
                                    <p><span class="product-single-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                    4.9 (18 Reviews)</p>
                                </div>
                                <!-- Product Single title End -->

                                <!-- Product Single Price Start -->
                                <div class="product-single-price wow fadeInUp" data-wow-delay="0.4s">
                                    @if(isset($product))
                                        <h2>৳{{ number_format($product->sale_price ?? 0, 2) }} @if($product->purchase_price) <span>৳{{ number_format($product->sale_price * 1.25, 2) }}</span> @endif</h2>
                                    @else
                                        <h2>৳899.00 <span>৳999.00</span></h2>
                                    @endif
                                </div>
                                <!-- Product Single Price End -->

                                <!-- Product Single Description Start -->
                                <div class="product-single-description wow fadeInUp" data-wow-delay="0.2s">
                                    <p>{{ isset($product) && $product->description ? $product->description : 'Experience premium sound quality with Mini Smart Speaker, designed to deliver crystal-clear audio, deep bass, and seamless connectivity for your everyday lifestyle. Whether you\'re listening to music, attending calls, working out.' }}</p>
                                </div>
                                <!-- Product Single Description End -->

                                <!-- Product Single Item Color Start -->
                                <div class="product-single-item-color wow fadeInUp" data-wow-delay="0.4s">
                                    <h3>Color:</h3>
                                    <div class="product-item-variant-colors">
                                        <input type="radio" name="color" id="black" checked>
                                        <label for="black" class="color-variant black"></label>
                                        
                                        <input type="radio" name="color" id="gray">
                                        <label for="gray" class="color-variant gray"></label>
                                        
                                        <input type="radio" name="color" id="blue">
                                        <label for="blue" class="color-variant blue"></label>
                                        
                                        <input type="radio" name="color" id="green">
                                        <label for="green" class="color-variant green"></label>
                                    </div>
                                </div>
                                <!-- Product Single Item Color End -->
                                
                                <!-- Product Single Item Size Start -->
                                <div class="product-single-item-size wow fadeInUp" data-wow-delay="0.4s">
                                    <h3>Model / Brand:</h3>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold">{{ isset($product) ? ($product->brand ?? 'Genuine') . ' - ' . ($product->model ?? 'Standard') : 'All Compatible' }}</span>
                                </div>
                                <!-- Product Single Item Size End -->

                                <!-- Product Single Content Body Start -->
                                <div class="product-single-content-body wow fadeInUp" data-wow-delay="0.8s">
                                    <div class="qty-box">
                                        <button class="qty-btn minus" onclick="var q=document.getElementById('pSingleQty'); if(parseInt(q.value)>1) q.value=parseInt(q.value)-1;"><i class="fa-solid fa-minus"></i></button>
                                        <input type="text" class="qty-input" id="pSingleQty" value="1" readonly>
                                        <button class="qty-btn plus" onclick="var q=document.getElementById('pSingleQty'); q.value=parseInt(q.value)+1;"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="product-single-content-btn">
                                        @php
                                            $pName = isset($product) ? $product->name : 'Wireless Earbuds Pro';
                                            $pPrice = isset($product) ? ($product->sale_price ?? 899) : 899;
                                            $waMsg = 'আমি কিনতে চাই: ' . $pName . ' (মূল্য: ৳' . number_format($pPrice, 2) . ')';
                                        @endphp
                                        <a href="https://wa.me/8801353106967?text={{ rawurlencode($waMsg) }}" target="_blank" class="btn-default"><span><i class="fa-brands fa-whatsapp me-1"></i> Buy via WhatsApp</span></a>
                                    </div>
                                    <div class="product-single-action">
                                        <ul>
                                            <li><a href="tel:+8801353106967" title="Call to Order"><i class="fa-solid fa-phone text-dark fs-5"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Product Single Content Body End -->

                                <!-- Product Single Content Footer Start -->
                                <div class="product-single-content-footer wow fadeInUp" data-wow-delay="1s">
                                    <!-- Product Single Details List Start -->
                                    <div class="product-single-details-list">
                                        <ul>
                                            <li><span>SKU:</span> {{ isset($product) ? ($product->sku ?? 'M3-ACC-101') : 'EARBUD-1001' }}</li>
                                            <li><span>Categories:</span> {{ isset($product) ? ($product->category ?? 'Mobile Accessories') : 'Wireless Earbuds' }}</li>
                                            <li><span>Stock:</span> <b class="text-success">{{ isset($product) ? ($product->quantity > 0 ? 'In Stock (' . $product->quantity . ' available)' : 'Out of Stock') : 'In Stock (Ready to Ship)' }}</b></li>
                                        </ul>
                                    </div>
                                    <!-- Product Single Details List End -->
                                    
                                    <!-- Product Single Payment Method Start -->
                                    <div class="product-single-payment-method">
                                        <h3>Payment Options:</h3>
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('mobikart/images/icon-payment-options-1.svg') }}" alt="bKash / COD"></a></li>
                                            <li><a href="#"><img src="{{ asset('mobikart/images/icon-payment-options-2.svg') }}" alt="MasterCard"></a></li>
                                            <li><a href="#"><img src="{{ asset('mobikart/images/icon-payment-options-3.svg') }}" alt="Visa"></a></li>
                                            <li><a href="#"><img src="{{ asset('mobikart/images/icon-payment-options-4.svg') }}" alt="Paypal"></a></li>
                                            <li><a href="#"><img src="{{ asset('mobikart/images/icon-payment-options-5.svg') }}" alt="Nagad"></a></li>
                                            <li><a href="#"><img src="{{ asset('mobikart/images/icon-payment-options-6.svg') }}" alt="Rocket"></a></li>
                                        </ul>
                                    </div>
                                    <!-- Product Single Payment Method End -->
                                </div>
                                <!-- Product Single Content Footer End -->
                            </div>
                            <!-- Product Single Info Content End -->
                        </div>
                        <!-- Product Single Info Box End -->

                        <!-- Product Single Info Start -->
                        <div class="product-single-review-box wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Product Single Box Start -->
                            <div class="product-single-review-tab tab-content" id="missionvision">
                                <!-- Product Step Nav start -->
                                <div class="product-step-nav">
                                    <ul class="nav nav-tabs" id="mvTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="first-tab" data-bs-toggle="tab" data-bs-target="#first" type="button" role="tab" aria-controls="first" aria-selected="true">Product Description</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="second-tab" data-bs-toggle="tab" data-bs-target="#second" type="button" role="tab" aria-controls="second" aria-selected="false">Additional Information</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="third-tab" data-bs-toggle="tab" data-bs-target="#third" type="button" role="tab" aria-controls="third" aria-selected="false">Reviews (50)</button>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Product Step Nav End -->
                                
                                <!-- Product Tab Item Box Start -->
                                <div class="product-tab-item-box tab-pane fade show active" id="first" role="tabpanel">
                                    <div class="product-tab-item-content">
                                        <p>SonicPods Pro Wireless Earbuds are designed for users who want premium sound quality, modern style, and all-day comfort in a compact design. Featuring advanced Bluetooth connectivity, immersive audio performance, and an ergonomic charging case, these earbuds deliver a seamless listening experience whether you're working, exercising,relaxing.</p>
                                        <p>Experience next-generation wireless audio with SonicPods Pro Wireless Earbuds. Designed with a sleek matte-black finish and lightweight construction, these earbuds combine style and performance in one premium package. The compact charging case easily fits into your pocket while providing additional battery life for uninterrupted listening throughout the day. Advanced Bluetooth technology ensures quick pairing and stable connectivity across smartphones, tablets, laptops, and smart devices.</p>
                                        <ul>
                                            <li>Premium true wireless earbuds with crystal-clear immersive sound quality.</li>
                                            <li>Deep bass audio delivers powerful and engaging listening experiences.</li>
                                            <li>Bluetooth 5.3 technology ensures stable and seamless wireless connectivity.</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Product Tab Item End -->

                                <!-- Product Tab Item Box Start -->
                                <div class="product-tab-item-box tab-pane fade" id="second" role="tabpanel">
                                    <div class="product-additional-content">
                                        <!-- Product Additional Content Title Start -->
                                        <div class="product-additional-content-title">
                                            <h2>Additional Information</h2>
                                        </div>
                                        <!-- Product Additional Content Title End -->

                                        <!-- Product Additional Info Table Start -->
                                        <div class="product-additional-info-table">
                                            <table>
                                                <tr>
                                                    <td><b>Connectivity</b></td>
                                                    <td>Bluetooth 5.3</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Battery Life</b></td>
                                                    <td>Up to 30 Hours</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Charging Port</b></td>
                                                    <td>USB Type-C</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Water Resistance</b></td>
                                                    <td>IPX5 Sweat</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- Product Additional Info Table End -->
                                    </div>                            
                                </div>
                                <!-- Product Tab Item Box End -->
                                
                                <!-- Product Tab Item Box Start -->
                                <div class="product-tab-item-box tab-pane fade" id="third" role="tabpanel">
                                    <div class="product-review-form-content">
                                        <!-- Customer Review List Start -->
                                        <div class="customer-review-list">
                                            <!-- Customer Review Item Start -->
                                            <div class="customer-review-item">
                                                <div class="icon-box">
                                                    <img src="{{ asset('mobikart/images/author-1.jpg') }}" alt="">
                                                </div>
                                                <div class="customer-review-item-body">
                                                    <div class="customer-review-item-content">
                                                        <p><span>Author</span> - Aug 12, 2025</p>
                                                        <p>Great puppy food with balanced nutrition</p>
                                                    </div>
                                                    <div class="customer-review-item-rating">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Customer Review Item End -->

                                            <!-- Customer Review Item Start -->
                                            <div class="customer-review-item">
                                                <div class="icon-box">
                                                    <img src="{{ asset('mobikart/images/author-2.jpg') }}" alt="">
                                                </div>
                                                <div class="customer-review-item-body">
                                                    <div class="customer-review-item-content">
                                                        <p>Author - Aug 15, 2025</p>
                                                        <p>Quality ingredients and good packaging</p>
                                                    </div>
                                                    <div class="customer-review-item-rating">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Customer Review Item End -->
                                        </div>
                                        <!-- Customer Review List End -->

                                        <!-- Contact Form Start -->
                                        <div class="review-form">
                                            <div class="review-form-content">
                                                <h3>Add a review</h3>
                                                <p>Your email address will not be published. Required fields are marked Your rating</p>
                                            </div>
                                            <form id="reviewForm" action="#" method="POST" data-toggle="validator">
                                                <div class="row">                                
                                                    <div class="form-group col-md-12 mb-4">
                                                        <input type="text" name="review" class="form-control" id="review" placeholder="Your review" required>
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-6 mb-4">
                                                        <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required>
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-6 mb-4">
                                                        <input type="email" name ="email" class="form-control" id="email" placeholder="Email" required>
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group review-form-note">
                                                        <input type="checkbox" id="note" name="note">
                                                        <label for="note" class="form-label">Save my name, email, and website in this browser for the next time I comment.</label>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn-default"><span>Submit Message</span></button>
                                                        <div id="msgSubmit" class="h3 hidden mb-0"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Contact Form End -->
                                    </div>                                    
                                </div>
                                <!-- Product Tab Item Box End -->
                            </div>
                            <!-- Product Single Box End -->
                        </div> 
                        <!-- Product Single Info End -->
                    </div>
                    <!-- Page Product Single Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Products Single End -->

    <!-- Related Product Section Start -->
    <div class="related-products">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <span class="section-sub-title wow fadeInUp">Shop by Product</span>
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
                        <div class="product-item wow fadeInUp" data-wow-delay="0.2s">
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
    <!-- Related Product Section End -->

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
                                <li><a href="{{ route('products') }}">Fast Chargers</a></li>
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

