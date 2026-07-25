@extends('layouts.frontend')

@section('title', 'Mobile Accessories Catalog - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Accessories Shop</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Accessories Shop</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<!-- MAIN CONTENT SECTION START -->
<div class="ul-inner-page-container">
    <div class="ul-inner-products-wrapper">
        <div class="ul-container">
            <div class="row ul-bs-row flex-column-reverse flex-md-row">
                <!-- left sidebar filter -->
                <div class="col-lg-3 col-md-4">
                    <div class="ul-products-sidebar">
                        <!-- search widget -->
                        <div class="ul-products-sidebar-widget ul-products-search">
                            <form action="{{ route('shop.catalog') }}" method="GET" class="ul-products-search-form">
                                <input type="text" name="search" id="ul-products-search-field" placeholder="Search Accessories..." value="{{ request('search') }}">
                                <button type="submit"><i class="flaticon-search-interface-symbol"></i></button>
                            </form>
                        </div>

                        <!-- categories widget -->
                        <div class="ul-products-sidebar-widget ul-products-categories">
                            <h3 class="ul-products-sidebar-widget-title">Categories</h3>

                            <div class="ul-products-categories-link">
                                <a href="{{ route('shop.catalog') }}" class="{{ request('category') == '' ? 'active fw-bold' : '' }}">
                                    <span><i class="flaticon-arrow-point-to-right"></i> All Accessories</span>
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('shop.catalog', ['category' => $cat->id, 'search' => request('search')]) }}" class="{{ request('category') == $cat->id ? 'active fw-bold' : '' }}">
                                        <span><i class="flaticon-arrow-point-to-right"></i> {{ $cat->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- product status widget -->
                        <div class="ul-products-sidebar-widget">
                            <h3 class="ul-products-sidebar-widget-title">Filter Options</h3>

                            <div class="ul-products-categories-link">
                                <a href="{{ route('shop.catalog') }}"><span><i class="flaticon-arrow-point-to-right"></i> In Stock Items</span></a>
                                @if(request('search') || request('category'))
                                    <a href="{{ route('shop.catalog') }}" class="text-danger"><span><i class="flaticon-close"></i> Clear All Filters</span></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- right products grid -->
                <div class="col-lg-9 col-md-8">
                    @if($accessories->isEmpty())
                        <div class="text-center py-5">
                            <i class="flaticon-shopping-bag display-1 text-muted"></i>
                            <h3 class="mt-3">No accessories found</h3>
                            <p class="text-muted">Try adjusting your search query or selected category filter.</p>
                            <a href="{{ route('shop.catalog') }}" class="ul-btn mt-3">Browse All Accessories <i class="flaticon-up-right-arrow"></i></a>
                        </div>
                    @else
                        <div class="row ul-bs-row row-cols-lg-3 row-cols-2 row-cols-xxs-1">
                            @foreach($accessories as $item)
                                <div class="col mb-4">
                                    <div class="ul-product">
                                        <div class="ul-product-heading">
                                            <span class="ul-product-price">৳{{ number_format($item->sale_price, 2) }}</span>
                                            <span class="ul-product-discount-tag">In Stock</span>
                                        </div>

                                        <div class="ul-product-img">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" onerror="this.src='{{ asset('frontend/img/product-img-1.jpg') }}'">

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
                                            <h5 class="ul-product-category"><a href="{{ route('shop.catalog', ['category' => $item->category_id]) }}">{{ $item->categoryRelation->name ?? $item->category ?? 'Accessory' }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- SAAFIE CUSTOM PAGINATION -->
                        @if ($accessories->hasPages())
                            <div class="ul-pagination">
                                <ul>
                                    {{-- Previous Page Link --}}
                                    @if ($accessories->onFirstPage())
                                        <li class="disabled"><span><i class="flaticon-left-arrow"></i></span></li>
                                    @else
                                        <li><a href="{{ $accessories->previousPageUrl() }}"><i class="flaticon-left-arrow"></i></a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    <li class="pages">
                                        @foreach ($accessories->getUrlRange(1, $accessories->lastPage()) as $page => $url)
                                            @if ($page == $accessories->currentPage())
                                                <a href="{{ $url }}" class="active">{{ sprintf('%02d', $page) }}</a>
                                            @else
                                                <a href="{{ $url }}">{{ sprintf('%02d', $page) }}</a>
                                            @endif
                                        @endforeach
                                    </li>

                                    {{-- Next Page Link --}}
                                    @if ($accessories->hasMorePages())
                                        <li><a href="{{ $accessories->nextPageUrl() }}"><i class="flaticon-arrow-point-to-right"></i></a></li>
                                    @else
                                        <li class="disabled"><span><i class="flaticon-arrow-point-to-right"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MAIN CONTENT SECTION END -->
@endsection
