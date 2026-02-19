<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="fw-semibold">Admin Dashboard</h4>
                <p class="mb-0 text-muted">Overview of system statistics</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-semibold fs-24 mb-1"><?php echo e($totalUsers); ?></h4>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                        <div>
                            <div class="avatar-sm bg-primary-subtle rounded">
                                <i class="ri-user-line fs-24 text-primary avatar-title"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-semibold fs-24 mb-1"><?php echo e($totalAdmins); ?></h4>
                            <p class="text-muted mb-0">Admin Users</p>
                        </div>
                        <div>
                            <div class="avatar-sm bg-success-subtle rounded">
                                <i class="ri-shield-user-line fs-24 text-success avatar-title"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-semibold fs-24 mb-1"><?php echo e($newUsersLast7Days); ?></h4>
                            <p class="text-muted mb-0">New Users (7 days)</p>
                        </div>
                        <div>
                            <div class="avatar-sm bg-info-subtle rounded">
                                <i class="ri-user-add-line fs-24 text-info avatar-title"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-semibold fs-24 mb-1"><?php echo e($totalPackages); ?></h4>
                            <p class="text-muted mb-0">Total Packages</p>
                        </div>
                        <div>
                            <div class="avatar-sm bg-warning-subtle rounded">
                                <i class="ri-box-3-line fs-24 text-warning avatar-title"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($totalPendingItems > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-semibold fs-24 mb-1"><?php echo e($totalPendingItems); ?></h4>
                            <p class="text-muted mb-0">Pending Items</p>
                        </div>
                        <div>
                            <div class="avatar-sm bg-danger-subtle rounded">
                                <i class="ri-time-line fs-24 text-danger avatar-title"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-primary">
                            <i class="ri-user-settings-line me-1"></i>
                            Manage Users
                        </a>
                        <a href="<?php echo e(route('dashboard.overview')); ?>" class="btn btn-outline-primary">
                            <i class="ri-dashboard-line me-1"></i>
                            View Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/returnpals/returnpals/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>