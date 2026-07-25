@extends('layouts.frontend')

@section('title', 'Wishlist - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Wishlist</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Wishlist</span>
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
                        <th>Stock Status</th>
                        <th>Action</th>
                        <th>Remove</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($wishlistItems as $item)
                        <tr>
                            <td>
                                <div class="ul-cart-product">
                                    <a href="{{ route('shop.show', $item->id) }}" class="ul-cart-product-img">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                    </a>
                                    <a href="{{ route('shop.show', $item->id) }}" class="ul-cart-product-title">{{ $item->name }}</a>
                                </div>
                            </td>
                            <td><span class="ul-cart-item-price">৳{{ number_format($item->sale_price, 2) }}</span></td>
                            <td><span class="badge bg-success px-3 py-2">In Stock</span></td>
                            <td>
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <button type="submit" class="ul-btn py-2 px-3 fs-6">Add to Cart <i class="flaticon-shopping-bag ms-1"></i></button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('wishlist.toggle') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <div class="ul-cart-item-remove">
                                        <button type="submit" title="Remove from Wishlist"><i class="flaticon-close"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="flaticon-heart display-3 text-muted mb-3 d-block"></i>
                                <h4 class="fw-bold">Your wishlist is empty</h4>
                                <p class="text-muted">Explore our catalog and save your favorite mobile accessories!</p>
                                <a href="{{ route('shop.catalog') }}" class="ul-btn mt-3">Explore Catalog <i class="flaticon-up-right-arrow"></i></a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
