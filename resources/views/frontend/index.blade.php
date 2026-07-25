@extends('layouts.frontend')

@section('title', 'M3 Mobile Care - Premium Accessories & Gadgets Shop')

@section('content')
<!-- BANNER SECTION START -->
<div class="overflow-hidden">
    <div class="ul-container">
        <section class="ul-banner">
            <div class="ul-banner-slider-wrapper">
                <div class="ul-banner-slider swiper">
                    <div class="swiper-wrapper">
                        <!-- single slide -->
                        <div class="swiper-slide ul-banner-slide">
                            <div class="ul-banner-slide-img">
                                <img src="{{ asset('frontend/img/banner-slide-1.jpg') }}" alt="Banner Image">
                            </div>
                            <div class="ul-banner-slide-txt">
                                <span class="ul-banner-slide-sub-title">Original Accessories & Gadgets</span>
                                <h1 class="ul-banner-slide-title">Premium Chargers, Covers & Glass Protectors</h1>
                                <p class="ul-banner-slide-price">Starting From <span class="price">৳199</span></p>
                                <a href="{{ route('shop.catalog') }}" class="ul-btn">SHOP NOW <i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide ul-banner-slide ul-banner-slide--2">
                            <div class="ul-banner-slide-img">
                                <img src="{{ asset('frontend/img/banner-slide-2.jpg') }}" alt="Banner Image">
                            </div>
                            <div class="ul-banner-slide-txt">
                                <span class="ul-banner-slide-sub-title">Fast Charging & Heavy Duty Covers</span>
                                <h1 class="ul-banner-slide-title">Best Mobile Accessories Collection</h1>
                                <p class="ul-banner-slide-price">Starting From <span class="price">৳299</span></p>
                                <a href="{{ route('shop.catalog') }}" class="ul-btn">SHOP NOW <i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide ul-banner-slide ul-banner-slide--3">
                            <div class="ul-banner-slide-img">
                                <img src="{{ asset('frontend/img/banner-slide-3.jpg') }}" alt="Banner Image">
                            </div>
                            <div class="ul-banner-slide-txt">
                                <span class="ul-banner-slide-sub-title">High Quality Wireless Earbuds & Gadgets</span>
                                <h1 class="ul-banner-slide-title">Enjoy High-Fidelity Audio Everywhere</h1>
                                <p class="ul-banner-slide-price">Starting From <span class="price">৳450</span></p>
                                <a href="{{ route('shop.catalog') }}" class="ul-btn">SHOP NOW <i class="flaticon-up-right-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- slider navigation -->
                    <div class="ul-banner-slider-nav-wrapper">
                        <div class="ul-banner-slider-nav">
                            <button class="prev"><span class="icon"><i class="flaticon-down"></i></span></button>
                            <button class="next"><span class="icon"><i class="flaticon-down"></i></span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ul-banner-img-slider-wrapper">
                <div class="ul-banner-img-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/img/banner-img-slide-1.jpg') }}" alt="Banner Image">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/img/banner-img-slide-2.jpg') }}" alt="Banner Image">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('frontend/img/banner-img-slide-3.jpg') }}" alt="Banner Image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- BANNER SECTION END -->

<!-- CATEGORY SECTION START -->
<div class="ul-container">
    <section class="ul-categories">
        <div class="ul-inner-container">
            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-2 row-cols-xxs-1 ul-bs-row">
                <!-- single category -->
                <div class="col">
                    <a class="ul-category" href="{{ route('shop.catalog') }}">
                        <div class="ul-category-img">
                            <img src="{{ asset('frontend/img/category-1.jpg') }}" alt="Chargers">
                        </div>
                        <div class="ul-category-txt">
                            <span>Chargers & Cables</span>
                        </div>
                        <div class="ul-category-btn">
                            <span><i class="flaticon-arrow-point-to-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- single category -->
                <div class="col">
                    <a class="ul-category" href="{{ route('shop.catalog') }}">
                        <div class="ul-category-img">
                            <img src="{{ asset('frontend/img/category-2.jpg') }}" alt="Covers">
                        </div>
                        <div class="ul-category-txt">
                            <span>Back Covers</span>
                        </div>
                        <div class="ul-category-btn">
                            <span><i class="flaticon-arrow-point-to-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- single category -->
                <div class="col">
                    <a class="ul-category" href="{{ route('shop.catalog') }}">
                        <div class="ul-category-img">
                            <img src="{{ asset('frontend/img/category-3.jpg') }}" alt="Glass Protectors">
                        </div>
                        <div class="ul-category-txt">
                            <span>Tempered Glass</span>
                        </div>
                        <div class="ul-category-btn">
                            <span><i class="flaticon-arrow-point-to-right"></i></span>
                        </div>
                    </a>
                </div>

                <!-- single category -->
                <div class="col">
                    <a class="ul-category" href="{{ route('shop.catalog') }}">
                        <div class="ul-category-img">
                            <img src="{{ asset('frontend/img/category-4.jpg') }}" alt="Earphones">
                        </div>
                        <div class="ul-category-txt">
                            <span>Earphones & TWS</span>
                        </div>
                        <div class="ul-category-btn">
                            <span><i class="flaticon-arrow-point-to-right"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- CATEGORY SECTION END -->


