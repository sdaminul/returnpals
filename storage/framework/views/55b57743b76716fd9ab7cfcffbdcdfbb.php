<?php $__env->startSection('title', 'Received'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h4 class="fw-semibold">Received</h4>
                    <p class="mb-0 text-muted">Packages that have been received and are being processed</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Received Packages</div>
            <div class="seco-title"><?php echo e($packages->count()); ?> Total Received</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap table-hover table-centered mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="py-55">Reference</th>
                            <th class="py-55">Items</th>
                            <th class="py-55">Qty</th>
                            <th class="py-55">Status</th>
                            <th class="py-55">Date Received</th>
                            <th class="py-55">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($package->reference); ?></td>
                                <td>
                                    <?php $__currentLoopData = $package->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($item->product_name); ?> (x<?php echo e($item->quantity); ?>)<?php if(!$loop->last): ?>, <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td><?php echo e($package->total_quantity); ?></td>
                                <td>
                                    <?php
                                        $cls = match($package->status){
                                            'Processed' => 'bg-success-subtle text-success',
                                            'Processing' => 'bg-warning-subtle text-warning',
                                            'Received' => 'bg-info-subtle text-info',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                    ?>
                                    <span class="badge <?php echo e($cls); ?> py-1 px-2 fs-12"><?php echo e($package->status); ?></span>
                                </td>
                                <td><?php echo e(optional($package->received_at)->format('n/j/Y') ?? '--'); ?></td>
                                <td><?php echo e($package->notes); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No received packages yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\returnpals\resources\views/dashboard/received.blade.php ENDPATH**/ ?>