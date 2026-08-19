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
    .btn-orange-gradient {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        border: none !important;
        color: #ffffff !important;
        padding: 14px 28px !important;
        border-radius: 12px !important;
        font-weight: 700 !important;
        font-size: 1.05rem !important;
        box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35) !important;
        transition: all 0.3s ease !important;
        cursor: pointer;
    }
    .btn-orange-gradient:hover {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.45) !important;
        color: #ffffff !important;
    }
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
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 p-3 shadow-xs" role="alert">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                <div class="d-flex align-items-center">
                    <i class="ti tabler-circle-check fs-2 text-success me-2.5"></i>
                    <div>
                        <strong class="d-block text-dark fw-bold">বার্তা সফলভাবে পাঠানো হয়েছে!</strong>
                        <span class="text-secondary small">{{ session('success') }}</span>
                    </div>
                </div>
                @if(session('whatsapp_url'))
                    <a href="{{ session('whatsapp_url') }}" target="_blank" class="btn btn-success btn-sm px-3 py-2 fw-bold text-white shadow-xs text-nowrap">
                        <i class="ti tabler-brand-whatsapp me-1"></i> হোয়াটসঅ্যাপে মেসেজ পাঠান
                    </a>
                @endif
            </div>
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
                        <p class="text-secondary fs-7 mb-0">{{ $shopSettings['address'] ?? '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও' }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="btn btn-success rounded-circle p-3 me-3 text-white"><i class="ti tabler-phone-call fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">হটলাইন কল:</h6>
                        <p class="text-secondary fs-7 mb-0">{{ $shopSettings['phone'] ?? '+8801353106967 / +8801353106966' }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="btn btn-info rounded-circle p-3 me-3 text-white"><i class="ti tabler-brand-whatsapp fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">হোয়াটসঅ্যাপ:</h6>
                        @php
                            $waNum = preg_replace('/[^0-9]/', '', $shopSettings['whatsapp'] ?? '8801353106967');
                        @endphp
                        <p class="text-secondary fs-7 mb-0">
                            <a href="https://wa.me/{{ $waNum }}" target="_blank" class="text-decoration-none text-info fw-bold">{{ $shopSettings['whatsapp'] ?? '+8801353106967' }}</a>
                        </p>
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
                
                <!-- Dynamic AJAX Alert Box -->
                <div id="ajaxContactAlert" class="alert alert-success alert-dismissible fade show mb-4 rounded-3 p-3 shadow-xs d-none" role="alert">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-circle-check fs-2 text-success me-2.5"></i>
                            <div>
                                <strong class="d-block text-dark fw-bold">বার্তা সফলভাবে পাঠানো হয়েছে!</strong>
                                <span id="ajaxAlertMessage" class="text-secondary small">আপনার বার্তাটি সংরক্ষিত হয়েছে এবং হোয়াটসঅ্যাপে পাঠানো হচ্ছে...</span>
                            </div>
                        </div>
                        <a id="ajaxAlertWaBtn" href="#" target="_blank" class="btn btn-success btn-sm px-3 py-2 fw-bold text-white shadow-xs text-nowrap">
                            <i class="ti tabler-brand-whatsapp me-1"></i> হোয়াটসঅ্যাপে মেসেজ পাঠান
                        </a>
                    </div>
                    <button type="button" class="btn-close" onclick="document.getElementById('ajaxContactAlert').classList.add('d-none')"></button>
                </div>

                <form id="contactForm" action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7" for="c_name">আপনার নাম <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="c_name" class="form-control form-control-lg" placeholder="যেমন: রহিম আহমেদ" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold fs-7" for="c_phone">মোবাইল নাম্বার <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" id="c_phone" class="form-control form-control-lg" placeholder="017XXXXXXXX" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold fs-7" for="c_message">বার্তা / বিবরণ <span class="text-danger">*</span></label>
                            <textarea name="message" id="c_message" rows="4" class="form-control" placeholder="আপনার ডিভাইসের সমস্যা বা সার্ভিস সম্পর্কে বিস্তারিত লিখুন..." required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="btnSubmitContact" class="btn btn-orange-gradient btn-lg w-100 fw-bold shadow-sm">
                                <i class="ti tabler-send me-1"></i> বার্তা পাঠান ও হোয়াটসঅ্যাপে যুক্ত হোন
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('btnSubmitContact');
        const alertBox = document.getElementById('ajaxContactAlert');
        const alertMessage = document.getElementById('ajaxAlertMessage');
        const alertWaBtn = document.getElementById('ajaxAlertWaBtn');

        if (!form) return;

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const name = document.getElementById('c_name').value.trim();
            const phone = document.getElementById('c_phone').value.trim();
            const message = document.getElementById('c_message').value.trim();

            if (!name || !phone || !message) {
                form.submit(); // fallback
                return;
            }

            // Disable button during send
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>সংরক্ষণ ও হোয়াটসঅ্যাপে রিডাইরেক্ট হচ্ছে...';

            // Build direct WhatsApp link
            let shopWa = "{{ preg_replace('/[^0-9]/', '', $shopSettings['whatsapp'] ?? '8801353106967') }}";
            if (shopWa.startsWith('01')) {
                shopWa = '88' + shopWa;
            } else if (!shopWa.startsWith('880')) {
                shopWa = '8801353106967';
            }

            const waText = "নমস্কার M3 Mobile Care,\n\n👤 নাম: " + name + "\n📞 মোবাইল: " + phone + "\n💬 বার্তা: " + message;
            const waUrl = "https://api.whatsapp.com/send?phone=" + shopWa + "&text=" + encodeURIComponent(waText);

            try {
                // Send AJAX to server to save in Admin Panel
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                const targetWaUrl = data.whatsapp_url || waUrl;

                // Show success in UI
                alertBox.classList.remove('d-none');
                alertMessage.textContent = 'আপনার বার্তাটি অ্যাডমিন প্যানেলে সংরক্ষিত হয়েছে। হোয়াটসঅ্যাপে সেন্ড করুন...';
                alertWaBtn.href = targetWaUrl;

                // Reset form fields
                form.reset();

                // Direct open WhatsApp
                const newWin = window.open(targetWaUrl, '_blank');
                if (!newWin || newWin.closed || typeof newWin.closed == 'undefined') {
                    window.location.href = targetWaUrl;
                }
            } catch (err) {
                // On any network failure, directly launch WhatsApp so customer never gets stuck
                alertBox.classList.remove('d-none');
                alertWaBtn.href = waUrl;
                const newWin = window.open(waUrl, '_blank');
                if (!newWin || newWin.closed || typeof newWin.closed == 'undefined') {
                    window.location.href = waUrl;
                }
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    });
</script>

@include('_partials.public-footer')
@endsection
