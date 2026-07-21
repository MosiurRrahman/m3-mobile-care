<!-- BEGIN: Vendor JS-->

<?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/popper/popper.js', 'resources/assets/vendor/js/bootstrap.js', 'resources/assets/vendor/libs/node-waves/node-waves.js', 'resources/assets/vendor/libs/@algolia/autocomplete-js.js']); ?>

<?php if($configData['hasCustomizer']): ?>
  <?php echo app('Illuminate\Foundation\Vite')('resources/assets/vendor/libs/pickr/pickr.js'); ?>
<?php endif; ?>

<?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js', 'resources/assets/vendor/libs/hammer/hammer.js', 'resources/assets/vendor/js/menu.js']); ?>

<?php echo $__env->yieldContent('vendor-script'); ?>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<?php echo app('Illuminate\Foundation\Vite')(['resources/assets/js/main.js']); ?>
<!-- END: Theme JS-->

<!-- Pricing Modal JS-->
<?php echo $__env->yieldPushContent('pricing-script'); ?>
<!-- END: Pricing Modal JS-->

<!-- BEGIN: Page JS-->
<?php echo $__env->yieldContent('page-script'); ?>
<!-- END: Page JS-->

<!-- app JS -->
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
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
    <?php if(session('success')): ?>
      iziToast.success({
        title: 'Success',
        message: '<?php echo e(addslashes(session('success'))); ?>',
        icon: 'ti tabler-circle-check',
      });
    <?php endif; ?>

    <?php if(session('error')): ?>
      iziToast.error({
        title: 'Error',
        message: '<?php echo e(addslashes(session('error'))); ?>',
        icon: 'ti tabler-alert-circle',
        timeout: 6000,
      });
    <?php endif; ?>

    <?php if(session('warning')): ?>
      iziToast.warning({
        title: 'Warning',
        message: '<?php echo e(addslashes(session('warning'))); ?>',
        icon: 'ti tabler-alert-triangle',
        timeout: 5500,
      });
    <?php endif; ?>

    <?php if(session('info')): ?>
      iziToast.info({
        title: 'Info',
        message: '<?php echo e(addslashes(session('info'))); ?>',
        icon: 'ti tabler-info-circle',
      });
    <?php endif; ?>

    <?php if($errors->any()): ?>
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $validationError): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        iziToast.error({
          title: 'Validation Error',
          message: '<?php echo e(addslashes($validationError)); ?>',
          icon: 'ti tabler-alert-circle',
          timeout: 6000,
        });
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  });
</script>

<?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/layouts/sections/scripts.blade.php ENDPATH**/ ?>