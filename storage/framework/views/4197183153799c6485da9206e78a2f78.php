<!DOCTYPE html>
<?php
  use Illuminate\Support\Str;
  use App\Helpers\Helpers;

  $menuFixed =
      $configData['layout'] === 'vertical'
          ? $menuFixed ?? ''
          : ($configData['layout'] === 'front'
              ? ''
              : $configData['headerType']);
  $navbarType =
      $configData['layout'] === 'vertical'
          ? $configData['navbarType']
          : ($configData['layout'] === 'front'
              ? 'layout-navbar-fixed'
              : '');
  $isFront = ($isFront ?? '') == true ? 'Front' : '';
  $contentLayout = isset($container) ? ($container === 'container-xxl' ? 'layout-compact' : 'layout-wide') : '';

  // Get skin name from configData - only applies to admin layouts
  $isAdminLayout = !Str::contains($configData['layout'] ?? '', 'front');
  $skinName = $isAdminLayout ? $configData['skinName'] ?? 'default' : 'default';

  // Get semiDark value from configData - only applies to admin layouts
  $semiDarkEnabled = $isAdminLayout && filter_var($configData['semiDark'] ?? false, FILTER_VALIDATE_BOOLEAN);

  // Generate primary color CSS if color is set
  $primaryColorCSS = '';
  if (isset($configData['color']) && $configData['color']) {
      $primaryColorCSS = Helpers::generatePrimaryColorCSS($configData['color']);
  }

?>

<html lang="<?php echo e(session()->get('locale') ?? app()->getLocale()); ?>"
  class="<?php echo e($navbarType ?? ''); ?> <?php echo e($contentLayout ?? ''); ?> <?php echo e($menuFixed ?? ''); ?> <?php echo e($menuCollapsed ?? ''); ?> <?php echo e($footerFixed ?? ''); ?> <?php echo e($customizerHidden ?? ''); ?>"
  dir="<?php echo e($configData['textDirection']); ?>" data-skin="<?php echo e($skinName); ?>" data-assets-path="<?php echo e(asset('/assets') . '/'); ?>"
  data-base-url="<?php echo e(url('/')); ?>" data-framework="laravel" data-template="<?php echo e($configData['layout']); ?>-menu-template"
  data-bs-theme="<?php echo e($configData['theme']); ?>" <?php if($isAdminLayout && $semiDarkEnabled): ?> data-semidark-menu="true" <?php endif; ?>>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#060913" />

  <title><?php echo $__env->yieldContent('title', config('variables.templateName') . ' - ' . config('variables.templateSuffix')); ?></title>
  <meta name="description" content="<?php echo $__env->yieldContent('meta_description', config('variables.templateDescription')); ?>" />
  <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords', config('variables.templateKeyword')); ?>" />
  <meta name="author" content="<?php echo e(config('variables.creatorName')); ?>" />
  <meta name="robots" content="<?php echo $__env->yieldContent('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'); ?>" />

  <!-- Local SEO Geo Meta Tags -->
  <meta name="geo.region" content="BD-13" />
  <meta name="geo.placename" content="Dhaka" />
  <meta name="geo.position" content="23.8103;90.4125" />
  <meta name="ICBM" content="23.8103, 90.4125" />

  <!-- Open Graph / Facebook / WhatsApp -->
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', config('variables.ogTitle')); ?>" />
  <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', config('variables.templateDescription')); ?>" />
  <meta property="og:url" content="<?php echo e(url()->current()); ?>" />
  <meta property="og:image" content="<?php echo $__env->yieldContent('og_image', config('variables.ogImage')); ?>" />
  <meta property="og:site_name" content="<?php echo e(config('variables.creatorName')); ?>" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?php echo $__env->yieldContent('og_title', config('variables.ogTitle')); ?>" />
  <meta name="twitter:description" content="<?php echo $__env->yieldContent('og_description', config('variables.templateDescription')); ?>" />
  <meta name="twitter:image" content="<?php echo $__env->yieldContent('og_image', config('variables.ogImage')); ?>" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
  
  <!-- Canonical SEO -->
  <link rel="canonical" href="<?php echo e(url()->current()); ?>" />

  <!-- Preconnect for CDNs and Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Favicon Icons for All Devices -->
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/img/branding/logo-light-icon.png')); ?>?v=2" />
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('assets/img/branding/logo-light-icon.png')); ?>?v=2" />
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/img/branding/logo-light-icon.png')); ?>?v=2" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/img/branding/logo-light-icon.png')); ?>?v=2" />

  <!-- Include Styles -->
  <?php echo $__env->make('layouts/sections/styles' . $isFront, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php if(
      $primaryColorCSS &&
          (config('custom.custom.primaryColor') ||
              isset($_COOKIE['admin-primaryColor']) ||
              isset($_COOKIE['front-primaryColor']))): ?>
    <!-- Primary Color Style -->
    <style id="primary-color-style">
      <?php echo $primaryColorCSS; ?>

    </style>
  <?php endif; ?>

  <!-- Include Scripts for customizer, helper, analytics, config -->
  <?php echo $__env->make('layouts/sections/scriptsIncludes' . $isFront, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php echo $__env->yieldContent('head_extra'); ?>
</head>

<body>
  <!-- Layout Content -->
  <?php echo $__env->yieldContent('layoutContent'); ?>
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  <?php echo $__env->make('layouts/sections/scripts' . $isFront, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html>
<?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/layouts/commonMaster.blade.php ENDPATH**/ ?>