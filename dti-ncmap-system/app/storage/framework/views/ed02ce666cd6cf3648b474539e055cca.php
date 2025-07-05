<?php $__env->startSection('title', 'Admin Dashboard - DTI NCMAP System'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-download"></i> Export
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Offices
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_offices']); ?></div>
                        <small class="text-success"><?php echo e($stats['active_offices']); ?> active</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Staff
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_staff']); ?></div>
                        <small class="text-success"><?php echo e($stats['active_staff']); ?> active</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Reminders
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_reminders']); ?></div>
                        <small class="text-info"><?php echo e($stats['active_reminders']); ?> active</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-alarm text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_users']); ?></div>
                        <small class="text-warning"><?php echo e($stats['admin_users']); ?> admins</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-circle text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Today's Reminders -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Today's Reminders</h6>
                <a href="<?php echo e(route('admin.reminders.index')); ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($todaysReminders->count() > 0): ?>
                    <?php $__currentLoopData = $todaysReminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3 p-3 border rounded reminder-<?php echo e(strtolower($reminder->priority)); ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?php echo e($reminder->title); ?></h6>
                                    <p class="mb-1 text-muted"><?php echo e(Str::limit($reminder->description, 100)); ?></p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> <?php echo e($reminder->reminder_time ? $reminder->reminder_time->format('H:i') : 'All day'); ?>

                                        <?php if($reminder->officeLocation): ?>
                                            | <i class="bi bi-building"></i> <?php echo e($reminder->officeLocation->office_name); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                                <span class="badge bg-<?php echo e($reminder->priority_color); ?>"><?php echo e($reminder->priority); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-check" style="font-size: 2rem;"></i>
                        <p class="mt-2">No reminders for today</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Upcoming Reminders -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Upcoming Reminders</h6>
                <a href="<?php echo e(route('admin.reminders.index')); ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($upcomingReminders->count() > 0): ?>
                    <?php $__currentLoopData = $upcomingReminders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3 p-2 border-start border-3 border-<?php echo e($reminder->priority_color); ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1"><?php echo e($reminder->title); ?></h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> <?php echo e($reminder->reminder_date->format('M d, Y')); ?>

                                        <?php if($reminder->reminder_time): ?>
                                            <i class="bi bi-clock"></i> <?php echo e($reminder->reminder_time->format('H:i')); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                                <span class="badge bg-<?php echo e($reminder->priority_color); ?>"><?php echo e($reminder->priority); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                        <p class="mt-2">No upcoming reminders</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Offices -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Office Locations</h6>
                <a href="<?php echo e(route('admin.offices.index')); ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentOffices->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <?php $__currentLoopData = $recentOffices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($office->office_name); ?></strong><br>
                                            <small class="text-muted"><?php echo e($office->office_code); ?></small>
                                        </td>
                                        <td>
                                            <?php echo e($office->province); ?><br>
                                            <small class="text-muted"><?php echo e($office->municipality); ?></small>
                                        </td>
                                        <td>
                                            <?php if($office->is_active): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-building" style="font-size: 2rem;"></i>
                        <p class="mt-2">No office locations yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Staff -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Staff Members</h6>
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentStaff->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <?php $__currentLoopData = $recentStaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($staff->full_name); ?></strong><br>
                                            <small class="text-muted"><?php echo e($staff->position); ?></small>
                                        </td>
                                        <td>
                                            <?php echo e($staff->officeLocation?->office_name ?? 'N/A'); ?><br>
                                            <small class="text-muted"><?php echo e($staff->province); ?></small>
                                        </td>
                                        <td>
                                            <?php if($staff->is_active): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                        <p class="mt-2">No staff members yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>