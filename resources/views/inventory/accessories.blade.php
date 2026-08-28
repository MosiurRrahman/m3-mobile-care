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
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.inventory.barcode.print') }}" class="btn btn-outline-warning text-dark" style="border-color: #f37021;">
                <i class="ti tabler-barcode me-1 text-warning"></i>বারকোড প্রিন্ট
            </a>
            <a href="{{ route('admin.inventory.salesman-sheet', ['type' => 'accessory']) }}" class="btn btn-outline-primary">
                <i class="ti tabler-printer me-1"></i>সেলস প্রাইস শিট
            </a>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
            <a href="{{ route('admin.inventory.create', ['type' => 'accessory']) }}" class="btn btn-primary">
                <i class="ti tabler-plus me-1"></i>Add Accessory
            </a>
            @endif
        </div>
    </div>

    <!-- Alert Notifications -->

    <!-- Main Content -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom py-3">
                <form action="{{ route('admin.inventory.accessories') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="ti tabler-search text-muted fs-7"></i></span>
                            <input type="text" name="search" class="form-control form-control-sm border-start-0" placeholder="Search SKU, name..." value="{{ request('search') }}">
                        </div>
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
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti tabler-filter me-1"></i>Filter</button>
                        <a href="{{ route('admin.inventory.accessories') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-2 ps-3 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 50px;">Image</th>
                            <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 140px;">SKU & Barcode</th>
                            <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Product Name & Model</th>
                            <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 140px;">Category</th>
                            <th class="py-2 text-center text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 120px;">Stock Status</th>
                            <th class="py-2 text-end text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 110px;">Cost</th>
                            <th class="py-2 text-end text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 120px;">Sale Price</th>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                            <th class="py-2 text-end pe-3 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 120px;">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        @php
                            $isOutStock = $item->quantity == 0;
                            $isLowStock = $item->quantity <= $item->alert_quantity && !$isOutStock;
                        @endphp
                        <tr>
                            <td class="ps-3 py-2">
                                @if(!empty($item->images) && is_array($item->images) && count($item->images) > 0)
                                    <img src="{{ asset('storage/' . $item->images[0]) }}" class="rounded" alt="{{ $item->name }}" style="width: 36px; height: 36px; object-fit: cover; border: 1px solid #e2e8f0;">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center bg-light text-secondary" style="width: 36px; height: 36px; border: 1px solid #e2e8f0;">
                                        <i class="ti tabler-device-mobile fs-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-2">
                                <span class="fw-semibold text-dark font-monospace" style="font-size: 0.82rem;">{{ $item->sku }}</span>
                                @if($item->barcode)
                                    <div class="text-muted small font-monospace" style="font-size: 0.72rem;">
                                        <i class="ti tabler-barcode me-1"></i>{{ $item->barcode }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-2">
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 260px;" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </div>
                                @if($item->brand || $item->model)
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        {{ $item->brand }} {{ $item->model ? '• ' . $item->model : '' }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-2 text-secondary" style="font-size: 0.84rem;">
                                {{ $item->categoryRelation ? $item->categoryRelation->name : ($item->category ?? '—') }}
                            </td>
                            <td class="py-2 text-center">
                                @if($isOutStock)
                                    <span class="badge bg-label-danger rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                        <i class="ti tabler-point-filled fs-9 me-1"></i>0 Out
                                    </span>
                                @elseif($isLowStock)
                                    <span class="badge bg-label-warning rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                        <i class="ti tabler-point-filled fs-9 me-1"></i>{{ $item->quantity }} pcs
                                    </span>
                                @else
                                    <span class="badge bg-label-success rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                        <i class="ti tabler-point-filled fs-9 me-1"></i>{{ $item->quantity }} pcs
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 text-end text-muted" style="font-size: 0.84rem;">
                                {{ number_format($item->purchase_price, 2) }} ৳
                            </td>
                            <td class="py-2 text-end fw-bold text-dark" style="font-size: 0.86rem;">
                                {{ number_format($item->sale_price, 2) }} ৳
                            </td>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                            <td class="py-2 text-end pe-3">
                                <div class="d-inline-flex align-items-center gap-1">
                                    <a href="{{ route('admin.inventory.barcode.print', ['item_id' => $item->id, 'qty' => 60]) }}" target="_blank" class="btn btn-icon btn-sm btn-label-warning rounded" title="Print Barcode">
                                        <i class="ti tabler-barcode"></i>
                                    </a>

                                    <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-icon btn-sm btn-label-primary rounded" title="Edit Item">
                                        <i class="ti tabler-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this accessory from inventory?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-sm btn-label-danger rounded" title="Delete">
                                            <i class="ti tabler-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin()) ? 8 : 7 }}" class="text-center py-5 text-muted">
                                <i class="ti tabler-box-off fs-1 d-block mb-2 text-muted"></i>
                                No accessories found matching your filter criteria.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($items->hasPages())
            <div class="card-footer border-top py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="text-muted small">Showing {{ $items->firstItem() }}-{{ $items->lastItem() }} of {{ $items->total() }} accessories</span>
                <div>
                    {{ $items->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
