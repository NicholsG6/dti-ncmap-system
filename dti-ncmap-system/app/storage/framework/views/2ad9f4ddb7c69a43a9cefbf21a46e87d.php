<?php $__env->startSection('title', $office->office_name . ' - DTI NCMAP System'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <!-- Office Information -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-building"></i>
                        <?php echo e($office->office_name); ?>

                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="bi bi-info-circle"></i> Office Information</h6>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Office Code:</strong></td>
                                        <td><?php echo e($office->office_code); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Region:</strong></td>
                                        <td><?php echo e($office->region); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Province:</strong></td>
                                        <td><?php echo e($office->province); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Municipality:</strong></td>
                                        <td><?php echo e($office->municipality); ?></td>
                                    </tr>
                                    <?php if($office->district): ?>
                                        <tr>
                                            <td><strong>District:</strong></td>
                                            <td><?php echo e($office->district); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-geo-alt"></i> Location & Contact</h6>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td><?php echo e($office->complete_address); ?></td>
                                    </tr>
                                    <?php if($office->contact_number): ?>
                                        <tr>
                                            <td><strong>Contact:</strong></td>
                                            <td><?php echo e($office->contact_number); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($office->email_address): ?>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <a href="mailto:<?php echo e($office->email_address); ?>">
                                                    <?php echo e($office->email_address); ?>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($office->service_hours): ?>
                                        <tr>
                                            <td><strong>Service Hours:</strong></td>
                                            <td><?php echo e($office->service_hours); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if($office->office_description): ?>
                        <div class="mt-4">
                            <h6><i class="bi bi-card-text"></i> Description</h6>
                            <p class="text-muted"><?php echo e($office->office_description); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($office->office_head): ?>
                        <div class="mt-4">
                            <h6><i class="bi bi-person-badge"></i> Office Head</h6>
                            <p class="text-muted"><?php echo e($office->office_head); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary" onclick="getDirections(<?php echo e($office->latitude); ?>, <?php echo e($office->longitude); ?>)">
                            <i class="bi bi-geo-alt"></i> Get Directions
                        </button>
                        <a href="<?php echo e(route('map.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-map"></i> Back to Map
                        </a>
                        <a href="<?php echo e(route('map.staff.directory', ['location_id' => $office->id])); ?>" class="btn btn-outline-info">
                            <i class="bi bi-people"></i> View Staff (<?php echo e($office->staffMembers->count()); ?>)
                        </a>
                    </div>
                </div>
            </div>

            <!-- Office Map -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-map"></i>
                        Office Location
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div id="office-map" style="height: 400px;"></div>
                </div>
                
            </div>
        </div>

        <!-- Staff Members -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-people"></i>
                        Staff Members (<?php echo e($office->staffMembers->count()); ?>)
                    </h6>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <?php if($office->staffMembers->count() > 0): ?>
                        <?php $__currentLoopData = $office->staffMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 p-3 border rounded">
                                <h6 class="mb-1"><?php echo e($staff->full_name); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e($staff->position); ?></p>
                                
                                <?php if($staff->cellphone_number): ?>
                                    <p class="mb-1 small">
                                        <i class="bi bi-telephone"></i> <?php echo e($staff->cellphone_number); ?>

                                    </p>
                                <?php endif; ?>
                                
                                <?php if($staff->email_address): ?>
                                    <p class="mb-1 small">
                                        <i class="bi bi-envelope"></i> 
                                        <a href="mailto:<?php echo e($staff->email_address); ?>"><?php echo e($staff->email_address); ?></a>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">Type <?php echo e($staff->type_code); ?></small>
                                    <?php if($staff->service_area): ?>
                                        <small class="text-muted"><?php echo e($staff->service_area); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-people" style="font-size: 2rem;"></i>
                            <p class="mt-2">No staff members assigned</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-bar-chart"></i>
                        Quick Stats
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-primary mb-0"><?php echo e($office->staffMembers->count()); ?></h4>
                                <small class="text-muted">Staff</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-success mb-0"><?php echo e($office->staffMembers->where('type_code', 'A')->count()); ?></h4>
                                <small class="text-muted">Type A</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h4 class="text-info mb-0"><?php echo e($office->staffMembers->where('type_code', 'B')->count()); ?></h4>
                            <small class="text-muted">Type B</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let map;
    
    function initMap() {
        const officeLocation = { lat: <?php echo e($office->latitude); ?>, lng: <?php echo e($office->longitude); ?> };
        
        map = new google.maps.Map(document.getElementById('office-map'), {
            zoom: 15,
            center: officeLocation,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const marker = new google.maps.Marker({
            position: officeLocation,
            map: map,
            title: '<?php echo e($office->office_name); ?>',
            icon: {
                url: 'data:image/svg+xml;base64,' + btoa(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                        <circle cx="16" cy="16" r="12" fill="#0d6efd" stroke="white" stroke-width="2"/>
                        <text x="16" y="20" text-anchor="middle" fill="white" font-size="12" font-weight="bold">DTI</text>
                    </svg>
                `),
                scaledSize: new google.maps.Size(32, 32)
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="max-width: 250px;">
                    <h6><?php echo e($office->office_name); ?></h6>
                    <p class="mb-1"><strong>Code:</strong> <?php echo e($office->office_code); ?></p>
                    <p class="mb-1"><?php echo e($office->complete_address); ?></p>
                    <?php if($office->contact_number): ?>
                        <p class="mb-1"><strong>Contact:</strong> <?php echo e($office->contact_number); ?></p>
                    <?php endif; ?>
                </div>
            `
        });

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
        
        // Open info window by default
        infoWindow.open(map, marker);
    }
    
    function getDirections(lat, lng) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const origin = `${position.coords.latitude},${position.coords.longitude}`;
                const destination = `${lat},${lng}`;
                const url = `https://www.google.com/maps/dir/${origin}/${destination}`;
                window.open(url, '_blank');
            }, () => {
                const url = `https://www.google.com/maps/search/${lat},${lng}`;
                window.open(url, '_blank');
            });
        } else {
            const url = `https://www.google.com/maps/search/${lat},${lng}`;
            window.open(url, '_blank');
        }
    }
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\3rdweek\dti-ncmap-system\resources\views/map/office-details.blade.php ENDPATH**/ ?>