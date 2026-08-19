@extends('layouts/blankLayout')

@section('title', 'ERT Live Repair Tracking – ' . ($shopSettings['shop_name'] ?? 'M3 Mobile Care'))
@section('meta_description', 'M3 Mobile Care ERT (Estimated Repair Tracking) - আপনার মোবাইল সার্ভিসের রিয়েল-টাইম স্ট্যাটাস, ডায়াগনস্টিক নোট এবং টেস্ট ট্র্যাকিং করুন।')
@section('meta_keywords', 'ERT Live Tracking, M3 Mobile Care Ticket Track, Mobile Repair Status Ranisankail')

@section('head_extra')
<!-- Premium Fonts & Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
@endsection

@section('content')
<style>
    :root {
        --brand-blue: #0284c7;
        --brand-orange: #f97316;
        --brand-orange-hover: #ea580c;
        --dark-heading: #0f172a;
        --body-text: #334155;
        --muted-text: #64748b;
        --surface-light: #f8fafc;
        --border-subtle: #e2e8f0;
        --shadow-md: 0 12px 32px rgba(15, 23, 42, 0.06);
        --radius-lg: 20px;
        --radius-md: 12px;
    }

    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: var(--surface-light) !important;
        color: var(--body-text) !important;
        line-height: 1.65;
    }

    .ert-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 30px 0 20px 0;
        position: relative;
    }

    .ert-main-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-md);
        padding: 10px;
    }

    .btn-ux-primary {
        background-color: var(--brand-orange) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 14px 28px !important;
        border-radius: var(--radius-md) !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        box-shadow: 0 4px 14px rgba(249, 115, 22, 0.28) !important;
        transition: all 0.3s ease !important;
    }
    .btn-ux-primary:hover {
        background-color: var(--brand-orange-hover) !important;
        transform: translateY(-2px) !important;
    }

    /* Vertical Timeline UI */
    .timeline-ert {
        position: relative;
        padding-left: 12%;
    }
    .timeline-ert-item {
        position: relative;
        padding-bottom: 24px;
        border-left: 2px solid var(--border-subtle);
        padding-left: 24px;
    }
    .timeline-ert-item:last-child {
        border-left: 2px solid transparent;
        padding-bottom: 0;
    }
    .timeline-ert-icon {
        position: absolute;
        left: -13px;
        top: 0;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #cbd5e1;
        border: 4px solid #ffffff;
        box-shadow: 0 0 0 2px var(--border-subtle);
    }
    .timeline-ert-item.completed .timeline-ert-icon {
        background: #10b981;
        box-shadow: 0 0 0 2px #10b981;
    }
    .timeline-ert-item.active .timeline-ert-icon {
        background: var(--brand-orange);
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.25);
    }
    .timeline-ert-item.cancelled .timeline-ert-icon {
        background: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.25);
    }
</style>

@include('_partials.public-navbar')

