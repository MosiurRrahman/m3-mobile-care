<?php
use Illuminate\Support\Facades\Route;
$configData = Helper::appClasses();
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu" <?php $__currentLoopData = $configData['menuAttributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute=>
  $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php echo e($attribute); ?>="<?php echo e($value); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>

  <!-- ! Hide app brand if navbar-full -->
  <?php if(!isset($navbarFull)): ?>
  <div class="app-brand demo">
    <a href="<?php echo e(url('/')); ?>" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="<?php echo e(asset('assets/img/branding/logo-light-icon.png')); ?>" alt="M3 Logo" style="height: 38px; width: auto; object-fit: contain;">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2" style="color: #f37021 !important; text-transform: uppercase; font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">M3 Mobile Care</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
      <i class="icon-base ti tabler-x d-block d-xl-none"></i>
    </a>
  </div>
  <?php endif; ?>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <?php $__currentLoopData = $menuData[0]->menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    

    
    <?php if(isset($menu->menuHeader)): ?>
    <li class="menu-header small">
      <span class="menu-header-text"><?php echo e(__($menu->menuHeader)); ?></span>
    </li>
    <?php else: ?>
    
    <?php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    } elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach ($menu->slug as $slug) {
    if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
    $activeClass = 'active open';
    }
    }
    } else {
    if (
    str_contains($currentRouteName, $menu->slug) and
    strpos($currentRouteName, $menu->slug) === 0
    ) {
    $activeClass = 'active open';
    }
    }
    }
    ?>

    
    <li class="menu-item <?php echo e($activeClass); ?>">
      <a href="<?php echo e(isset($menu->url) ? url($menu->url) : 'javascript:void(0);'); ?>"
        class="<?php echo e(isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link'); ?>" <?php if(isset($menu->target) and
        !empty($menu->target)): ?> target="_blank" <?php endif; ?>>
        <?php if(isset($menu->icon)): ?>
        <i class="<?php echo e($menu->icon); ?>"></i>
        <?php endif; ?>
        <div><?php echo e(isset($menu->name) ? __($menu->name) : ''); ?></div>
        <?php if(isset($menu->badge)): ?>
        <div class="badge bg-<?php echo e($menu->badge[0]); ?> rounded-pill ms-auto"><?php echo e($menu->badge[1]); ?></div>
        <?php endif; ?>
      </a>

      
      <?php if(isset($menu->submenu)): ?>
      <?php echo $__env->make('layouts.sections.menu.submenu', ['menu' => $menu->submenu], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endif; ?>
    </li>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ul>

</aside>
<?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/layouts/sections/menu/verticalMenu.blade.php ENDPATH**/ ?>