<!-- BEGIN: Vendor JS-->

@vite(['resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/popper/popper.js', 'resources/assets/vendor/js/bootstrap.js', 'resources/assets/vendor/libs/node-waves/node-waves.js', 'resources/assets/vendor/libs/@algolia/autocomplete-js.js'])

@if ($configData['hasCustomizer'])
  @vite('resources/assets/vendor/libs/pickr/pickr.js')
@endif

@vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js', 'resources/assets/vendor/libs/hammer/hammer.js', 'resources/assets/vendor/js/menu.js'])

@yield('vendor-script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/main.js'])
<!-- END: Theme JS-->

<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->

<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<!-- app JS -->
@vite(['resources/js/app.js'])
<!-- END: app JS-->

<!-- Toast Notifications (iziToast) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script>
  // Global iziToast defaults
  iziToast.settings({
    timeout: 4500,
    resetOnHover: true,
    transitionIn: 'bounceInLeft',
    transitionOut: 'fadeOutRight',
    position: 'topRight',
    displayMode: 'replace',
    close: true,
    progressBar: true,
    progressBarColor: 'rgba(255,255,255,0.5)',
  });

  // Fire Laravel flash messages as toasts
  document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
      iziToast.success({
        title: 'Success',
        message: '{{ addslashes(session('success')) }}',
        icon: 'ti tabler-circle-check',
      });
    @endif

    @if(session('error'))
      iziToast.error({
        title: 'Error',
        message: '{{ addslashes(session('error')) }}',
        icon: 'ti tabler-alert-circle',
        timeout: 6000,
      });
    @endif

    @if(session('warning'))
      iziToast.warning({
        title: 'Warning',
        message: '{{ addslashes(session('warning')) }}',
        icon: 'ti tabler-alert-triangle',
        timeout: 5500,
      });
    @endif

    @if(session('info'))
      iziToast.info({
        title: 'Info',
        message: '{{ addslashes(session('info')) }}',
        icon: 'ti tabler-info-circle',
      });
    @endif

    @if($errors->any())
      @foreach($errors->all() as $validationError)
        iziToast.error({
          title: 'Validation Error',
          message: '{{ addslashes($validationError) }}',
          icon: 'ti tabler-alert-circle',
          timeout: 6000,
        });
      @endforeach
    @endif
  });
</script>