<main>
    <!-- HERO HEADER -->
    <section class="ert-hero-header text-center">
        <div class="container">
            <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-3">
                <ol class="breadcrumb mb-0 fs-7">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-slate-400 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-warning fw-semibold" aria-current="page">ERT Live Tracking</li>
                </ol>
            </nav>

            <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold mb-3 fs-7">
                <i class="ti tabler-activity me-1"></i> LIVE ESTIMATED REPAIR TRACKER
            </span>
            <h1 class="text-white fw-extrabold display-6 mb-3">ERT লাইভ রিপেয়ার ট্র্যাকিং</h1>
            <p class="text-slate-300 fs-6 max-w-2xl mx-auto">
                আপনার রসিদে থাকা <strong>Ticket ID</strong> বসিয়ে লাইভ রিপেয়ার স্ট্যাটাস, টেকনিশিয়ান নোট ও ডেলিভারি তথ্য দেখুন।
            </p>
        </div>
    </section>

    <!-- SEARCH & TRACKING STAGE -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="ert-main-card">

                        <!-- Search Form -->
                        <form action="{{ route('track.form') }}" method="GET" class="mb-4">
                            <div class="row g-3 justify-content-center align-items-center">
                                <div class="col-md-8">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="ti tabler-barcode fs-3"></i></span>
                                        <input type="text" name="ticket_id" class="form-control bg-light border-start-0 ps-0 fw-bold fs-5 text-uppercase" placeholder="যেমন: M3-202608-XXXX" value="{{ request('ticket_id') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-ux-primary w-100">
                                        <i class="ti tabler-search me-1.5"></i> স্ট্যাটাস দেখুন
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if($searched)
                            @if($repair)
                                <div class="alert alert-success d-flex align-items-center mb-4 rounded-3 p-3">
                                    <i class="ti tabler-circle-check fs-2 me-2.5"></i>
                                    <div>
                                        <strong class="fs-8">সফলভাবে পাওয়া গেছে!</strong> টিকিট নাম্বার: <span class="fw-extrabold text-uppercase">{{ $repair->ticket_id }}</span>
                                    </div>
                                </div>

                                <!-- Ticket Quick Summary Grid -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <div class="p-2 bg-light rounded-3 border text-center h-100">
                                            <span class="text-muted fs-8 text-uppercase fw-bold d-block mb-1">ডিভাইসের নাম</span>
                                            <h6 class="mb-0 fw-bold text-dark"><i class="ti tabler-device-mobile text-orange me-1"></i> {{ $repair->device_brand }} {{ $repair->device_model }}</h6>
                                            @if($repair->serial_imei)
                                                <small class="text-muted d-block mt-1">IMEI/SN: {{ $repair->serial_imei }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 bg-light rounded-3 border text-center h-100">
                                            <span class="text-muted fs-8 text-uppercase fw-bold d-block mb-1">বর্তমান স্ট্যাটাস</span>
                                            @php
                                                $statusBadges = [
                                                    'pending' => ['bg-warning text-dark', 'অপেক্ষমান (Pending)'],
                                                    'diagnosing' => ['bg-info text-white', 'ডায়াগনসিস চলছে'],
                                                    'waiting_for_approval' => ['bg-secondary text-white', 'গ্রাহক অনুমোদনের অপেক্ষা'],
                                                    'repairing' => ['bg-primary text-white', 'কাজ চলছে (Repairing)'],
                                                    'quality_check' => ['bg-dark text-white', 'কোয়ালিটি চেক'],
                                                    'completed' => ['bg-success text-white', 'সম্পূর্ণ তৈরি (Ready)'],
                                                    'delivered' => ['bg-secondary text-white', 'ডেলিভারি সম্পন্ন (Delivered)'],
                                                    'cancelled' => ['bg-danger text-white', 'বাতিল (Cancelled)'],
                                                ];
                                                $badgeInfo = $statusBadges[$repair->status] ?? ['bg-secondary text-white', ucfirst($repair->status)];
                                            @endphp
                                            <span class="badge {{ $badgeInfo[0] }} fs-8 px-3 py-2 rounded-pill mt-1"><i class="ti tabler-clock me-1"></i> {{ $badgeInfo[1] }}</span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="p-2 bg-light rounded-3 border text-center h-100">
                                            <span class="text-muted fs-8 text-uppercase fw-bold d-block mb-1">আউটলেট তথ্য</span>
                                            <h6 class="mb-0 fw-bold text-dark"><i class="ti tabler-map-pin text-success me-1"></i> M3 Mobile Care</h6>
                                            <small class="text-muted d-block mt-1">রাণীশংকৈল, ঠাকুরগাঁও</small>
                                        </div>
                                    </div> --}}
                                </div>

                                <!-- Full Diagnostic & Timeline Details -->
                                <div class="row g-4">
                                    <div class="col-lg-7">
                                        <div class="p-4 border rounded-3 bg-white h-100">
                                            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="ti tabler-report-medical text-orange me-1"></i> সমস্যা ও ডায়াগনস্টিক নোট</h6>
                                            <div class="mb-3">
                                                <label class="text-muted fs-8 fw-bold">গ্রাহকের বর্ণিত সমস্যা:</label>
                                                <p class="fw-medium text-dark bg-light p-3 rounded border mb-0">{{ $repair->issue_description }}</p>
                                            </div>
                                            @if($repair->technician_notes)
                                            <div>
                                                <label class="text-muted fs-8 fw-bold">টেকনিশিয়ানের আপডেট / পরামর্শ:</label>
                                                <p class="fw-medium text-dark bg-warning-subtle p-3 rounded border border-warning mb-0"><i class="ti tabler-notes me-1"></i> {{ $repair->technician_notes }}</p>
                                            </div>
                                            @endif

                                            @if($repair->expected_delivery_date)
                                            <div class="mt-3 p-3 bg-info-subtle rounded border border-info">
                                                <span class="fw-bold text-info-emphasis"><i class="ti tabler-calendar-event me-1"></i> সম্ভাব্য ডেলিভারির তারিখ:</span>
                                                <span class="fw-extrabold ms-1 text-dark">{{ \Carbon\Carbon::parse($repair->expected_delivery_date)->format('d M, Y (h:i A)') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="p-4 border rounded-3 bg-white h-100">
                                            <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="ti tabler-timeline text-orange me-1"></i> রিপেয়ারের ধাপসমূহ</h6>
                                            
                                            @php
                                                $status = $repair->status;
                                                $techNotes = !empty($repair->technician_notes) ? trim($repair->technician_notes) : null;
                                                $partsUsed = !empty($repair->used_parts) && is_array($repair->used_parts) 
                                                    ? implode(', ', array_filter(array_column($repair->used_parts, 'name'))) 
                                                    : null;

                                                // Sequential step definitions up to the current progress
                                                $stepDefinitions = [
                                                    'pending' => [
                                                        'title' => '১. রিসিভড & এন্ট্রি',
                                                        'date' => $repair->created_at->format('d M, Y h:i A'),
                                                        'desc' => 'টিকিট #' . $repair->ticket_id . ' সিস্টেমে রিসিভড করা হয়েছে।',
                                                    ],
                                                    'diagnosing' => [
                                                        'title' => '২. ডায়াগনসিস ও পার্টস চেকিং',
                                                        'date' => null,
                                                        'desc' => $techNotes ?: 'টেকনিশিয়ান ডিভাইসটি ল্যাবে পরীক্ষা ও সমস্যা ডায়াগনসিস করছেন।',
                                                    ],
                                                    'waiting_for_approval' => [
                                                        'title' => '২. গ্রাহক অনুমোদনের অপেক্ষা',
                                                        'date' => null,
                                                        'desc' => $techNotes ?: 'আনুমানিক খরচ নির্ধারণ করে গ্রাহকের অনুমোদনের অপেক্ষায় রাখা হয়েছে।',
                                                    ],
                                                    'repairing' => [
                                                        'title' => '৩. রিপেয়ার কাজ চলছে',
                                                        'date' => null,
                                                        'desc' => $techNotes ?: ($partsUsed ? 'পার্টস প্রতিস্থাপন: ' . $partsUsed : 'ল্যাবে অভিজ্ঞ টেকনিশিয়ান দ্বারা রিপেয়ার কাজ চলছে।'),
                                                    ],
                                                    'quality_check' => [
                                                        'title' => '৩. কোয়ালিটি টেস্ট',
                                                        'date' => null,
                                                        'desc' => $techNotes ?: 'রিপেয়ার শেষে পারফরম্যান্স ও কোয়ালিটি টেস্ট চলছে।',
                                                    ],
                                                    'completed' => [
                                                        'title' => '৪. টেস্ট সম্পন্ন ও ডেলিভারির জন্য প্রস্তুত',
                                                        'date' => $repair->completed_at ? \Carbon\Carbon::parse($repair->completed_at)->format('d M, Y h:i A') : null,
                                                        'desc' => $techNotes ?: 'ডিভাইসটি সফলভাবে প্রস্তুত করা হয়েছে। আউটলেট থেকে ডেলিভারি গ্রহণ করতে পারেন।',
                                                    ],
                                                    'delivered' => [
                                                        'title' => '৫. ডেলিভারি সম্পন্ন',
                                                        'date' => $repair->updated_at->format('d M, Y h:i A'),
                                                        'desc' => $techNotes ?: 'পণ্যটি সফলভাবে গ্রাহকের নিকট হস্তান্তর করা হয়েছে। ধন্যবাদ!',
                                                    ],
                                                    'cancelled' => [
                                                        'title' => 'সার্ভিস বাতিল (Cancelled)',
                                                        'date' => $repair->updated_at->format('d M, Y h:i A'),
                                                        'desc' => $techNotes ?: 'অনিবার্য কারণে সার্ভিসটি বাতিল করা হয়েছে।',
                                                    ],
                                                ];

                                                // Determine sequence of steps to show up to the current status
                                                if ($status === 'pending') {
                                                    $visibleKeys = ['pending'];
                                                } elseif ($status === 'diagnosing') {
                                                    $visibleKeys = ['pending', 'diagnosing'];
                                                } elseif ($status === 'waiting_for_approval') {
                                                    $visibleKeys = ['pending', 'waiting_for_approval'];
                                                } elseif ($status === 'repairing') {
                                                    $visibleKeys = ['pending', 'diagnosing', 'repairing'];
                                                } elseif ($status === 'quality_check') {
                                                    $visibleKeys = ['pending', 'diagnosing', 'repairing', 'quality_check'];
                                                } elseif ($status === 'completed') {
                                                    $visibleKeys = ['pending', 'diagnosing', 'repairing', 'completed'];
                                                } elseif ($status === 'delivered') {
                                                    $visibleKeys = ['pending', 'diagnosing', 'repairing', 'completed', 'delivered'];
                                                } elseif ($status === 'cancelled') {
                                                    $visibleKeys = ['pending', 'cancelled'];
                                                } else {
                                                    $visibleKeys = ['pending'];
                                                }

                                                $lastIndex = count($visibleKeys) - 1;
                                            @endphp

                                            <div class="timeline-ert pt-2">
                                                @foreach($visibleKeys as $idx => $sKey)
                                                    @php
                                                        $isLast = ($idx === $lastIndex);
                                                        $sItem = $stepDefinitions[$sKey] ?? null;
                                                        if (!$sItem) continue;

                                                        $isCancelled = ($sKey === 'cancelled');
                                                        $itemClass = $isCancelled ? 'cancelled' : ($isLast ? 'active' : 'completed');
                                                        
                                                        // For past steps, show clean concise completed notes
                                                        $desc = $sItem['desc'];
                                                        if (!$isLast) {
                                                            if ($sKey === 'pending') {
                                                                $desc = 'সিস্টেমে রিসিভ ও এন্ট্রি সম্পন্ন।';
                                                            } elseif ($sKey === 'diagnosing') {
                                                                $desc = 'ডিভাইস পরীক্ষা ও পার্টস ডায়াগনসিস সম্পন্ন।';
                                                            } elseif ($sKey === 'repairing') {
                                                                $desc = 'রিপেয়ারিং ও সার্ভিস কাজ সম্পন্ন।';
                                                            } elseif ($sKey === 'completed') {
                                                                $desc = 'টেস্টিং ও ডেলিভারি প্রস্তুতি সম্পন্ন।';
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="timeline-ert-item {{ $itemClass }}">
                                                        <div class="timeline-ert-icon"></div>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $sItem['title'] }}</h6>
                                                        <div class="text-slate-600 fs-8 mt-1 lh-sm">{{ $desc }}</div>
                                                        @if($sItem['date'])
                                                            <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                                                <i class="ti tabler-calendar-time me-1"></i>{{ $sItem['date'] }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger text-center p-5 rounded-4">
                                    <i class="ti tabler-alert-circle fs-1 d-block mb-2 text-danger"></i>
                                    <h5 class="fw-bold mb-2">দুঃখিত! কোনো তথ্য পাওয়া যায়নি।</h5>
                                    <p class="mb-0 text-muted">আপনার দেওয়া Ticket ID <strong>"{{ request('ticket_id') }}"</strong> আমাদের সিস্টেমে খুঁজে পাওয়া যায়নি। অনুগ্রহ করে রসিদে থাকা সঠিক টিকিট নাম্বারটি পুনরায় চেক করুন।</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5 text-muted bg-light rounded-4 border">
                                <i class="ti tabler-barcode fs-1 d-block mb-2 text-orange"></i>
                                <h5 class="fw-bold text-dark mb-1">টিকিট নাম্বার ইনপুট দিন</h5>
                                <p class="fs-7 mb-0">আপনার মেমোতে থাকা টিকিট নাম্বারটি উপরে ইনপুট দিয়ে <strong>"স্ট্যাটাস দেখুন"</strong> বাটনে ক্লিক করুন।</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('_partials.public-footer')
@endsection
