@extends('layouts/blankLayout')

@section('title', 'প্রোডাক্টস (Products & Accessories) – ' . ($shopSettings['shop_name'] ?? 'M3 Mobile Care'))
@section('meta_description', 'M3 Mobile Care - মোবাইল চার্জার, কাভার, ডিসপ্লে পার্টস, গ্লাস প্রোটেক্টর ও অরিজিনাল এক্সেসরিজ।')

@section('head_extra')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
@endsection

@section('content')
<style>
    body { font-family: 'Outfit', sans-serif !important; background-color: #f8fafc !important; }
    .products-hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 60px 0; }
    .product-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        border-color: #f37021;
        box-shadow: 0 15px 35px rgba(243, 112, 33, 0.12);
    }
    .product-img-holder {
        height: 200px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-img-holder img {
        max-height: 100%;
        width: auto;
        object-fit: contain;
    }
</style>

@include('_partials.public-navbar')

<div class="products-hero text-center">
    <div class="container">
        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-3">ORIGINAL ACCESSORIES & SPARES</span>
        <h1 class="text-white fw-extrabold display-5 mb-3">মোবাইল এক্সেসরিজ ও পার্টস</h1>
        <p class="text-slate-300 fs-5 max-w-2xl mx-auto">
            জেনুইন ফাস্ট চার্জার, এয়ারপডস, ডিসপ্লে পার্টস, ব্যাক কাভার ও প্রিমিয়াম ক্যাবল সংগ্রহ করুন।
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- Search & Filter Bar -->
    <div class="card p-3 mb-4 border shadow-sm rounded-4">
        <form action="{{ route('products') }}" method="GET" class="row g-3">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="ti tabler-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="প্রোডাক্টের নাম বা মডেল দিয়ে খুঁজুন..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">সকল ক্যাটাগরি</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-orange-gradient text-white w-100 fw-bold">সার্চ করুন</button>
            </div>
        </form>
    </div>

    <!-- Product Grid (No Price Display) -->
    @if($products->count() > 0)
        <div class="row g-4 mb-4">
            @foreach($products as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card h-100 d-flex flex-column">
                        <div class="product-img-holder p-3 position-relative">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                            @else
                                <i class="ti tabler-device-mobile text-muted display-4"></i>
                            @endif
                            <span class="badge bg-success position-absolute top-0 end-0 m-3 fs-8">স্টকে আছে</span>
                        </div>
                        <div class="p-3.5 flex-grow-1 d-flex flex-column">
                            <span class="text-uppercase text-muted fs-8 fw-bold">{{ $item->category }}</span>
                            <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $item->name }}">{{ $item->name }}</h6>
                            @if($item->model_compatibility)
                                <small class="text-muted mb-2 d-block">মডেল: {{ $item->model_compatibility }}</small>
                            @endif
                            <div class="mt-auto pt-3 border-top text-end">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('অর্ডার করতে চাই: ' . $item->name) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 w-100 fw-semibold">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> WhatsApp অর্ডার
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted bg-white rounded-4 border">
            <i class="ti tabler-package-off fs-1 text-warning d-block mb-2"></i>
            <h5 class="fw-bold">কোনো প্রোডাক্ট পাওয়া যায়নি!</h5>
            <p class="mb-0">অন্য কোনো নাম বা ক্যাটাগরি দিয়ে চেষ্টা করুন।</p>
        </div>
    @endif
</div>

@include('_partials.public-footer')
@endsection
