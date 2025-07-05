<?php $__env->startSection('title', 'Office Locations - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Office Locations</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('admin.offices.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Office Location
        </a>
    </div>
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.offices.index')); ?>" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="<?php echo e(request('search')); ?>" placeholder="Office name, code, address...">
            </div>
            <div class="col-md-3">
                <label for="province" class="form-label">Province</label>
                <select class="form-select" id="province" name="province">
                    <option value="">All Provinces</option>
                    <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($prov); ?>" <?php echo e(request('province') === $prov ? 'selected' : ''); ?>>
                            <?php echo e($prov); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Office Locations Table -->
<div class="card">
    <div class="card-body">
        <?php if($offices->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Office Details</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Staff</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $offices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($office->office_name); ?></strong><br>
                                    <small class="text-muted"><?php echo e($office->office_code); ?></small>
                                    <?php if($office->office_head): ?>
                                        <br><small class="text-muted">Head: <?php echo e($office->office_head); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($office->province); ?>, <?php echo e($office->municipality); ?><br>
                                    <small class="text-muted"><?php echo e(Str::limit($office->complete_address, 50)); ?></small>
                                </td>
                                <td>
                                    <?php if($office->contact_number): ?>
                                        <i class="bi bi-phone"></i> <?php echo e($office->contact_number); ?><br>
                                    <?php endif; ?>
                                    <?php if($office->email_address): ?>
                                        <i class="bi bi-envelope"></i> <?php echo e($office->email_address); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($office->staffMembers->count()); ?> members</span>
                                </td>
                                <td>
                                    <?php if($office->is_active): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.offices.show', $office)); ?>" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.offices.edit', $office)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="<?php echo e(route('admin.offices.destroy', $office)); ?>" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this office location?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing <?php echo e($offices->firstItem()); ?> to <?php echo e($offices->lastItem()); ?> of <?php echo e($offices->total()); ?> results
                </div>
                <?php echo e($offices->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-building" style="font-size: 3rem; color: #6c757d;"></i>
                <h4 class="mt-3 text-muted">No Office Locations Found</h4>
                <p class="text-muted">No office locations match your current filters.</p>
                <a href="<?php echo e(route('admin.offices.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Office Location
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views/admin/offices/index.blade.php ENDPATH**/ ?>