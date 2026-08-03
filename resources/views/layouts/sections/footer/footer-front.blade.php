<!-- Footer: Start -->
<footer class="landing-footer bg-body footer-text">
  <div class="footer-top position-relative overflow-hidden z-1">
    <div class="container">
      <div class="row gx-0 gy-6 g-lg-10">
        <div class="col-lg-6">
          <a href="{{ url('/') }}" class="app-brand-link mb-4">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">{{ config('variables.templateName') }}</span>
          </a>
          <p class="footer-text footer-logo-description mb-4">M3 Mobile Care - Bangladesh's leading smartphone repair & diagnostic platform. Screen replacements, motherboard micro-soldering, and live status tracking.</p>
        </div>
        <div class="col-lg-6 text-lg-end">
          <h6 class="footer-title mb-4">Quick Navigation</h6>
          <ul class="list-unstyled d-flex flex-wrap justify-content-lg-end gap-3">
            <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
            <li><a href="{{ route('book.form') }}" class="footer-link">Book Repair</a></li>
            <li><a href="{{ route('track.form') }}" class="footer-link">Track Ticket</a></li>
            <li><a href="{{ url('/sitemap.xml') }}" class="footer-link" target="_blank">Sitemap</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom py-3 py-md-5">
    <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
      <div class="mb-2 mb-md-0">
        <span class="footer-bottom-text">© {{ date('Y') }} </span>
        <a href="{{ config('variables.creatorUrl') }}" target="_blank" class="fw-medium text-white">{{ config('variables.creatorName') }}</a>.
        <span class="footer-bottom-text"> All rights reserved.</span>
      </div>
      <div>
        @if(config('variables.facebookUrl'))
        <a href="{{ config('variables.facebookUrl') }}" class="me-2 text-white" target="_blank" aria-label="Facebook">
          <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.8609 18.0262V11.1962H14.1651L14.5076 8.52204H11.8609V6.81871C11.8609 6.04704 12.0759 5.51871 13.1834 5.51871H14.5868V3.13454C13.904 3.06136 13.2176 3.02603 12.5309 3.02871C10.4943 3.02871 9.09593 4.27204 9.09593 6.55454V8.51704H6.80676V11.1912H9.10093V18.0262H11.8609Z" fill="currentColor" />
          </svg>
        </a>
        @endif
      </div>
    </div>
  </div>
</footer>
<!-- Footer: End -->
