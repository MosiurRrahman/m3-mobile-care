<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #000;
            background: #fff;
            font-size: 13px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 4px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .shop-name {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 4px 0;
        }
        .shop-tagline {
            font-size: 12px;
            margin: 0 0 4px 0;
        }
        .shop-contact {
            font-size: 12px;
            margin: 0;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .label {
            width: 40%;
            color: #333;
        }
        .value {
            width: 60%;
            font-weight: 500;
        }
        .cost-box {
            border-top: 2px dashed #000;
            border-bottom: 2px dashed #000;
            padding: 10px 0;
            margin: 15px 0;
        }
        .cost-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }
        .cost-row.total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding: 0 10px;
        }
        .sig-line {
            width: 130px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 11px;
            padding-top: 4px;
        }
        @media print {
            body { padding: 0; }
            .container { border: none; padding: 0; max-width: 100%; }
            .no-print { display: none; }
        }
        .btn-bar {
            text-align: center;
            margin-bottom: 15px;
        }
        .btn {
            background: #000;
            color: #fff;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="btn-bar no-print">
        <button class="btn" onclick="window.print()">🖨️ Print Customer Receipt</button>
        <button class="btn" onclick="window.close()" style="background:#555; margin-left:5px;">Close</button>
    </div>

    <div class="container">
        <div class="header">
            <h1 class="shop-name">{{ \App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}</h1>
            <p class="shop-tagline">Special Product Pre-Order & Sourcing Slip</p>
            <p class="shop-contact">Phone: {{ \App\Models\Setting::get('phone', '+8801353106967') }} | Address: {{ \App\Models\Setting::get('address', 'Dhaka, Bangladesh') }}</p>
        </div>

        <div class="title">CUSTOMER ORDER SLIP</div>

        <table class="info-table">
            <tr>
                <td class="label">Order Number:</td>
                <td class="value"><strong>{{ $order->order_number }}</strong></td>
            </tr>
            <tr>
                <td class="label">Order Date:</td>
                <td class="value">{{ $order->created_at->format('d M, Y h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Customer Name:</td>
                <td class="value"><strong>{{ $order->customer_name }}</strong></td>
            </tr>
            <tr>
                <td class="label">Mobile Number:</td>
                <td class="value">{{ $order->customer_phone }}</td>
            </tr>
            <tr>
                <td class="label">Requested Item:</td>
                <td class="value"><strong>{{ $order->item_name }}</strong></td>
            </tr>
            @if($order->brand || $order->device_model)
            <tr>
                <td class="label">Device Model:</td>
                <td class="value">{{ trim(($order->brand ?? '') . ' ' . ($order->device_model ?? '')) }}</td>
            </tr>
            @endif
            @if($order->expected_delivery_date)
            <tr>
                <td class="label">Expected Delivery:</td>
                <td class="value" style="font-weight:bold;">{{ $order->expected_delivery_date->format('d M, Y') }}</td>
            </tr>
            @endif
        </table>

        <div class="cost-box">
            <div class="cost-row">
                <span>Total Item Price:</span>
                <span><strong>৳{{ number_format($order->selling_price, 2) }}</strong></span>
            </div>
            <div class="cost-row" style="color: #28a745;">
                <span>Advance Paid ({{ $order->advance_payment_method ?? 'Cash' }}):</span>
                <span>- ৳{{ number_format($order->advance_paid, 2) }}</span>
            </div>
            <div class="cost-row total" style="color: {{ $order->due_amount > 0 ? '#d9534f' : '#28a745' }};">
                <span>Remaining Due at Delivery:</span>
                <span>৳{{ number_format($order->due_amount, 2) }}</span>
            </div>
        </div>

        <div class="signatures">
            <div class="sig-line">Customer Signature</div>
            <div class="sig-line">Authorized Signatory</div>
        </div>

        <div class="footer">
            <p>Thank you for placing your order with {{ \App\Models\Setting::get('shop_name', 'M3 Mobile Care') }}!<br>
            Please present this slip when collecting your item.</p>
        </div>
    </div>
</body>
</html>