<!-- PRODUCTS SECTION START -->
<div class="ul-container">
    <section class="ul-products">
        <div class="ul-inner-container">
            <div class="ul-section-heading">
                <div class="left">
                    <span class="ul-section-sub-title">Accessories Collection</span>
                    <h2 class="ul-section-title">Featured Accessories Every Day</h2>
                </div>

                <div class="right"><a href="{{ route('shop.catalog') }}" class="ul-btn">More Collection <i class="flaticon-up-right-arrow"></i></a></div>
            </div>

            <div class="row ul-bs-row">
                <!-- 1st row sub-banner -->
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="ul-products-sub-banner">
                        <div class="ul-products-sub-banner-img">
                            <img src="{{ asset('frontend/img/products-sub-banner-1.jpg') }}" alt="Sub Banner Image">
                        </div>
                        <div class="ul-products-sub-banner-txt">
                            <h3 class="ul-products-sub-banner-title">Trending Accessories Special Deals!</h3>
                            <a href="{{ route('shop.catalog') }}" class="ul-btn">Shop Now <i class="flaticon-up-right-arrow"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
                    <!-- products slider 1 -->
                    <div class="swiper ul-products-slider-1">
                        <div class="swiper-wrapper">
                            @foreach($accessories as $item)
                                <div class="swiper-slide">
                                    <div class="ul-product">
                                        <div class="ul-product-heading">
                                            <span class="ul-product-price">৳{{ number_format($item->sale_price, 2) }}</span>
                                            <span class="ul-product-discount-tag">In Stock</span>
                                        </div>

                                        <div class="ul-product-img">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}">

                                            <div class="ul-product-actions">
                                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                    <button type="submit" title="Add to Cart" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="flaticon-shopping-bag"></i></button>
                                                </form>
                                                <form action="{{ route('wishlist.toggle') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                    <button type="submit" title="Add to Wishlist" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="flaticon-heart"></i></button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="ul-product-txt">
                                            <h4 class="ul-product-title"><a href="{{ route('shop.show', $item->id) }}">{{ $item->name }}</a></h4>
                                            <h5 class="ul-product-category"><a href="{{ route('shop.catalog') }}">{{ $item->categoryRelation->name ?? $item->category ?? 'Accessory' }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- slider navigation -->
                    <div class="ul-products-slider-nav ul-products-slider-1-nav">
                        <button class="prev"><i class="flaticon-left-arrow"></i></button>
                        <button class="next"><i class="flaticon-arrow-point-to-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- PRODUCTS SECTION END -->


<!-- AD SECTION START -->
<div class="ul-container">
    <section class="ul-ad">
        <div class="ul-inner-container">
            <div class="ul-ad-content">
                <div class="ul-ad-txt">
                    <span class="ul-ad-sub-title">Trending Accessories</span>
                    <h2 class="ul-section-title">Get Discount On Genuine Mobile Gadgets!</h2>
                    <div class="ul-ad-categories">
                        <span class="category"><span><i class="flaticon-check-mark"></i></span>Chargers</span>
                        <span class="category"><span><i class="flaticon-check-mark"></i></span>Glass</span>
                        <span class="category"><span><i class="flaticon-check-mark"></i></span>Back Covers</span>
                        <span class="category"><span><i class="flaticon-check-mark"></i></span>Earphones</span>
                    </div>
                </div>

                <div class="ul-ad-img">
                    <img src="{{ asset('frontend/img/ad-img.png') }}" alt="Ad Image">
                </div>

                <a href="{{ route('shop.catalog') }}" class="ul-btn">Check Discount <i class="flaticon-up-right-arrow"></i></a>
            </div>
        </div>
    </section>
</div>
<!-- AD SECTION END -->


<!-- MOST SELLING START -->
<div class="ul-container">
    <section class="ul-products ul-most-selling-products">
        <div class="ul-inner-container">
            <div class="ul-section-heading flex-lg-row flex-column text-md-start text-center">
                <div class="left">
                    <span class="ul-section-sub-title">Most Selling Items</span>
                    <h2 class="ul-section-title">Top Accessories This Week</h2>
                </div>

                <div class="right">
                    <div class="ul-most-sell-filter-navs">
                        <button type="button" data-filter="all">All Products</button>
                        <button type="button" data-filter=".best-selling">Best Selling</button>
                        <button type="button" data-filter=".on-selling">On Selling</button>
                    </div>
                </div>
            </div>

            <!-- products grid -->
            <div class="ul-bs-row row row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-1 ul-filter-products-wrapper">
                @foreach($accessories->take(8) as $item)
                    <div class="mix col best-selling">
                        <div class="ul-product-horizontal">
                            <div class="ul-product-horizontal-img">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                            </div>

                            <div class="ul-product-horizontal-txt">
                                <span class="ul-product-price">৳{{ number_format($item->sale_price, 2) }}</span>
                                <h4 class="ul-product-title"><a href="{{ route('shop.show', $item->id) }}">{{ $item->name }}</a></h4>
                                <h5 class="ul-product-category"><a href="{{ route('shop.catalog') }}">{{ $item->categoryRelation->name ?? $item->category ?? 'Accessory' }}</a></h5>
                                <div class="ul-product-rating">
                                    <span class="star"><i class="flaticon-star"></i></span>
                                    <span class="star"><i class="flaticon-star"></i></span>
                                    <span class="star"><i class="flaticon-star"></i></span>
                                    <span class="star"><i class="flaticon-star"></i></span>
                                    <span class="star"><i class="flaticon-star"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
<!-- MOST SELLING END -->
@endsection
