<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->document_number }} - {{ $document->title }} | {{ $shopSettings['name'] }}</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Google Fonts for Bengali (Hind Siliguri, Tiro Bangla, Kalpurush fallback) & English (Outfit, Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Tiro+Bangla:ital@0;1&family=Outfit:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: '{{ $document->font_family ?? "Hind Siliguri" }}', 'Hind Siliguri', 'Outfit', 'Inter', sans-serif;
            background-color: #f4f5f7;
            color: #111111;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .page-container {
            width: 210mm;
            min-height: 297mm;
            padding: 18mm 20mm;
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
        }

        .shop-brand-name {
            font-family: 'Outfit', 'Hind Siliguri', sans-serif;
            font-weight: 800;
            color: #f37021 !important;
            font-size: 26px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .shop-slogan {
            font-size: 13px;
            color: #555555;
            font-weight: 600;
            margin-top: 3px;
        }

        .shop-header {
            border-bottom: 2px solid #f37021;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        /* Logo Background Watermark (Full Page Size & Centered on Every Page) */
        .watermark-logo {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            max-width: 700px;
            max-height: 700px;
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
            filter: grayscale(10%);
        }

        .document-body {
            position: relative;
            z-index: 1;
            font-family: '{{ $document->font_family ?? "Hind Siliguri" }}', 'Hind Siliguri', sans-serif;
            font-size: 15px;
            line-height: 1.85;
            min-height: 540px;
            color: #111111;
        }

        .document-body h1, .document-body h2, .document-body h3, .document-body h4 {
            font-family: '{{ $document->font_family ?? "Hind Siliguri" }}', 'Outfit', sans-serif;
            color: #111111;
        }

        .document-body table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .document-body th, .document-body td {
            border: 1px solid #d0d0d0;
            padding: 8px 12px;
        }

        .document-body th {
            background-color: #fff4ec !important;
            color: #111;
            font-weight: 700;
        }

        .signature-section {
            margin-top: 60px;
            padding-top: 20px;
            position: relative;
            z-index: 1;
        }

        @media print {
            body {
                background-color: #ffffff;
            }

            .page-container {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 5mm 0;
                box-shadow: none;
            }

            .watermark-logo {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                width: 85% !important;
                max-width: 720px !important;
                height: auto !important;
                opacity: 0.08 !important;
                z-index: -1 !important;
                pointer-events: none !important;
                display: block !important;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4 portrait;
                margin: 12mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Print Control Bar (Screen View Only) -->
    <div class="no-print bg-dark text-white p-3 text-center sticky-top shadow d-flex justify-content-center align-items-center gap-3">
        <span><strong>{{ $document->document_number }}</strong> - অফিশিয়াল প্যাডে প্রিন্ট প্রিভিউ (ফন্ট: {{ $document->font_family ?? 'Hind Siliguri' }})</span>
        <button onclick="window.print()" class="btn btn-warning fw-bold btn-sm px-4 text-white" style="background-color: #f37021; border-color: #f37021;">
            🖨️ এখনই প্রিন্ট করুন (Print Now)
        </button>
        <button onclick="window.close()" class="btn btn-outline-light btn-sm">
            বন্ধ করুন (Close)
        </button>
    </div>

    <!-- Printable A4 Document Container -->
    <div class="page-container">
        <!-- Logo Image Watermark in Background -->
        @if(!empty($shopSettings['logo']))
            <img src="{{ $shopSettings['logo'] }}" alt="Watermark Logo" class="watermark-logo">
        @endif

        <!-- Shop Pad Header -->
        <div class="shop-header">
            <div class="row align-items-center">
                <div class="col-7">
                    <div class="d-flex align-items-center gap-3">
                        @if(!empty($shopSettings['logo']))
                            <img src="{{ $shopSettings['logo'] }}" alt="Logo" style="max-height: 60px; width: auto; object-fit: contain;">
                        @endif
                        <div>
                            <div class="shop-brand-name">{{ $shopSettings['name'] }}</div>
                            <div class="shop-slogan">{{ $shopSettings['slogan'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-5 text-end text-secondary small">
                    <div style="font-weight: 500;">📍 {{ $shopSettings['address'] }}</div>
                    <div style="font-weight: 500;">📞 {{ $shopSettings['phone'] }}</div>
                    @if(!empty($shopSettings['email']))
                        <div style="font-weight: 500;">✉️ {{ $shopSettings['email'] }}</div>
                    @endif
                </div>
            </div>
            <!-- Shop Brand Color Divider Line -->
            <div style="height: 3px; background-color: #f37021; margin-top: 12px; border-radius: 2px;"></div>
        </div>

        <!-- Document Reference & Date Row -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3 small" style="font-size: 13px;">
            <div><strong style="color: #f37021;">স্মারক নং / Ref:</strong> <span style="font-family: 'Outfit', sans-serif; font-weight: 600;">{{ $document->document_number }}</span></div>
            <div><strong style="color: #f37021;">তারিখ / Date:</strong> <span style="font-weight: 600;">{{ $document->date ? $document->date->format('d/m/Y') : date('d/m/Y') }}</span></div>
        </div>

        <!-- Recipient Information (If available) -->
        @if($document->recipient_name || $document->recipient_phone || $document->recipient_address)
            <div class="mb-4 p-2 px-3 rounded border" style="background-color: #fff9f5; border-left: 4px solid #f37021 !important;">
                <div class="row text-dark small">
                    @if($document->recipient_name)
                        <div class="col-6"><strong>প্রাপক / দ্বিতীয় পক্ষ:</strong> {{ $document->recipient_name }}</div>
                    @endif
                    @if($document->recipient_phone)
                        <div class="col-6"><strong>মোবাইল:</strong> {{ $document->recipient_phone }}</div>
                    @endif
                    @if($document->recipient_address)
                        <div class="col-12 mt-1"><strong>ঠিকানা:</strong> {{ $document->recipient_address }}</div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Document Main Body Content -->
        <div class="document-body">
            {!! $document->content !!}
        </div>

        <!-- Signature Lines Footer -->
        <div class="signature-section">
            <div class="row text-center pt-4">
                <div class="col-6">
                    <div style="border-top: 1.5px dashed #333; width: 75%; margin: 0 auto; padding-top: 6px;">
                        <strong class="d-block text-dark">গ্রহীতা / দ্বিতীয় পক্ষের স্বাক্ষর</strong>
                        <small class="text-muted fs-9">Recipient / Party Signature</small>
                    </div>
                </div>
                <div class="col-6 ms-auto">
                    <div style="border-top: 1.5px dashed #f37021; width: 75%; margin: 0 auto; padding-top: 6px;">
                        <strong class="d-block text-dark" style="color: #f37021;">অনুমোদিত স্বাক্ষরকারী</strong>
                        <small class="text-muted fs-9">Authorized Signature ({{ $shopSettings['name'] }})</small>
                    </div>
                </div>
            </div>

            <!-- Page Footer Note -->
            <div class="text-center text-muted small mt-5 pt-3" style="font-size: 11px; border-top: 1px solid #eee;">
                {{ $shopSettings['name'] }} | {{ $shopSettings['address'] }} | ফোন: {{ $shopSettings['phone'] }}
            </div>
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
