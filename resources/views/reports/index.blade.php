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
                <h5 class="card-title fw-bold mb-3"><i class="ti tabler-report-money me-2 text-success"></i>Collected Cash Flow Breakdown (ক্যাশ ফ্লো ব্রেকডাউন)</h5>
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

    <!-- Product-wise sales & Brand Service Reports -->
    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="fw-bold mb-0"><i class="ti tabler-shopping-cart-check me-2 text-primary"></i>Product-Wise POS Sales</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th class="text-center">Quantity Sold</th>
                            <th class="text-end">Revenue Generated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productSales as $sale)
                        <tr>
                            <td>
                                <span class="fw-bold text-dark">{{ $sale->item ? $sale->item->name : 'Deleted product' }}</span>
                                <div class="text-muted small">SKU: {{ $sale->item ? $sale->item->sku : '' }}</div>
                            </td>
                            <td>{{ $sale->item ? $sale->item->category : 'N/A' }}</td>
                            <td class="text-center fw-bold">{{ $sale->qty_sold }}</td>
                            <td class="text-end fw-bold text-success">{{ number_format($sale->revenue, 2) }} BDT</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No product sales logged in this timeframe.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="fw-bold mb-0"><i class="ti tabler-device-mobile-message me-2 text-primary"></i>Brand-Wise Service Volume</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Device Brand</th>
                            <th class="text-center">Tickets Logged</th>
                            <th class="text-end">Service Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brandRepairs as $brand)
                        <tr>
                            <td><span class="fw-bold text-dark">{{ $brand->device_brand }}</span></td>
                            <td class="text-center fw-bold">{{ $brand->count }}</td>
                            <td class="text-end fw-bold text-success">{{ number_format($brand->total_cost ?? 0, 2) }} BDT</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">No service tickets logged in this timeframe.</td>
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
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="fw-bold mb-0"><i class="ti tabler-award me-2 text-primary"></i>Technician Productivity Leaderboard</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Technician</th>
                            <th class="text-center">Jobs Resolved</th>
                            <th class="text-end">Revenue Contribution</th>
                            @if(auth()->user()->isSuperAdmin())
                            <th class="text-end text-success">Commission Earned</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topTechnicians as $tech)
                        <tr>
                            <td>
                                <span class="fw-bold text-dark">{{ $tech->name }}</span>
                                <div class="text-muted small">{{ $tech->skill_level }}</div>
                            </td>
                            <td class="text-center"><span class="badge bg-success fs-6">{{ $tech->completed_jobs_count }}</span></td>
                            <td class="text-end fw-bold text-dark">{{ number_format($tech->revenue_generated ?? 0, 2) }} BDT</td>
                            @if(auth()->user()->isSuperAdmin())
                            <td class="text-end fw-bold text-success">{{ number_format($tech->commission_earned ?? 0, 2) }} BDT</td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isSuperAdmin() ? 4 : 3 }}" class="text-center py-4 text-muted">No technician diagnostics recorded in this timeframe.</td>
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
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="fw-bold mb-0 text-danger"><i class="ti tabler-package-off me-2"></i>Low Stock Inventory Alert</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SKU Code</th>
                            <th>Item Name</th>
                            <th>Stock Left</th>
                            <th>Threshold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockItems as $item)
                        <tr>
                            <td><span class="fw-bold text-dark">{{ $item->sku }}</span></td>
                            <td>
                                <span class="text-dark small">{{ $item->name }}</span>
                                <span class="badge bg-label-{{ $item->type === 'spare_part' ? 'primary' : 'info' }} ms-1 fs-9">{{ ucfirst($item->type) }}</span>
                            </td>
                            <td><span class="fw-extrabold text-danger fs-6">{{ $item->quantity }}</span> pcs</td>
                            <td><span class="fw-semibold text-muted">{{ $item->alert_quantity }} pcs</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-success fw-bold">
                                <i class="ti tabler-check-circle fs-2 d-block mb-1 text-success"></i>
                                All inventory levels are above alert thresholds!
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
