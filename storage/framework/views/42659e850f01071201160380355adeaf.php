<?php $__env->startSection('title', 'Sold Items'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h4 class="fw-semibold">Sold Items</h4>
                    <p class="mb-0 text-muted">Track your earnings from liquidated packages</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 fs-15 fw-medium">Total Earnings</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">£<?php echo e(number_format($totalEarnings, 2)); ?></h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-primary bg-opacity-10 rounded pkey-item">
                                <i class="ri-money-pound-box-line text-primary"></i>
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
                            <p class="mb-2 fs-15 fw-medium d-flex align-items-center gap-2">Items Sold</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0"><?php echo e($itemsSold); ?></h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-success bg-opacity-10 rounded pkey-item">
                                <i class="ri-list-check-3 text-success"></i>
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
                            <p class="mb-2 fs-15 fw-medium">Average Earnings</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">£<?php echo e(number_format($averageEarnings, 2)); ?></h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-warning bg-opacity-10 rounded pkey-item">
                                <i class="ri-money-pound-circle-line text-warning"></i>
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
                            <p class="mb-2 fs-15 fw-medium">Avg Margin</p>
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0"><?php echo e($avgMargin); ?>%</h3>
                        </div>
                        <div>
                            <div class="avatar-md bg-info bg-opacity-10 rounded pkey-item">
                                <i class="ri-percent-line text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Sold Items</div>
            <div class="seco-title"><?php echo e($items->count()); ?> Total Sold</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap table-hover table-centered mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="py-55">Reference</th>
                            <th class="py-55">Product</th>
                            <th class="py-55">Qty</th>
                            <th class="py-55">Unit Price</th>
                            <th class="py-55">Total Revenue</th>
                            <th class="py-55">Profit</th>
                            <th class="py-55">Margin</th>
                            <th class="py-55">Sold Date</th>
                            <th class="py-55">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->reference); ?></td>
                                <td><?php echo e($item->product_name); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td>$<?php echo e(number_format((float)$item->unit_price, 2)); ?></td>
                                <td class="text-success">$<?php echo e(number_format((float)$item->total_revenue, 2)); ?></td>
                                <td class="text-success">$<?php echo e(number_format((float)$item->profit, 2)); ?></td>
                                <td class="text-primary"><?php echo e($item->margin); ?>%</td>
                                <td><?php echo e(optional($item->sold_at)->format('n/j/Y') ?? '--'); ?></td>
                                <td>
                                    <span class="badge bg-success-subtle text-success py-1 px-2 fs-12"><?php echo e($item->status); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">No sold items yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/returnpals/returnpals/resources/views/dashboard/sold-items.blade.php ENDPATH**/ ?>