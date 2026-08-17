@extends('layouts/blankLayout')

@section('title', 'সার্ভিসসমূহ (Services) – ' . ($shopSettings['shop_name'] ?? 'M3 Mobile Care'))
@section('meta_description', 'M3 Mobile Care - ডিসপ্লে চেঞ্জ, ব্যাটারি রিপ্লেসমেন্ট, মাদারবোর্ড আইসি সার্ভিস, ওয়াটার ড্যামেজ ফিক্স ও সফটওয়্যার আনলকিং এর বিস্তারিত সেবা।')
@section('meta_keywords', 'M3 Mobile Care Services, Display Repair Ranisankail, Battery Replacement Thakurgaon, Motherboard IC Repair, Water Damage Repair')

@section('head_extra')
<!-- Premium Google Fonts -->
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
        --surface-card: #ffffff;
        --border-subtle: #e2e8f0;
        --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
        --shadow-md: 0 12px 32px rgba(15, 23, 42, 0.06);
        --shadow-hover: 0 20px 40px rgba(249, 115, 22, 0.12);
        --radius-lg: 20px;
        --radius-md: 12px;
        --radius-pill: 9999px;
    }

    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: var(--surface-light) !important;
        color: var(--body-text) !important;
        line-height: 1.65;
    }

    /* Page Hero Header */
    .services-page-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 70px 0 60px 0;
        position: relative;
    }

    .ux-service-detail-card {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: all 0.35s ease;
        box-shadow: var(--shadow-sm);
        height: 100%;
    }
    .ux-service-detail-card:hover {
        border-color: var(--brand-orange);
        box-shadow: var(--shadow-hover);
        transform: translateY(-6px);
    }

    .service-detail-img {
        height: 240px;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }
    .service-detail-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .ux-service-detail-card:hover .service-detail-img img {
        transform: scale(1.06);
    }

    .feature-list-check {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .feature-list-check li {
        position: relative;
        padding-left: 24px;
        margin-bottom: 8px;
        font-size: 0.88rem;
        color: #475569;
    }
    .feature-list-check li::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 0;
        color: #10b981;
        font-weight: 800;
    }

    .btn-ux-primary {
        background-color: var(--brand-orange) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 24px !important;
        border-radius: var(--radius-md) !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        box-shadow: 0 4px 14px rgba(249, 115, 22, 0.25) !important;
        transition: all 0.25s ease !important;
    }
    .btn-ux-primary:hover {
        background-color: var(--brand-orange-hover) !important;
        transform: translateY(-2px) !important;
    }
</style>

@include('_partials.public-navbar')

