<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Label Print - {{ $shopSettings['name'] }}</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Tabler / FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <!-- Select2 for easy searching -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- JsBarcode JS Library -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        :root {
            --brand-primary: #f37021;
            --brand-dark: #1e293b;
        }

        body {
            font-family: 'Inter', 'Hind Siliguri', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Screen Control Panel */
        .control-panel {
            background: #ffffff;
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .brand-header {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            color: var(--brand-primary);
            letter-spacing: -0.5px;
        }

        .btn-brand {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-brand:hover {
            background-color: #d95d13;
            border-color: #d95d13;
            color: #ffffff;
        }

        /* Preview Workspace */
        .preview-workspace {
            padding: 25px 15px 50px 15px;
            min-height: calc(100vh - 180px);
        }

        /* Barcode Sticker Card Styling */
        .barcode-sticker {
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 4px;
            padding: 4px 6px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-sizing: border-box;
            page-break-inside: avoid;
            break-inside: avoid;
            position: relative;
        }

        .sticker-shop-name {
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .sticker-product-name {
            font-size: 9.5px;
            font-weight: 700;
            color: #334155;
            line-height: 1.15;
            max-height: 22px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 1px;
            max-width: 100%;
        }

        .sticker-sku {
            font-size: 8px;
            color: #64748b;
            font-weight: 600;
            line-height: 1;
        }

        .sticker-barcode-svg {
            max-width: 100%;
            height: auto;
            margin: 1px 0;
        }

        .sticker-price-tag {
            font-size: 11px;
            font-weight: 800;
            color: #000000;
            line-height: 1.1;
            margin-top: 1px;
        }

        /* 1. Single Thermal Roll (e.g. 50mm x 30mm or 40x30mm) */
        .layout-thermal {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin: 0 auto;
            max-width: 400px;
        }
        .layout-thermal .barcode-sticker {
            width: 50mm;
            height: 30mm;
            padding: 3mm 4mm;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        /* 2. A4 Sheet (24 Labels: 3 cols x 8 rows) */
        .layout-a4-24 {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 10mm 8mm;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 34mm;
            gap: 2mm 3mm;
            align-content: start;
        }
        .layout-a4-24 .barcode-sticker {
            width: 100%;
            height: 34mm;
            padding: 2.5mm 3mm;
            border: 1px dashed #e2e8f0;
        }

        /* 3. A4 Sheet (40 Labels: 4 cols x 10 rows) */
        .layout-a4-40 {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 8mm 6mm;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: 27mm;
            gap: 1.5mm 2mm;
            align-content: start;
        }
        .layout-a4-40 .barcode-sticker {
            width: 100%;
            height: 27mm;
            padding: 1.5mm 2mm;
            border: 1px dashed #e2e8f0;
        }
        .layout-a4-40 .sticker-shop-name { font-size: 8.5px; }
        .layout-a4-40 .sticker-product-name { font-size: 8px; max-height: 18px; }
        .layout-a4-40 .sticker-price-tag { font-size: 9.5px; }

        /* 4. A4 Sheet (60 Labels: 5 cols x 12 rows - 5*12 Grid) */
        .layout-a4-60 {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 5mm 4mm;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-auto-rows: 23.2mm;
            gap: 0.8mm 1.5mm;
            align-content: start;
        }
        .layout-a4-60 .barcode-sticker {
            width: 100%;
            height: 23.2mm;
            padding: 1mm 1.5mm;
            border: 1px dashed #e2e8f0;
            overflow: hidden;
        }
        .layout-a4-60 .sticker-shop-name { 
            font-size: 7.5px; 
            margin-bottom: 0px; 
            line-height: 1;
        }
        .layout-a4-60 .sticker-product-name { 
            font-size: 7px; 
            max-height: 14px; 
            line-height: 1.1; 
            margin-bottom: 0px; 
            -webkit-line-clamp: 1;
        }
        .layout-a4-60 .sticker-price-tag { 
            font-size: 8px; 
            margin-top: 0px; 
            font-weight: 800; 
            line-height: 1;
        }
        .layout-a4-60 .sticker-barcode-svg {
            max-width: 100%;
            margin: 0.5px 0;
        }

        /* PRINT MEDIA QUERIES */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .preview-workspace {
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
            }

            /* Thermal Roll Print Settings */
            .layout-thermal {
                gap: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }
            .layout-thermal .barcode-sticker {
                width: 50mm !important;
                height: 30mm !important;
                border: none !important;
                box-shadow: none !important;
                page-break-after: always !important;
                break-after: page !important;
                margin: 0 auto !important;
            }

            /* A4 Print Settings */
            .layout-a4-24, .layout-a4-40, .layout-a4-60 {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 4mm 4mm !important;
                page-break-after: always !important;
            }
            .layout-a4-24 .barcode-sticker, .layout-a4-40 .barcode-sticker, .layout-a4-60 .barcode-sticker {
                border: 1px solid transparent !important;
            }

            @page {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- TOP CONTROL PANEL (HIDDEN IN PRINT) -->
    <div class="control-panel no-print p-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ url()->previous() ?: route('admin.inventory.accessories') }}" class="btn btn-outline-secondary btn-sm" title="Back">
                        <i class="ti tabler-arrow-left me-1"></i> Back
                    </a>
                    <span class="fs-4 brand-header">🏷️ Barcode Print Studio</span>
                    <span class="badge bg-dark text-white px-2 py-1">{{ $shopSettings['name'] }}</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearQueue()">
                        <i class="ti tabler-trash me-1"></i> Clear List
                    </button>
                    <button type="button" class="btn btn-brand px-4 shadow-sm" onclick="window.print()">
                        <i class="ti tabler-printer me-1 fs-5"></i> <strong>Print Labels (প্রিন্ট করুন)</strong>
                    </button>
                </div>
            </div>

            <!-- Configuration & Selector Toolbar -->
            <div class="card border-0 bg-light p-3">
                <div class="row g-2 align-items-center">
                    <!-- Product Selector -->
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label small fw-bold mb-1">Select Product to Add:</label>
                        <select id="product_selector" class="form-select select2">
                            <option value="">🔍 Search Product by Name, SKU or Barcode...</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" 
                                    data-name="{{ $item->name }}" 
                                    data-sku="{{ $item->sku }}" 
                                    data-barcode="{{ $item->barcode ?: $item->sku }}" 
                                    data-price="{{ number_format($item->sale_price, 0) }}"
                                    data-brand="{{ $item->brand ?? '' }}"
                                    {{ (isset($selectedItemId) && $selectedItemId == $item->id) ? 'selected' : '' }}>
                                    {{ $item->name }} | Price: {{ number_format($item->sale_price, 0) }} Tk | Barcode: {{ $item->barcode ?: 'Auto' }} (Stock: {{ $item->quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label small fw-bold mb-1">Copies / Stickers:</label>
                        <div class="input-group">
                            <input type="number" id="add_qty" class="form-control" value="{{ $selectedQty ?? 60 }}" min="1" max="500">
                            <button class="btn btn-primary" type="button" onclick="addProductFromSelector()">
                                <i class="ti tabler-plus"></i> Add
                            </button>
                        </div>
                    </div>

                    <!-- Paper Layout -->
                    <div class="col-lg-3 col-md-3 col-6">
                        <label class="form-label small fw-bold mb-1">Sticker Layout:</label>
                        <select id="layout_select" class="form-select" onchange="changeLayout(this.value)">
                            <option value="layout-a4-60" selected>A4 Sheet (60 Labels - 5×12 Grid)</option>
                            <option value="layout-thermal">Thermal Roll (50×30mm)</option>
                            <option value="layout-a4-24">A4 Sheet (24 Labels - 3×8 Grid)</option>
                            <option value="layout-a4-40">A4 Sheet (40 Labels - 4×10 Grid)</option>
                        </select>
                    </div>

                    <!-- Display Options Toggles -->
                    <div class="col-lg-2 col-12">
                        <label class="form-label small fw-bold mb-1">Sticker Details:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_shop" checked onchange="toggleOption('show_shop')">
                                <label class="form-check-label small" for="show_shop">Shop</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_title" checked onchange="toggleOption('show_title')">
                                <label class="form-check-label small" for="show_title">Title</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_price" checked onchange="toggleOption('show_price')">
                                <label class="form-check-label small" for="show_price">Price</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_code" checked onchange="toggleOption('show_code')">
                                <label class="form-check-label small" for="show_code">Code</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Queue Summary Badges -->
            <div class="mt-2 d-flex justify-content-between align-items-center">
                <div id="queue_items_badges" class="d-flex flex-wrap gap-1 align-items-center">
                    <!-- Populated dynamically via JS -->
                </div>
                <div class="text-muted small fw-bold">
                    Total Stickers to Print: <span id="total_sticker_count" class="badge bg-primary fs-6">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- PRINT & PREVIEW WORKSPACE -->
    <div class="preview-workspace">
        <div id="stickers_container" class="layout-a4-60">
            <!-- Dynamically populated barcode stickers -->
        </div>

        <div id="empty_state" class="text-center py-5" style="display: none;">
            <div class="card border-0 shadow-sm p-5 mx-auto" style="max-width: 500px;">
                <i class="ti tabler-barcode-off text-muted mb-3" style="font-size: 60px;"></i>
                <h5 class="fw-bold text-secondary">No Barcodes Selected</h5>
                <p class="text-muted small mb-3">Please select a product above and click <strong>"Add"</strong> to generate barcode stickers for printing.</p>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#product_selector').select2('open')">
                    <i class="ti tabler-plus me-1"></i> Select Product
                </button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Shop Settings
        const shopName = @json($shopSettings['name'] ?? 'M3 Mobile Care');

        // Queue of products to generate stickers: [ { id, name, sku, barcode, price, brand, qty } ]
        let printQueue = [];

        // Preload initial item if passed from URL
        @if(isset($selectedItem) && $selectedItem)
            printQueue.push({
                id: '{{ $selectedItem->id }}',
                name: '{{ addslashes($selectedItem->name) }}',
                sku: '{{ $selectedItem->sku }}',
                barcode: '{{ $selectedItem->barcode ?: $selectedItem->sku }}',
                price: '{{ number_format($selectedItem->sale_price, 0) }}',
                brand: '{{ addslashes($selectedItem->brand ?? "") }}',
                qty: {{ $selectedQty ?? 5 }}
            });
        @endif

        $(document).ready(function() {
            // Initialize Select2 with Bootstrap 5 Theme
            $('#product_selector').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: '🔍 Search Product by Name, SKU or Barcode...'
            });

            // Initial render
            renderStickers();
        });

        function addProductFromSelector() {
            const selectEl = $('#product_selector');
            const selectedVal = selectEl.val();
            if (!selectedVal) {
                alert('Please select a product first!');
                return;
            }

            const selectedOption = selectEl.find('option:selected');
            const qty = parseInt($('#add_qty').val()) || 1;

            const productData = {
                id: selectedVal,
                name: selectedOption.data('name'),
                sku: selectedOption.data('sku'),
                barcode: selectedOption.data('barcode'),
                price: selectedOption.data('price'),
                brand: selectedOption.data('brand'),
                qty: qty
            };

            // Check if already in queue
            const existingIndex = printQueue.findIndex(item => item.id == productData.id);
            if (existingIndex > -1) {
                printQueue[existingIndex].qty += qty;
            } else {
                printQueue.push(productData);
            }

            renderStickers();
        }

        function removeProduct(id) {
            printQueue = printQueue.filter(item => item.id != id);
            renderStickers();
        }

        function updateItemQty(id, newQty) {
            const item = printQueue.find(item => item.id == id);
            if (item) {
                item.qty = Math.max(1, parseInt(newQty) || 1);
                renderStickers();
            }
        }

        function clearQueue() {
            if (confirm('Are you sure you want to clear the print list?')) {
                printQueue = [];
                renderStickers();
            }
        }

        function changeLayout(layoutClass) {
            const container = $('#stickers_container');
            container.removeClass('layout-thermal layout-a4-24 layout-a4-40 layout-a4-60');
            container.addClass(layoutClass);
            renderStickers();
        }

        function toggleOption(optKey) {
            renderStickers();
        }

        function renderStickers() {
            const container = $('#stickers_container');
            const badgesContainer = $('#queue_items_badges');
            const emptyState = $('#empty_state');

            container.empty();
            badgesContainer.empty();

            if (printQueue.length === 0) {
                emptyState.show();
                container.hide();
                $('#total_sticker_count').text(0);
                return;
            }

            emptyState.hide();
            container.show();

            const showShop = $('#show_shop').is(':checked');
            const showTitle = $('#show_title').is(':checked');
            const showPrice = $('#show_price').is(':checked');
            const showCode = $('#show_code').is(':checked');
            const currentLayout = $('#layout_select').val();

            let totalCount = 0;

            // Render Queue Badges at top
            printQueue.forEach(item => {
                totalCount += item.qty;
                badgesContainer.append(`
                    <div class="badge bg-white text-dark border d-flex align-items-center gap-2 p-2 rounded shadow-xs">
                        <span class="fw-semibold">${item.name}</span>
                        <input type="number" min="1" value="${item.qty}" style="width: 55px; height: 24px; padding: 2px 4px;" class="form-control form-control-sm text-center" onchange="updateItemQty('${item.id}', this.value)">
                        <button type="button" class="btn-close btn-close-sm" style="font-size: 8px;" onclick="removeProduct('${item.id}')"></button>
                    </div>
                `);
            });

            $('#total_sticker_count').text(totalCount);

            // Determine Barcode dimensions based on layout
            let bcWidth = 1.35;
            let bcHeight = 24;
            let fontSize = 9;

            if (currentLayout === 'layout-thermal') {
                bcWidth = 1.5;
                bcHeight = 28;
                fontSize = 10;
            } else if (currentLayout === 'layout-a4-24') {
                bcWidth = 1.35;
                bcHeight = 24;
                fontSize = 9;
            } else if (currentLayout === 'layout-a4-40') {
                bcWidth = 1.1;
                bcHeight = 18;
                fontSize = 8;
            } else if (currentLayout === 'layout-a4-60') {
                bcWidth = 0.95;
                bcHeight = 14;
                fontSize = 7;
            }

            let stickerIndex = 0;

            // Render Individual Stickers
            printQueue.forEach(item => {
                const codeToRender = item.barcode || item.sku || '00000000';

                for (let i = 0; i < item.qty; i++) {
                    stickerIndex++;
                    const svgId = `bc_svg_${item.id}_${i}`;

                    const stickerHtml = `
                        <div class="barcode-sticker">
                            ${showShop ? `<div class="sticker-shop-name">${shopName}</div>` : ''}
                            ${showTitle ? `
                                <div class="sticker-product-name" title="${item.name}">
                                    ${item.brand ? `[${item.brand}] ` : ''}${item.name}
                                </div>
                            ` : ''}
                            <svg id="${svgId}" class="sticker-barcode-svg"></svg>
                            ${showPrice ? `
                                <div class="sticker-price-tag">
                                    Tk. ${item.price} /-
                                </div>
                            ` : ''}
                        </div>
                    `;

                    container.append(stickerHtml);

                    // Generate SVG Barcode via JsBarcode
                    try {
                        JsBarcode(`#${svgId}`, codeToRender, {
                            format: "CODE128",
                            width: bcWidth,
                            height: bcHeight,
                            displayValue: showCode,
                            fontSize: fontSize,
                            font: "Inter",
                            textMargin: 1,
                            margin: 0
                        });
                    } catch (e) {
                        // Fallback generic code128
                        console.warn('JsBarcode render error:', e);
                        JsBarcode(`#${svgId}`, item.sku, {
                            format: "CODE128",
                            width: bcWidth,
                            height: bcHeight,
                            displayValue: showCode,
                            fontSize: fontSize,
                            margin: 0
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>
