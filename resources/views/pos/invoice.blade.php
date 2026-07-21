@extends('layouts/blankLayout')

@section('title', 'Sales Invoice - M3 Mobile Care')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <div class="card border border-dark p-4 bg-white shadow-none">
        <div class="card-body">
            <!-- Store Details -->
            <div class="text-center mb-4">
                <h3 class="fw-extrabold text-dark mb-1">{{ App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}</h3>
                <p class="text-muted small mb-1">{{ App\Models\Setting::get('address', 'Level 3, Multiplan Center, Elephant Road, Dhaka') }}</p>
                <p class="text-muted small mb-1">Phone: {{ App\Models\Setting::get('phone', '+880 1712-345678') }} | Email: {{ App\Models\Setting::get('email', 'info@m3mobilecare.com') }}</p>
                <hr class="border-dark my-3">
                <h4 class="fw-bold text-dark mb-0">RETAIL SALES BILL</h4>
            </div>

            <!-- Invoice meta details -->
            <div class="row mb-4 small text-dark">
                <div class="col-6 mb-2">
                    <strong>Invoice No:</strong> {{ $sale->invoice_no }}
                </div>
                <div class="col-6 mb-2 text-end">
                    <strong>Date:</strong> {{ $sale->created_at->format('M d, Y h:i A') }}
                </div>
                <div class="col-6">
                    <strong>Salesman:</strong> {{ $sale->salesman ? $sale->salesman->name : 'Staff' }}
                </div>
                <div class="col-6 text-end">
                    <strong>Payment Method:</strong> <span class="badge bg-dark">{{ $sale->payment_method }}</span>
                </div>
            </div>

            <!-- Customer registry -->
            <div class="p-3 bg-light rounded-3 mb-4 small text-dark">
                <h6 class="fw-bold mb-1"><i class="ti tabler-user me-1"></i>Customer Details:</h6>
                @if($sale->customer)
                    <div class="fw-semibold">{{ $sale->customer->name }}</div>
                    <div>Phone: {{ $sale->customer->phone }}</div>
                    @if($sale->customer->address)
                        <div>Address: {{ $sale->customer->address }}</div>
                    @endif
                @else
                    <div class="italic text-muted">Walk-in Customer (Guest)</div>
                @endif
            </div>

            <!-- Sold items list -->
            <h6 class="fw-bold mb-2 text-dark">Items Sold:</h6>
            <table class="table table-sm table-bordered align-middle small text-dark mb-4">
                <thead class="table-light">
                    <tr>
                        <th>Product Description</th>
                        <th class="text-center" style="width: 80px;">Qty</th>
                        <th class="text-end" style="width: 100px;">Rate</th>
                        <th class="text-end" style="width: 120px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->details as $detail)
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $detail->item ? $detail->item->name : 'Unlisted Item' }}</span>
                            <div class="text-muted small">SKU: {{ $detail->item ? $detail->item->sku : '' }}</div>
                        </td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-end">{{ number_format($detail->sale_price, 2) }}</td>
                        <td class="text-end fw-semibold">{{ number_format($detail->quantity * $detail->sale_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Dynamic cost summaries -->
            <div class="row justify-content-end text-dark small">
                <div class="col-8 col-sm-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted fw-semibold">Subtotal:</td>
                            <td class="text-end fw-bold">{{ number_format($sale->total_amount, 2) }} BDT</td>
                        </tr>
                        @if($sale->discount > 0)
                        <tr>
                            <td class="text-muted fw-semibold text-danger">Discount Applied:</td>
                            <td class="text-end fw-bold text-danger">-{{ number_format($sale->discount, 2) }} BDT</td>
                        </tr>
                        @endif
                        <tr class="border-top">
                            <td class="fw-bold fs-6 text-dark">Total Bill:</td>
                            <td class="text-end fw-extrabold fs-6 text-dark">{{ number_format($sale->payable_amount, 2) }} BDT</td>
                        </tr>
                        @foreach($sale->payments as $payment)
                        <tr>
                            <td class="text-muted fw-semibold">
                                {{ $payment->payment_method }}
                                @if($payment->transaction_type === 'due_payment')
                                    <span style="font-size: 0.65rem;" class="text-muted">(Due Pay)</span>
                                @endif:
                            </td>
                            <td class="text-end fw-bold text-success">{{ number_format($payment->amount, 2) }} BDT</td>
                        </tr>
                        @endforeach
                        <tr class="border-top">
                            <td class="text-muted fw-semibold text-success">Total Paid:</td>
                            <td class="text-end fw-bold text-success">{{ number_format($sale->paid_amount, 2) }} BDT</td>
                        </tr>
                        @if($sale->payment_method === 'Cash' && $sale->change_returned > 0)
                        <tr>
                            <td class="text-muted fw-semibold text-success">Change Returned:</td>
                            <td class="text-end fw-bold text-success">{{ number_format($sale->change_returned, 2) }} BDT</td>
                        </tr>
                        @endif
                        @if($sale->due_amount > 0)
                        <tr class="table-danger">
                            <td class="fw-bold text-danger">Due Amount:</td>
                            <td class="text-end fw-extrabold text-danger">{{ number_format($sale->due_amount, 2) }} BDT</td>
                        </tr>
                        @else
                        <tr>
                            <td class="text-muted fw-semibold">Due Amount:</td>
                            <td class="text-end">0.00 BDT</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Footer instructions -->
            <hr class="border-dark my-4">
            <div class="text-center text-muted small">
                <p class="mb-1 fw-bold text-dark">Thank you for shopping with {{ App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}!</p>
                <p class="mb-0">{!! nl2br(e(App\Models\Setting::get('receipt_footer', "Note: Accessories carry a 6-month warranty. Please preserve this invoice copy for claiming warranty services."))) !!}</p>
            </div>
        </div>
    </div>

    <!-- Print Action Buttons -->
    <div class="d-flex gap-2 justify-content-center mt-4 print-hidden">
        <button class="btn btn-secondary px-4" onclick="window.close()"><i class="ti tabler-x me-1"></i>Close Page</button>
        <button class="btn btn-primary px-4" onclick="window.print()"><i class="ti tabler-printer me-1"></i>Print Bill</button>
    </div>
</div>

<script>
    // Automatically trigger printing when loaded
    window.addEventListener('load', function() {
        // Wait a small moment for rendering then print
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
    }
    .card {
        border: none !important;
    }
}
</style>
@endsection
