@extends('layouts/contentNavbarLayout')

@section('title', 'Accessories Stock - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Accessories Stock Management</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Accessories</li>
                </ol>
            </nav>
        </div>
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
        <a href="{{ route('admin.inventory.create', ['type' => 'accessory']) }}" class="btn btn-primary">
            <i class="ti tabler-plus me-1"></i>Add Accessory
        </a>
        @endif
    </div>

    <!-- Alert Notifications -->

    <!-- Main Content -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 py-3">
                <form action="{{ route('admin.inventory.accessories') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search SKU, name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="category_id" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="supplier_id" class="form-select form-select-sm">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="stock_status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="in" {{ request('stock_status') == 'in' ? 'selected' : '' }}>In Stock</option>
                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock Alert</option>
                            <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="per_page" class="form-select form-select-sm">
                            <option value="10" {{ request('per_page', '10') == '10' ? 'selected' : '' }}>10 / Page</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 / Page</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 / Page</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 / Page</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-1.5">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti tabler-search me-0.5"></i>Filter</button>
                        <a href="{{ route('admin.inventory.accessories') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">Image</th>
                            <th>SKU</th>
                            <th>Accessory Name</th>
                            <th>Category</th>
                            <th>Barcode</th>
                            <th>Stock Quantity</th>
                            <th>Cost Price</th>
                            <th>Sale Price</th>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                            <th class="text-end" style="width: 150px;">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        @php
                            $isLowStock = $item->quantity <= $item->alert_quantity;
                        @endphp
                        <tr class="{{ $isLowStock ? 'table-warning' : '' }}">
                            <td>
                                @if(!empty($item->images) && is_array($item->images) && count($item->images) > 0)
                                    <img src="{{ asset('storage/' . $item->images[0]) }}" class="rounded shadow-xs" alt="{{ $item->name }}" style="width: 42px; height: 42px; object-fit: cover; border: 1px solid rgba(0,0,0,0.08);">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center bg-light text-muted" style="width: 42px; height: 42px; border: 1px solid rgba(0,0,0,0.08);">
                                        <i class="ti tabler-photo fs-4 text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td><span class="fw-bold text-dark">{{ $item->sku }}</span></td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->name }}</div>
                                @if($isLowStock)
                                    <span class="badge bg-label-danger fs-9">Low Stock Alert (Threshold: {{ $item->alert_quantity }})</span>
                                @endif
                            </td>
                            <td>{{ $item->categoryRelation ? $item->categoryRelation->name : $item->category }}</td>
                            <td>{{ $item->barcode ?? 'N/A' }}</td>
                            <td>
                                <span class="fw-extrabold text-dark fs-5 {{ $isLowStock ? 'text-danger' : 'text-success' }}">{{ $item->quantity }}</span> pcs
                            </td>
                            <td>{{ number_format($item->purchase_price, 2) }} BDT</td>
                            <td><span class="fw-bold text-success">{{ number_format($item->sale_price, 2) }} BDT</span></td>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                            <td class="text-end">
                                <div class="d-inline-flex">
                                    <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-icon btn-sm btn-outline-primary me-1" title="Edit Item">
                                        <i class="ti tabler-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item from catalog?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">No accessories matching search details.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($items->hasPages())
            <div class="card-footer bg-transparent border-0 d-flex justify-content-end py-3">
                {{ $items->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
