<!-- Public Footer Section -->
<footer style="background-color: #0f172a;" class="text-slate-300 pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-4 pb-5 border-bottom border-slate-800">
            <!-- Col 1: Shop Brand & About -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care Logo" width="42" height="42" class="me-2.5">
                    <span class="fs-4 fw-extrabold text-white" style="font-family: 'Outfit', sans-serif;">M3 <span style="color: #f37021;">MOBILE CARE</span></span>
                </div>
                <p class="text-slate-400 fs-7 lh-base mb-4">
                    বিশ্বস্ত ও আধুনিক প্রযুক্তিসম্পন্ন মোবাইল সার্ভিসিং সেন্টার। আমাদের অভিজ্ঞ টেকনিশিয়ান দ্বারা আমরা সর্বোচ্চ মানের ডিসপ্লে, ব্যাটারি ও মাদারবোর্ড সার্ভিস প্রদান করি।
                </p>
                <div class="d-flex gap-2">
                    <a href="https://www.facebook.com/m3mobilecare" target="_blank" class="btn btn-sm btn-dark rounded-circle p-2 text-primary bg-slate-800 border-0" aria-label="Facebook"><i class="ti tabler-brand-facebook fs-5"></i></a>
                    <a href="https://wa.me/8801353106967" target="_blank" class="btn btn-sm btn-dark rounded-circle p-2 text-success bg-slate-800 border-0" aria-label="WhatsApp"><i class="ti tabler-brand-whatsapp fs-5"></i></a>
                    <a href="tel:+8801353106967" class="btn btn-sm btn-dark rounded-circle p-2 text-info bg-slate-800 border-0" aria-label="Call"><i class="ti tabler-phone-call fs-5"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-lg-2 col-md-6 ms-lg-auto">
                <h6 class="text-white fw-bold mb-3">কুইক লিংকস (Links)</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-7 mb-0">
                    <li><a href="{{ route('home') }}" class="text-slate-400 text-decoration-none hover-text-warning"><i class="ti tabler-chevron-right fs-8 me-1"></i> হোম (Home)</a></li>
                    <li><a href="{{ route('services') }}" class="text-slate-400 text-decoration-none hover-text-warning"><i class="ti tabler-chevron-right fs-8 me-1"></i> সার্ভিসসমূহ</a></li>
                    <li><a href="{{ route('track.form') }}" class="text-slate-400 text-decoration-none hover-text-warning"><i class="ti tabler-chevron-right fs-8 me-1"></i> ERT ট্র্যাকিং</a></li>
                    <li><a href="{{ route('about') }}" class="text-slate-400 text-decoration-none hover-text-warning"><i class="ti tabler-chevron-right fs-8 me-1"></i> আমাদের সম্পর্কে</a></li>
                    <li><a href="{{ route('contact') }}" class="text-slate-400 text-decoration-none hover-text-warning"><i class="ti tabler-chevron-right fs-8 me-1"></i> যোগাযোগ</a></li>
                </ul>
            </div>

            <!-- Col 3: Popular Services -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3">পপুলার সার্ভিসেস</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-7 mb-0">
                    <li><span class="text-slate-400"><i class="ti tabler-check text-success me-1"></i> ১৬০+ ডিসপ্লে রিপ্লেসমেন্ট</span></li>
                    <li><span class="text-slate-400"><i class="ti tabler-check text-success me-1"></i> অরজিনাল ব্যাটারি চেঞ্জ</span></li>
                    <li><span class="text-slate-400"><i class="ti tabler-check text-success me-1"></i> আইসি ও মাদারবোর্ড রিপেয়ার</span></li>
                    <li><span class="text-slate-400"><i class="ti tabler-check text-success me-1"></i> ওয়াটার ড্যামেজ সলিউশন</span></li>
                    <li><span class="text-slate-400"><i class="ti tabler-check text-success me-1"></i> সফটওয়্যার ও আনলকিং</span></li>
                </ul>
            </div>

            <!-- Col 4: Address & Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white fw-bold mb-3">যোগাযোগের ঠিকানা</h6>
                <ul class="list-unstyled d-flex flex-column gap-2.5 fs-7 mb-0 text-slate-400">
                    <li class="d-flex align-items-start">
                        <i class="ti tabler-map-pin text-warning me-2 fs-5 mt-0.5"></i>
                        <span>(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ti tabler-phone-call text-success me-2 fs-5"></i>
                        <a href="tel:+8801353106967" class="text-slate-400 text-decoration-none">+8801353106967 / +8801353106966</a>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ti tabler-mail text-info me-2 fs-5"></i>
                        <span>support@m3mobilecares.com</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ti tabler-clock text-warning me-2 fs-5"></i>
                        <span>প্রতিদিন সকাল ৯:০০ - রাত ৯:৩০</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center pt-4 fs-7 text-slate-500">
            <p class="mb-0">© {{ date('Y') }} <strong>M3 Mobile Care</strong>. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Action Button -->
<a href="https://wa.me/8801353106967" target="_blank" class="floating-whatsapp-btn shadow-lg" aria-label="Contact us on WhatsApp">
    <i class="ti tabler-brand-whatsapp fs-2"></i>
    <span class="tooltip-text">কথা বলুন WhatsApp-এ</span>
</a>

<style>
    .text-slate-300 { color: #cbd5e1 !important; }
    .text-slate-400 { color: #94a3b8 !important; }
    .text-slate-500 { color: #64748b !important; }
    .border-slate-800 { border-color: #1e293b !important; }
    .bg-slate-800 { background-color: #1e293b !important; }
    .hover-text-warning:hover { color: #f59e0b !important; }
    .hover-text-success:hover { color: #10b981 !important; }
    
    .floating-whatsapp-btn {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 56px;
        height: 56px;
        background-color: #25d366;
        color: #ffffff !important;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4) !important;
    }
    .floating-whatsapp-btn:hover {
        transform: scale(1.1);
        background-color: #20ba5a;
        color: #ffffff !important;
    }
    .floating-whatsapp-btn .tooltip-text {
        visibility: hidden;
        width: 150px;
        background-color: #1e293b;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 6px 10px;
        position: absolute;
        z-index: 1;
        right: 68px;
        font-size: 0.8rem;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .floating-whatsapp-btn:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
</style>
