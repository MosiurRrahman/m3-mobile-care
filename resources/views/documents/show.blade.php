@extends('layouts/contentNavbarLayout')

@section('title', $document->title . ' - M3 Mobile Care')

@section('content')
<div class="row justify-content-center">
    <!-- Action Bar Header -->
    <div class="col-12 col-xl-10 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                <a href="{{ route('admin.documents.index') }}" class="text-muted me-1"><i class="ti tabler-arrow-left"></i></a>
                {{ $document->document_number }}
            </h4>
            <span class="badge bg-warning text-dark me-2" style="background-color: #f37021 !important; color: #fff !important;">{{ $document->type_label }}</span>
            <span class="badge bg-label-secondary me-2"><i class="ti tabler-typography me-1"></i>{{ $document->font_family ?? 'Hind Siliguri' }}</span>
            <span class="text-muted small">তৈরির তারিখ: {{ $document->date ? $document->date->format('d M, Y') : '-' }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documents.print', $document->id) }}" target="_blank" class="btn btn-warning text-white shadow-sm" style="background-color: #f37021; border-color: #f37021;">
                <i class="ti tabler-printer me-1"></i>অফিশিয়াল প্যাডে প্রিন্ট করুন
            </a>
            <a href="{{ route('admin.documents.edit', $document->id) }}" class="btn btn-outline-warning">
                <i class="ti tabler-pencil me-1"></i>এডিট
            </a>
            <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ডকুমেন্টটি মুছে ফেলতে চান?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="ti tabler-trash me-1"></i>ডিলিট
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="col-12 col-xl-10 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti tabler-check me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Document Letterhead Preview Card -->
    <div class="col-12 col-xl-10">
        <div class="card shadow border-0 overflow-hidden" style="background: #ffffff; font-family: '{{ $document->font_family ?? "Hind Siliguri" }}', 'Hind Siliguri', 'Outfit', sans-serif;">
            <!-- Shop Letterhead Header Pad Structure -->
            <div class="card-header border-bottom py-4 px-5 bg-white position-relative">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            @if(!empty($shopSettings['logo']))
                                <img src="{{ $shopSettings['logo'] }}" alt="Shop Logo" style="max-height: 60px; width: auto; object-fit: contain;">
                            @endif
                            <div>
                                <h3 class="fw-extrabold mb-0" style="color: #f37021; font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; text-transform: uppercase;">{{ $shopSettings['name'] }}</h3>
                                <p class="text-muted small mb-0 fw-semibold">{{ $shopSettings['slogan'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end text-muted small border-start-md ps-md-4">
                        <div class="mb-1 fw-medium"><i class="ti tabler-map-pin me-1" style="color: #f37021;"></i>{{ $shopSettings['address'] }}</div>
                        <div class="mb-1 fw-medium"><i class="ti tabler-phone me-1" style="color: #f37021;"></i>{{ $shopSettings['phone'] }}</div>
                        @if(!empty($shopSettings['email']))
                            <div class="fw-medium"><i class="ti tabler-mail me-1" style="color: #f37021;"></i>{{ $shopSettings['email'] }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Document Meta Sub-Header -->
            <div class="px-5 py-3 bg-light border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small" style="color: #f37021 !important; font-weight: 600;">স্মারক নং / Ref:</span>
                    <strong class="text-dark ms-1" style="font-family: 'Outfit', sans-serif;">{{ $document->document_number }}</strong>
                </div>
                <div>
                    <span class="text-muted small" style="color: #f37021 !important; font-weight: 600;">তারিখ / Date:</span>
                    <strong class="text-dark ms-1">{{ $document->date ? $document->date->format('d/m/Y') : date('d/m/Y') }}</strong>
                </div>
            </div>

            <!-- Recipient Information Box (if present) -->
            @if($document->recipient_name || $document->recipient_phone || $document->recipient_address)
                <div class="px-5 pt-4">
                    <div class="p-3 rounded border" style="background-color: #fff9f5; border-left: 4px solid #f37021 !important;">
                        <h6 class="fw-bold mb-2" style="color: #f37021;">প্রাপক / দ্বিতীয় পক্ষের বিবরণ:</h6>
                        <div class="row g-2 text-dark small">
                            @if($document->recipient_name)
                                <div class="col-md-4"><strong>নাম:</strong> {{ $document->recipient_name }}</div>
                            @endif
                            @if($document->recipient_phone)
                                <div class="col-md-4"><strong>মোবাইল:</strong> {{ $document->recipient_phone }}</div>
                            @endif
                            @if($document->recipient_address)
                                <div class="col-md-4"><strong>ঠিকানা:</strong> {{ $document->recipient_address }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Body Content -->
            <div class="card-body p-5 position-relative" style="min-height: 400px; font-size: {{ $document->font_size ?? '15px' }}; line-height: 1.85; color: #111111; font-family: '{{ $document->font_family ?? "Hind Siliguri" }}', 'Hind Siliguri', sans-serif;">
                <!-- Logo Watermark Background -->
                @if(!empty($shopSettings['logo']))
                    <div class="position-absolute top-50 start-50 translate-middle opacity-10 pointer-events-none text-center select-none" style="z-index: 0; user-select: none;">
                        <img src="{{ $shopSettings['logo'] }}" alt="Watermark" style="max-width: 520px; width: 75%; opacity: 0.08;">
                    </div>
                @endif

                <div class="position-relative" style="z-index: 1;">
                    {!! $document->content !!}
                </div>
            </div>

            <!-- Signature & Letterhead Footer -->
            <div class="card-footer bg-white px-5 pt-5 pb-4 border-0">
                <div class="row pt-5 mt-4">
                    <div class="col-5 ms-auto text-center">
                        <div class="border-top pt-2 text-center ms-auto" style="border-top: 1.5px dashed #f37021;">
                            <p class="fw-bold mb-0" style="color: #f37021;">অনুমোদিত স্বাক্ষরকারী</p>
                            <small class="text-muted">Authorized Signature ({{ $shopSettings['name'] }})</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
