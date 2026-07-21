<?php if(isset($pageConfigs)): ?>
  <?php echo Helper::updatePageConfig($pageConfigs); ?>

<?php endif; ?>
<?php
  $configData = Helper::appClasses();
?>


<?php
  /* Display elements */
  $contentNavbar = $contentNavbar ?? true;
  $containerNav = $containerNav ?? 'container-xxl';
  $isNavbar = $isNavbar ?? true;
  $isMenu = $isMenu ?? true;
  $isFlex = $isFlex ?? false;
  $isFooter = $isFooter ?? true;
  $customizerHidden = $customizerHidden ?? '';

  /* HTML Classes */
  $navbarDetached = 'navbar-detached';
  $menuFixed = isset($configData['menuFixed']) ? $configData['menuFixed'] : '';
  if (isset($navbarType)) {
      $configData['navbarType'] = $navbarType;
  }
  $navbarType = isset($configData['navbarType']) ? $configData['navbarType'] : '';
  $footerFixed = isset($configData['footerFixed']) ? $configData['footerFixed'] : '';
  $menuCollapsed = isset($configData['menuCollapsed']) ? $configData['menuCollapsed'] : '';

  /* Content classes */
  $container =
      isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
          ? 'container-xxl'
          : 'container-fluid';

?>

<?php $__env->startSection('layoutContent'); ?>
  <div class="layout-wrapper layout-content-navbar <?php echo e($isMenu ? '' : 'layout-without-menu'); ?>">
    <div class="layout-container">

      <?php if($isMenu): ?>
        <?php echo $__env->make('layouts/sections/menu/verticalMenu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <?php endif; ?>

      <!-- Layout page -->
      <div class="layout-page">

        
        

        <!-- BEGIN: Navbar-->
        <?php if($isNavbar): ?>
          <?php echo $__env->make('layouts/sections/navbar/navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        <!-- END: Navbar-->

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->
          <?php if($isFlex): ?>
            <div class="<?php echo e($container); ?> d-flex align-items-stretch flex-grow-1 p-0">
            <?php else: ?>
              <div class="<?php echo e($container); ?> flex-grow-1 container-p-y">
          <?php endif; ?>

          <?php echo $__env->yieldContent('content'); ?>

        </div>
        <!-- / Content -->

        <!-- Footer -->
        <?php if($isFooter): ?>
          <?php echo $__env->make('layouts/sections/footer/footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        <!-- / Footer -->
        <div class="content-backdrop fade"></div>
      </div>
      <!--/ Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>

  <?php if($isMenu): ?>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  <?php endif; ?>
  <!-- Drag Target Area To SlideIn Menu On Small Screens -->
  <div class="drag-target"></div>
  <!-- Live Tracking Modal for Dashboards -->
  <div class="modal fade" id="dashboardTrackModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg" style="background: rgba(13, 19, 33, 0.96); backdrop-filter: blur(25px); border: 1px solid rgba(255, 255, 255, 0.12) !important;">
              <div class="modal-header border-bottom border-white border-opacity-10 p-4 d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                      <img src="<?php echo e(asset('assets/img/branding/logo-dark-icon.png')); ?>" alt="M3 Logo" style="height: 36px; width: auto; object-fit: contain;" class="me-3">
                      <div>
                          <h4 class="modal-title fw-bold text-white mb-0">Repair Details</h4>
                          <span class="text-slate-400 small">Traced Code: <strong style="color: #f37021 !important;" id="tracedTicketId"></strong></span>
                      </div>
                  </div>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(1) brightness(2) !important;"></button>
              </div>
              <div class="modal-body p-4" id="dashboardTrackModalBody" style="background: transparent;">
                  <!-- Loaded dynamically via AJAX -->
              </div>
              <div class="modal-footer border-top border-white border-opacity-10 p-3">
                  <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal" style="color: #e2e8f0; border-color: rgba(255,255,255,0.2);">Close</button>
              </div>
          </div>
      </div>
  </div>

  <script>
  function performLiveTrack(ticketId) {
      const modalBody = document.getElementById('dashboardTrackModalBody');
      const tracedCode = document.getElementById('tracedTicketId');
      
      tracedCode.textContent = ticketId;
      modalBody.innerHTML = `
          <div class="text-center py-5">
              <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
              </div>
              <p class="text-slate-400 mt-2">Fetching live status from lab...</p>
          </div>
      `;
      
      const modalEl = document.getElementById('dashboardTrackModal');
      const modal = new bootstrap.Modal(modalEl);
      modal.show();
      
      fetch(`/track-ajax?ticket_id=${encodeURIComponent(ticketId)}`)
          .then(response => response.text())
          .then(html => {
              modalBody.innerHTML = html;
          })
          .catch(err => {
              modalBody.innerHTML = `
                  <div class="text-center py-5">
                      <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                          <i class="ti tabler-alert-circle text-danger fs-2"></i>
                      </div>
                      <h5 class="text-danger fw-bold mb-1">Connection Error</h5>
                      <p class="text-slate-400 small">Failed to retrieve status. Please try again.</p>
                  </div>
              `;
          });
  }
  </script>

  </div>
  <!-- / Layout wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/commonMaster', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/layouts/contentNavbarLayout.blade.php ENDPATH**/ ?>