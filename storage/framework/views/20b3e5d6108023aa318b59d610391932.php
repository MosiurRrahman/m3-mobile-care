

<?php $__env->startSection('title', 'Customers Registry - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Customers Registry</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customers</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="ti tabler-plus me-1"></i>Register Customer
        </button>
    </div>

    <!-- Alert Notifications -->

    <!-- Filter & Search Section -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body bg-light py-3 rounded-3">
                <form action="<?php echo e(route('admin.customers.index')); ?>" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search by name, phone or email..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2">
                        <select name="per_page" class="form-select">
                            <option value="15" <?php echo e(request('per_page', '15') == '15' ? 'selected' : ''); ?>>15 / Page</option>
                            <option value="30" <?php echo e(request('per_page') == '30' ? 'selected' : ''); ?>>30 / Page</option>
                            <option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50 / Page</option>
                            <option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100 / Page</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="due_only" id="due_only" value="1" <?php echo e(request('due_only') ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label fw-bold text-dark" for="due_only">Dues Only</label>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="ti tabler-search me-1"></i>Filter</button>
                        <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Customers List Table -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Alternative Phone</th>
                                <th>Email</th>
                                <th>District</th>
                                <th>Due Balance</th>
                                <th class="text-end" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + $customers->firstItem()); ?></td>
                                <td><span class="fw-bold text-dark"><?php echo e($customer->name); ?></span></td>
                                <td><span class="fw-semibold"><?php echo e($customer->phone); ?></span></td>
                                <td><?php echo e($customer->alt_phone ?? 'N/A'); ?></td>
                                <td><?php echo e($customer->email ?? 'N/A'); ?></td>
                                <td><?php echo e($customer->district ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($customer->total_sales_due > 0): ?>
                                        <span class="badge bg-label-danger fw-bold fs-7"><?php echo e(number_format($customer->total_sales_due, 2)); ?> BDT</span>
                                    <?php else: ?>
                                        <span class="text-muted small">0.00 BDT</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex">
                                        <a href="<?php echo e(route('admin.customers.show', $customer->id)); ?>" class="btn btn-icon btn-sm btn-outline-info me-1" title="Customer Profile & History"><i class="ti tabler-user-check"></i></a>
                                        <button class="btn btn-icon btn-sm btn-outline-primary me-1 edit-customer-btn" 
                                                data-id="<?php echo e($customer->id); ?>"
                                                data-name="<?php echo e($customer->name); ?>"
                                                data-phone="<?php echo e($customer->phone); ?>"
                                                data-alt_phone="<?php echo e($customer->alt_phone); ?>"
                                                data-email="<?php echo e($customer->email); ?>"
                                                data-address="<?php echo e($customer->address); ?>"
                                                data-district="<?php echo e($customer->district); ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCustomerModal" 
                                                title="Edit Customer Profile">
                                            <i class="ti tabler-edit"></i>
                                        </button>
                                        
                                        <?php if(auth()->user()->isSuperAdmin()): ?>
                                        <form action="<?php echo e(route('admin.customers.destroy', $customer->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer? This will break their transaction history.');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="ti tabler-users fs-2 d-block mb-2"></i>
                                    No registered customers found.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php if($customers->hasPages()): ?>
            <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
                <?php echo e($customers->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal: Add Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addCustomerModalLabel">Register Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.customers.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_name">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="add_name" class="form-control" placeholder="e.g. Rahim Ali" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="add_phone" class="form-control" placeholder="e.g. 01712345678" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_alt_phone">Alternative Phone Number</label>
                        <input type="text" name="alt_phone" id="add_alt_phone" class="form-control" placeholder="e.g. 01812345678">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_email">Email Address</label>
                        <input type="email" name="email" id="add_email" class="form-control" placeholder="e.g. customer@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_district">District / City</label>
                        <input type="text" name="district" id="add_district" class="form-control" placeholder="e.g. Dhaka" value="Dhaka">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="add_address">Address Details</label>
                        <textarea name="address" id="add_address" rows="3" class="form-control" placeholder="e.g. Dhanmondi, Road 12"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Customer -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editCustomerModalLabel">Edit Customer Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="editCustomerForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_name">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="edit_phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_alt_phone">Alternative Phone Number</label>
                        <input type="text" name="alt_phone" id="edit_alt_phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_email">Email Address</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_district">District / City</label>
                        <input type="text" name="district" id="edit_district" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="edit_address">Address Details</label>
                        <textarea name="address" id="edit_address" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-customer-btn');
        const editForm = document.getElementById('editCustomerForm');
        const editName = document.getElementById('edit_name');
        const editPhone = document.getElementById('edit_phone');
        const editAltPhone = document.getElementById('edit_alt_phone');
        const editEmail = document.getElementById('edit_email');
        const editAddress = document.getElementById('edit_address');
        const editDistrict = document.getElementById('edit_district');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const phone = this.getAttribute('data-phone');
                const altPhone = this.getAttribute('data-alt_phone');
                const email = this.getAttribute('data-email');
                const address = this.getAttribute('data-address');
                const district = this.getAttribute('data-district');

                editForm.action = `/admin/customers/${id}`;
                
                editName.value = name;
                editPhone.value = phone;
                editAltPhone.value = altPhone === 'null' ? '' : altPhone;
                editEmail.value = email === 'null' ? '' : email;
                editAddress.value = address === 'null' ? '' : address;
                editDistrict.value = district === 'null' ? '' : district;
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/customers/index.blade.php ENDPATH**/ ?>