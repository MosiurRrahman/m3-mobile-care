@extends('layouts/contentNavbarLayout')

@section('title', 'Online Orders - Admin Panel')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="ti tabler-shopping-cart text-primary me-2"></i>Online Store Orders</h4>
            <p class="text-muted mb-0">Manage customer orders placed through the e-commerce website</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="ti tabler-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="ti tabler-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by Invoice #, Customer Name or Phone..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-4 text-end">
                    <button type="submit" class="btn btn-primary"><i class="ti tabler-filter me-1"></i>Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice No</th>
                        <th>Date & Time</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-primary">#{{ $order->invoice_no }}</a>
                            </td>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->customer->name ?? 'Guest Customer' }}</div>
                                <span class="text-muted small">{{ $order->customer->district ?? 'N/A' }}</span>
                            </td>
                            <td><span class="badge bg-label-info">{{ $order->customer->phone ?? 'N/A' }}</span></td>
                            <td><span class="fw-bold text-success">৳{{ number_format($order->payable_amount, 2) }}</span></td>
                            <td>
                                <span class="badge bg-label-secondary text-uppercase">{{ $order->payment_method ?? 'COD' }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($order->status) {
                                        'Delivered' => 'bg-success',
                                        'Processing' => 'bg-warning text-dark',
                                        'Cancelled' => 'bg-danger',
                                        default => 'bg-info',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $order->status ?? 'Pending' }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary me-1" title="View Order Details">
                                    <i class="ti tabler-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="ti tabler-shopping-cart-off fs-1 d-block mb-2"></i>
                                No online orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
