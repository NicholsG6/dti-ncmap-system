<?php $__env->startSection('title', 'Manage Reminders - DTI NCMAP System'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-alarm"></i>
        Manage Reminders
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('admin.reminders.create')); ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-plus"></i> Add New Reminder
            </a>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.reminders.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="<?php echo e(request('search')); ?>" 
                       placeholder="Title, description...">
            </div>
            
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="Active" <?php echo e(request('status') === 'Active' ? 'selected' : ''); ?>>Active</option>
                    <option value="Completed" <?php echo e(request('status') === 'Completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="Cancelled" <?php echo e(request('status') === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority">
                    <option value="">All Priorities</option>
                    <option value="High" <?php echo e(request('priority') === 'High' ? 'selected' : ''); ?>>High</option>
                    <option value="Medium" <?php echo e(request('priority') === 'Medium' ? 'selected' : ''); ?>>Medium</option>
                    <option value="Low" <?php echo e(request('priority') === 'Low' ? 'selected' : ''); ?>>Low</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="location_id" class="form-label">Office Location</label>
                <select class="form-select" id="location_id" name="location_id">
                    <option value="">All Locations</option>
                    <?php $__currentLoopData = \App\Models\OfficeLocation::active()->orderBy('office_name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($office->id); ?>" <?php echo e(request('location_id') == $office->id ? 'selected' : ''); ?>>
                            <?php echo e($office->office_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
                <div class="btn-group w-100">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('admin.reminders.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Reminders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-alarm text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['active']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">High Priority</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['high_priority']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Overdue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['overdue']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reminders Table -->
<div class="card">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            Reminders (<?php echo e($reminders->total()); ?>)
        </h6>
    </div>
    <div class="card-body">
        <?php if($reminders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date & Time</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($reminder->is_overdue ? 'table-warning' : ''); ?>">
                                <td>
                                    <strong><?php echo e($reminder->title); ?></strong>
                                    <?php if($reminder->description): ?>
                                        <br><small class="text-muted"><?php echo e(Str::limit($reminder->description, 50)); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e($reminder->reminder_date->format('M d, Y')); ?></strong>
                                    <?php if($reminder->reminder_time_input): ?>
                                        <br><small class="text-muted"><?php echo e($reminder->reminder_time_input); ?></small>
                                    <?php endif; ?>
                                    <?php if($reminder->is_overdue): ?>
                                        <br><span class="badge bg-danger">Overdue</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($reminder->priority_color); ?>"><?php echo e($reminder->priority); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($reminder->status === 'Active' ? 'success' : ($reminder->status === 'Completed' ? 'primary' : 'secondary')); ?>">
                                        <?php echo e($reminder->status); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($reminder->officeLocation): ?>
                                        <small><?php echo e($reminder->officeLocation->office_name); ?></small>
                                    <?php elseif($reminder->staffMember): ?>
                                        <small><?php echo e($reminder->staffMember->full_name); ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">General</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?php echo e($reminder->creator->name ?? 'System'); ?></small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.reminders.show', $reminder)); ?>" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.reminders.edit', $reminder)); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete(<?php echo e($reminder->id); ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <?php echo e($reminders->appends(request()->query())->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-alarm" style="font-size: 3rem; color: #ccc;"></i>
                <h5 class="mt-3 text-muted">No reminders found</h5>
                <p class="text-muted">Create your first reminder to get started.</p>
                <a href="<?php echo e(route('admin.reminders.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Add New Reminder
                </a>
            </div>
        <?php endif; ?>
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
                Are you sure you want to delete this reminder? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
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
    function confirmDelete(reminderId) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/reminders/${reminderId}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    
    // Auto-submit form on select change
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('priority').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('location_id').addEventListener('change', function() {
        this.form.submit();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views/admin/reminders/index.blade.php ENDPATH**/ ?>