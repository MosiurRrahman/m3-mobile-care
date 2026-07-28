<?php
    $shopPhone = \App\Models\Setting::get('phone', '+880 1712-345678');
    $shopEmail = \App\Models\Setting::get('email', 'info@m3mobilecare.com');
    $shopAddress = \App\Models\Setting::get('address', 'Goffar Market, Ranisankail, Thakurgaon');
?>

<!-- FOOTER SECTION START -->
<footer class="ul-footer">
    <div class="ul-inner-container">
        <div class="ul-footer-top">
            <!-- single links column -->
            <div class="ul-footer-top-widget">
                <h3 class="ul-footer-top-widget-title">Accessories Shop</h3>

                <div class="ul-footer-top-widget-links">
                    <a href="<?php echo e(route('shop.catalog')); ?>">Chargers & Fast Cables</a>
                    <a href="<?php echo e(route('shop.catalog')); ?>">Phone Cases & Covers</a>
                    <a href="<?php echo e(route('shop.catalog')); ?>">Tempered Glass Screen</a>
                    <a href="<?php echo e(route('shop.catalog')); ?>">Wireless Earbuds & TWS</a>
                    <a href="<?php echo e(route('shop.catalog')); ?>">Power Banks & Battery</a>
                </div>
            </div>

            <!-- single links column -->
            <div class="ul-footer-top-widget">
                <h3 class="ul-footer-top-widget-title">Quick Links</h3>

                <div class="ul-footer-top-widget-links">
                    <a href="<?php echo e(route('shop.about')); ?>">About Us</a>
                    <a href="<?php echo e(route('shop.contact')); ?>">Contact Us</a>
                    <a href="<?php echo e(route('shop.faq')); ?>">FAQ</a>
                    <a href="<?php echo e(route('customer.login')); ?>">My Account</a>
                </div>
            </div>

            <!-- single links column -->
            <div class="ul-footer-top-widget">
                <h3 class="ul-footer-top-widget-title">Store Address</h3>

                <div class="ul-footer-top-widget-links">
                    <a role="button" class="text-white opacity-75 d-block text-decoration-none">
                        <i class="flaticon-home me-1"></i> <?php echo e($shopAddress); ?>

                    </a>
                    <a role="button" class="text-white opacity-75 d-block text-decoration-none">
                        <i class="flaticon-mail me-1"></i> <?php echo e($shopEmail); ?>

                    </a>
                    <a href="tel:<?php echo e($shopPhone); ?>" class="text-white opacity-75 d-block text-decoration-none">
                        <i class="flaticon-phone-call me-1"></i> <?php echo e($shopPhone); ?>

                    </a>
                </div>
            </div>

            <!-- single links column -->
            <div class="ul-footer-top-widget">
                <h3 class="ul-footer-top-widget-title">Customer Support</h3>

                <div class="ul-footer-top-widget-links">
                    <a href="<?php echo e(route('shop.contact')); ?>">Contact Support</a>
                    <a href="<?php echo e(route('shop.faq')); ?>">Store FAQ</a>
                    <a href="<?php echo e(route('shop.catalog')); ?>">Product Catalog</a>
                    <a href="<?php echo e(route('shop.cart')); ?>">Shopping Cart</a>
                </div>
            </div>
        </div>

        <div class="ul-footer-middle">
            <!-- single widget -->
            <div class="ul-footer-middle-widget">
                <h3 class="ul-footer-middle-widget-title">Follow us</h3>
                <div class="ul-footer-middle-widget-content">
                    <div class="social-links">
                        <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                        <a href="#"><i class="flaticon-twitter"></i></a>
                        <a href="#"><i class="flaticon-linkedin-big-logo"></i></a>
                        <a href="#"><i class="flaticon-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- single widget -->
            <div class="ul-footer-middle-widget">
                <h3 class="ul-footer-middle-widget-title">Need help? Call now!</h3>
                <div class="ul-footer-middle-widget-content">
                    <div class="contact-nums">
                        <a href="tel:01353106967">01353106967</a>, <a href="tel:01353106966">01353106966</a>
                    </div>
                </div>
            </div>

            <!-- single widget -->
            <div class="ul-footer-middle-widget align-self-center">
                <a href="<?php echo e(route('home')); ?>" class="d-inline-flex align-items-center text-decoration-none">
                    <img src="<?php echo e(asset('assets/img/branding/logo-light-icon.png')); ?>" alt="M3 Mobile Care" class="logo me-2" style="max-height: 42px; width: auto; object-fit: contain;">
                    <span class="fw-extrabold fs-4 text-white" style="letter-spacing: -0.5px;">M3 <span style="color: var(--ul-primary);">Mobile Care</span></span>
                </a>
            </div>
        </div>

        <div class="ul-footer-bottom">
            <p class="copyright-txt">Copyright <?php echo e(date('Y')); ?> © <a href="<?php echo e(route('home')); ?>" class="ul-footer-bottom-link">M3 Mobile Care</a>. All Rights Reserved.</p>
            <img src="<?php echo e(asset('frontend/img/payment-methods.png')); ?>" alt="payment methods logos">
        </div>
    </div>
</footer>
<!-- FOOTER SECTION END -->
<?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/frontend/partials/footer.blade.php ENDPATH**/ ?>