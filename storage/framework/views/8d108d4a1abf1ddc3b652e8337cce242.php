<?php $__env->startSection('title', 'Manage Users'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="fw-semibold">Manage Users</h4>
                <p class="mb-0 text-muted">Search and manage user accounts</p>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>">
                        <div class="row g-2">
                            <div class="col-md-10">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Search by name or email..." 
                                    value="<?php echo e($search ?? ''); ?>"
                                >
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Users (<?php echo e($users->total()); ?>)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Admin Status</th>
                                    <th class="py-3">Joined</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($user->id); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img 
                                                    src="<?php echo e(asset('dashboard/assets/images/users/dummy-avatar.jpg')); ?>" 
                                                    alt="avatar" 
                                                    class="rounded-circle me-2" 
                                                    width="32" 
                                                    height="32"
                                                >
                                                <span><?php echo e($user->name); ?></span>
                                                <?php if($user->id === Auth::id()): ?>
                                                    <span class="badge bg-info-subtle text-info ms-2">You</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <?php if($user->is_admin): ?>
                                                <span class="badge bg-success-subtle text-success py-1 px-2">
                                                    <i class="ri-shield-check-line me-1"></i>Admin
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary py-1 px-2">
                                                    User
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($user->created_at->format('M d, Y')); ?></td>
                                        <td>
                                            <?php if($user->id !== Auth::id()): ?>
                                                <form method="POST" action="<?php echo e(route('admin.users.toggle-admin', $user)); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-sm <?php echo e($user->is_admin ? 'btn-warning' : 'btn-success'); ?>"
                                                        onclick="return confirm('Are you sure you want to <?php echo e($user->is_admin ? 'revoke' : 'grant'); ?> admin access for <?php echo e($user->name); ?>?')"
                                                    >
                                                        <i class="ri-shield-user-line me-1"></i>
                                                        <?php echo e($user->is_admin ? 'Revoke Admin' : 'Make Admin'); ?>

                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">Cannot modify own status</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <?php if($search): ?>
                                                No users found matching "<?php echo e($search); ?>"
                                            <?php else: ?>
                                                No users found
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($users->hasPages()): ?>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing <?php echo e($users->firstItem()); ?> to <?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?> users
                            </div>
                            <div>
                                <?php echo e($users->appends(['search' => $search])->links('pagination::bootstrap-5')); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/returnpals/returnpals/resources/views/admin/users/index.blade.php ENDPATH**/ ?>