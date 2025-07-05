<?php $__env->startSection('title', 'Staff Directory - DTI NCMAP System'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people-fill"></i>
                        DTI Staff Directory - Region 7
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="<?php echo e(route('map.staff.directory')); ?>" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search Staff</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="<?php echo e(request('search')); ?>" 
                                       placeholder="Name, position, email...">
                            </div>
                            
                            <div class="col-md-3">
                                <label for="location_id" class="form-label">Office Location</label>
                                <select class="form-select" id="location_id" name="location_id">
                                    <option value="">All Offices</option>
                                    <?php $__currentLoopData = $offices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($office->id); ?>" <?php echo e(request('location_id') == $office->id ? 'selected' : ''); ?>>
                                            <?php echo e($office->office_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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
                            
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                    <a href="<?php echo e(route('map.staff.directory')); ?>" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Results Count -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="bi bi-person-badge"></i>
                            Found <?php echo e($staff->total()); ?> staff members
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('map.index')); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-map"></i> View Map
                            </a>
                        </div>
                    </div>

                    <!-- Staff Cards Grid -->
                    <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card staff-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0"><?php echo e($member->full_name); ?></h6>
                                            <span class="badge bg-<?php echo e($member->type_code === 'A' ? 'primary' : ($member->type_code === 'B' ? 'info' : 'success')); ?>">
                                                Type <?php echo e($member->type_code); ?>

                                            </span>
                                        </div>
                                        
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-briefcase"></i>
                                            <?php echo e($member->position); ?>

                                        </p>
                                        
                                        <?php if($member->officeLocation): ?>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-building"></i>
                                                <?php echo e($member->officeLocation->office_name); ?>

                                            </p>
                                        <?php endif; ?>
                                        
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-geo-alt"></i>
                                            <?php echo e($member->municipality); ?>, <?php echo e($member->province); ?>

                                        </p>
                                        
                                        <?php if($member->cellphone_number): ?>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-telephone"></i>
                                                <?php echo e($member->cellphone_number); ?>

                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if($member->email_address): ?>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-envelope"></i>
                                                <a href="mailto:<?php echo e($member->email_address); ?>" class="text-decoration-none">
                                                    <?php echo e($member->email_address); ?>

                                                </a>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if($member->service_area): ?>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-map"></i>
                                                <strong>Service Area:</strong> <?php echo e($member->service_area); ?>

                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if($member->contact_person): ?>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-person-check"></i>
                                                <strong>Contact Person:</strong> <?php echo e($member->contact_person); ?>

                                            </p>
                                        <?php endif; ?>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i>
                                                Added: <?php echo e($member->date_created->format('M d, Y')); ?>

                                            </small>
                                        </div>
                                        
                                        <?php if($member->officeLocation): ?>
                                            <div class="mt-2">
                                                <a href="<?php echo e(route('map.office.show', $member->officeLocation)); ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-building"></i> View Office
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
                                    <h5 class="mt-3 text-muted">No staff members found</h5>
                                    <p class="text-muted">Try adjusting your search criteria or browse all staff.</p>
                                    <a href="<?php echo e(route('map.staff.directory')); ?>" class="btn btn-primary">
                                        <i class="bi bi-arrow-clockwise"></i> Show All Staff
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if($staff->hasPages()): ?>
                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($staff->appends(request()->query())->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .staff-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .staff-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .staff-card .card-title {
        color: #0d6efd;
        font-weight: 600;
    }
    
    .staff-card .text-muted {
        font-size: 0.9rem;
    }
    
    .staff-card .text-muted i {
        width: 16px;
        margin-right: 8px;
    }
    
    .badge {
        font-size: 0.75rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-submit form on input change
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
    
    document.getElementById('location_id').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('province').addEventListener('change', function() {
        this.form.submit();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views/map/staff-directory.blade.php ENDPATH**/ ?>