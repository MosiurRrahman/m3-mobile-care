<?php $__env->startSection('title', 'Categories Management - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
  <div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h4 class="fw-bold mb-0">Inventory Categories</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.inventory.accessories')); ?>">Inventory</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
          </ol>
        </nav>
      </div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="ti tabler-plus me-1"></i>Add New Category
      </button>
    </div>

    <!-- Table Card -->
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 80px;">ID</th>
                <th>Category Name</th>
                <th>Category Slug</th>
                <th>Status</th>
                <th>Created At</th>
                <th class="text-end" style="width: 150px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                  <td class="fw-semibold text-muted">#<?php echo e($category->id); ?></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar-wrapper me-2">
                        <div
                          class="avatar avatar-sm bg-label-primary rounded-circle d-flex align-items-center justify-content-center"
                          style="width: 32px; height: 32px;">
                          <i class="ti tabler-category fs-5"></i>
                        </div>
                      </div>
                      <span class="fw-bold text-dark"><?php echo e($category->name); ?></span>
                    </div>
                  </td>
                  <td><code class="text-muted"><?php echo e($category->slug); ?></code></td>
                  <td>
                    <?php if($category->status === 'active'): ?>
                      <span class="badge bg-label-success">Active</span>
                    <?php else: ?>
                      <span class="badge bg-label-secondary">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td class="small text-muted"><?php echo e($category->created_at->format('M d, Y')); ?></td>
                  <td class="text-end">
                    <button class="btn btn-icon btn-sm btn-outline-primary edit-category-btn"
                      data-id="<?php echo e($category->id); ?>" data-name="<?php echo e($category->name); ?>" data-slug="<?php echo e($category->slug); ?>"
                      data-status="<?php echo e($category->status); ?>" data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                      <i class="ti tabler-edit"></i>
                    </button>
                    <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-icon btn-sm btn-outline-danger"><i
                          class="ti tabler-trash"></i></button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="ti tabler-category fs-1 mb-2"></i>
                    <p class="mb-0">No categories found. Click "Add New Category" to create one.</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Create Category -->
  <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="createCategoryModalLabel">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-semibold" for="create_name">Category Name <span
                  class="text-danger">*</span></label>
              <input type="text" name="name" id="create_name" class="form-control"
                placeholder="e.g. Chargers & Adapters" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold" for="create_slug">Category Slug (Optional)</label>
              <input type="text" name="slug" id="create_slug" class="form-control"
                placeholder="e.g. chargers-adapters">
              <div class="form-text small text-muted">Will be auto-generated from name if left empty.</div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold" for="create_status">Status <span class="text-danger">*</span></label>
              <select name="status" id="create_status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal: Edit Category -->
  <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="editCategoryModalLabel">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editCategoryForm" action="" method="POST">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-semibold" for="edit_name">Category Name <span
                  class="text-danger">*</span></label>
              <input type="text" name="name" id="edit_name" class="form-control" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold" for="edit_slug">Category Slug <span
                  class="text-danger">*</span></label>
              <input type="text" name="slug" id="edit_slug" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold" for="edit_status">Status <span class="text-danger">*</span></label>
              <select name="status" id="edit_status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const editForm = document.getElementById('editCategoryForm');
      const editName = document.getElementById('edit_name');
      const editSlug = document.getElementById('edit_slug');
      const editStatus = document.getElementById('edit_status');

      document.querySelectorAll('.edit-category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const name = this.getAttribute('data-name');
          const slug = this.getAttribute('data-slug');
          const status = this.getAttribute('data-status');

          editForm.action = `/admin/categories/${id}`;
          editName.value = name;
          editSlug.value = slug;
          editStatus.value = status;
        });
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/categories/index.blade.php ENDPATH**/ ?>