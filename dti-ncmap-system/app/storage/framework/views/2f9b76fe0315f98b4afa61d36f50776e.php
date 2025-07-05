<?php $__env->startSection('title', $reminder->title . ' - DTI NCMAP System'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-alarm"></i>
        Reminder Details
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.reminders.edit', $reminder)); ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.reminders.index')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Main Reminder Details -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo e($reminder->title); ?></h6>
                <div>
                    <span class="badge bg-<?php echo e($reminder->priority_color); ?> me-2"><?php echo e($reminder->priority); ?></span>
                    <span class="badge bg-<?php echo e($reminder->status === 'Active' ? 'success' : ($reminder->status === 'Completed' ? 'primary' : 'secondary')); ?>">
                        <?php echo e($reminder->status); ?>

                    </span>
                </div>
            </div>
            <div class="card-body">
                <?php if($reminder->description): ?>
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p class="text-muted"><?php echo e($reminder->description); ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Date & Time</h6>
                        <p>
                            <i class="bi bi-calendar text-primary"></i>
                            <strong><?php echo e($reminder->reminder_date->format('l, F j, Y')); ?></strong>
                        </p>
                        <?php if($reminder->reminder_time_input): ?>
                            <p>
                                <i class="bi bi-clock text-primary"></i>
                                <?php echo e($reminder->reminder_time_input); ?>

                            </p>
                        <?php else: ?>
                            <p class="text-muted">
                                <i class="bi bi-clock text-muted"></i>
                                All day reminder
                            </p>
                        <?php endif; ?>
                        
                        <?php if($reminder->is_overdue): ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Overdue</strong> - This reminder is past its due date.
                            </div>
                        <?php elseif($reminder->reminder_date_time > now() && $reminder->reminder_date_time < now()->addDays(1)): ?>
                            <div class="alert alert-info">
                                <i class="bi bi-clock"></i>
                                <strong>Due Soon</strong> - This reminder is due within 24 hours.
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Associated With</h6>
                        <?php if($reminder->officeLocation): ?>
                            <p>
                                <i class="bi bi-building text-primary"></i>
                                <strong>Office:</strong> <?php echo e($reminder->officeLocation->office_name); ?>

                            </p>
                            <p class="text-muted">
                                <?php echo e($reminder->officeLocation->complete_address); ?>

                            </p>
                            <a href="<?php echo e(route('admin.offices.show', $reminder->officeLocation)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-building"></i> View Office
                            </a>
                        <?php elseif($reminder->staffMember): ?>
                            <p>
                                <i class="bi bi-person text-primary"></i>
                                <strong>Staff:</strong> <?php echo e($reminder->staffMember->full_name); ?>

                            </p>
                            <p class="text-muted">
                                <?php echo e($reminder->staffMember->position); ?>

                                <?php if($reminder->staffMember->officeLocation): ?>
                                    <br><?php echo e($reminder->staffMember->officeLocation->office_name); ?>

                                <?php endif; ?>
                            </p>
                            <a href="<?php echo e(route('admin.staff.show', $reminder->staffMember)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-person"></i> View Staff
                            </a>
                        <?php else: ?>
                            <p class="text-muted">
                                <i class="bi bi-globe text-muted"></i>
                                General reminder (not associated with specific office or staff)
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Information -->
        <?php if($reminder->officeLocation && $reminder->officeLocation->staffMembers->count() > 0): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-people"></i>
                        Staff at <?php echo e($reminder->officeLocation->office_name); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $reminder->officeLocation->staffMembers->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle text-muted me-2"></i>
                                    <div>
                                        <strong><?php echo e($staff->full_name); ?></strong>
                                        <br><small class="text-muted"><?php echo e($staff->position); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if($reminder->officeLocation->staffMembers->count() > 6): ?>
                        <a href="<?php echo e(route('admin.offices.show', $reminder->officeLocation)); ?>" class="btn btn-sm btn-outline-primary mt-2">
                            View all <?php echo e($reminder->officeLocation->staffMembers->count()); ?> staff members
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <?php if($reminder->status === 'Active'): ?>
                    <form method="POST" action="<?php echo e(route('admin.reminders.update', $reminder)); ?>" class="mb-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="status" value="Completed">
                        <input type="hidden" name="title" value="<?php echo e($reminder->title); ?>">
                        <input type="hidden" name="reminder_date" value="<?php echo e($reminder->reminder_date->format('Y-m-d')); ?>">
                        <input type="hidden" name="priority" value="<?php echo e($reminder->priority); ?>">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Mark as Completed
                        </button>
                    </form>
                <?php endif; ?>
                
                <?php if($reminder->status !== 'Cancelled'): ?>
                    <form method="POST" action="<?php echo e(route('admin.reminders.update', $reminder)); ?>" class="mb-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="status" value="Cancelled">
                        <input type="hidden" name="title" value="<?php echo e($reminder->title); ?>">
                        <input type="hidden" name="reminder_date" value="<?php echo e($reminder->reminder_date->format('Y-m-d')); ?>">
                        <input type="hidden" name="priority" value="<?php echo e($reminder->priority); ?>">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-x-circle"></i> Cancel Reminder
                        </button>
                    </form>
                <?php endif; ?>
                
                <a href="<?php echo e(route('admin.reminders.edit', $reminder)); ?>" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-pencil"></i> Edit Reminder
                </a>
                
                <button type="button" class="btn btn-danger w-100" onclick="confirmDelete()">
                    <i class="bi bi-trash"></i> Delete Reminder
                </button>
            </div>
        </div>
        
        <!-- Reminder Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="bi bi-info-circle"></i> Reminder Info
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Created</label>
                    <div><?php echo e($reminder->created_at->format('M d, Y \a\t g:i A')); ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Last Updated</label>
                    <div><?php echo e($reminder->updated_at->format('M d, Y \a\t g:i A')); ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Created By</label>
                    <div><?php echo e($reminder->creator->name ?? 'System'); ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Priority Level</label>
                    <div>
                        <span class="badge bg-<?php echo e($reminder->priority_color); ?>"><?php echo e($reminder->priority); ?></span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Current Status</label>
                    <div>
                        <span class="badge bg-<?php echo e($reminder->status === 'Active' ? 'success' : ($reminder->status === 'Completed' ? 'primary' : 'secondary')); ?>">
                            <?php echo e($reminder->status); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="bi bi-arrow-left-right"></i> Navigate
                </h6>
            </div>
            <div class="card-body">
                <a href="<?php echo e(route('admin.reminders.index')); ?>" class="btn btn-outline-secondary w-100 mb-2">
                    <i class="bi bi-list"></i> All Reminders
                </a>
                <a href="<?php echo e(route('admin.reminders.create')); ?>" class="btn btn-outline-primary w-100">
                    <i class="bi bi-plus"></i> New Reminder
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the reminder "<?php echo e($reminder->title); ?>"? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="<?php echo e(route('admin.reminders.destroy', $reminder)); ?>" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views/admin/reminders/show.blade.php ENDPATH**/ ?>