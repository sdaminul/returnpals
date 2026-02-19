<?php $__env->startSection('title', 'Items Pending'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h4 class="fw-semibold">Items Pending</h4>
                    <p class="mb-0 text-muted">Track items awaiting processing, inspection, or quality checks</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 fs-15 fw-medium">Pending Items</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0"><?php echo e($pendingCount); ?></h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-primary bg-opacity-10 rounded pkey-item">
                                <i class="ri-time-line text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 fs-15 fw-medium d-flex align-items-center gap-2">Total Quantity</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0"><?php echo e($totalQty); ?></h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-success bg-opacity-10 rounded pkey-item">
                                <i class="ri-list-view text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 fs-15 fw-medium">Oldest Stock</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0"><?php echo e($oldest?->received_at?->format('n/j/Y') ?? '--'); ?></h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-warning bg-opacity-10 rounded pkey-item">
                                <i class="ri-unsplash-line text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Items Pending Sale</div>
            <div class="seco-title"><?php echo e($pendingCount); ?> Items Pending</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap table-hover table-centered mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="py-55">Reference</th>
                            <th class="py-55">Product</th>
                            <th class="py-55">Qty</th>
                            <th class="py-55">Received Date</th>
                            <th class="py-55">Current Stage</th>
                            <th class="py-55">Est. Completion</th>
                            <th class="py-55">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->reference); ?></td>
                                <td><?php echo e($item->product_name); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td><?php echo e(optional($item->received_at)->format('n/j/Y') ?? '--'); ?></td>
                                <td>
                                    <?php
                                        $cls = match($item->stage){
                                            'Quality Check' => 'bg-info-subtle text-info',
                                            'Return Verification' => 'bg-danger-subtle text-danger',
                                            'Initial Inspection' => 'bg-success-subtle text-success',
                                            default => 'bg-warning-subtle text-warning'
                                        };
                                    ?>
                                    <span class="badge <?php echo e($cls); ?> py-1 px-2 fs-12"><?php echo e($item->stage); ?></span>
                                </td>
                                <td><?php echo e(optional($item->est_completion)->format('n/j/Y') ?? '--'); ?></td>
                                <td><?php echo e($item->note); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No pending items yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\returnpals\resources\views/dashboard/item-pending.blade.php ENDPATH**/ ?>