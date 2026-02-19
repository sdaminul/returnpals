<?php $__env->startSection('title', 'Invoices'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h4 class="fw-semibold">Invoices</h4>
                    <p class="mb-0 text-muted">View and download your invoices</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Invoice List</div>
            <div class="seco-title"><?php echo e($invoices->count()); ?> invoice<?php echo e($invoices->count() === 1 ? '' : 's'); ?></div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap table-hover table-centered mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="py-55">Invoice #</th>
                            <th class="py-55">Customer</th>
                            <th class="py-55">Date</th>
                            <th class="py-55">Due Date</th>
                            <th class="py-55">Amount</th>
                            <th class="py-55">Items</th>
                            <th class="py-55">Status</th>
                            <th class="py-55 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($invoice->invoice_number); ?></td>
                                <td><?php echo e($invoice->customer); ?></td>
                                <td><?php echo e(optional($invoice->invoice_date)->format('n/j/Y') ?? '--'); ?></td>
                                <td><?php echo e(optional($invoice->due_date)->format('n/j/Y') ?? '--'); ?></td>
                                <td class="text-success">$<?php echo e(number_format((float)$invoice->amount, 2)); ?></td>
                                <td><?php echo e($invoice->items); ?></td>
                                <td>
                                    <?php $cls = $invoice->status === 'Paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'; ?>
                                    <span class="badge <?php echo e($cls); ?> py-1 px-2 fs-12"><?php echo e($invoice->status); ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('dashboard.invoices.download', $invoice)); ?>" title="Download"><i class="ri-download-2-fill fs-18"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No invoices yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/returnpals/returnpals/resources/views/dashboard/invoices.blade.php ENDPATH**/ ?>