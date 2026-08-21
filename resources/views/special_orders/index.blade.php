@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Special Orders & Pre-Orders - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">📦 Customer Special Orders (প্রি-অর্ডার ও ঢাকা পার্টস)</h4>
            <span class="text-muted">কাস্টমারের জন্য ঢাকা বা বাইরে থেকে আনা পার্টস ও বিশেষ প্রোডাক্টের ট্র্যাকিং</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.special-orders.create') }}" class="btn btn-primary">
                <i class="ti tabler-plus me-1"></i>New Special Order
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-0 shadow-sm text-center p-3 h-100">
            <span class="text-muted small fw-bold text-uppercase">Total Orders</span>
            <h3 class="fw-bold text-dark mt-2 mb-0">{{ $stats['total'] }}</h3>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-0 shadow-sm text-center p-3 h-100 bg-label-warning">
            <span class="text-warning small fw-bold text-uppercase">In Transit / Pending</span>
            <h3 class="fw-bold text-warning mt-2 mb-0">{{ $stats['pending'] }}</h3>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-0 shadow-sm text-center p-3 h-100 bg-label-info">
            <span class="text-info small fw-bold text-uppercase">Received in Shop</span>
            <h3 class="fw-bold text-info mt-2 mb-0">{{ $stats['received'] }}</h3>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-0 shadow-sm text-center p-3 h-100 bg-label-success">
            <span class="text-success small fw-bold text-uppercase">Delivered</span>
            <h3 class="fw-bold text-success mt-2 mb-0">{{ $stats['delivered'] }}</h3>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-0 shadow-sm text-center p-3 h-100">
            <span class="text-muted small fw-bold text-uppercase">Advance Paid</span>
            <h4 class="fw-bold text-primary mt-2 mb-0">৳{{ number_format($stats['total_advance'], 0) }}</h4>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-0 shadow-sm text-center p-3 h-100">
            <span class="text-muted small fw-bold text-uppercase">Total Due</span>
            <h4 class="fw-bold text-danger mt-2 mb-0">৳{{ number_format($stats['total_due'], 0) }}</h4>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <form method="GET" action="{{ route('admin.special-orders.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="ti tabler-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search order#, customer, item or supplier..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses (সকল স্ট্যাটাস)</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (অর্ডার গৃহীত)</option>
                    <option value="ordered_from_dhaka" {{ request('status') == 'ordered_from_dhaka' ? 'selected' : '' }}>In Transit (ঢাকা থেকে পাঠানো হয়েছে)</option>
                    <option value="received_in_shop" {{ request('status') == 'received_in_shop' ? 'selected' : '' }}>Received in Shop (দোকানে পৌঁছেছে)</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered (ডেলিভারি সম্পন্ন)</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled (বাতিল)</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="month" name="month" class="form-control" value="{{ request('month') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="ti tabler-filter me-1"></i>Filter</button>
                <a href="{{ route('admin.special-orders.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Customer Details</th>
                    <th>Item / Requested Part</th>
                    <th>Source & Supplier</th>
                    <th>Selling Price</th>
                    <th>Adv / Due</th>
                    <th>Status</th>
                    <th>Delivery Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.special-orders.show', $order->id) }}" class="fw-bold text-decoration-none">
                            {{ $order->order_number }}
                        </a>
                        <div class="text-muted small">{{ $order->created_at->format('d M, Y') }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                        <div class="text-muted small"><i class="ti tabler-phone me-1"></i>{{ $order->customer_phone }}</div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $order->item_name }}</span>
                        @if($order->device_model || $order->brand)
                            <div class="text-muted small">{{ trim(($order->brand ?? '') . ' ' . ($order->device_model ?? '')) }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-label-info">{{ $order->source_supplier ?: 'Dhaka Supplier' }}</span>
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                            <div class="small text-muted mt-1">Cost: ৳{{ number_format($order->estimated_cost, 0) }} @if($order->courier_cost > 0) + C:৳{{ number_format($order->courier_cost, 0) }} @endif</div>
                        @endif
                    </td>
                    <td>
                        <span class="fw-bold text-dark">৳{{ number_format($order->selling_price, 2) }}</span>
                    </td>
                    <td>
                        <div class="small text-success fw-semibold">Adv: ৳{{ number_format($order->advance_paid, 0) }}</div>
                        @if($order->due_amount > 0)
                            <div class="badge bg-label-danger mt-1">Due: ৳{{ number_format($order->due_amount, 0) }}</div>
                        @else
                            <div class="badge bg-label-success mt-1">Paid</div>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusBadges = [
                                'pending' => 'bg-secondary',
                                'ordered_from_dhaka' => 'bg-warning text-dark',
                                'received_in_shop' => 'bg-info',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger'
                            ];
                            $statusTitles = [
                                'pending' => 'অর্ডার গৃহীত',
                                'ordered_from_dhaka' => 'ঢাকা থেকে আসার পথে',
                                'received_in_shop' => 'দোকানে পৌঁছেছে',
                                'delivered' => 'ডেলিভার্ড',
                                'cancelled' => 'বাতিল'
                            ];
                        @endphp
                        <span class="badge {{ $statusBadges[$order->status] ?? 'bg-secondary' }}">
                            {{ $statusTitles[$order->status] ?? ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        {{ $order->expected_delivery_date ? $order->expected_delivery_date->format('d M, Y') : 'N/A' }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.special-orders.show', $order->id) }}" class="btn btn-icon btn-sm btn-outline-primary" title="View Details">
                                <i class="ti tabler-eye"></i>
                            </a>
                            <a href="{{ route('admin.special-orders.print', $order->id) }}" target="_blank" class="btn btn-icon btn-sm btn-outline-secondary" title="Print Slip">
                                <i class="ti tabler-printer"></i>
                            </a>
                            <a href="{{ route('admin.special-orders.edit', $order->id) }}" class="btn btn-icon btn-sm btn-outline-warning" title="Edit Order">
                                <i class="ti tabler-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="ti tabler-package-off fs-1 d-block mb-2 opacity-50"></i>
                        No special orders found. Click "New Special Order" to book on-demand parts from Dhaka!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="card-footer bg-white border-top py-3">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