<main>
    <!-- PAGE HERO HEADER -->
    <section class="services-page-hero text-center">
        <div class="container">
            <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-3">
                <ol class="breadcrumb mb-0 fs-7">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-slate-400 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-warning fw-semibold" aria-current="page">Services</li>
                </ol>
            </nav>

            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-3">PROFESSIONAL REPAIR SOLUTIONS</span>
            <h1 class="text-white fw-extrabold display-5 mb-3">আমাদের প্রিমিয়াম মোবাইল সার্ভিসিং বিবরণ</h1>
            <p class="text-slate-300 fs-5 max-w-2xl mx-auto mb-4">
                Apple, Samsung, Xiaomi, Realme, Vivo, Oppo স্মার্টফোনের অরিজিনাল পার্টস ও অভিজ্ঞ ইঞ্জিনিয়ার দ্বারা ১০০% নিবেদিত সমাধান।
            </p>

            <!-- Hero Stats Strip -->
            <div class="d-flex flex-wrap justify-content-center gap-4 text-white fs-7 pt-3 border-top border-slate-800">
                <span><i class="ti tabler-shield-check text-success me-1"></i> ১০০% টেস্টেড অরিজিনাল পার্টস</span>
                <span><i class="ti tabler-bolt text-warning me-1"></i> ২০-৪৫ মিনিটে এক্সপ্রেস রিপেয়ার</span>
                <span><i class="ti tabler-award text-info me-1"></i> ৩০-৯০ দিনের লিখিত অফিশিয়াল ওয়ারেন্টি</span>
            </div>
        </div>
    </section>

    <!-- DETAILED SERVICES LIST SECTION -->
    <section class="py-5">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="fw-extrabold text-dark display-6 mb-2">প্রতিটি সার্ভিসের বিস্তারিত ফিচার ও সুবিধা</h2>
                <p class="text-muted fs-6">আপনার ফোনের সমস্যা সম্পর্কিত বিস্তারিত জেনে বিশ্বস্ততার সাথে সার্ভিস গ্রহণ করুন</p>
            </div>

            <div class="row g-4">
                
                <!-- SERVICE 1: DISPLAY REPAIR -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-detail-card d-flex flex-column">
                        <div class="service-detail-img">
                            <img src="{{ asset('assets/img/services/display_repair.jpg') }}" alt="Display Replacement Service">
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8">EXPRESS FIX</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">১. ডিসপ্লে & টাচ স্ক্রিন চেঞ্জ</h4>
                            <p class="text-muted fs-7 mb-3">
                                ডিসপ্লে ফেটে যাওয়া, কালো দাগ পড়া, টাচ কাজ না করা বা কালার ডিস্টোরশন সমস্যার ১০০% অরিজিনাল সমাধান।
                            </p>
                            
                            <h6 class="fw-bold text-dark fs-8 text-uppercase tracking-wider mb-2">সার্ভিস সুবিধা ও বৈশিষ্ট্য:</h6>
                            <ul class="feature-list-check flex-grow-1 mb-4">
                                <li>অরিজিনাল OLED / AMOLED ও গ্রেড-এ ডিসপ্লে প্যানেল</li>
                                <li>অরিজিনাল ব্রাইটনেস ও নিখুঁত টাচ রেসপন্স এর নিশ্চয়তা</li>
                                <li>গ্লাস ব্রোকেন হলে সুনির্দিষ্ট গ্লাস লেমিনেশন সুবিধা</li>
                                <li>পিক্সেল লস বা টাচ ল্যাগ ছাড়া পারফেক্ট ফিটিং</li>
                                <li>৩০ থেকে ৯০ দিনের অফিশিয়াল রিপ্লেসমেন্ট ওয়ারেন্টি</li>
                            </ul>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('ডিসপ্লে চেঞ্জ সার্ভিস সম্পর্কে জানতে চাই') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> তথ্য নিন
                                </a>
                                <a href="{{ route('book.form') }}" class="btn btn-ux-primary">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SERVICE 2: BATTERY REPLACEMENT -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-detail-card d-flex flex-column">
                        <div class="service-detail-img">
                            <img src="{{ asset('assets/img/services/battery_replacement.jpg') }}" alt="Battery Replacement Service">
                            <span class="badge bg-success text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8">90 DAYS WARRANTY</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">২. অরিজিনাল ব্যাটারি চেঞ্জ</h4>
                            <p class="text-muted fs-7 mb-3">
                                ফোন দ্রুত চার্জ শেষ হওয়া, ফোন অতিরিক্ত গরম হওয়া বা ব্যাটারি ফুলে ব্যাককাভার উঁচু হয়ে যাওয়ার স্থায়ী সমাধান।
                            </p>
                            
                            <h6 class="fw-bold text-dark fs-8 text-uppercase tracking-wider mb-2">সার্ভিস সুবিধা ও বৈশিষ্ট্য:</h6>
                            <ul class="feature-list-check flex-grow-1 mb-4">
                                <li>১০০% জেনুইন সেল ও অরিজিনাল এমএএইচ (mAh) ক্ষমতা</li>
                                <li>অতিরিক্ত হিট প্রটেকশন আইসি সিকিউরিটি চিপস</li>
                                <li>আইফোন ব্যাটারি হেলথ % নোটিফিকেশন রিস্টোর ব্যবস্থা</li>
                                <li>ফাস্ট চার্জিং প্রোটোকল সাপোর্ট</li>
                                <li>৯০ দিনের অফিশিয়াল পারফরম্যান্স গ্যারান্টি</li>
                            </ul>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('ব্যাটারি চেঞ্জ সার্ভিস সম্পর্কে জানতে চাই') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> তথ্য নিন
                                </a>
                                <a href="{{ route('book.form') }}" class="btn btn-ux-primary">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SERVICE 3: MOTHERBOARD IC REPAIR -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-detail-card d-flex flex-column">
                        <div class="service-detail-img">
                            <img src="{{ asset('assets/img/services/motherboard_repair.jpg') }}" alt="Motherboard Micro-soldering Service">
                            <span class="badge bg-primary text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8">SPECIALIST LAB</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">৩. মাদারবোর্ড ও আইসি ল্যাব</h4>
                            <p class="text-muted fs-7 mb-3">
                                ডেড ফোন সচল করা, শর্ট সার্কিট রিমুভ, পাওয়ার আইসি, নেটওয়ার্ক আইসি ও চার্জিং আইসি ক্র্যাশ মাইক্রো-সোল্ডারিং।
                            </p>
                            
                            <h6 class="fw-bold text-dark fs-8 text-uppercase tracking-wider mb-2">সার্ভিস সুবিধা ও বৈশিষ্ট্য:</h6>
                            <ul class="feature-list-check flex-grow-1 mb-4">
                                <li>হাই-প্রিসিশন মাইক্রোস্কোপ ল্যাবে নিখুঁত টেস্ট</li>
                                <li>পাওয়ার আইসি, চার্জিং আইসি, নেটওয়ার্ক আইসি রিবেলিং</li>
                                <li>অন্য কোথাও ঠিক না হওয়া জটিল ডেড ফোন সচল করা</li>
                                <li>ফোনের গুরুত্বপূর্ণ মেমোরি ডাটা অক্ষত রাখা</li>
                                <li>টেস্টিং শেষে আফটার-সার্ভিস ওয়ারেন্টি</li>
                            </ul>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('মাদারবোর্ড রিপেয়ার সার্ভিস সম্পর্কে জানতে চাই') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> তথ্য নিন
                                </a>
                                <a href="{{ route('book.form') }}" class="btn btn-ux-primary">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SERVICE 4: WATER DAMAGE RECOVERY -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-detail-card d-flex flex-column">
                        <div class="service-detail-img">
                            <img src="{{ asset('assets/img/services/water_damage_repair.jpg') }}" alt="Water Damage Recovery Service">
                            <span class="badge bg-info text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8">DATA SAFE</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">৪. ওয়াটার ড্যামেজ রিকভারি</h4>
                            <p class="text-muted fs-7 mb-3">
                                পানিতে পড়া, বৃষ্টিতে ভেজা বা কফি/তরল ঢুকে ফোন বন্ধ হয়ে যাওয়া সমস্যার আধুনিক ইলেকট্রনিক ড্রাই সলিউশন।
                            </p>
                            
                            <h6 class="fw-bold text-dark fs-8 text-uppercase tracking-wider mb-2">সার্ভিস সুবিধা ও বৈশিষ্ট্য:</h6>
                            <ul class="feature-list-check flex-grow-1 mb-4">
                                <li>স্পেশাল কেমিক্যাল ওয়াশ ও আল্ট্রাসনিক ডাই ক্লিনিং</li>
                                <li>সার্কিটের মরিচা ও অক্সিডেশন সম্পূর্ণ রিমুভ</li>
                                <li>মাদারবোর্ড শর্ট সার্কিট ডায়াগনস্টিক ও ফিক্স</li>
                                <li>ফোনের পার্সোনাল গ্যালারি ও ফাইল ১০০% রিকভারি</li>
                                <li>সেফটি চেকিং ও থার্মাল টেস্ট</li>
                            </ul>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('ওয়াটার ড্যামেজ সার্ভিস সম্পর্কে জানতে চাই') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> তথ্য নিন
                                </a>
                                <a href="{{ route('book.form') }}" class="btn btn-ux-primary">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SERVICE 5: SOFTWARE & UNLOCKING -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-detail-card d-flex flex-column">
                        <div class="service-detail-img">
                            <img src="{{ asset('assets/img/services/software_flashing.jpg') }}" alt="Software Unlock & Flashing Service">
                            <span class="badge bg-secondary text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8">OFFICIAL OS</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">৫. সফটওয়্যার ও আনলকিং</h4>
                            <p class="text-muted fs-7 mb-3">
                                প্যাটার্ন লক রিমুভ, FRP বাইপাস, লোগোতে আটকে থাকা, আইফোন আইক্লাউড আনলক ও অফিশিয়াল আপডেট সার্ভিস।
                            </p>
                            
                            <h6 class="fw-bold text-dark fs-8 text-uppercase tracking-wider mb-2">সার্ভিস সুবিধা ও বৈশিষ্ট্য:</h6>
                            <ul class="feature-list-check flex-grow-1 mb-4">
                                <li>অফিশিয়াল স্টক ফার্মওয়্যার ফ্ল্যাশিং সুবিধা</li>
                                <li>লোগো হ্যাং (Bootloop) সমস্যার তাৎক্ষণিক সলিউশন</li>
                                <li>Google FRP Lock & Password Unlock</li>
                                <li>আইফোন সিস্টেম রিকভারি ও আইক্লাউড হেল্প</li>
                                <li>সিকিউর ও ভাইরাস মুক্ত ওএস ইন্সটলেশন</li>
                            </ul>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('সফটওয়্যার আনলকিং সম্পর্কে জানতে চাই') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> তথ্য নিন
                                </a>
                                <a href="{{ route('book.form') }}" class="btn btn-ux-primary">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SERVICE 6: CAMERA & SPEAKER FIX -->
                <div class="col-lg-4 col-md-6">
                    <div class="ux-service-detail-card d-flex flex-column">
                        <div class="service-detail-img">
                            <img src="{{ asset('assets/img/services/camera_repair.jpg') }}" alt="Camera & Speaker Repair Service">
                            <span class="badge bg-dark text-white position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold fs-8">HARDWARE FIX</span>
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-2">৬. ক্যামেরা, স্পিকার & পোর্ট ফিক্স</h4>
                            <p class="text-muted fs-7 mb-3">
                                ক্যামেরা ঘোলা আসা, লেন্স গ্লাস ফেটে যাওয়া, স্পিকারে শব্দ না হওয়া বা চার্জিং পোর্টের লুজ কানেকশন ফিক্স।
                            </p>
                            
                            <h6 class="fw-bold text-dark fs-8 text-uppercase tracking-wider mb-2">সার্ভিস সুবিধা ও বৈশিষ্ট্য:</h6>
                            <ul class="feature-list-check flex-grow-1 mb-4">
                                <li>অরিজিনাল ক্যামেরা মডিউল ও ক্লিন গ্লাস চেঞ্জ</li>
                                <li>ইয়ার স্পিকার, রিংগার ও মাইক্রোফোন সার্ভিস</li>
                                <li>Type-C ও Lightning চার্জিং পোর্ট রি-সোল্ডারিং</li>
                                <li>ক্যামেরা ফোকাসিং ও অপটিক্যাল জুম ক্যালিব্রেশন</li>
                                <li>তাতক্ষণিক ডাস্ট স্পট ক্লিনিং</li>
                            </ul>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="https://wa.me/8801353106967?text={{ urlencode('ক্যামেরা ও স্পিকার ফিক্স সম্পর্কে জানতে চাই') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="ti tabler-brand-whatsapp me-1"></i> তথ্য নিন
                                </a>
                                <a href="{{ route('book.form') }}" class="btn btn-ux-primary">বুকিং দিন</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- DIRECT CONTACT CTA STAGE -->
    <section class="py-5 bg-white border-top">
        <div class="container">
            <div class="p-5 rounded-4 bg-dark text-white text-center shadow-lg">
                <h2 class="text-white fw-extrabold mb-3">আপনার ফোনের জন্য কোনটা ভালো সার্ভিস হবে জানতে চান?</h2>
                <p class="text-slate-300 fs-6 max-w-2xl mx-auto mb-4">
                    আমাদের সার্ভিস সেন্টারে সরাসরি চলে আসুন অথবা কল দিয়ে বিনামূল্যে আমাদের বিশেষজ্ঞ চিপ-লেভেল টেকনিশিয়ানের পরামর্শ নিন।
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="tel:+8801353106967" class="btn btn-warning fw-bold px-4 py-3 rounded-3">
                        <i class="ti tabler-phone-call me-1.5"></i> কল দিন: +8801353106967
                    </a>
                    <a href="{{ route('book.form') }}" class="btn btn-orange text-white fw-bold px-4 py-3 rounded-3" style="background-color: #f97316;">
                        <i class="ti tabler-calendar-plus me-1.5"></i> অনলাইন বুকিং দিন
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

@include('_partials.public-footer')
@endsection
