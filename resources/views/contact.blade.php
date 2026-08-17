@extends('layouts/blankLayout')

@section('title', 'যোগাযোগ (Contact Us) – ' . ($shopSettings['shop_name'] ?? 'M3 Mobile Care'))
@section('meta_description', 'M3 Mobile Care - সরাসরি কল করুন বা আমাদের রাণীশংকৈল আউটলেটে ভিজিট করুন।')

@section('head_extra')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
@endsection

@section('content')
<style>
    body { font-family: 'Outfit', sans-serif !important; background-color: #f8fafc !important; }
    .contact-hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 60px 0; }
    .contact-card { background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03); }
</style>

@include('_partials.public-navbar')

<div class="contact-hero text-center">
    <div class="container">
        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold mb-3">GET IN TOUCH</span>
        <h1 class="text-white fw-extrabold display-5 mb-3">আমাদের সাথে যোগাযোগ করুন</h1>
        <p class="text-slate-300 fs-5 max-w-2xl mx-auto">
            যেকোনো প্রশ্ন বা রিপেয়ার সংক্রান্ত তথ্যের জন্য সরাসরি কল করুন অথবা নীচের ফর্মে মেসেজ পাঠান।
        </p>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="ti tabler-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Contact Info Cards -->
        <div class="col-lg-5">
            <div class="contact-card h-100">
                <h4 class="fw-extrabold text-dark mb-4">আউটলেট পরিচিতি</h4>

                <div class="d-flex align-items-start mb-4">
                    <div class="btn btn-warning rounded-circle p-3 me-3 text-dark"><i class="ti tabler-map-pin fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">ঠিকানা:</h6>
                        <p class="text-secondary fs-7 mb-0">(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="btn btn-success rounded-circle p-3 me-3 text-white"><i class="ti tabler-phone-call fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">হটলাইন কল:</h6>
                        <p class="text-secondary fs-7 mb-0">+8801353106967 / +8801353106966</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="btn btn-info rounded-circle p-3 me-3 text-white"><i class="ti tabler-brand-whatsapp fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">হোয়াটসঅ্যাপ:</h6>
                        <p class="text-secondary fs-7 mb-0">+8801353106967</p>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <div class="btn btn-primary rounded-circle p-3 me-3 text-white"><i class="ti tabler-clock fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">শপের সময়সূচী:</h6>
                        <p class="text-secondary fs-7 mb-0">প্রতিদিন সকাল ৯:০০ টা - রাত ৯:৩০ টা</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Message Form -->
        <div class="col-lg-7">
            <div class="contact-card">
                <h4 class="fw-extrabold text-dark mb-4">মেসেজ পাঠান</h4>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">আপনার নাম <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="যেমন: রহিম আহমেদ" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7">মোবাইল নাম্বার <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control form-control-lg" placeholder="017XXXXXXXX" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold fs-7">বার্তা / বিবরণ <span class="text-danger">*</span></label>
                            <textarea name="message" rows="4" class="form-control" placeholder="আপনার ডিভাইসের সমস্যা বা সার্ভিস সম্পর্কে বিস্তারিত লিখুন..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-orange-gradient btn-lg text-white w-100 fw-bold shadow-sm">
                                <i class="ti tabler-send me-1"></i> বার্তা পাঠান
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('_partials.public-footer')
@endsection
