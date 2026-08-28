@extends('layouts/contentNavbarLayout')

@section('title', 'Purchases & Suppliers - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Purchases & Supplier Management</h4>
            <span class="text-muted small">Record parts/accessories purchase orders and manage supplier records</span>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                <i class="ti tabler-user-plus me-1"></i>Register Supplier
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPurchaseModal">
                <i class="ti tabler-plus me-1"></i>New Stock-In Entry
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success border-0 small py-2 d-flex align-items-center justify-content-between">
                <div><i class="ti tabler-check me-2"></i>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="col-12 mb-3">
            <div class="alert alert-danger border-0 small py-2">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Purchases History and Suppliers Tabs -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0 pt-3">
                <ul class="nav nav-tabs" id="purchaseTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="purchases-tab" data-bs-toggle="tab" data-bs-target="#purchases-content" type="button" role="tab" aria-controls="purchases-content" aria-selected="true">
                            <i class="ti tabler-receipt me-1"></i>Stock-In Purchase Logs ({{ $purchases instanceof \Illuminate\Pagination\LengthAwarePaginator ? $purchases->total() : count($purchases) }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers-content" type="button" role="tab" aria-controls="suppliers-content" aria-selected="false">
                            <i class="ti tabler-users me-1"></i>Registered Suppliers ({{ count($suppliers) }})
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0 tab-content" id="purchaseTabsContent">
                <!-- Tab: Purchases -->
                <div class="tab-pane fade show active p-3" id="purchases-content" role="tabpanel" aria-labelledby="purchases-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.84rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-2 ps-3 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Purchase No</th>
                                    <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Supplier</th>
                                    <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Restocked Items</th>
                                    <th class="py-2 text-end text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Total Cost</th>
                                    <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Date Ordered</th>
                                    <th class="py-2 text-end pe-3 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 130px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                <tr>
                                    <td class="py-2 ps-3">
                                        <span class="badge bg-label-secondary font-monospace text-dark fw-bold px-2 py-1" style="font-size: 0.76rem;">
                                            {{ $purchase->purchase_no }}
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="fw-bold text-dark">{{ $purchase->supplier ? $purchase->supplier->name : 'N/A' }}</div>
                                        @if($purchase->supplier && $purchase->supplier->phone)
                                            @php
                                                $sPhones = array_filter(array_map('trim', explode(',', $purchase->supplier->phone)));
                                            @endphp
                                            @if(!empty($sPhones))
                                                <div class="text-muted" style="font-size: 0.74rem;">
                                                    <i class="ti tabler-phone fs-8 text-primary"></i> {{ $sPhones[0] }}
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="py-2" style="max-width: 380px;">
                                        <div class="d-flex flex-column gap-1">
                                            <div class="d-flex align-items-center gap-1 flex-wrap">
                                                <span class="badge bg-label-primary rounded-pill px-2 py-1 fw-bold" style="font-size: 0.74rem;">
                                                    <i class="ti tabler-packages me-1"></i>{{ $purchase->details->count() }} Products
                                                </span>
                                                <span class="text-muted fw-medium" style="font-size: 0.75rem;">({{ $purchase->details->sum('quantity') }} pcs total)</span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                                @foreach($purchase->details->take(2) as $detail)
                                                    <span class="badge bg-light text-secondary border px-2 py-1 text-truncate" style="font-size: 0.72rem; max-width: 170px;" title="{{ $detail->item ? $detail->item->name : 'Item' }}">
                                                        {{ $detail->item ? $detail->item->name : 'Item' }} <span class="text-dark fw-bold">(x{{ $detail->quantity }})</span>
                                                    </span>
                                                @endforeach
                                                @if($purchase->details->count() > 2)
                                                    <button type="button" class="btn btn-xs btn-label-info py-0 px-2 rounded fw-medium" data-bs-toggle="modal" data-bs-target="#viewPurchaseModal{{ $purchase->id }}" style="font-size: 0.72rem;">
                                                        +{{ $purchase->details->count() - 2 }} more
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 text-end fw-bold text-dark" style="font-size: 0.88rem;">
                                        {{ number_format($purchase->total_amount, 2) }} ৳
                                    </td>
                                    <td class="py-2 text-muted" style="font-size: 0.8rem;">
                                        {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}
                                    </td>
                                    <td class="py-2 text-end pe-3">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <button type="button" class="btn btn-sm btn-icon btn-label-info rounded" data-bs-toggle="modal" data-bs-target="#viewPurchaseModal{{ $purchase->id }}" title="View Purchase Receipt & Breakdown">
                                                <i class="ti tabler-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-label-primary rounded" data-bs-toggle="modal" data-bs-target="#editPurchaseModal{{ $purchase->id }}" title="Edit Purchase">
                                                <i class="ti tabler-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-label-danger rounded" data-bs-toggle="modal" data-bs-target="#deletePurchaseModal{{ $purchase->id }}" title="Delete Purchase">
                                                <i class="ti tabler-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="ti tabler-receipt-off fs-2 d-block mb-2 text-muted"></i>
                                        No stock-in purchases logged yet. Click "New Stock-In Entry" to log a purchase.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($purchases instanceof \Illuminate\Pagination\LengthAwarePaginator && $purchases->hasPages())
                        <div class="px-3 py-2 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="text-muted small">
                                Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} entries
                            </span>
                            <div>
                                {{ $purchases->links() }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Tab: Suppliers -->
                <div class="tab-pane fade p-3" id="suppliers-content" role="tabpanel" aria-labelledby="suppliers-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.84rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-2 ps-3 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Supplier Name</th>
                                    <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Phone Number(s)</th>
                                    <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Address Details</th>
                                    <th class="py-2 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px;">Date Registered</th>
                                    <th class="py-2 text-end pe-3 text-uppercase text-muted fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.5px; width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suppliers as $supplier)
                                <tr>
                                    <td class="py-2 ps-3"><span class="fw-bold text-dark">{{ $supplier->name }}</span></td>
                                    <td class="py-2">
                                        @php
                                            $phoneList = array_map('trim', explode(',', $supplier->phone ?? ''));
                                        @endphp
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($phoneList as $pNum)
                                                @if(!empty($pNum))
                                                    <div><i class="ti tabler-phone fs-6 text-primary me-1"></i><span class="fw-semibold text-dark">{{ $pNum }}</span></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-2 text-muted">{{ $supplier->address ?? 'N/A' }}</td>
                                    <td class="py-2 text-muted" style="font-size: 0.8rem;">{{ $supplier->created_at->format('M d, Y') }}</td>
                                    <td class="py-2 text-end pe-3">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <button type="button" class="btn btn-sm btn-icon btn-label-primary rounded" data-bs-toggle="modal" data-bs-target="#editSupplierModal{{ $supplier->id }}" title="Edit Supplier">
                                                <i class="ti tabler-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-label-danger rounded" data-bs-toggle="modal" data-bs-target="#deleteSupplierModal{{ $supplier->id }}" title="Delete Supplier">
                                                <i class="ti tabler-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="ti tabler-users-minus fs-2 d-block mb-2 text-muted"></i>
                                        No registered suppliers found. Click "Register Supplier" to add one.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- ALL MODALS (PLACED OUTSIDE TABLES TO PREVENT OVERLAY BUGS) -->
<!-- ========================================================= -->

<!-- Modal: Add Supplier -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addSupplierModalLabel">Register Supplier Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.purchases.suppliers') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="sup_name">Supplier / Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="sup_name" class="form-control" placeholder="e.g. Dhaka Parts Depot" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number(s) <span class="text-danger">*</span></label>
                        <div id="add-supplier-phones-container">
                            <div class="input-group mb-2">
                                <input type="text" name="phone[]" class="form-control" placeholder="e.g. 01924915598" required>
                                <button type="button" class="btn btn-outline-danger disabled remove-phone-input-btn"><i class="ti tabler-trash"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="add-phone-field-btn">
                            <i class="ti tabler-plus me-1"></i>Add Another Phone Number
                        </button>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="sup_address">Office Address Details</label>
                        <textarea name="address" id="sup_address" rows="3" class="form-control" placeholder="e.g. Level 4, Plaza Tower, Dhaka"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: New Stock-In Entry -->
<div class="modal fade" id="addPurchaseModal" tabindex="-1" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addPurchaseModalLabel">Log Stock-In Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.purchases.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold" for="p_supplier_id">Select Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id" id="p_supplier_id" class="form-select" required>
                                <option value="" disabled selected>Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="p_purchase_date">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" id="p_purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 text-primary"><i class="ti tabler-list me-1"></i>Purchase Items:</h6>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle mb-3" id="purchase-items-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Catalog Description</th>
                                    <th style="width: 120px;">Qty Purchased</th>
                                    <th style="width: 150px;">Unit Cost (BDT)</th>
                                    <th class="text-center" style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody id="purchase-rows-body">
                                <tr>
                                    <td>
                                        <select name="items[0][inventory_item_id]" class="form-select form-select-sm" required>
                                            <option value="" disabled selected>Select Item...</option>
                                            @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} @if($item->brand || $item->model || $item->sub_category) [Brand: {{ $item->brand ?? "-" }}, Model: {{ $item->model ?? $item->sub_category ?? "-" }}] @endif (SKU: {{ $item->sku }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control form-control-sm text-center" value="1" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][cost_price]" step="0.01" min="0" class="form-control form-control-sm text-end" placeholder="0.00" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link btn-sm text-danger disabled remove-purchase-row"><i class="ti tabler-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-item-row-btn">
                        <i class="ti tabler-plus me-1"></i>Add Another Item
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Process Stock-In & Quantities</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals for Purchase Iteration -->
@foreach($purchases as $purchase)
    <!-- Modal: View Purchase Details & Breakdown Receipt -->
    <div class="modal fade" id="viewPurchaseModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-light py-3">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">
                            <i class="ti tabler-receipt me-1 text-primary"></i>Purchase Receipt: {{ $purchase->purchase_no }}
                        </h5>
                        <div class="text-muted small">Ordered on {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M, Y') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Supplier Info Card -->
                    <div class="card bg-lighter border mb-3">
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <span class="text-muted small d-block">Supplier / Vendor:</span>
                                    <span class="fw-bold text-dark fs-6">{{ $purchase->supplier ? $purchase->supplier->name : 'N/A' }}</span>
                                    @if($purchase->supplier && $purchase->supplier->address)
                                        <div class="text-muted small">{{ $purchase->supplier->address }}</div>
                                    @endif
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <span class="text-muted small d-block">Contact Phone:</span>
                                    <span class="fw-semibold text-dark">{{ $purchase->supplier ? ($purchase->supplier->phone ?: 'N/A') : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Breakdown Table -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-dark mb-0"><i class="ti tabler-packages me-1 text-primary"></i>Restocked Items Breakdown</h6>
                        <span class="badge bg-label-primary">{{ $purchase->details->count() }} Products ({{ $purchase->details->sum('quantity') }} pcs)</span>
                    </div>
                    <div class="table-responsive border rounded mb-3">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.83rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 py-2" style="width: 40px;">#</th>
                                    <th class="py-2">Item Name & SKU</th>
                                    <th class="py-2">Brand / Model</th>
                                    <th class="text-center py-2" style="width: 90px;">Qty</th>
                                    <th class="text-end py-2" style="width: 120px;">Unit Cost</th>
                                    <th class="text-end pe-3 py-2" style="width: 130px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->details as $pIndex => $detail)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $pIndex + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $detail->item ? $detail->item->name : 'Deleted Item' }}</div>
                                        @if($detail->item && $detail->item->sku)
                                            <span class="text-muted font-monospace" style="font-size: 0.72rem;">SKU: {{ $detail->item->sku }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($detail->item && ($detail->item->brand || $detail->item->model || $detail->item->sub_category))
                                            <span class="badge bg-label-secondary font-monospace" style="font-size: 0.72rem;">
                                                {{ $detail->item->brand ?? '-' }} | {{ $detail->item->model ?? $detail->item->sub_category ?? '-' }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-primary px-2 py-0.5 fw-bold">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="text-end text-muted">
                                        {{ number_format($detail->cost_price, 2) }} ৳
                                    </td>
                                    <td class="text-end pe-3 fw-bold text-dark">
                                        {{ number_format($detail->quantity * $detail->cost_price, 2) }} ৳
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light border-top">
                                <tr>
                                    <th colspan="3" class="ps-3 text-end fw-bold">Total Summary:</th>
                                    <th class="text-center fw-bold">{{ $purchase->details->sum('quantity') }} pcs</th>
                                    <th class="text-end fw-bold">Grand Total:</th>
                                    <th class="text-end pe-3 fw-bold text-danger fs-6">{{ number_format($purchase->total_amount, 2) }} ৳</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editPurchaseModal{{ $purchase->id }}">
                        <i class="ti tabler-edit me-1"></i>Edit Purchase
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Purchase -->
    <div class="modal fade" id="editPurchaseModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Purchase Entry: {{ $purchase->purchase_no }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.purchases.update', $purchase->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Select Supplier <span class="text-danger">*</span></label>
                                <select name="supplier_id" class="form-select" required>
                                    <option value="" disabled>Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" name="purchase_date" class="form-control" value="{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3 text-primary"><i class="ti tabler-list me-1"></i>Purchase Items:</h6>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle mb-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Catalog Description</th>
                                        <th style="width: 120px;">Qty Purchased</th>
                                        <th style="width: 150px;">Unit Cost (BDT)</th>
                                        <th class="text-center" style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="edit-purchase-rows-{{ $purchase->id }}">
                                    @foreach($purchase->details as $index => $detail)
                                    <tr>
                                        <td>
                                            <select name="items[{{ $index }}][inventory_item_id]" class="form-select form-select-sm" required>
                                                <option value="" disabled>Select Item...</option>
                                                @foreach($items as $item)
                                                <option value="{{ $item->id }}" {{ $detail->inventory_item_id == $item->id ? 'selected' : '' }}>{{ $item->name }} @if($item->brand || $item->model || $item->sub_category) [Brand: {{ $item->brand ?? "-" }}, Model: {{ $item->model ?? $item->sub_category ?? "-" }}] @endif (SKU: {{ $item->sku }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control form-control-sm text-center" value="{{ $detail->quantity }}" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][cost_price]" step="0.01" min="0" class="form-control form-control-sm text-end" value="{{ $detail->cost_price }}" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-link btn-sm text-danger remove-edit-row"><i class="ti tabler-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary add-edit-item-row" data-purchase-id="{{ $purchase->id }}">
                            <i class="ti tabler-plus me-1"></i>Add Another Item
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Purchase Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Delete Purchase Confirm -->
    <div class="modal fade" id="deletePurchaseModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">Delete Purchase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-3">
                    <i class="ti tabler-alert-triangle fs-1 text-danger mb-2 d-block"></i>
                    <p class="mb-0">Are you sure you want to delete purchase <strong>{{ $purchase->purchase_no }}</strong>? Inventory quantities restocked will be reverted.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modals for Supplier Iteration -->
@foreach($suppliers as $supplier)
    @php
        $supplierPhones = array_filter(array_map('trim', explode(',', $supplier->phone ?? '')));
        if (empty($supplierPhones)) { $supplierPhones = ['']; }
    @endphp
    <!-- Modal: Edit Supplier -->
    <div class="modal fade" id="editSupplierModal{{ $supplier->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Supplier Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.purchases.suppliers.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Supplier / Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number(s) <span class="text-danger">*</span></label>
                            <div id="edit-supplier-phones-container-{{ $supplier->id }}">
                                @foreach($supplierPhones as $pVal)
                                <div class="input-group mb-2">
                                    <input type="text" name="phone[]" class="form-control" value="{{ $pVal }}" placeholder="e.g. 01924915598" required>
                                    <button type="button" class="btn btn-outline-danger {{ count($supplierPhones) === 1 ? 'disabled' : '' }} remove-phone-input-btn"><i class="ti tabler-trash"></i></button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-1 add-edit-phone-btn" data-supplier-id="{{ $supplier->id }}">
                                <i class="ti tabler-plus me-1"></i>Add Another Phone Number
                            </button>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Office Address Details</label>
                            <textarea name="address" rows="3" class="form-control">{{ $supplier->address }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Delete Supplier Confirm -->
    <div class="modal fade" id="deleteSupplierModal{{ $supplier->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">Delete Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-3">
                    <i class="ti tabler-alert-triangle fs-1 text-danger mb-2 d-block"></i>
                    <p class="mb-0">Are you sure you want to delete supplier <strong>{{ $supplier->name }}</strong>?</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.purchases.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Stock-In Purchase dynamic rows
        let rowCount = 1;
        const addRowBtn = document.getElementById('add-item-row-btn');
        const rowsBody = document.getElementById('purchase-rows-body');

        if (addRowBtn) {
            addRowBtn.addEventListener('click', function() {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <select name="items[${rowCount}][inventory_item_id]" class="form-select form-select-sm" required>
                            <option value="" disabled selected>Select Item...</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} @if($item->brand || $item->model || $item->sub_category) [Brand: {{ $item->brand ?? "-" }}, Model: {{ $item->model ?? $item->sub_category ?? "-" }}] @endif (SKU: {{ $item->sku }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[${rowCount}][quantity]" class="form-control form-control-sm text-center" value="1" min="1" required>
                    </td>
                    <td>
                        <input type="number" name="items[${rowCount}][cost_price]" step="0.01" min="0" class="form-control form-control-sm text-end" placeholder="0.00" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link btn-sm text-danger remove-purchase-row"><i class="ti tabler-trash"></i></button>
                    </td>
                `;
                rowsBody.appendChild(tr);
                rowCount++;
                updateRemoveButtons();
            });
        }

        if (rowsBody) {
            rowsBody.addEventListener('click', function(e) {
                if (e.target.closest('.remove-purchase-row')) {
                    const tr = e.target.closest('tr');
                    tr.remove();
                    updateRemoveButtons();
                }
            });
        }

        function updateRemoveButtons() {
            const buttons = document.querySelectorAll('.remove-purchase-row');
            if (buttons.length === 1) {
                buttons[0].classList.add('disabled');
            } else {
                buttons.forEach(btn => btn.classList.remove('disabled'));
            }
        }

        // Add dynamic row for edit purchase modals
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-edit-item-row')) {
                const btn = e.target.closest('.add-edit-item-row');
                const purchaseId = btn.dataset.purchaseId;
                const tbody = document.getElementById('edit-purchase-rows-' + purchaseId);
                const nextIndex = tbody.children.length;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <select name="items[${nextIndex}][inventory_item_id]" class="form-select form-select-sm" required>
                            <option value="" disabled selected>Select Item...</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} @if($item->brand || $item->model || $item->sub_category) [Brand: {{ $item->brand ?? "-" }}, Model: {{ $item->model ?? $item->sub_category ?? "-" }}] @endif (SKU: {{ $item->sku }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[${nextIndex}][quantity]" class="form-control form-control-sm text-center" value="1" min="1" required>
                    </td>
                    <td>
                        <input type="number" name="items[${nextIndex}][cost_price]" step="0.01" min="0" class="form-control form-control-sm text-end" placeholder="0.00" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link btn-sm text-danger remove-edit-row"><i class="ti tabler-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            }

            if (e.target.closest('.remove-edit-row')) {
                const tr = e.target.closest('tr');
                const tbody = tr.parentElement;
                if (tbody.children.length > 1) {
                    tr.remove();
                }
            }
        });

        // Dynamic Multiple Phone Inputs for Supplier Modals
        const addPhoneBtn = document.getElementById('add-phone-field-btn');
        const phonesContainer = document.getElementById('add-supplier-phones-container');

        if (addPhoneBtn && phonesContainer) {
            addPhoneBtn.addEventListener('click', function() {
                const div = document.createElement('div');
                div.className = 'input-group mb-2';
                div.innerHTML = `
                    <input type="text" name="phone[]" class="form-control" placeholder="e.g. 01924915598" required>
                    <button type="button" class="btn btn-outline-danger remove-phone-input-btn"><i class="ti tabler-trash"></i></button>
                `;
                phonesContainer.appendChild(div);
                updatePhoneRemoveState(phonesContainer);
            });
        }

        document.addEventListener('click', function(e) {
            // Add phone in edit supplier modal
            if (e.target.closest('.add-edit-phone-btn')) {
                const btn = e.target.closest('.add-edit-phone-btn');
                const supplierId = btn.dataset.supplierId;
                const container = document.getElementById('edit-supplier-phones-container-' + supplierId);
                const div = document.createElement('div');
                div.className = 'input-group mb-2';
                div.innerHTML = `
                    <input type="text" name="phone[]" class="form-control" placeholder="e.g. 01924915598" required>
                    <button type="button" class="btn btn-outline-danger remove-phone-input-btn"><i class="ti tabler-trash"></i></button>
                `;
                container.appendChild(div);
                updatePhoneRemoveState(container);
            }

            // Remove phone input field
            if (e.target.closest('.remove-phone-input-btn')) {
                const btn = e.target.closest('.remove-phone-input-btn');
                if (btn.classList.contains('disabled')) return;
                const inputGroup = btn.closest('.input-group');
                const container = inputGroup.parentElement;
                if (container.children.length > 1) {
                    inputGroup.remove();
                    updatePhoneRemoveState(container);
                }
            }
        });

        function updatePhoneRemoveState(container) {
            const btns = container.querySelectorAll('.remove-phone-input-btn');
            if (btns.length === 1) {
                btns[0].classList.add('disabled');
            } else {
                btns.forEach(b => b.classList.remove('disabled'));
            }
        }
    });
</script>
@endsection
