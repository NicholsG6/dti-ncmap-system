<?php $__env->startSection('title', 'Staff Members - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Members</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Staff Member
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center bg-primary text-white">
            <div class="card-body">
                <h4 class="mb-0"><?php echo e($staffStats['total'] ?? 0); ?></h4>
                <small>Total Staff</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-success text-white">
            <div class="card-body">
                <h4 class="mb-0"><?php echo e($staffStats['active'] ?? 0); ?></h4>
                <small>Active</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-info text-white">
            <div class="card-body">
                <h4 class="mb-0"><?php echo e($staffStats['type_a'] ?? 0); ?></h4>
                <small>Type A</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center bg-warning text-white">
            <div class="card-body">
                <h4 class="mb-0"><?php echo e($staffStats['type_b'] ?? 0); ?></h4>
                <small>Type B</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.staff.index')); ?>" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="<?php echo e(request('search')); ?>" placeholder="Name, position, contact...">
            </div>
            <div class="col-md-2">
                <label for="location_id" class="form-label">Office Location</label>
                <select class="form-select" id="location_id" name="location_id">
                    <option value="">All Locations</option>
                    <?php $__currentLoopData = $offices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($location->id); ?>" <?php echo e(request('location_id') == $location->id ? 'selected' : ''); ?>>
                            <?php echo e($location->office_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="type_code" class="form-label">Type</label>
                <select class="form-select" id="type_code" name="type_code">
                    <option value="">All Types</option>
                    <option value="A" <?php echo e(request('type_code') === 'A' ? 'selected' : ''); ?>>Type A</option>
                    <option value="B" <?php echo e(request('type_code') === 'B' ? 'selected' : ''); ?>>Type B</option>
                    <option value="C" <?php echo e(request('type_code') === 'C' ? 'selected' : ''); ?>>Type C</option>
                </select>
            </div>
            <div class="col-md-2">
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
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Staff Members Table -->
<div class="card">
    <div class="card-body">
        <?php if($staff->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Staff Details</th>
                            <th>Location</th>
                            <th>Contact Information</th>
                            <th>Type & Status</th>
                            <th>Service Area</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <?php echo e(strtoupper(substr($staffMember->first_name, 0, 1) . substr($staffMember->last_name, 0, 1))); ?>

                                            </div>
                                        </div>
                                        <div>
                                            <strong><?php echo e($staffMember->first_name); ?> <?php echo e($staffMember->middle_name); ?> <?php echo e($staffMember->last_name); ?></strong><br>
                                            <small class="text-muted"><?php echo e($staffMember->position); ?></small><br>
                                            <?php if($staff->contact_person): ?>
                                                <small class="text-info">Contact: <?php echo e($staff->contact_person); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($staff->officeLocation): ?>
                                        <strong><?php echo e($staff->officeLocation->office_name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($staff->province); ?>, <?php echo e($staff->municipality); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo e($staff->province); ?>, <?php echo e($staff->municipality); ?></span>
                                    <?php endif; ?>
                                    <?php if($staff->district): ?>
                                        <br><small class="text-muted">District: <?php echo e($staff->district); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($staff->cellphone_number): ?>
                                        <i class="bi bi-phone"></i> <?php echo e($staff->cellphone_number); ?><br>
                                    <?php endif; ?>
                                    <?php if($staff->email_address): ?>
                                        <i class="bi bi-envelope"></i> <?php echo e($staff->email_address); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($staff->type_code === 'A' ? 'primary' : ($staff->type_code === 'B' ? 'info' : 'success')); ?> mb-1">
                                        Type <?php echo e($staff->type_code); ?>

                                    </span><br>
                                    <?php if($staff->type_advanced): ?>
                                        <small class="text-muted"><?php echo e($staff->type_advanced); ?></small><br>
                                    <?php endif; ?>
                                    <?php if($staff->is_active): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($staff->service_area): ?>
                                        <small><?php echo e(Str::limit($staff->service_area, 50)); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.staff.show', $staff)); ?>" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.staff.edit', $staff)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="<?php echo e(route('admin.staff.destroy', $staff)); ?>" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this staff member?')">
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
                    Showing <?php echo e($staffMembers->firstItem()); ?> to <?php echo e($staffMembers->lastItem()); ?> of <?php echo e($staffMembers->total()); ?> results
                </div>
                <?php echo e($staffMembers->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 3rem; color: #6c757d;"></i>
                <h4 class="mt-3 text-muted">No Staff Members Found</h4>
                <p class="text-muted">No staff members match your current filters.</p>
                <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Staff Member
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views/admin/staff/index.blade.php ENDPATH**/ ?>