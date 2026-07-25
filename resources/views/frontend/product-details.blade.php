@extends('layouts.frontend')

@section('title', $product->name . ' - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Shop Details</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <a href="{{ route('shop.catalog') }}">Shop</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Shop Details</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- MAIN CONTENT SECTION START -->
<div class="ul-inner-page-container">
    <div class="ul-product-details">
        <div class="ul-product-details-top">
            <div class="row ul-bs-row row-cols-lg-2 row-cols-1 align-items-center">
                <!-- img -->
                <div class="col">
                    <div class="ul-product-details-img">
                        <div class="ul-product-details-img-slider swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide text-center">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-height: 480px; width: 100%; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- txt -->
                <div class="col">
                    <div class="ul-product-details-txt">
                        <!-- product rating -->
                        <div class="ul-product-details-rating">
                            <span class="rating">
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </span>
                            <span class="review-number">(5.0 Rating / Verified Genuine)</span>
                        </div>

                        <!-- price -->
                        <span class="ul-product-details-price">৳{{ number_format($product->sale_price, 2) }}</span>

                        <!-- product title -->
                        <h3 class="ul-product-details-title">{{ $product->name }}</h3>

                        <!-- product description -->
                        <p class="ul-product-details-descr">
                            {{ $product->description ?: 'High quality genuine mobile accessory designed for durability and optimal device performance. Official item from M3 Mobile Care.' }}
                        </p>

                        <!-- product options -->
                        <div class="ul-product-details-options">
                            @if($product->categoryRelation || $product->category)
                                <div class="ul-product-details-option">
                                    <span class="title">Category: <strong>{{ $product->categoryRelation->name ?? $product->category }}</strong></span>
                                </div>
                            @endif
                            @if($product->brand)
                                <div class="ul-product-details-option">
                                    <span class="title">Brand: <strong>{{ $product->brand }}</strong></span>
                                </div>
                            @endif
                            @if($product->model)
                                <div class="ul-product-details-option">
                                    <span class="title">Model: <strong>{{ $product->model }}</strong></span>
                                </div>
                            @endif
                            @if($product->sku)
                                <div class="ul-product-details-option">
                                    <span class="title">SKU Code: <strong>{{ $product->sku }}</strong></span>
                                </div>
                            @endif
                        </div>

                        <!-- product quantity & form -->
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="ul-product-details-option ul-product-details-quantity">
                                <span class="title">Quantity</span>
                                <div class="ul-product-quantity-wrapper">
                                    <input type="number" name="quantity" id="ul-product-details-quantity" class="ul-product-quantity" value="1" min="1" readonly>
                                    <div class="btns">
                                        <button type="button" class="quantityIncreaseButton" onclick="let input=document.getElementById('ul-product-details-quantity'); input.value = parseInt(input.value||1)+1;"><i class="flaticon-plus"></i></button>
                                        <button type="button" class="quantityDecreaseButton" onclick="let input=document.getElementById('ul-product-details-quantity'); if(parseInt(input.value)>1) input.value = parseInt(input.value)-1;"><i class="flaticon-minus-sign"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- product actions -->
                            <div class="ul-product-details-actions">
                                <div class="left">
                                    <button type="submit" class="btn-action-pill btn-add-cart">
                                        ADD TO CART <span class="icon-divider"><i class="flaticon-cart"></i></span>
                                    </button>
                                    <a href="https://wa.me/?text={{ urlencode('I want to buy: ' . $product->name . ' - Price: ৳' . number_format($product->sale_price, 2)) }}" target="_blank" class="btn-action-pill btn-whatsapp-order">
                                        WhatsApp Order <span class="icon-divider"><i class="flaticon-up-right-arrow"></i></span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="ul-product-details-bottom">
            <!-- description -->
            <div class="ul-product-details-long-descr-wrapper">
                <h3 class="ul-product-details-inner-title">Item Description</h3>
                <p>{{ $product->description ?: 'Premium quality mobile accessory with high durability, sleek ergonomics, and top performance. Tested and certified for quality assurance by M3 Mobile Care.' }}</p>
            </div>
        </div>
    </div>
</div>
<!-- MAIN CONTENT SECTION END -->
@endsection
