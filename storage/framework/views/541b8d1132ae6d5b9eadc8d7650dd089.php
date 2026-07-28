

<?php $__env->startSection('title', 'Manage Staff - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Staff Accounts Management</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Staff Management</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="ti tabler-plus me-1"></i>Register Staff Account
        </button>
    </div>

    <!-- Alert Notifications -->
    <?php if($errors->any()): ?>
        <div class="col-12 mb-3">
            <div class="alert alert-danger border-0 small py-2">
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Staff List -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Staff Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Phone</th>
                                <th>Branch</th>
                                <th>Skill / Experience</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $roleColors = [
                                    'super_admin' => 'bg-label-danger',
                                    'admin' => 'bg-label-primary',
                                    'technician' => 'bg-label-success',
                                    'salesman' => 'bg-label-info'
                                ];
                                $roleLabels = [
                                    'super_admin' => 'Super Admin',
                                    'admin' => 'Admin Manager',
                                    'technician' => 'Technician',
                                    'salesman' => 'Salesman'
                                ];
                                $color = $roleColors[$user->role] ?? 'bg-label-secondary';
                                $label = $roleLabels[$user->role] ?? ucfirst($user->role);
                            ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($user->avatar): ?>
                                            <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-label-primary p-2 d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <i class="ti tabler-user fs-6"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <span class="fw-bold text-dark d-block mb-0"><?php echo e($user->name); ?></span>
                                            <?php if(auth()->id() === $user->id): ?>
                                                <span class="badge bg-success fs-9 py-0.5">Logged In</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($user->email); ?></td>
                                <td><span class="badge <?php echo e($color); ?> fs-6"><?php echo e($label); ?></span></td>
                                <td><?php echo e($user->phone ?? 'N/A'); ?></td>
                                <td><?php echo e($user->branch ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($user->role === 'technician'): ?>
                                        <div class="small text-dark"><?php echo e($user->skill_level ?? 'N/A'); ?></div>
                                        <div class="small text-muted"><?php echo e($user->experience ?? 'No exp logged'); ?></div>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($user->is_active): ?>
                                        <span class="badge bg-label-success fw-bold">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary fw-bold">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center">
                                        <button class="btn btn-icon btn-sm btn-outline-primary me-1 edit-user-btn" 
                                                data-id="<?php echo e($user->id); ?>"
                                                data-name="<?php echo e($user->name); ?>"
                                                data-email="<?php echo e($user->email); ?>"
                                                data-role="<?php echo e($user->role); ?>"
                                                data-phone="<?php echo e($user->phone); ?>"
                                                data-skill_level="<?php echo e($user->skill_level); ?>"
                                                data-experience="<?php echo e($user->experience); ?>"
                                                data-branch="<?php echo e($user->branch); ?>"
                                                data-is_active="<?php echo e($user->is_active ? '1' : '0'); ?>"
                                                data-permissions="<?php echo e(json_encode($user->permissions ?? [])); ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal" 
                                                title="Edit Staff">
                                            <i class="ti tabler-edit"></i>
                                        </button>
                                        
                                        <?php if(auth()->id() !== $user->id): ?>
                                        <form action="<?php echo e(route('admin.users.toggle-status', $user->id)); ?>" method="POST" class="me-1" onsubmit="return confirm('Are you sure you want to change the status of this staff account?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-icon btn-sm <?php echo e($user->is_active ? 'btn-outline-warning' : 'btn-outline-success'); ?>" title="<?php echo e($user->is_active ? 'Deactivate User' : 'Activate User'); ?>">
                                                <i class="ti <?php echo e($user->is_active ? 'tabler-user-off' : 'tabler-user-check'); ?>"></i>
                                            </button>
                                        </form>
                                        <?php else: ?>
                                            <button class="btn btn-icon btn-sm btn-outline-secondary me-1" disabled title="Cannot deactivate yourself"><i class="ti tabler-user-off"></i></button>
                                        <?php endif; ?>
                                        
                                        <?php if(auth()->id() !== $user->id): ?>
                                        <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this staff account?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                                        </form>
                                        <?php else: ?>
                                            <button class="btn btn-icon btn-sm btn-outline-secondary" disabled title="Cannot delete yourself"><i class="ti tabler-trash"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Staff -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addUserModalLabel">Register Staff Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="add_name" class="form-control" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="add_email" class="form-control" placeholder="e.g. john@m3mobile.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="add_password" class="form-control" placeholder="Minimum 6 characters" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_role">System Role <span class="text-danger">*</span></label>
                        <select name="role" id="add_role" class="form-select" required>
                            <option value="admin">Admin (Manager)</option>
                            <option value="super_admin">Super Admin (Owner)</option>
                            <option value="technician">Technician</option>
                            <option value="salesman">Salesman (POS Retail)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_phone">Phone Number</label>
                        <input type="text" name="phone" id="add_phone" class="form-control" placeholder="e.g. 01712345678">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_branch">Branch Name</label>
                        <input type="text" name="branch" id="add_branch" class="form-control" placeholder="e.g. Multiplan Center">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_avatar">Profile Avatar</label>
                        <input type="file" name="avatar" id="add_avatar" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold d-block mb-2 text-dark">Feature Access Permissions</label>
                        <div class="row g-2 border rounded p-3 bg-light">
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[pos]" id="add_perm_pos" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="add_perm_pos">POS Terminal</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[repairs]" id="add_perm_repairs" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="add_perm_repairs">Job Cards (Repairs)</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[inventory]" id="add_perm_inventory" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="add_perm_inventory">Inventory Management</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[purchases]" id="add_perm_purchases" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="add_perm_purchases">Suppliers & Purchases</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[expenses]" id="add_perm_expenses" value="1">
                                    <label class="form-check-label fw-semibold" for="add_perm_expenses">Expense Manager</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[reports]" id="add_perm_reports" value="1">
                                    <label class="form-check-label fw-semibold" for="add_perm_reports">Financial Reports</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[cash]" id="add_perm_cash" value="1">
                                    <label class="form-check-label fw-semibold" for="add_perm_cash">Cash Register</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[settings]" id="add_perm_settings" value="1">
                                    <label class="form-check-label fw-semibold" for="add_perm_settings">Shop Settings</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[social_media]" id="add_perm_social" value="1">
                                    <label class="form-check-label fw-semibold" for="add_perm_social">Social Media Manager</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tech fields -->
                    <div id="tech-fields-add" class="d-none">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="add_skill_level">Skill level</label>
                            <select name="skill_level" id="add_skill_level" class="form-select">
                                <option value="Level 1 - Basic Diagnostics">Level 1 - Basic Diagnostics</option>
                                <option value="Level 2 - Hardware Replacements">Level 2 - Hardware Replacements</option>
                                <option value="Level 3 - Advanced IC Reballing">Level 3 - Advanced IC Reballing</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="add_experience">Years of Experience</label>
                            <input type="text" name="experience" id="add_experience" class="form-control" placeholder="e.g. 5 Years in mobile hardware repair">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Staff -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editUserModalLabel">Edit Staff Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="editUserForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_password">New Password <span class="text-muted">(Leave blank to keep current)</span></label>
                        <input type="password" name="password" id="edit_password" class="form-control" placeholder="Minimum 6 characters">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_role">System Role <span class="text-danger">*</span></label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="admin">Admin (Manager)</option>
                            <option value="super_admin">Super Admin (Owner)</option>
                            <option value="technician">Technician</option>
                            <option value="salesman">Salesman (POS Retail)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_phone">Phone Number</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_branch">Branch Name</label>
                        <input type="text" name="branch" id="edit_branch" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_avatar">Profile Avatar</label>
                        <input type="file" name="avatar" id="edit_avatar" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3" id="edit-status-group">
                        <label class="form-label fw-semibold d-block mb-1">Account Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active" value="1">
                            <label class="form-check-label fw-bold text-dark" for="edit_is_active" id="edit_is_active_label">Active</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold d-block mb-2 text-dark">Feature Access Permissions</label>
                        <div class="row g-2 border rounded p-3 bg-light">
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[pos]" data-perm="pos" id="edit_perm_pos" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_pos">POS Terminal</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[repairs]" data-perm="repairs" id="edit_perm_repairs" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_repairs">Job Cards (Repairs)</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[inventory]" data-perm="inventory" id="edit_perm_inventory" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_inventory">Inventory Management</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[purchases]" data-perm="purchases" id="edit_perm_purchases" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_purchases">Suppliers & Purchases</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[expenses]" data-perm="expenses" id="edit_perm_expenses" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_expenses">Expense Manager</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[reports]" data-perm="reports" id="edit_perm_reports" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_reports">Financial Reports</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[cash]" data-perm="cash" id="edit_perm_cash" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_cash">Cash Register</label>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[settings]" data-perm="settings" id="edit_perm_settings" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_settings">Shop Settings</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[social_media]" data-perm="social_media" id="edit_perm_social" value="1">
                                    <label class="form-check-label fw-semibold" for="edit_perm_social">Social Media Manager</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tech fields -->
                    <div id="tech-fields-edit" class="d-none">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="edit_skill_level">Skill level</label>
                            <select name="skill_level" id="edit_skill_level" class="form-select">
                                <option value="Level 1 - Basic Diagnostics">Level 1 - Basic Diagnostics</option>
                                <option value="Level 2 - Hardware Replacements">Level 2 - Hardware Replacements</option>
                                <option value="Level 3 - Advanced IC Reballing">Level 3 - Advanced IC Reballing</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="edit_experience">Years of Experience</label>
                            <input type="text" name="experience" id="edit_experience" class="form-control">
                        </div>
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
        const editButtons = document.querySelectorAll('.edit-user-btn');
        const editForm = document.getElementById('editUserForm');
        const editName = document.getElementById('edit_name');
        const editEmail = document.getElementById('edit_email');
        const editPassword = document.getElementById('edit_password');
        const editRole = document.getElementById('edit_role');
        const editPhone = document.getElementById('edit_phone');
        const editBranch = document.getElementById('edit_branch');
        const editSkill = document.getElementById('edit_skill_level');
        const editExperience = document.getElementById('edit_experience');

        const addRoleSelect = document.getElementById('add_role');
        const editRoleSelect = document.getElementById('edit_role');
        const techFieldsAdd = document.getElementById('tech-fields-add');
        const techFieldsEdit = document.getElementById('tech-fields-edit');

        // Toggle technician fields in modal
        function toggleTechFields(role, container) {
            if (role === 'technician') {
                container.classList.remove('d-none');
            } else {
                container.classList.add('d-none');
            }
        }

        addRoleSelect.addEventListener('change', function() {
            toggleTechFields(this.value, techFieldsAdd);
        });

        editRoleSelect.addEventListener('change', function() {
            toggleTechFields(this.value, techFieldsEdit);
        });

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const role = this.getAttribute('data-role');
                const phone = this.getAttribute('data-phone');
                const skill = this.getAttribute('data-skill_level');
                const experience = this.getAttribute('data-experience');
                const branch = this.getAttribute('data-branch');

                editForm.action = `/admin/users/${id}`;
                
                editName.value = name;
                editEmail.value = email;
                editPassword.value = '';
                editRole.value = role;
                editPhone.value = phone === 'null' ? '' : phone;
                editBranch.value = branch === 'null' ? '' : branch;
                editSkill.value = skill === 'null' ? 'Level 1 - Basic Diagnostics' : skill;
                editExperience.value = experience === 'null' ? '' : experience;

                // Handle status switch
                const isActive = this.getAttribute('data-is_active') === '1';
                const editIsActiveInput = document.getElementById('edit_is_active');
                const editIsActiveLabel = document.getElementById('edit_is_active_label');
                const editStatusGroup = document.getElementById('edit-status-group');
                const loggedInUserId = <?php echo e(auth()->id()); ?>;

                if (parseInt(id) === loggedInUserId) {
                    editStatusGroup.classList.add('d-none'); // Hide status toggle for own account
                } else {
                    editStatusGroup.classList.remove('d-none');
                }

                editIsActiveInput.checked = isActive;
                editIsActiveLabel.textContent = isActive ? 'Active' : 'Inactive';

                const permissions = JSON.parse(this.getAttribute('data-permissions') || '{}');
                document.querySelectorAll('.edit-perm-check').forEach(chk => {
                    const perm = chk.getAttribute('data-perm');
                    chk.checked = !!permissions[perm];
                });

                toggleTechFields(role, techFieldsEdit);
            });
        });
        const editIsActiveInput = document.getElementById('edit_is_active');
        const editIsActiveLabel = document.getElementById('edit_is_active_label');
        if (editIsActiveInput && editIsActiveLabel) {
            editIsActiveInput.addEventListener('change', function() {
                editIsActiveLabel.textContent = this.checked ? 'Active' : 'Inactive';
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/users/index.blade.php ENDPATH**/ ?>