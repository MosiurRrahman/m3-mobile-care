

<?php $__env->startSection('title', 'Social Media Manager - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Social Media & Campaign Manager</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Social Manager</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
            <i class="ti tabler-plus me-1"></i>Create New Post
        </button>
    </div>

    <!-- Notifications -->
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

    <!-- Analytics Dashboard Cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Total Posts Published</span>
                    <h3 class="card-title fw-extrabold mb-0 text-primary"><?php echo e($totalPostsCount); ?></h3>
                </div>
                <div class="rounded-circle bg-label-primary p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-share fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Total Reach</span>
                    <h3 class="card-title fw-extrabold mb-0 text-success"><?php echo e(number_format($totalReach)); ?></h3>
                </div>
                <div class="rounded-circle bg-label-success p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-users fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Engagements</span>
                    <h3 class="card-title fw-extrabold mb-0 text-warning"><?php echo e(number_format($totalEngagement)); ?></h3>
                </div>
                <div class="rounded-circle bg-label-warning p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-thumb-up fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold d-block mb-1">Avg Engagement Rate</span>
                    <h3 class="card-title fw-extrabold mb-0 text-info"><?php echo e(number_format($avgEngagementRate, 2)); ?>%</h3>
                </div>
                <div class="rounded-circle bg-label-info p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ti tabler-chart-pie fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Filtering -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom bg-transparent p-0">
                <ul class="nav nav-tabs card-header-tabs ms-0" id="socialTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold py-3 px-4" id="scheduled-tab" data-bs-toggle="tab" data-bs-target="#scheduled-pane" type="button" role="tab">
                            <i class="ti tabler-clock me-1"></i>Scheduled & Queued (<?php echo e($scheduled->count()); ?>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3 px-4" id="drafts-tab" data-bs-toggle="tab" data-bs-target="#drafts-pane" type="button" role="tab">
                            <i class="ti tabler-file-text me-1"></i>Draft Box (<?php echo e($drafts->count()); ?>)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold py-3 px-4" id="published-tab" data-bs-toggle="tab" data-bs-target="#published-pane" type="button" role="tab">
                            <i class="ti tabler-circle-check me-1"></i>Published History (<?php echo e($published->count()); ?>)
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body py-4">
                <div class="tab-content p-0" id="socialTabsContent">
                    
                    <!-- Pane 1: Scheduled -->
                    <div class="tab-pane fade show active" id="scheduled-pane" role="tabpanel">
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $scheduled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border border-light h-100 shadow-none">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <?php echo $__env->make('social.platform-badge', ['platform' => $post->platform], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                    <span class="badge bg-label-info"><i class="ti tabler-clock fs-8 me-1"></i>Scheduled</span>
                                                </div>
                                                <p class="text-dark small mb-3"><?php echo e($post->content); ?></p>
                                                <?php if($post->media_path): ?>
                                                    <img src="<?php echo e(asset('storage/' . $post->media_path)); ?>" class="img-fluid rounded mb-3 w-100" style="max-height: 180px; object-fit: cover;">
                                                <?php endif; ?>
                                            </div>
                                            <div class="border-top pt-3 mt-2">
                                                <div class="small text-muted mb-3">
                                                    <i class="ti tabler-calendar-event me-1"></i>
                                                    <?php echo e($post->scheduled_at ? $post->scheduled_at->format('M d, Y - h:i A') : 'Not Set'); ?>

                                                </div>
                                                <div class="d-flex gap-2">
                                                    <form action="<?php echo e(route('admin.social.publish', $post->id)); ?>" method="POST" class="flex-grow-1">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-success w-100"><i class="ti tabler-send me-1"></i>Publish Now</button>
                                                    </form>
                                                    <button class="btn btn-sm btn-outline-primary edit-post-btn"
                                                            data-id="<?php echo e($post->id); ?>"
                                                            data-platform="<?php echo e($post->platform); ?>"
                                                            data-content="<?php echo e($post->content); ?>"
                                                            data-scheduled="<?php echo e($post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : ''); ?>"
                                                            data-status="<?php echo e($post->status); ?>"
                                                            data-bs-toggle="modal" data-bs-target="#editPostModal">
                                                        <i class="ti tabler-edit"></i>
                                                    </button>
                                                    <form action="<?php echo e(route('admin.social.destroy', $post->id)); ?>" method="POST" onsubmit="return confirm('Delete this post?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti tabler-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12 text-center py-5 text-muted">
                                    <i class="ti tabler-calendar-event fs-1 mb-2"></i>
                                    <p class="mb-0">No scheduled posts queued.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Pane 2: Drafts -->
                    <div class="tab-pane fade" id="drafts-pane" role="tabpanel">
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $drafts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border border-light h-100 shadow-none">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <?php echo $__env->make('social.platform-badge', ['platform' => $post->platform], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                    <span class="badge bg-label-secondary">Draft</span>
                                                </div>
                                                <p class="text-dark small mb-3"><?php echo e($post->content); ?></p>
                                                <?php if($post->media_path): ?>
                                                    <img src="<?php echo e(asset('storage/' . $post->media_path)); ?>" class="img-fluid rounded mb-3 w-100" style="max-height: 180px; object-fit: cover;">
                                                <?php endif; ?>
                                            </div>
                                            <div class="border-top pt-3 mt-2">
                                                <div class="d-flex gap-2">
                                                    <form action="<?php echo e(route('admin.social.publish', $post->id)); ?>" method="POST" class="flex-grow-1">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-success w-100"><i class="ti tabler-send me-1"></i>Publish Now</button>
                                                    </form>
                                                    <button class="btn btn-sm btn-outline-primary edit-post-btn"
                                                            data-id="<?php echo e($post->id); ?>"
                                                            data-platform="<?php echo e($post->platform); ?>"
                                                            data-content="<?php echo e($post->content); ?>"
                                                            data-scheduled="<?php echo e($post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : ''); ?>"
                                                            data-status="<?php echo e($post->status); ?>"
                                                            data-bs-toggle="modal" data-bs-target="#editPostModal">
                                                        <i class="ti tabler-edit"></i>
                                                    </button>
                                                    <form action="<?php echo e(route('admin.social.destroy', $post->id)); ?>" method="POST" onsubmit="return confirm('Delete this post?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti tabler-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12 text-center py-5 text-muted">
                                    <i class="ti tabler-file-text fs-1 mb-2"></i>
                                    <p class="mb-0">Draft box is empty.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Pane 3: Published -->
                    <div class="tab-pane fade" id="published-pane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Platform</th>
                                        <th>Content Preview</th>
                                        <th>Published Date</th>
                                        <th>Reach</th>
                                        <th>Engagements</th>
                                        <th>Engagement Rate</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $published; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo $__env->make('social.platform-badge', ['platform' => $post->platform], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($post->media_path): ?>
                                                        <img src="<?php echo e(asset('storage/' . $post->media_path)); ?>" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <span class="small text-dark text-truncate d-inline-block" style="max-width: 250px;"><?php echo e($post->content); ?></span>
                                                </div>
                                            </td>
                                            <td class="small text-muted"><?php echo e($post->published_at ? $post->published_at->format('M d, Y - h:i A') : 'N/A'); ?></td>
                                            <td><span class="badge bg-label-success"><?php echo e(number_format($post->reach)); ?></span></td>
                                            <td><span class="badge bg-label-warning"><?php echo e(number_format($post->engagement)); ?></span></td>
                                            <td class="fw-bold text-info">
                                                <?php echo e($post->reach > 0 ? number_format(($post->engagement / $post->reach) * 100, 1) . '%' : '0%'); ?>

                                            </td>
                                            <td class="text-end">
                                                <form action="<?php echo e(route('admin.social.destroy', $post->id)); ?>" method="POST" onsubmit="return confirm('Delete this post entry?');" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-icon btn-sm btn-outline-danger"><i class="ti tabler-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No published campaigns recorded yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Post -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createPostModalLabel">Compose New Social Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.social.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Target Platform <span class="text-danger">*</span></label>
                        <select name="platform" class="form-select" required>
                            <option value="Facebook">Facebook Page</option>
                            <option value="Instagram">Instagram Business</option>
                            <option value="Twitter">Twitter / X Feed</option>
                            <option value="LinkedIn">LinkedIn Company Profile</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Post Content / Caption <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Write something inspiring to post..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Attach Media (Image)</label>
                        <input type="file" name="media" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Scheduled Date & Time (Optional)</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control">
                        <span class="text-muted small fs-8">Leave empty if you intend to Publish immediately.</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Save Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Save in Draft Box</option>
                            <option value="scheduled">Queue in Schedule Feed</option>
                            <option value="published">Publish Immediately</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Process Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Post -->
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editPostModalLabel">Edit Social Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="editPostForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Target Platform <span class="text-danger">*</span></label>
                        <select name="platform" id="edit_platform" class="form-select" required>
                            <option value="Facebook">Facebook Page</option>
                            <option value="Instagram">Instagram Business</option>
                            <option value="Twitter">Twitter / X Feed</option>
                            <option value="LinkedIn">LinkedIn Company Profile</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Post Content / Caption <span class="text-danger">*</span></label>
                        <textarea name="content" id="edit_content" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Media (Image)</label>
                        <input type="file" name="media" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Scheduled Date & Time (Optional)</label>
                        <input type="datetime-local" name="scheduled_at" id="edit_scheduled" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Save Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="draft">Save in Draft Box</option>
                            <option value="scheduled">Queue in Schedule Feed</option>
                            <option value="published">Publish Immediately</option>
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
        const editButtons = document.querySelectorAll('.edit-post-btn');
        const editForm = document.getElementById('editPostForm');
        const editPlatform = document.getElementById('edit_platform');
        const editContent = document.getElementById('edit_content');
        const editScheduled = document.getElementById('edit_scheduled');
        const editStatus = document.getElementById('edit_status');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const platform = this.getAttribute('data-platform');
                const content = this.getAttribute('data-content');
                const scheduled = this.getAttribute('data-scheduled');
                const status = this.getAttribute('data-status');

                editForm.action = `/admin/social/${id}`;
                editPlatform.value = platform;
                editContent.value = content;
                editScheduled.value = scheduled;
                editStatus.value = status;
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/social/index.blade.php ENDPATH**/ ?>