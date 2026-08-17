@extends('layouts/contentNavbarLayout')

@section('title', 'Salesman Price Catalog Generator - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti tabler-printer me-2 text-primary"></i>Salesman Price Catalog Generator
            </h4>
            <span class="text-muted small">Generate and print hardcopy selling price lists for salesmen with hidden cost prices.</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.inventory.accessories') }}" class="btn btn-outline-secondary">
                <i class="ti tabler-arrow-left me-1"></i>Back to Inventory
            </a>
            <a href="{{ route('admin.inventory.salesman-sheet.print', request()->all()) }}" target="_blank" class="btn btn-warning fw-bold text-white" style="background-color: #f37021; border-color: #f37021;">
                <i class="ti tabler-printer me-1"></i>Print A4 Hardcopy
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-label-primary border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold fs-6">
                    <i class="ti tabler-filter me-2"></i>Catalog Customization & Filters
                </h5>
            </div>
            <div class="card-body pt-4">
                <form method="GET" action="{{ route('admin.inventory.salesman-sheet') }}">
                    <div class="row g-3 align-items-end">
                        <!-- Product Type -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Product Type</label>
                            <select name="type" class="form-select">
                                <option value="accessory" {{ $type == 'accessory' ? 'selected' : '' }}>Accessories</option>
                                <option value="spare_part" {{ $type == 'spare_part' ? 'selected' : '' }}>Spare Parts</option>
                                <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All Products</option>
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand -->
                        <div class="col-md-2">
                            <label class="form-label fw-bold small">Brand</label>
                            <select name="brand" class="form-select">
                                <option value="">All Brands</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b }}" {{ $brand == $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selling Price Discount Range Margin -->
                        <div class="col-md-2">
                            <label class="form-label fw-bold small text-primary">Min Price Margin</label>
                            <select name="discount_margin" class="form-select border-primary">
                                <option value="0" {{ $discountMargin == 0 ? 'selected' : '' }}>0% (Retail Price Only)</option>
                                <option value="5" {{ $discountMargin == 5 ? 'selected' : '' }}>Up to 5% Discount Range</option>
                                <option value="10" {{ $discountMargin == 10 ? 'selected' : '' }}>Up to 10% Discount Range (Standard)</option>
                                <option value="15" {{ $discountMargin == 15 ? 'selected' : '' }}>Up to 15% Discount Range</option>
                                <option value="20" {{ $discountMargin == 20 ? 'selected' : '' }}>Up to 20% Discount Range</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti tabler-search me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Table Card -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold fs-6">
                    <i class="ti tabler-list me-2"></i>Product Catalog Preview (Total: {{ count($items) }} items)
                </h5>
                <span class="badge bg-label-danger fs-7">🔒 Cost / Purchase Price is 100% Hidden</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product Name</th>
                            <th>Code / SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Stock (Qty)</th>
                            <th class="text-end">Retail Price (MRP)</th>
                            <th class="text-end text-primary">Selling Price Range (Min - Max)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            @php
                                $mrp = floatval($item->sale_price);
                                $minPrice = $mrp - ($mrp * ($discountMargin / 100));
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong class="text-dark">{{ $item->name }}</strong>
                                </td>
                                <td><code class="text-secondary">{{ $item->sku }}</code></td>
                                <td><span class="badge bg-label-info">{{ $item->category }}</span></td>
                                <td>{{ $item->brand ?? 'Generic' }}</td>
                                <td>
                                    @if($item->quantity > 0)
                                        <span class="badge bg-label-success">{{ $item->quantity }} Pcs</span>
                                    @else
                                        <span class="badge bg-label-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">BDT {{ number_format($mrp, 2) }}</td>
                                <td class="text-end fw-bold text-success" style="font-size: 15px;">
                                    @if($discountMargin > 0)
                                        BDT {{ number_format($minPrice, 0) }} - BDT {{ number_format($mrp, 0) }}
                                    @else
                                        BDT {{ number_format($mrp, 0) }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No products found matching your filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
