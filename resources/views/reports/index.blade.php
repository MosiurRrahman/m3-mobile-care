@extends('layouts/contentNavbarLayout')

@section('title', 'Financial & Operational Reports - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Financial & Operational Reports</h4>
            <span class="text-muted small">Analyze shop performance metrics: sales profit, service counts, technician statistics</span>
        </div>

        <!-- Timeframe filter -->
        <form action="{{ route('admin.reports.index') }}" method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded border shadow-sm">
            <label class="fw-bold text-dark small mb-0 ms-1">Timeframe:</label>
            <select name="timeframe" onchange="this.form.submit()" class="form-select form-select-sm border-0 bg-light" style="width: 145px;">
                <option value="day" {{ $timeframe === 'day' ? 'selected' : '' }}>Today</option>
                <option value="week" {{ $timeframe === 'week' ? 'selected' : '' }}>This Week</option>
                <option value="month" {{ $timeframe === 'month' ? 'selected' : '' }}>Monthly Report</option>
                <option value="3months" {{ $timeframe === '3months' ? 'selected' : '' }}>3 Months Report</option>
                <option value="6months" {{ $timeframe === '6months' ? 'selected' : '' }}>6 Months Report</option>
                <option value="year" {{ $timeframe === 'year' ? 'selected' : '' }}>Yearly Report</option>
            </select>
        </form>
    </div>

    <!-- Financial Summary Cards -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4"><i class="ti tabler-cash me-2 text-primary"></i>Financial Summary ({{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }})</h5>

                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 bg-light rounded border-start border-primary border-4 h-100">
                            <span class="small text-muted d-block mb-1">Service Repair Income</span>
                            <h4 class="fw-extrabold text-primary mb-0">{{ number_format($serviceIncome, 2) }} BDT</h4>
                            <span class="text-muted small">{{ $repairsCompleted }} jobs resolved</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 bg-light rounded border-start border-info border-4 h-100">
                            <span class="small text-muted d-block mb-1">Product POS Sales</span>
                            <h4 class="fw-extrabold text-info mb-0">{{ number_format($salesIncome, 2) }} BDT</h4>
                            <div class="mt-2 pt-2 border-top" style="font-size: 11px; line-height: 1.7;">
                                <div class="d-flex justify-content-between text-muted">
                                    <span>Cash Received:</span>
                                    <span class="text-success fw-semibold">{{ number_format($salesPaid, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span>Outstanding Dues:</span>
                                    <span class="text-danger fw-semibold">{{ number_format($salesDue, 2) }}</span>
                                </div>
                            </div>
                            <span class="text-muted small d-block mt-2">Accessories & spare parts</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 bg-light rounded border-start border-danger border-4 h-100">
                            <span class="small text-muted d-block mb-1">Total Shop Outflow</span>
                            <h4 class="fw-extrabold text-danger mb-0">{{ number_format($expenses, 2) }} BDT</h4>
                            <span class="text-muted small">Rent, salaries, purchases, utilities</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        @php
                            $isProfit = $netProfit >= 0;
                            $totalCogs = $partsCogs + $posCogs + $commissionsTotal;
                        @endphp
                        <div class="p-3 bg-light rounded border-start border-{{ $isProfit ? 'success' : 'danger' }} border-4 h-100">
                            <span class="small text-muted d-block mb-1">Net Profit / Loss</span>
                            <h4 class="fw-extrabold text-{{ $isProfit ? 'success' : 'danger' }} mb-0">{{ number_format($netProfit, 2) }} BDT</h4>
                            <span class="badge bg-{{ $isProfit ? 'success' : 'danger' }} mt-1 mb-2">{{ $isProfit ? 'Surplus' : 'Deficit' }}</span>
                            <div class="mt-2 pt-2 border-top" style="font-size: 11px; line-height: 1.7;">
                                <div class="d-flex justify-content-between text-muted">
                                    <span>Parts COGS:</span>
                                    <span class="text-danger fw-semibold">-{{ number_format($partsCogs, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span>POS COGS:</span>
                                    <span class="text-danger fw-semibold">-{{ number_format($posCogs, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span>Commissions:</span>
                                    <span class="text-warning fw-semibold">-{{ number_format($commissionsTotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span>Expenses:</span>
                                    <span class="text-danger fw-semibold">-{{ number_format($expenses, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods Cash Flow (MFS tracking) -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm border-start border-success border-3">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-3"><i class="ti tabler-report-money me-2 text-success"></i>Collected Cash Flow Breakdown</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-white text-center h-100 shadow-xs">
                            <span class="badge bg-label-success p-2 rounded-circle mb-2"><i class="ti tabler-cash fs-4"></i></span>
                            <span class="text-muted d-block small mb-1">Cash Collection</span>
                            <h5 class="fw-extrabold text-success mb-0">{{ number_format($paymentMethodsBreakdown['Cash'], 2) }} BDT</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-white text-center h-100 shadow-xs">
                            <span class="badge p-2 rounded-circle mb-2" style="background-color: rgba(216, 27, 96, 0.1); color: #d81b60;"><i class="ti tabler-wallet fs-4"></i></span>
                            <span class="text-muted d-block small mb-1">bKash Collection</span>
                            <h5 class="fw-extrabold mb-0" style="color: #d81b60;">{{ number_format($paymentMethodsBreakdown['bKash'], 2) }} BDT</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-white text-center h-100 shadow-xs">
                            <span class="badge p-2 rounded-circle mb-2" style="background-color: rgba(243, 156, 18, 0.1); color: #f39c12;"><i class="ti tabler-wallet fs-4"></i></span>
                            <span class="text-muted d-block small mb-1">Nagad Collection</span>
                            <h5 class="fw-extrabold text-warning mb-0" style="color: #f39c12 !important;">{{ number_format($paymentMethodsBreakdown['Nagad'], 2) }} BDT</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-white text-center h-100 shadow-xs">
                            <span class="badge p-2 rounded-circle mb-2" style="background-color: rgba(142, 68, 173, 0.1); color: #8e44ad;"><i class="ti tabler-wallet fs-4"></i></span>
                            <span class="text-muted d-block small mb-1">Rocket Collection</span>
                            <h5 class="fw-extrabold mb-0" style="color: #8e44ad;">{{ number_format($paymentMethodsBreakdown['Rocket'], 2) }} BDT</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product-Wise Sales (Top Items) -->
    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: rgba(115, 103, 240, 0.12);">
                        <i class="ti tabler-shopping-cart-check text-primary fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Product-Wise POS Sales</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Top selling accessories & parts</small>
                    </div>
                </div>
                <span class="badge bg-label-primary rounded-pill px-2 py-1 fw-bold" style="font-size: 0.78rem;">
                    {{ count($productSales) }} Items Sold
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.83rem;">
                    <thead class="bg-light">
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                            <th class="py-2 text-uppercase text-muted fw-bold ps-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Product Name</th>
                            <th class="py-2 text-uppercase text-muted fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Category</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px;">Qty Sold</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-end pe-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productSales as $sale)
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.035);">
                            <td class="py-2 ps-3">
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 200px;" title="{{ $sale->item ? $sale->item->name : 'Deleted product' }}">
                                    {{ $sale->item ? $sale->item->name : 'Deleted product' }}
                                </div>
                                @if($sale->item && $sale->item->sku)
                                <span class="badge bg-label-secondary font-monospace text-dark" style="font-size: 0.68rem; padding: 1px 4px;">
                                    {{ $sale->item->sku }}
                                </span>
                                @endif
                            </td>
                            <td class="py-2">
                                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.72rem;">
                                    {{ $sale->item ? ($sale->item->category ?? 'N/A') : 'N/A' }}
                                </span>
                            </td>
                            <td class="py-2 text-center">
                                <span class="badge bg-label-success rounded-pill px-2 py-1 fw-bold" style="font-size: 0.75rem;">
                                    {{ $sale->qty_sold }} pcs
                                </span>
                            </td>
                            <td class="py-2 text-end pe-3">
                                <span class="fw-bold text-success" style="font-size: 0.84rem;">
                                    {{ number_format($sale->revenue, 2) }} BDT
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="ti tabler-basket-off fs-3 d-block mb-1 text-muted"></i>
                                No product sales logged in this timeframe.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Brand-Wise Service Volume -->
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: rgba(0, 207, 232, 0.12);">
                        <i class="ti tabler-device-mobile-message text-info fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Brand-Wise Service Volume</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Repair jobs by device brand</small>
                    </div>
                </div>
                <span class="badge bg-label-info rounded-pill px-2 py-1 fw-bold" style="font-size: 0.78rem;">
                    {{ count($brandRepairs) }} Brands
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.83rem;">
                    <thead class="bg-light">
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                            <th class="py-2 text-uppercase text-muted fw-bold ps-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Brand</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px;">Tickets</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-end pe-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brandRepairs as $brand)
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.035);">
                            <td class="py-2 ps-3">
                                <div class="d-flex align-items-center">
                                    <i class="ti tabler-device-mobile text-muted me-1 fs-6"></i>
                                    <span class="fw-bold text-dark">{{ $brand->device_brand ?: 'Other / Generic' }}</span>
                                </div>
                            </td>
                            <td class="py-2 text-center">
                                <span class="badge bg-label-primary rounded-pill px-2 py-1 fw-bold" style="font-size: 0.75rem;">
                                    {{ $brand->count }}
                                </span>
                            </td>
                            <td class="py-2 text-end pe-3">
                                <span class="fw-bold text-success" style="font-size: 0.84rem;">
                                    {{ number_format($brand->total_cost ?? 0, 2) }} BDT
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                <i class="ti tabler-device-mobile-off fs-3 d-block mb-1 text-muted"></i>
                                No service tickets logged in this timeframe.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Technician Performance -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: rgba(255, 171, 0, 0.12);">
                        <i class="ti tabler-award text-warning fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Technician Leaderboard</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Productivity & commissions</small>
                    </div>
                </div>
                <span class="badge bg-label-warning rounded-pill px-2 py-1 fw-bold" style="font-size: 0.78rem;">
                    {{ count($topTechnicians) }} Technicians
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.83rem;">
                    <thead class="bg-light">
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                            <th class="py-2 text-uppercase text-muted fw-bold ps-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Technician</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px;">Resolved</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-end" style="font-size: 0.72rem; letter-spacing: 0.5px;">Revenue</th>
                            @if(auth()->user()->isSuperAdmin())
                            <th class="py-2 text-uppercase text-muted fw-bold text-end pe-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Commission</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topTechnicians as $tech)
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.035);">
                            <td class="py-2 ps-3">
                                <div class="fw-bold text-dark">{{ $tech->name }}</div>
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem; padding: 1px 4px;">
                                    {{ $tech->skill_level ?: 'Technician' }}
                                </span>
                            </td>
                            <td class="py-2 text-center">
                                <span class="badge bg-label-success rounded-pill px-2 py-1 fw-bold" style="font-size: 0.75rem;">
                                    {{ $tech->completed_jobs_count }}
                                </span>
                            </td>
                            <td class="py-2 text-end">
                                <span class="fw-bold text-dark" style="font-size: 0.84rem;">
                                    {{ number_format($tech->revenue_generated ?? 0, 2) }} BDT
                                </span>
                            </td>
                            @if(auth()->user()->isSuperAdmin())
                            <td class="py-2 text-end pe-3">
                                <span class="fw-bold text-success" style="font-size: 0.84rem;">
                                    +{{ number_format($tech->commission_earned ?? 0, 2) }} BDT
                                </span>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isSuperAdmin() ? 4 : 3 }}" class="text-center py-4 text-muted">
                                <i class="ti tabler-user-off fs-3 d-block mb-1 text-muted"></i>
                                No technician diagnostics recorded in this timeframe.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock Warning Alerts -->
    <div class="col-lg-6 mb-4" id="stock-alerts">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: rgba(234, 84, 85, 0.12);">
                        <i class="ti tabler-alert-triangle text-danger fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-danger" style="font-size: 0.95rem;">Low Stock Inventory Alert</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Items below or at threshold</small>
                    </div>
                </div>
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 rounded-pill px-2 py-1 fw-bold" style="font-size: 0.78rem;">
                    {{ $lowStockItems->total() }} Items Alert
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.83rem;">
                    <thead class="bg-light">
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                            <th class="py-2 text-uppercase text-muted fw-bold ps-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">SKU</th>
                            <th class="py-2 text-uppercase text-muted fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Item & Type</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px;">Stock</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-center" style="font-size: 0.72rem; letter-spacing: 0.5px;">Alert Level</th>
                            <th class="py-2 text-uppercase text-muted fw-bold text-end pe-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockItems as $item)
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.035);">
                            <td class="py-2 ps-3">
                                <span class="badge bg-label-secondary font-monospace text-dark px-2 py-1" style="font-size: 0.74rem;">
                                    {{ $item->sku }}
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="fw-semibold text-dark text-truncate" style="max-width: 190px;" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </div>
                                <span class="badge bg-label-{{ $item->type === 'spare_part' ? 'primary' : 'info' }}" style="font-size: 0.65rem; padding: 2px 5px; line-height: 1;">
                                    {{ ucfirst(str_replace('_', ' ', $item->type)) }}
                                </span>
                            </td>
                            <td class="py-2 text-center">
                                @if($item->quantity == 0)
                                <span class="badge bg-danger rounded-pill px-2 py-1 text-white fw-bold" style="font-size: 0.72rem;">
                                    0 Out
                                </span>
                                @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 fw-bold" style="font-size: 0.72rem;">
                                    {{ $item->quantity }} pcs
                                </span>
                                @endif
                            </td>
                            <td class="py-2 text-center">
                                <span class="text-muted small fw-medium" style="font-size: 0.75rem;">
                                    ≤ {{ $item->alert_quantity }} pcs
                                </span>
                            </td>
                            <td class="py-2 text-end pe-3">
                                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-xs btn-label-primary px-2 py-1 rounded" style="font-size: 0.72rem;" title="Restock item">
                                    <i class="ti tabler-plus me-1" style="font-size: 0.72rem;"></i>Restock
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="ti tabler-circle-check fs-3 text-success d-block mb-1"></i>
                                Great! All inventory stock levels are healthy.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($lowStockItems->hasPages())
            <div class="card-footer bg-transparent border-top py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted" style="font-size: 0.75rem;">Showing {{ $lowStockItems->firstItem() ?? 0 }}-{{ $lowStockItems->lastItem() ?? 0 }} of {{ $lowStockItems->total() }} alerts</small>
                <div>
                    {{ $lowStockItems->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
