<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesman Price Catalog - {{ $shopSettings['name'] }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Google Fonts for English (Outfit, Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', 'Outfit', sans-serif;
            background-color: #f8f9fa;
            color: #111;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .page-container {
            width: 210mm;
            min-height: 297mm;
            padding: 12mm 15mm;
            margin: 15px auto;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .shop-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            color: #f37021;
            font-size: 24px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .catalog-badge {
            background-color: #f37021;
            color: #fff;
            padding: 4px 12px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 4px;
            display: inline-block;
        }

        .category-header {
            background-color: #fff4ec !important;
            border-left: 4px solid #f37021;
            padding: 6px 12px;
            font-weight: 700;
            font-size: 15px;
            margin-top: 15px;
            margin-bottom: 8px;
            color: #111;
        }

        .table-price-sheet {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .table-price-sheet th {
            background-color: #f1f3f5 !important;
            border: 1px solid #dee2e6;
            padding: 7px 10px;
            font-weight: 700;
            color: #212529;
            text-align: left;
        }

        .table-price-sheet td {
            border: 1px solid #dee2e6;
            padding: 6px 10px;
            vertical-align: middle;
        }

        .table-price-sheet tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .price-range-badge {
            font-weight: 700;
            color: #2b8a3e;
            font-size: 13.5px;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .page-container {
                width: 100% !important;
                min-height: 297mm !important;
                margin: 0 !important;
                padding: 10mm 12mm !important;
                box-shadow: none !important;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4 portrait;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Top Control Bar -->
    <div class="no-print bg-dark text-white p-3 text-center sticky-top shadow d-flex justify-content-center align-items-center gap-3">
        <span><strong>{{ $shopSettings['name'] }}</strong> - Salesman Price Catalog</span>
        <button onclick="window.print()" class="btn btn-warning fw-bold btn-sm px-4 text-white" style="background-color: #f37021; border-color: #f37021;">
            🖨️ Print Now
        </button>
        <button onclick="window.close()" class="btn btn-outline-light btn-sm">
            Close
        </button>
    </div>

    <!-- Printable A4 Catalog Container -->
    <div class="page-container">
        <!-- Shop Header -->
        <div class="row align-items-center border-bottom pb-3 mb-3">
            <div class="col-7">
                <div class="d-flex align-items-center gap-3">
                    @if(!empty($shopSettings['logo']))
                        <img src="{{ $shopSettings['logo'] }}" alt="Logo" style="max-height: 55px; width: auto; object-fit: contain;">
                    @endif
                    <div>
                        <div class="shop-title">{{ $shopSettings['name'] }}</div>
                        <div class="text-muted small fw-semibold">{{ $shopSettings['slogan'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-5 text-end">
                <div class="catalog-badge">📋 SALESMAN PRICE CATALOG</div>
                <div class="text-muted small mt-1">Date: {{ date('d/m/Y') }}</div>
                <div class="text-secondary fs-9">Phone: {{ $shopSettings['phone'] }}</div>
            </div>
        </div>

        @if(count($items) > 0)
            @php $globalIndex = 1; @endphp
            @foreach($items as $catName => $categoryItems)
                <!-- Category Section Header -->
                <div class="category-header d-flex justify-content-between align-items-center">
                    <span>📂 {{ $catName }} ({{ count($categoryItems) }} Items)</span>
                    @if($discountMargin > 0)
                        <span class="badge bg-secondary text-white fw-normal fs-9">Max Discount Margin: {{ $discountMargin }}%</span>
                    @endif
                </div>

                <!-- Products Table -->
                <table class="table-price-sheet">
                    <thead>
                        <tr>
                            <th style="width: 35px;" class="text-center">#</th>
                            <th style="width: 110px;">SKU / Code</th>
                            <th>Product Description & Brand</th>
                            <th style="width: 70px;" class="text-center">Stock</th>
                            <th style="width: 110px;" class="text-end">Retail MRP</th>
                            <th style="width: 150px;" class="text-end">Selling Price Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryItems as $item)
                            @php
                                $mrp = floatval($item->sale_price);
                                $minPrice = $mrp - ($mrp * ($discountMargin / 100));
                            @endphp
                            <tr>
                                <td class="text-center text-secondary fw-semibold">{{ $globalIndex++ }}</td>
                                <td><code class="text-dark fw-bold">{{ $item->sku }}</code></td>
                                <td>
                                    <strong class="text-dark">{{ $item->name }}</strong>
                                    @if(!empty($item->brand))
                                        <span class="text-muted small">({{ $item->brand }})</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold text-dark">
                                    {{ $item->quantity > 0 ? $item->quantity : 'Out' }}
                                </td>
                                <td class="text-end fw-bold">BDT {{ number_format($mrp, 0) }}</td>
                                <td class="text-end price-range-badge">
                                    @if($discountMargin > 0)
                                        BDT {{ number_format($minPrice, 0) }} - BDT {{ number_format($mrp, 0) }}
                                    @else
                                        BDT {{ number_format($mrp, 0) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @else
            <div class="text-center py-5 text-muted">
                No products found for this price catalog.
            </div>
        @endif

        <!-- Footer Notice for Salesman -->
        <div class="border-top pt-2 mt-4 text-center text-muted small" style="font-size: 11px;">
            ** Official Internal Salesman Price Catalog. Do not sell below the minimum price range. **
        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
