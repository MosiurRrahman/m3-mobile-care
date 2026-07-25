@extends('layouts.frontend')

@section('title', 'Cart List - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Cart List</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Cart List</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-cart-container">
    <div class="cart-top">
        <div class="table-responsive">
            <table class="ul-cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cartItems as $item)
                        <tr>
                            <td>
                                <div class="ul-cart-product">
                                    <a href="{{ route('shop.show', $item->id) }}" class="ul-cart-product-img"><img src="{{ $item->image_url }}" alt="{{ $item->name }}"></a>
                                    <a href="{{ route('shop.show', $item->id) }}" class="ul-cart-product-title">{{ $item->name }}</a>
                                </div>
                            </td>
                            <td><span class="ul-cart-item-price">৳{{ number_format($item->sale_price, 2) }}</span></td>
                            <td>
                                <div class="ul-product-details-quantity mt-0">
                                    <form action="{{ route('cart.update') }}" method="POST" class="ul-product-quantity-wrapper">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="number" name="quantity" class="ul-product-quantity" value="{{ $item->quantity ?? 1 }}" min="1" onchange="this.form.submit();" style="width: 70px; text-align: center;">
                                    </form>
                                </div>
                            </td>
                            <td><span class="ul-cart-item-subtotal">৳{{ number_format(($item->sale_price * ($item->quantity ?? 1)), 2) }}</span></td>
                            <td>
                                <div class="ul-cart-item-remove">
                                    <a href="{{ route('cart.remove', $item->id) }}" class="text-danger" title="Remove item" onclick="return confirm('Remove this product from cart?');">
                                        <i class="flaticon-close"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <div class="ul-cart-product">
                                    <a href="{{ route('shop.catalog') }}" class="ul-cart-product-img"><img src="{{ asset('frontend/img/banner-img-slide-1.jpg') }}" alt="Product"></a>
                                    <a href="{{ route('shop.catalog') }}" class="ul-cart-product-title">Anker 20W PowerPort III Nano Fast Charger</a>
                                </div>
                            </td>
                            <td><span class="ul-cart-item-price">৳1,500.00</span></td>
                            <td>
                                <div class="ul-product-details-quantity mt-0">
                                    <form action="#" class="ul-product-quantity-wrapper">
                                        <input type="number" name="product-quantity" class="ul-product-quantity" value="1" min="1" readonly="">
                                        <div class="btns">
                                            <button type="button" class="quantityIncreaseButton"><i class="flaticon-plus"></i></button>
                                            <button type="button" class="quantityDecreaseButton"><i class="flaticon-minus-sign"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td><span class="ul-cart-item-subtotal">৳1,500.00</span></td>
                            <td>
                                <div class="ul-cart-item-remove"><button type="button"><i class="flaticon-close"></i></button></div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <div class="ul-cart-actions">
                <div class="ul-cart-coupon-code-form-wrapper">
                    <span class="title">Coupon:</span>
                    <form action="#" class="ul-cart-coupon-code-form" onsubmit="event.preventDefault(); alert('Coupon applied!');">
                        <input name="coupon-code" placeholder="Enter Coupon Code" type="text">
                        <button class="mb-btn">Apply</button>
                    </form>
                </div>

                <button class="ul-cart-update-cart-btn" onclick="location.reload();">Update Cart</button>
            </div>
        </div>
    </div>

    @php
        $cartSubtotal = 0;
        foreach($cartItems as $cItem) {
            $cartSubtotal += ($cItem->sale_price * ($cItem->quantity ?? 1));
        }
        $shipping = $cartSubtotal > 0 ? 60 : 0;
        $cartTotal = $cartSubtotal + $shipping;
    @endphp

    <div class="cart-bottom">
        <div class="ul-cart-expense-overview">
            <h3 class="ul-cart-expense-overview-title">Total</h3>
            <div class="middle">
                <div class="single-row">
                    <span class="inner-title">Subtotal</span>
                    <span class="number">৳{{ number_format($cartSubtotal, 2) }}</span>
                </div>

                <div class="single-row">
                    <span class="inner-title">Shipping Fee</span>
                    <span class="number">৳{{ number_format($shipping, 2) }}</span>
                </div>
            </div>
            <div class="bottom">
                <div class="single-row">
                    <span class="inner-title">Total</span>
                    <span class="number">৳{{ number_format($cartTotal, 2) }}</span>
                </div>

                <button class="ul-cart-checkout-direct-btn" onclick="window.location.href='{{ route('shop.checkout') }}'">CHECKOUT</button>
            </div>
        </div>
    </div>
</div>
@endsection
