<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Slip - {{ $repair->ticket_id }}</title>
    <!-- Simple Print-Adapted Stylesheet -->
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 26px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 13px;
        }
        .ticket-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0;
            letter-spacing: 1px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .details-table td.label {
            font-weight: bold;
            width: 180px;
            text-transform: uppercase;
        }
        .details-table td.value {
            border-bottom: 1px dashed #000;
        }
        .cost-section {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
            font-size: 16px;
        }
        .cost-box {
            border: 1px dashed #000;
            padding: 10px 15px;
            min-width: 250px;
        }
        .cost-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .cost-row.total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .terms {
            margin-top: 40px;
            font-size: 11px;
            border-top: 1px solid #000;
            padding-top: 15px;
        }
        .terms h5 {
            margin: 0 0 8px 0;
            font-size: 12px;
            text-transform: uppercase;
        }
        .terms p {
            margin: 0;
            white-space: pre-wrap;
            line-height: 1.4;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            padding: 0 20px;
        }
        .sig-line {
            width: 200px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 12px;
            padding-top: 5px;
            text-transform: uppercase;
        }
        @media print {
            body {
                padding: 0;
            }
            .container {
                border: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .print-btn-bar {
            max-width: 800px;
            margin: 0 auto 15px auto;
            text-align: right;
        }
        .btn {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-family: inherit;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="print-btn-bar no-print">
        <button class="btn" onclick="window.print()">Print This Ticket</button>
        <button class="btn" onclick="window.history.back()" style="background-color: #666; margin-left: 5px;">Back</button>
    </div>

    <div class="container">
        <!-- Logo & Header info from Settings -->
        <div class="header">
            @if(\App\Models\Setting::get('logo'))
                <!-- Render simple path or name -->
            @endif
            <h1>{{ \App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}</h1>
            <p>{{ \App\Models\Setting::get('shop_slogan', 'Premium Mobile Repair & Retail') }}</p>
            <p>Address: {{ \App\Models\Setting::get('address') }}</p>
            <p>Phone: {{ \App\Models\Setting::get('phone') }} | Email: {{ \App\Models\Setting::get('email') }}</p>
        </div>

        <div class="ticket-title">CUSTOMER JOB CARD CARD</div>

        <table class="details-table">
            <tbody>
                <tr>
                    <td class="label">Ticket Code:</td>
                    <td class="value" style="font-weight: bold;">{{ $repair->ticket_id }}</td>
                </tr>
                <tr>
                    <td class="label">Date Logged:</td>
                    <td class="value">{{ $repair->created_at->format('M d, Y - h:i A') }}</td>
                </tr>
                <tr>
                    <td class="label">Customer Name:</td>
                    <td class="value">{{ $repair->customer ? $repair->customer->name : 'Walk-in Customer' }}</td>
                </tr>
                <tr>
                    <td class="label">Contact Phone:</td>
                    <td class="value">{{ $repair->customer ? $repair->customer->phone : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Device Description:</td>
                    <td class="value" style="font-weight: bold;">{{ $repair->device_brand }} {{ $repair->device_model }}</td>
                </tr>
                <tr>
                    <td class="label">Problem Reported:</td>
                    <td class="value">{{ $repair->issue_description }}</td>
                </tr>
                @if(intval($repair->warranty_days) > 0)
                <tr>
                    <td class="label">Warranty Period:</td>
                    <td class="value" style="font-weight: bold;">{{ $repair->warranty_days }} Days @if($repair->warranty_expiry_date) (Expires: {{ \Carbon\Carbon::parse($repair->warranty_expiry_date)->format('M d, Y') }}) @endif</td>
                </tr>
                @endif
                @if($repair->expected_delivery_date)
                <tr>
                    <td class="label">Expected Pickup:</td>
                    <td class="value" style="font-weight: bold;">{{ \Carbon\Carbon::parse($repair->expected_delivery_date)->format('M d, Y') }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Costs Breakdowns -->
        <div class="cost-section">
            <div class="cost-box">
                @php
                    $totalPartsCost = 0;
                    if ($repair->used_parts && count($repair->used_parts) > 0) {
                        foreach ($repair->used_parts as $part) {
                            $totalPartsCost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
                        }
                    }
                    $totalBill = $repair->actual_cost !== null ? $repair->actual_cost : $repair->estimated_cost;
                    $isDelivered = $repair->status === 'delivered';
                    $balanceDue = $isDelivered ? 0 : max(0, $totalBill - $repair->advance_payment);
                @endphp
                <div class="cost-row">
                    <span>Total Bill:</span>
                    <span>{{ number_format($totalBill, 2) }} BDT</span>
                </div>
                @foreach($repair->payments as $payment)
                <div class="cost-row" style="font-size: 0.78rem; opacity: 0.9;">
                    <span>
                        Paid via {{ $payment->payment_method }}
                        @if($payment->transaction_type === 'initial')
                            (Adv)
                        @elseif($payment->transaction_type === 'delivery')
                            (Deliv)
                        @elseif($payment->transaction_type === 'due_payment')
                            (Due Pay)
                        @endif:
                    </span>
                    <span>{{ number_format($payment->amount, 2) }} BDT</span>
                </div>
                @endforeach
                <div class="cost-row" style="border-top: 1px dashed #ccc; padding-top: 2px; font-weight: bold;">
                    <span>Total Paid:</span>
                    <span>{{ number_format($repair->paid_amount, 2) }} BDT</span>
                </div>
                <div class="cost-row total" style="border-top: 1px solid #000; padding-top: 3px;">
                    <span>Due Balance:</span>
                    <span>{{ number_format($repair->due_amount, 2) }} BDT</span>
                </div>
            </div>
        </div>

        <!-- Terms Conditions -->
        <div class="terms">
            <h5>Terms & Repair Policies</h5>
            <p>{{ \App\Models\Setting::get('receipt_footer') ?: '' }}
1. DATA LOSS WAIVER: M3 Mobile Care is NOT liable for any user data loss. Customers must perform data backups prior to repair.
2. SOLDERING & MOTHERBOARD RISKS: Micro-soldering and motherboard component diagnostics carry risks of complete power loss.
3. WATER RESISTANCE: Opened/serviced devices lose their original factory dust and water resistance seals.
4. CLAIM WINDOW: Devices left unclaimed for more than 90 days will be disposed of or sold to recover repair costs.</p>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="sig-line">Customer Signature</div>
            <div class="sig-line">Authorized Receiver</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger auto-print
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
