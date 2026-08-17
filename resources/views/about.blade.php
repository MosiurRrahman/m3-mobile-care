@extends('layouts/blankLayout')

@section('title', 'আমাদের সম্পর্কে (About Us) – ' . ($shopSettings['shop_name'] ?? 'M3 Mobile Care'))
@section('meta_description', 'M3 Mobile Care - রাণীশংকৈল, ঠাকুরগাঁও এর সেরা প্রিমিয়াম মোবাইল সার্ভিসিং ও চিপ-লেভেল রিপেয়ার সেন্টার। আমাদের ইতিহাস, মিশন ও প্রযুক্তি সম্পর্কে বিস্তারিত জানুন।')
@section('meta_keywords', 'About M3 Mobile Care, Ranisankail Mobile Shop, Thakurgaon Electronics Repair, Mobile Technician Ranisankail')

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
        --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
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

    .about-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 70px 0 60px 0;
        position: relative;
    }

    .about-feature-box {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        padding: 32px 24px;
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: var(--shadow-sm);
    }
    .about-feature-box:hover {
        border-color: var(--brand-orange);
        box-shadow: var(--shadow-md);
        transform: translateY(-4px);
    }

    .about-icon-circle {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(249, 115, 22, 0.08);
        color: var(--brand-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 20px;
    }
</style>

@include('_partials.public-navbar')

<main>
    <!-- PAGE HERO HEADER -->
    <section class="about-hero-header text-center">
        <div class="container">
            <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-3">
                <ol class="breadcrumb mb-0 fs-7">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-slate-400 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active text-warning fw-semibold" aria-current="page">About Us</li>
                </ol>
            </nav>

            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-3 fs-7">
                ABOUT M3 MOBILE CARE
            </span>
            <h1 class="text-white fw-extrabold display-5 mb-3">আমাদের লক্ষ্য, দর্শন ও পথচলা</h1>
            <p class="text-slate-300 fs-5 max-w-2xl mx-auto mb-4">
                (বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও এ আপনার একমাত্র নির্ভরযোগ্য ও প্রফেশনাল মোবাইল সার্ভিসিং ল্যাব।
            </p>

            <!-- Key Stats Strip -->
            <div class="d-flex flex-wrap justify-content-center gap-4 text-white fs-7 pt-3 border-top border-slate-800">
                <span><i class="ti tabler-calendar-event text-warning me-1"></i> ১০+ বছরের অভিজ্ঞতা</span>
                <span><i class="ti tabler-check text-success me-1"></i> ১৫,০০০+ সফল রিপেয়ার</span>
                <span><i class="ti tabler-shield-check text-info me-1"></i> ১০০% অরিজিনাল পার্টস</span>
                <span><i class="ti tabler-thumb-up text-primary me-1"></i> ৯৯% কাস্টমার সন্তুষ্টি</span>
            </div>
        </div>
    </section>

    <!-- CORE MISSION & VISION STORY -->
    <section class="py-5">
        <div class="container py-3">
            <div class="row align-items-center g-5 mb-5">
                <div class="col-lg-6">
                    <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold mb-2">OUR STORY & VISION</span>
                    <h2 class="fw-extrabold text-dark display-6 mb-3">কেন M3 Mobile Care অঞ্চলে অনন্য?</h2>
                    <p class="text-secondary fs-6 lh-lg mb-3">
                        <strong>M3 Mobile Care</strong> কেবল সাধারণ একটি মোবাইল মেরামতের দোকান নয়, এটি রাণীশংকৈল ও ঠাকুরগাঁও অঞ্চলের গ্রাহকদের কাছে আধুনিক হাই-টেক চিপ-লেভেল ইলেকট্রনিক্স রিপেয়ারিংয়ের বিশ্বস্ত প্রতীক।
                    </p>
                    <p class="text-secondary fs-6 lh-lg mb-4">
                        আমাদের ল্যাবে রয়েছে উচ্চ ক্ষমতার অপটিক্যাল মাইক্রোস্কোপ, স্মডি রিওয়ার্ক স্টেশন ও হাই-প্রিসিশন টেস্ট ইকুয়েপমেন্ট। আমরা বিশ্বাস করি গ্রাহকের সখের স্মার্টফোনটি কেবল একটি ডিভাইস নয়, এতে থাকে তাদের ব্যক্তিগত স্মৃতি, পরিচিতি ও কাজের মূল্যবান ডাটা। তাই আমরা শতভাগ স্বচ্ছতায় সেবা প্রদান করি।
                    </p>

                    <div class="p-3.5 bg-white border-start border-4 border-warning rounded-end shadow-sm">
                        <p class="mb-0 fw-bold text-dark fs-7">
                            "আমাদের মূল অঙ্গীকার হলো— কোনো কাল্পনিক চার্জ ছাড়াই সঠিক রোগ নির্ণয় এবং ১০০% অরিজিনাল পার্টস দিয়ে ডিভাইসের দীর্ঘমেয়াদী স্থায়িত্ব নিশ্চিত করা।"
                        </p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="p-4 bg-white rounded-4 border shadow-md text-center">
                        <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care Logo" class="img-fluid mb-3" style="max-height: 110px;">
                        <h3 class="fw-extrabold text-dark mb-1">M3 Mobile Care</h3>
                        <p class="text-muted fs-7 mb-4">Premier Mobile Repair & Technical Service Center</p>
                        
                        <div class="bg-light p-3.5 rounded-3 text-start border d-flex flex-column gap-2.5">
                            <div class="d-flex align-items-start">
                                <i class="ti tabler-map-pin text-orange me-2 fs-5 mt-0.5"></i>
                                <span><strong>ঠিকানা:</strong> (বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti tabler-phone-call text-success me-2 fs-5"></i>
                                <span><strong>হটলাইন:</strong> +8801353106967 / +8801353106966</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti tabler-clock text-info me-2 fs-5"></i>
                                <span><strong>সময়সূচী:</strong> প্রতিদিন সকাল ৯:০০ টা - রাত ৯:৩০ টা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5 CORE CUSTOMER COMMITMENTS -->
    <section class="py-5 bg-white border-y">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-2">OUR PROMISES</span>
                <h2 class="fw-extrabold text-dark display-6 mb-2">আমাদের ৫টি মূল প্রতিশ্রুতি</h2>
                <p class="text-muted fs-6">যেসব নীতির কারণে প্রতিদিন শত শত কাস্টমার আমাদের বেছে নেন</p>
            </div>

            <div class="row g-4">
                <!-- Promise 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="about-feature-box">
                        <div class="about-icon-circle"><i class="ti tabler-eye"></i></div>
                        <h4 class="fw-bold text-dark mb-2">১. শতভাগ স্বচ্ছতা</h4>
                        <p class="text-muted fs-7 mb-0">
                            কোনো হিডেন চার্জ ছাড়াই ফোন চেকের পর কাস্টমারকে সঠিক সমস্যা ও খরচ জানিয়ে অনুমতি নেওয়া হয়।
                        </p>
                    </div>
                </div>

                <!-- Promise 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="about-feature-box">
                        <div class="about-icon-circle"><i class="ti tabler-shield-lock"></i></div>
                        <h4 class="fw-bold text-dark mb-2">২. সম্পূর্ণ ডাটা নিরাপত্তা</h4>
                        <p class="text-muted fs-7 mb-0">
                            ফোন মেরামতের সময় গ্রাহকের ছবি, মেসেজ ও ফাইলস ১০০% নিরাপদ থাকে। কোনো ডাটা লস হয় না।
                        </p>
                    </div>
                </div>

                <!-- Promise 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="about-feature-box">
                        <div class="about-icon-circle"><i class="ti tabler-cpu"></i></div>
                        <h4 class="fw-bold text-dark mb-2">৩. হাই-টেক চিপ ল্যাব</h4>
                        <p class="text-muted fs-7 mb-0">
                            অন্য সাধারণ দোকানে ঠিক না হওয়া পানির ডেড ফোন ও লজিক বোর্ড ক্র্যাশ সচল করার মাইক্রো-সোল্ডারিং ল্যাব।
                        </p>
                    </div>
                </div>

                <!-- Promise 4 -->
                <div class="col-lg-4 col-md-6">
                    <div class="about-feature-box">
                        <div class="about-icon-circle"><i class="ti tabler-award"></i></div>
                        <h4 class="fw-bold text-dark mb-2">৪. লিখিত অফিশিয়াল ওয়ারেন্টি</h4>
                        <p class="text-muted fs-7 mb-0">
                            প্রতিটি সার্ভিস ও পার্টসের সাথে ৩০ দিন থেকে ৯০ দিনের মেমো সহ অফিশিয়াল ওয়ারেন্টি কার্ড প্রদান।
                        </p>
                    </div>
                </div>

                <!-- Promise 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="about-feature-box">
                        <div class="about-icon-circle"><i class="ti tabler-activity"></i></div>
                        <h4 class="fw-bold text-dark mb-2">৫. ERT লাইভ ট্র্যাকিং</h4>
                        <p class="text-muted fs-7 mb-0">
                            ডিজিটাল টিকিট নাম্বার দিয়ে ঘরে বসেই ওয়েবসাইট থেকে রিপেয়ার কাজের স্ট্যাটাস ট্র্যাকিং সুবিধা।
                        </p>
                    </div>
                </div>

                <!-- Promise 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="about-feature-box">
                        <div class="about-icon-circle"><i class="ti tabler-bolt"></i></div>
                        <h4 class="fw-bold text-dark mb-2">৬. তাতক্ষণিক এক্সপ্রেস ডেলিভারি</h4>
                        <p class="text-muted fs-7 mb-0">
                            জরুরী ডিসপ্লে ও ব্যাটারি চেঞ্জের কাজ মাত্র ২০ থেকে ৪৫ মিনিটের মধ্যে সম্পন্ন করে হ্যান্ডওভার।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LAB EQUIPMENT & TECHNICAL CAPABILITIES -->
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-dark text-white px-3 py-1.5 rounded-pill fw-bold mb-2">LAB EQUIPMENT</span>
                <h2 class="fw-extrabold text-dark display-6 mb-2">আমাদের আধুনিক ল্যাব প্রযুক্তি</h2>
                <p class="text-muted fs-6">বিশ্বমানের আধুনিক সরঞ্জাম যা নিখুঁত ও স্থায়ী রিপেয়ার নিশ্চিত করে</p>
            </div>

            <div class="row g-4 text-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="p-4 bg-white border rounded-4 shadow-sm h-100">
                        <i class="ti tabler-microscope text-primary display-4 mb-3 d-block"></i>
                        <h5 class="fw-bold text-dark mb-2">অপটিক্যাল মাইক্রোস্কোপ</h5>
                        <p class="text-muted fs-7 mb-0">মাদারবোর্ডের সূক্ষ্ম শর্ট সার্কিট ও আইসি ট্র্যাক ডায়াগনস্টিক করা হয়।</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="p-4 bg-white border rounded-4 shadow-sm h-100">
                        <i class="ti tabler-droplet-off text-info display-4 mb-3 d-block"></i>
                        <h5 class="fw-bold text-dark mb-2">আল্ট্রাসনিক কেমিক্যাল ওয়াশ</h5>
                        <p class="text-muted fs-7 mb-0">পানিতে পড়া ফোনের ইলেকট্রনিক কয়েল ও সার্কিট অক্সিডেশন ড্রাই ওয়াশ।</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="p-4 bg-white border rounded-4 shadow-sm h-100">
                        <i class="ti tabler-device-desktop-analytics text-warning display-4 mb-3 d-block"></i>
                        <h5 class="fw-bold text-dark mb-2">ডিজিটাল ডিসপ্লে লেমিনেটর</h5>
                        <p class="text-muted fs-7 mb-0">অরিজিনাল ডিসপ্লে বা গ্লাস বাবল-ফ্রি নিখুঁত লেমিনেশন মেশিন।</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="p-4 bg-white border rounded-4 shadow-sm h-100">
                        <i class="ti tabler-brand-android text-success display-4 mb-3 d-block"></i>
                        <h5 class="fw-bold text-dark mb-2">অফিশিয়াল ওএস ফ্ল্যাশার</h5>
                        <p class="text-muted fs-7 mb-0">লোগো হ্যাং, প্যাটার্ন লক ও FRP আনলকের অফিশিয়াল সফটওয়্যার বক্স।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DIRECT LOCATION & CALL STAGE -->
    <section class="py-5 bg-white border-top">
        <div class="container">
            <div class="p-5 rounded-4 bg-dark text-white text-center shadow-lg">
                <h2 class="text-white fw-extrabold mb-3">আমাদের সাথে সরাসরি যোগাযোগ করুন</h2>
                <p class="text-slate-300 fs-6 max-w-2xl mx-auto mb-4">
                    আপনার ফোনের যেকোনো সমস্যা বা জিজ্ঞাসায় সরাসরি ফোন দিন অথবা আমাদের আউটলেটে চলে আসুন।
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="tel:+8801353106967" class="btn btn-warning fw-bold px-4 py-3 rounded-3">
                        <i class="ti tabler-phone-call me-1.5"></i> কল দিন: +8801353106967
                    </a>
                    <a href="https://wa.me/8801353106967" target="_blank" class="btn btn-success fw-bold px-4 py-3 rounded-3">
                        <i class="ti tabler-brand-whatsapp me-1.5"></i> WhatsApp মেসেজ
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light px-4 py-3 rounded-3 fw-semibold">
                        যোগাযোগ পেজে যান
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

@include('_partials.public-footer')
@endsection
