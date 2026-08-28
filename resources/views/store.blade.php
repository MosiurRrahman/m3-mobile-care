<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Awaiken">
	<!-- Page Title -->
    <title>Products & Accessories Store | M3 Mobile Care - Ranisankail</title>
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
		<!-- Main Custom Css -->
	<link href="{{ asset('mobikart/css/custom.css') }}" rel="stylesheet" media="screen">
    <style>
        /* M3 Brand Gradient Overrides */
        .btn-default:not(.btn-border),
        a.btn-default:not(.btn-border),
        button.btn-default:not(.btn-border),
        .product-learn-more-btn .btn-default {
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
        .product-learn-more-btn .btn-default:hover {
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
        .product-category-item ul li input[type="checkbox"]:checked + label::before {
            background-color: #f97316 !important;
            border-color: #f97316 !important;
        }
        .product-category-result-pagination ul li.active a,
        .product-category-result-pagination ul li a:hover {
            background-color: #f97316 !important;
            color: #ffffff !important;
        }
        .product-category-filter-clear-btn a:hover {
            color: #f97316 !important;
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
                                <input type="text" name="product" class="form-control" placeholder="Search By Products..." required>
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
                                                    <h2>Quick Services</h2>
                                                    <ul>
                                                        <li><a href="{{ route('services') }}">Display & Touch Repair</a></li>
                                                        <li><a href="{{ route('services') }}">Battery Replacement</a></li>
                                                        <li><a href="{{ route('services') }}">Motherboard IC Fix</a></li>
                                                        <li><a href="{{ route('services') }}">Water Damage Fix</a></li>
                                                        <li><a href="{{ route('track.form') }}">Live Job Tracking</a></li>
                                                        <li><a href="{{ route('contact') }}">Store Support</a></li>
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

    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Our Products</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Products</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Page Products Section Start -->
    <div class="page-products">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <!-- Page Single Sidebar Start -->
                    <div class="page-single-sidebar">
                        <!-- Page Category Filter Header Start -->
                        <div class="product-category-filter-header wow fadeInUp">
                            <div class="product-category-filter-title">
                                <img src="{{ asset('mobikart/images/icon-filter.svg') }}" alt="">
                                <h2>Filter By</h2>
                            </div>
                            <div class="product-category-filter-clear-btn">
                                <a href="#">Clear All</a>
                            </div>
                        </div>
                        <!-- Page Category Filter Header End -->
                        
                        <!-- Product Category Item List Start -->
                        <div class="product-category-item-list">
                            <!-- Product Category Item Start -->
                            <div class="product-category-item wow fadeInUp" data-wow-delay="0.2s">
                                <h2 class="product-category-item-title">Categories</h2>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="Cases" name="Cases" value="Cases">
                                        <label for="Cases">Phone Cases</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Chargers" name="Chargers" value="Chargers">
                                        <label for="Chargers">Chargers</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Cables" name="Cables" value="Cables">
                                        <label for="Cables">Cables</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Earbuds" name="Earbuds" value="Earbuds">
                                        <label for="Earbuds">Wireless Earbuds</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Power_Banks" name="Power_Banks" value="Power_Banks">
                                        <label for="Power_Banks">Power Banks</label>
                                    </li>
                                </ul>
                            </div>
                            <!-- Product Category Item End -->
                            
                            <!-- Product Category Item Start -->
                            <div class="product-category-item wow fadeInUp" data-wow-delay="0.4s">
                                <h2 class="product-category-item-title">Brands</h2>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="Apple" name="Apple" value="Apple">
                                        <label for="Apple">Apple</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Samsung" name="Samsung" value="Samsung">
                                        <label for="Samsung">Samsung</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Xiaomi" name="Xiaomi" value="Xiaomi">
                                        <label for="Xiaomi">Xiaomi</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Oppo" name="Oppo" value="Oppo">
                                        <label for="Oppo">Oppo</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Vivo" name="Vivo" value="Vivo">
                                        <label for="Vivo">Vivo</label>
                                    </li>
                                </ul>
                            </div>
                            <!-- Product Category Item End -->
                            
                            <!-- Product Category Item Start -->
                            <div class="product-category-item wow fadeInUp" data-wow-delay="0.6s">
                                <h2 class="product-category-item-title">Colors</h2>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="Black" name="Black" value="Black">
                                        <label for="Black">Black</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="White" name="White" value="White">
                                        <label for="White">White</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Blue" name="Blue" value="Blue">
                                        <label for="Blue">Blue</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Red" name="Red" value="Red">
                                        <label for="Red">Red</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Green" name="Green" value="Green">
                                        <label for="Green">Green</label>
                                    </li>
                                </ul>
                            </div>
                            <!-- Product Category Item End -->

                            <!-- Product Category Item Start -->
                            <div class="product-category-item wow fadeInUp" data-wow-delay="0.8s">
                                <h2 class="product-category-item-title">Connectivity</h2>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="Wireless" name="Wireless" value="Wireless">
                                        <label for="Wireless">Wireless</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Wired" name="Wired" value="Wired">
                                        <label for="Wired">Wired</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Bluetooth" name="Bluetooth" value="Bluetooth">
                                        <label for="Bluetooth">Bluetooth</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="USB-C" name="USB-C" value="USB-C">
                                        <label for="USB-C">USB-C</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="Lightning" name="Lightning" value="Lightning">
                                        <label for="Lightning">Lightning</label>
                                    </li>
                                </ul>
                            </div>
                            <!-- Product Category Item End -->
                        </div>
                        <!-- Product Category Item List End -->
                    </div>
                    <!-- Page Single Sidebar End -->
                </div>

                <div class="col-xl-9 col-lg-8">
                    <!-- Product item List Box Start -->
                    <div class="product-item-list-box">
                        <!-- Product Category Filter Header Start -->
                        <div class="product-category-filter-header wow fadeInUp">
                            <div class="product-category-filter-title">
                                <h2>Showing all results</h2>
                            </div>
                            <div class="product-category-result-info">
                                <div class="product-category-result-pagination">
                                    <ul>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">9</a></li>
                                        <li><a href="#">12</a></li>
                                        <li><a href="#">15</a></li>
                                    </ul>
                                </div>
                                <div class="product-category-sorting-list">
                                    <select name="sorting_list" class="form-control form-select" id="sorting_list" required>
                                        <option value="" disabled selected>Default Sorting</option>
                                        <option value="Low_to_High">Low to High</option>
                                        <option value="High_to_Low">High to Low</option>
                                        <option value="Popularity">Popularity</option>
                                        <option value="Best_Sellers">Best Sellers</option>
                                        <option value="Trending">Trending</option>
                                        <option value="Most_Reviewed">Most Reviewed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Product Category Filter Header End -->

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
                            <div class="product-item wow fadeInUp" data-wow-delay="0.6s">
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

                            <!-- Product Item Start -->
                            <div class="product-item wow fadeInUp" data-wow-delay="0.8s">
                                <div class="product-item-header">
                                    <div class="product-item-image">
                                        <a href="{{ route('product.single.view') }}">
                                            <figure>
                                                <img src="{{ asset('mobikart/images/product-image-5.png') }}" alt="">
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
                                        <h2><a href="{{ route('product.single.view') }}">Nova Pro Smartphone</a></h2>
                                        <h3>৳3999.00 <span>৳5999.00</span></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Item End -->

                            <!-- Product Item Start -->
                            <div class="product-item wow fadeInUp" data-wow-delay="1s">
                                <div class="product-item-header">
                                    <div class="product-item-image">
                                        <a href="{{ route('product.single.view') }}">
                                            <figure>
                                                <img src="{{ asset('mobikart/images/product-image-6.png') }}" alt="">
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
                                        <h2><a href="{{ route('product.single.view') }}">Wireless Headphones</a></h2>
                                        <h3>৳799.00 <span>৳899.00</span></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Item End -->

                            <!-- Product Item Start -->
                            <div class="product-item wow fadeInUp" data-wow-delay="1.2s">
                                <div class="product-item-header">
                                    <div class="product-item-image">
                                        <a href="{{ route('product.single.view') }}">
                                            <figure>
                                                <img src="{{ asset('mobikart/images/product-image-7.png') }}" alt="">
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
                                        <h2><a href="{{ route('product.single.view') }}">Wireless AirPods</a></h2>
                                        <h3>৳899.00 <span>৳999.00</span></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Item End -->

                            <!-- Product Item Start -->
                            <div class="product-item wow fadeInUp" data-wow-delay="1.4s">
                                <div class="product-item-header">
                                    <div class="product-item-image">
                                        <a href="{{ route('product.single.view') }}">
                                            <figure>
                                                <img src="{{ asset('mobikart/images/product-image-8.png') }}" alt="">
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
                                        <h2><a href="{{ route('product.single.view') }}">Vision VR Headset</a></h2>
                                        <h3>৳599.00 <span>৳750.00</span></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Item End -->

                            <!-- Product Item Start -->
                            <div class="product-item wow fadeInUp" data-wow-delay="1.6s">
                                <div class="product-item-header">
                                    <div class="product-item-image">
                                        <a href="{{ route('product.single.view') }}">
                                            <figure>
                                                <img src="{{ asset('mobikart/images/product-image-9.png') }}" alt="">
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
                                        <h2><a href="{{ route('product.single.view') }}">Charging Power Bank</a></h2>
                                        <h3>299.00 <span>399.00</span></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Item End -->
                        </div>
                        <!-- Product Item List End -->

                        <!-- Product Leader More Button Start -->
                        <div class="product-learn-more-btn wow fadeInUp" data-wow-delay="0.2s">
                            <a href="#" class="btn-default"><span>Learn More</span></a>
                        </div>
                        <!-- Product Leader More Button End -->
                    </div>
                    <!-- Product item List Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Products End -->

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
                            <img src="{{ asset('mobikart/images/logo-white.svg') }}" alt="M3 Mobile Care">
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

