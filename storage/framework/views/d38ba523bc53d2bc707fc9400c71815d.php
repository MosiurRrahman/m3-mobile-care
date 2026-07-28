<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'M3 Mobile Care - Accessories & Gadgets Shop'); ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Libraries CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/icon/flaticon_glamer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/vendor/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/vendor/splide/splide.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/vendor/swiper/swiper-bundle.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/vendor/slim-select/slimselect.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/vendor/animate-wow/animate.min.css')); ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/style.css')); ?>">
    
    <?php
        $primaryColor = \App\Models\Setting::get('primary_color', '#f37021');
    ?>
    <style>
        :root {
            --ul-primary: <?php echo e($primaryColor); ?>;
        }
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: <?php echo e($primaryColor); ?>;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }
        .logo-text span {
            color: #111;
        }
        .ul-btn,
        .ul-product-price,
        .ul-product-title a:hover,
        .ul-banner-slide-price .price,
        .ul-banner-slide-sub-title,
        .ul-breadcrumb-nav a:hover,
        .ul-header-nav a:hover,
        .ul-header-nav a.active {
            color: <?php echo e($primaryColor); ?>;
        }
        .ul-btn {
            border-color: <?php echo e($primaryColor); ?>;
        }
        .ul-btn:hover {
            background-color: <?php echo e($primaryColor); ?> !important;
            color: #ffffff !important;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Header Section -->
    <?php echo $__env->make('frontend.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content Section -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer Section -->
    <?php echo $__env->make('frontend.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Libraries JS -->
    <script src="<?php echo e(asset('frontend/vendor/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/splide/splide.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/splide/splide-extension-auto-scroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/swiper/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/slim-select/slimselect.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/animate-wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/splittype/index.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/mixitup/mixitup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/vendor/fslightbox/fslightbox.js')); ?>"></script>

    <!-- Custom JS -->
    <script src="<?php echo e(asset('frontend/js/main.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>