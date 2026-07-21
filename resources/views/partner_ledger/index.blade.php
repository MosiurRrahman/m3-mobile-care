@extends('layouts/contentNavbarLayout')

@section('title', 'Partner Ledger - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Partner Profit & Capital Ledger (অংশীদারী খতিয়ান)</h4>
            <span class="text-muted small">Manage capital investments, dynamic profit ratios, payouts, and monthly closings</span>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti tabler-circle-check-filled me-2 fs-4 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti tabler-circle-x-filled me-2 fs-4 text-danger"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- Partner Accounts Overview -->
    <div class="col-12 mb-4">
        <div class="row g-3">
            @foreach($balances as $bal)
            @php
                $ratio = 0.00;
                $color = 'secondary';
                if ($bal->partner_name === 'Monowar Munna') {
                    $ratio = $monowarRatio;
                    $color = 'primary';
                } elseif ($bal->partner_name === 'Munna Raihan') {
                    $ratio = $raihanRatio;
                    $color = 'info';
                } elseif ($bal->partner_name === 'Mosiur') {
                    $ratio = $mosiurRatio;
                    $color = 'warning';
                }
            @endphp
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100 overflow-hidden" style="transition: transform 0.2s; cursor: default;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                    <div class="card-header bg-label-{{ $color }} pb-2 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold mb-0 text-{{ $color }}">{{ $bal->partner_name }}</h5>
                        <span class="badge bg-{{ $color }} fw-semibold fs-7">{{ number_format($ratio * 100, 2) }}% Share</span>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row g-2 text-center mb-3">
                            <div class="col-6 border-end">
                                <span class="text-muted small d-block mb-1">Capital (মূলধন)</span>
                                <h5 class="fw-bold mb-0 text-dark">{{ number_format($bal->capital_balance, 2) }} BDT</h5>
                            </div>
                            <div class="col-6">
                                <span class="text-muted small d-block mb-1">Profit Bal (লভ্যাংশ)</span>
                                <h5 class="fw-bold mb-0 text-success">{{ number_format($bal->accumulated_profit, 2) }} BDT</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                            <span class="text-muted small">Payback Status</span>
                            @if($bal->partner_name === 'Monowar Munna')
                                @if($bal->capital_balance <= 0)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle d-flex align-items-center gap-1">
                                        <i class="ti tabler-circle-check fs-6"></i> Fully Paid Back
                                    </span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle d-flex align-items-center gap-1">
                                        <i class="ti tabler-hourglass fs-6"></i> Active Investment
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    Permanent Partner
                                </span>
                            @endif
                        </div>
                        @if($bal->partner_name === 'Monowar Munna' && $bal->payback_completed_at)
                            <div class="small text-muted mt-2 text-center pt-1 border-top-dashed">
                                Payback completed on: <span class="fw-semibold text-dark">{{ $bal->payback_completed_at->format('d M, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Actions Row -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-bottom d-flex align-items-center justify-content-between py-3">
                <h5 class="card-title fw-bold mb-0">Month Closing & Profit Distribution</h5>
                <form action="" method="GET" id="monthFilterForm" class="d-flex align-items-center gap-2">
                    <input type="month" name="month" class="form-control form-control-sm" value="{{ $selectedMonth }}" onchange="document.getElementById('monthFilterForm').submit()">
                </form>
            </div>
            <div class="card-body pt-3">
                <div class="p-3 bg-light rounded mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted fw-semibold">Net Profit ({{ date('F Y', strtotime($selectedMonth . '-01')) }})</span>
                        <h4 class="fw-extrabold mb-0 {{ $monthProfit >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($monthProfit, 2) }} BDT
                        </h4>
                    </div>
                    <span class="text-muted small">Automatically computed from service repairs, POS sales, technician commissions, and general expenses</span>
                </div>

                <h6 class="fw-bold mb-2">Split Allocation (অনুপাত বন্টন):</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-sm align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Partner</th>
                                <th>Ratio</th>
                                <th>Share Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start fw-semibold">Monowar Munna</td>
                                <td class="text-primary fw-bold">{{ number_format($monowarRatio * 100, 2) }}%</td>
                                <td class="fw-bold">{{ number_format($monthProfit * $monowarRatio, 2) }} BDT</td>
                            </tr>
                            <tr>
                                <td class="text-start fw-semibold">Munna Raihan</td>
                                <td class="text-info fw-bold">{{ number_format($raihanRatio * 100, 2) }}%</td>
                                <td class="fw-bold">{{ number_format($monthProfit * $raihanRatio, 2) }} BDT</td>
                            </tr>
                            <tr>
                                <td class="text-start fw-semibold">Mosiur</td>
                                <td class="text-warning fw-bold">{{ number_format($mosiurRatio * 100, 2) }}%</td>
                                <td class="fw-bold">{{ number_format($monthProfit * $mosiurRatio, 2) }} BDT</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if($isAlreadyDistributed)
                    <div class="d-grid gap-2">
                        <button class="btn btn-secondary" disabled>
                            <i class="ti tabler-circle-check me-1"></i> Profit Already Distributed for this Month
                        </button>
                        <form action="{{ route('admin.partner-ledger.rollback') }}" method="POST" onsubmit="return confirm('Are you sure you want to unlock this month? This will reverse the profit distribution ledger entries and adjust partner balances back!')">
                            @csrf
                            <input type="hidden" name="month" value="{{ $selectedMonth }}">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti tabler-lock-open me-1"></i> Unlock & Recalculate Month
                              </button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('admin.partner-ledger.distribute') }}" method="POST" onsubmit="return confirm('Are you sure you want to lock the month and distribute the net profit/loss among partners? This cannot be undone!')">
                        @csrf
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="ti tabler-lock-open me-1"></i> Close Month & Distribute Profit
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-bottom py-3">
                <h5 class="card-title fw-bold mb-0">Record Partner Cash Withdrawal (উত্তোলন)</h5>
            </div>
            <form action="{{ route('admin.partner-ledger.withdraw') }}" method="POST" onsubmit="return confirm('Are you sure you want to process this cash withdrawal?')">
                @csrf
                <div class="card-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="partner_name">Select Partner <span class="text-danger">*</span></label>
                        <select name="partner_name" id="partner_name" class="form-select" required>
                            <option value="">-- Choose Partner --</option>
                            <option value="Monowar Munna">Monowar Munna</option>
                            <option value="Munna Raihan">Munna Raihan</option>
                            <option value="Mosiur">Mosiur</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" for="account_type">Account Type <span class="text-danger">*</span></label>
                            <select name="account_type" id="account_type" class="form-select" required>
                                <option value="profit">Profit Share Account (লভ্যাংশ)</option>
                                <option value="capital">Capital Account (মূলধন)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" for="withdraw_amount">Amount (BDT) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="withdraw_amount" step="0.01" min="0.01" class="form-control" required placeholder="e.g. 5000">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="withdraw_description">Description / Notes <span class="text-danger">*</span></label>
                        <textarea name="description" id="withdraw_description" rows="2" class="form-control" placeholder="e.g. Personal emergency withdrawal" required></textarea>
                    </div>
                    <div class="d-grid pt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti tabler-cash me-1"></i> Save Payout / Withdrawal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Ledger History -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="card-title fw-bold mb-0">Ledger Statement (খতিয়ান বিবরণী)</h5>
                <form action="" method="GET" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="month" value="{{ $selectedMonth }}">
                    <select name="partner" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Partners</option>
                        <option value="Monowar Munna" {{ request('partner') === 'Monowar Munna' ? 'selected' : '' }}>Monowar Munna</option>
                        <option value="Munna Raihan" {{ request('partner') === 'Munna Raihan' ? 'selected' : '' }}>Munna Raihan</option>
                        <option value="Mosiur" {{ request('partner') === 'Mosiur' ? 'selected' : '' }}>Mosiur</option>
                    </select>
                    <select name="account_type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Accounts</option>
                        <option value="profit" {{ request('account_type') === 'profit' ? 'selected' : '' }}>Profit Account</option>
                        <option value="capital" {{ request('account_type') === 'capital' ? 'selected' : '' }}>Capital Account</option>
                    </select>
                </form>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Partner</th>
                            <th>Account</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Running Bal</th>
                            <th>Description</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($entries as $entry)
                        <tr>
                            <td>{{ $entry->created_at->format('d M, Y H:i') }}</td>
                            <td><span class="fw-bold">{{ $entry->partner_name }}</span></td>
                            <td>
                                @if($entry->account_type === 'capital')
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">Capital</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Profit</span>
                                @endif
                            </td>
                            <td>
                                @if($entry->type === 'credit')
                                    <span class="text-success fw-bold"><i class="ti tabler-arrow-up-right me-1"></i>Credit</span>
                                @else
                                    <span class="text-danger fw-bold"><i class="ti tabler-arrow-down-left me-1"></i>Debit</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">{{ number_format($entry->amount, 2) }} BDT</td>
                            <td class="fw-bold">{{ number_format($entry->balance_after, 2) }} BDT</td>
                            <td style="max-width: 300px; white-space: normal;">{{ $entry->description }}</td>
                            <td><span class="text-muted small">{{ $entry->creator ? $entry->creator->name : 'System' }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No ledger transactions recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($entries->hasPages())
            <div class="card-footer py-3">
                {{ $entries->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
