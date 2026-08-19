@extends('layouts/blankLayout')

@section('title', 'Sales Invoice - ' . $sale->invoice_no)

@section('content')
<div class="container py-3" style="max-width: 660px;">
    <!-- Session Alerts -->
    @if(session('success'))
        <div class="alert alert-success border-0 py-2 mb-2 text-center small print-hidden">
            <i class="ti tabler-circle-check me-1"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 py-2 mb-2 text-center small print-hidden">
            <i class="ti tabler-alert-circle me-1"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card border border-secondary border-opacity-50 bg-white shadow-none invoice-card">
        <div class="card-body p-3 p-sm-4 text-dark">
            <!-- Store Header -->
            <div class="text-center pb-2 border-bottom border-dark border-opacity-75">
                <h4 class="fw-bolder mb-0 text-dark text-uppercase tracking-wide">{{ App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}</h4>
                <div class="text-muted small my-1" style="font-size: 0.78rem; line-height: 1.35;">
                    {{ App\Models\Setting::get('address', '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও') }}
                </div>
                <div class="text-muted small" style="font-size: 0.75rem;">
                    Mobile: {{ App\Models\Setting::get('phone', '+8801353106967 / +8801353106966') }}
                    @if(App\Models\Setting::get('email'))
                        | Email: {{ App\Models\Setting::get('email') }}
                    @endif
                </div>
                <div class="badge bg-dark text-white text-uppercase px-3 py-1 mt-2" style="font-size: 0.72rem; letter-spacing: 1px;">
                    Retail Sales Bill
                </div>
            </div>

            <!-- Invoice Meta & Customer Info Grid -->
            <div class="row g-2 py-2 border-bottom border-light" style="font-size: 0.82rem;">
                <div class="col-6">
                    <div><span class="text-muted">Invoice:</span> <strong class="text-dark">{{ $sale->invoice_no }}</strong></div>
                    <div><span class="text-muted">Date:</span> {{ $sale->created_at->format('d M Y, h:i A') }}</div>
                    <div><span class="text-muted">Salesman:</span> {{ $sale->salesman ? $sale->salesman->name : 'Staff' }}</div>
                </div>
                <div class="col-6 text-end">
                    <div><span class="text-muted">Customer:</span> <strong class="text-dark">{{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}</strong></div>
                    @if($sale->customer && $sale->customer->phone)
                        <div><span class="text-muted">Phone:</span> {{ $sale->customer->phone }}</div>
                    @endif
                    <div><span class="text-muted">Method:</span> <span class="badge bg-label-dark" style="font-size: 0.72rem;">{{ $sale->payment_method }}</span></div>
                </div>
            </div>

            <!-- Sold Items Table -->
            <table class="table table-sm table-bordered align-middle my-2" style="font-size: 0.8rem;">
                <thead class="table-light">
                    <tr class="text-center align-middle" style="font-size: 0.78rem;">
                        <th style="width: 30px;">#</th>
                        <th class="text-start">Description</th>
                        <th style="width: 50px;">Qty</th>
                        <th class="text-end" style="width: 80px;">Rate</th>
                        <th class="text-end" style="width: 90px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->details as $idx => $detail)
                    <tr>
                        <td class="text-center text-muted py-1">{{ $idx + 1 }}</td>
                        <td class="py-1">
                            <div class="fw-bold text-dark lh-sm">{{ $detail->item ? $detail->item->name : 'Unlisted Item' }}</div>
                            @if($detail->item && $detail->item->sku)
                                <small class="text-muted" style="font-size: 0.7rem;">SKU: {{ $detail->item->sku }}</small>
                            @endif
                        </td>
                        <td class="text-center fw-semibold py-1">{{ $detail->quantity }}</td>
                        <td class="text-end py-1">{{ number_format($detail->sale_price, 2) }}</td>
                        <td class="text-end fw-bold py-1">{{ number_format($detail->quantity * $detail->sale_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Cost Calculations Summary (Compact Align-Right) -->
            <div class="row justify-content-end my-1">
                <div class="col-8 col-sm-7">
                    <table class="table table-sm table-borderless mb-0" style="font-size: 0.82rem;">
                        <tr>
                            <td class="text-muted py-1">Subtotal:</td>
                            <td class="text-end fw-bold py-1">{{ number_format($sale->total_amount, 2) }} BDT</td>
                        </tr>
                        @if($sale->discount > 0)
                        <tr>
                            <td class="text-danger py-1">Discount:</td>
                            <td class="text-end fw-bold text-danger py-1">-{{ number_format($sale->discount, 2) }} BDT</td>
                        </tr>
                        @endif
                        <tr class="border-top border-dark border-opacity-50">
                            <td class="fw-bold fs-6 py-1">Total Payable:</td>
                            <td class="text-end fw-extrabold fs-6 py-1">{{ number_format($sale->payable_amount, 2) }} BDT</td>
                        </tr>
                        @foreach($sale->payments as $payment)
                        <tr>
                            <td class="text-muted py-1" style="font-size: 0.75rem;">
                                {{ $payment->payment_method }}
                                @if($payment->transaction_type === 'due_payment')
                                    <span>(Due Pay)</span>
                                @endif:
                            </td>
                            <td class="text-end fw-semibold text-success py-1" style="font-size: 0.75rem;">{{ number_format($payment->amount, 2) }} BDT</td>
                        </tr>
                        @endforeach
                        <tr class="border-top border-light">
                            <td class="text-success fw-bold py-1">Total Paid:</td>
                            <td class="text-end fw-bold text-success py-1">{{ number_format($sale->paid_amount, 2) }} BDT</td>
                        </tr>
                        @if($sale->payment_method === 'Cash' && $sale->change_returned > 0)
                        <tr>
                            <td class="text-success py-1">Change Returned:</td>
                            <td class="text-end fw-bold text-success py-1">{{ number_format($sale->change_returned, 2) }} BDT</td>
                        </tr>
                        @endif
                        @if($sale->due_amount > 0)
                        <tr class="border-top border-danger text-danger">
                            <td class="fw-bold py-1">Due Amount:</td>
                            <td class="text-end fw-extrabold py-1">{{ number_format($sale->due_amount, 2) }} BDT</td>
                        </tr>
                        @else
                        <tr>
                            <td class="text-muted py-1">Due Amount:</td>
                            <td class="text-end text-muted py-1">0.00 BDT</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Footer & Terms -->
            <div class="border-top border-dark border-opacity-25 pt-2 mt-2 text-center text-muted" style="font-size: 0.72rem; line-height: 1.35;">
                <div class="fw-bold text-dark mb-1">Thank you for choosing {{ App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}!</div>
                <div>{!! nl2br(e(App\Models\Setting::get('receipt_footer', "Note: Accessories carry a 6-month warranty. Please preserve this invoice copy for claiming warranty services."))) !!}</div>
            </div>
        </div>
    </div>

    <!-- Print & SMS Action Buttons -->
    <div class="d-flex gap-2 justify-content-center mt-3 print-hidden flex-wrap">
        <button class="btn btn-secondary btn-sm px-3" onclick="window.close()"><i class="ti tabler-x me-1"></i>Close</button>
        @if($sale->customer && $sale->customer->phone)
        <form action="{{ route('admin.sales.send-sms', $sale->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-info btn-sm px-3"><i class="ti tabler-send me-1"></i>Send SMS Bill</button>
        </form>
        @endif
        <button class="btn btn-primary btn-sm px-4" onclick="window.print()"><i class="ti tabler-printer me-1"></i>Print Bill</button>
    </div>
</div>

<script>
    // Automatically trigger printing when loaded
    window.addEventListener('load', function() {
        setTimeout(() => {
            window.print();
        }, 500);
    });
</script>

<style>
@media print {
    .print-hidden,
    #layout-menu,
    .layout-navbar,
    footer {
        display: none !important;
    }
    body {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 auto !important;
    }
    .invoice-card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
