<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
?>

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
<?php if(isset($navbarFull)): ?>
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4 ms-0">
  <a href="<?php echo e(url('/')); ?>" class="app-brand-link">
    <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
    <span class="app-brand-text demo menu-text fw-bold"><?php echo e(config('variables.templateName')); ?></span>
  </a>

  <!-- Display menu close icon only for horizontal-menu with navbar-full -->
  <?php if(isset($menuHorizontal)): ?>
  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
    <i class="icon-base ti tabler-x icon-sm d-flex align-items-center justify-content-center"></i>
  </a>
  <?php endif; ?>
</div>
<?php endif; ?>

<!-- ! Not required for layout-without-menu -->
<?php if(!isset($navbarHideToggle)): ?>
<div
  class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0<?php echo e(isset($menuHorizontal) ? ' d-xl-none ' : ''); ?> <?php echo e(isset($contentNavbar) ? ' d-xl-none ' : ''); ?>">
  <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
    <i class="icon-base ti tabler-menu-2 icon-md"></i>
  </a>
</div>
<?php endif; ?>

<style>
.quick-access-btn:hover {
    transform: translateY(-1.5px) scale(1.02);
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    filter: brightness(0.98);
}
.quick-access-btn:active {
    transform: translateY(0) scale(1);
}
</style>

<div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

  <!-- Quick Access Menu Links -->
  <div class="d-none d-md-flex align-items-center gap-2 me-auto">
      <?php if(auth()->check()): ?>
          <?php if(auth()->user()->hasPermissionTo('pos')): ?>
              <a href="<?php echo e(route('admin.pos.index')); ?>" class="btn btn-sm d-flex align-items-center gap-1.5 px-3 py-1.5 quick-access-btn" 
                 style="border-radius: 8px; font-weight: 700; font-size: 0.78rem; background-color: rgba(115, 103, 240, 0.08); color: #7367f0; border: 1px solid rgba(115, 103, 240, 0.2); transition: all 0.2s ease;">
                  <i class="ti tabler-device-laptop fs-5"></i>
                  <span>POS Terminal</span>
              </a>
          <?php endif; ?>

          <?php if(auth()->user()->hasPermissionTo('repairs')): ?>
              <a href="<?php echo e(route('admin.repairs.index')); ?>" class="btn btn-sm d-flex align-items-center gap-1.5 px-3 py-1.5 quick-access-btn" 
                 style="border-radius: 8px; font-weight: 700; font-size: 0.78rem; background-color: rgba(40, 199, 111, 0.08); color: #28c76f; border: 1px solid rgba(40, 199, 111, 0.2); transition: all 0.2s ease;">
                  <i class="ti tabler-tools fs-5"></i>
                  <span>Job Cards (Repairs)</span>
              </a>
          <?php endif; ?>

          <?php if(auth()->user()->hasPermissionTo('cash')): ?>
              <a href="<?php echo e(route('admin.cash.index')); ?>" class="btn btn-sm d-flex align-items-center gap-1.5 px-3 py-1.5 quick-access-btn" 
                 style="border-radius: 8px; font-weight: 700; font-size: 0.78rem; background-color: rgba(0, 207, 232, 0.08); color: #00cfe8; border: 1px solid rgba(0, 207, 232, 0.2); transition: all 0.2s ease;">
                  <i class="ti tabler-wallet fs-5"></i>
                  <span>Cash Register</span>
              </a>
          <?php endif; ?>
      <?php endif; ?>
  </div>

  <ul class="navbar-nav flex-row align-items-center ms-md-auto">

    <?php if($configData['hasCustomizer'] == true): ?>
    <!-- Style Switcher -->
    <li class="nav-item dropdown me-2">
      <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" id="nav-theme"
        href="javascript:void(0);" data-bs-toggle="dropdown">
        <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
        <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
        <li>
          <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="light"
            aria-pressed="false">
            <span><i class="icon-base ti tabler-sun icon-22px me-3" data-icon="sun"></i>Light</span>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark" aria-pressed="true">
            <span><i class="icon-base ti tabler-moon-stars icon-22px me-3" data-icon="moon-stars"></i>Dark</span>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
            aria-pressed="false">
            <span><i class="icon-base ti tabler-device-desktop-analytics icon-22px me-3"
                data-icon="device-desktop-analytics"></i>System</span>
          </button>
        </li>
      </ul>
    </li>
    <!-- / Style Switcher-->
    <?php endif; ?>

    <!-- User -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
          <img src="<?php echo e(Auth::user() && Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/img/avatars/1.png')); ?>" alt class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;" />
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item mt-0"
            href="<?php echo e(Route::has('profile.show') ? route('profile.show') : url('pages/profile-user')); ?>">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0 me-2">
                <div class="avatar avatar-online">
                  <img src="<?php echo e(Auth::user() && Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/img/avatars/1.png')); ?>" alt class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;" />
                </div>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-0">
                  <?php if(Auth::check()): ?>
                  <?php echo e(Auth::user()->name); ?>

                  <?php else: ?>
                  John Doe
                  <?php endif; ?>
                </h6>
                <small class="text-body-secondary">
                  <?php if(Auth::check()): ?>
                    <?php echo e(Auth::user()->role === 'super_admin' ? 'Super Admin' : (Auth::user()->role === 'admin' ? 'Admin Manager' : ucfirst(Auth::user()->role))); ?>

                  <?php else: ?>
                    Admin
                  <?php endif; ?>
                </small>
              </div>
            </div>
          </a>
        </li>
        <li>
          <div class="dropdown-divider my-1 mx-n2"></div>
        </li>
        <li>
          <a class="dropdown-item"
            href="<?php echo e(Route::has('profile.show') ? route('profile.show') : url('pages/profile-user')); ?>">
            <i class="icon-base ti tabler-user me-3 icon-md"></i><span class="align-middle">My Profile</span> </a>
        </li>
        <li>
          <div class="dropdown-divider my-1 mx-n2"></div>
        </li>
        <?php if(Auth::check()): ?>
        <li>
          <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Logout</span>
          </a>
        </li>
        <form method="POST" id="logout-form" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
        </form>
        <?php else: ?>
        <li>
          <div class="d-grid px-2 pt-2 pb-1">
            <a class="btn btn-sm btn-danger d-flex"
              href="<?php echo e(Route::has('login') ? route('login') : url('auth/login-basic')); ?>" target="_blank">
              <small class="align-middle">Login</small>
              <i class="icon-base ti tabler-login ms-2 icon-14px"></i>
            </a>
          </div>
        </li>
        <?php endif; ?>
      </ul>
    </li>
    <!--/ User -->
  </ul>
</div>
<?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/layouts/sections/navbar/navbar-partial.blade.php ENDPATH**/ ?>