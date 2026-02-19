<?php
    $packageCount = $summary['package_count'] ?? 0;
    $itemCount = $summary['item_count'] ?? 0;
?>

<div class="mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <div class="fw-semibold">Preview: <span id="bulkPreviewPackageCount"><?php echo e($packageCount); ?></span> package<?php echo e($packageCount === 1 ? '' : 's'); ?> found</div>
        </div>
        <span class="badge bg-warning-subtle text-warning px-3 py-2">
            <span id="bulkPreviewItemCount"><?php echo e($itemCount); ?></span> total item<?php echo e($itemCount === 1 ? '' : 's'); ?>

        </span>
    </div>
</div>

<div class="accordion mtaccord accordion-flush" id="bulkUploadAccordion">
    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $ref = $pkg['reference'];
            $items = $pkg['items'] ?? [];
            $isDup = (bool)($pkg['is_duplicate'] ?? false);
        ?>

        <div class="accordion-item" data-ref="<?php echo e($ref); ?>">

            <h2 class="accordion-header d-flex align-items-center" id="bulkHeading<?php echo e($idx); ?>">
                
                <button
                    type="button"
                    class="btn btn-sm btn-light me-0 bulk-remove"
                    title="Remove package"
                    onclick="event.stopPropagation();"
                >
                    <i class="ri-close-line fs-20"></i>
                </button>

                <button
                    class="accordion-button <?php echo e($idx === 0 ? '' : 'collapsed'); ?>"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#bulkCollapse<?php echo e($idx); ?>"
                    aria-expanded="<?php echo e($idx === 0 ? 'true' : 'false'); ?>"
                    aria-controls="bulkCollapse<?php echo e($idx); ?>"
                >
                    <div class="d-flex align-items-center gap-2">

                        <i class="ri-box-3-line text-warning"></i>

                        <span class="fw-semibold"><?php echo e($ref); ?></span>

                        <span class="badge bg-secondary-subtle text-secondary">
                            <?php echo e(count($items)); ?> item<?php echo e(count($items) === 1 ? '' : 's'); ?>

                        </span>

                        <?php if($isDup): ?>
                            <span class="badge bg-danger-subtle text-danger">
                                Already exists
                            </span>
                        <?php endif; ?>

                    </div>
                </button>

            </h2>

            <div
                id="bulkCollapse<?php echo e($idx); ?>"
                class="accordion-collapse collapse <?php echo e($idx === 0 ? 'show' : ''); ?>"
                aria-labelledby="bulkHeading<?php echo e($idx); ?>"
                data-bs-parent="#bulkUploadAccordion"
            >
                <div class="accordion-body px-0 pt-2 pb-0">

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th style="width: 90px;">Qty</th>
                                    <th style="width: 150px;">Condition</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $cond = $it['condition'] ?? 'New';
                                        $badge = match($cond){
                                            'New' => 'bg-success-subtle text-success',
                                            'Used' => 'bg-warning-subtle text-warning',
                                            'Return' => 'bg-info-subtle text-info',
                                            'Return Review' => 'bg-danger-subtle text-danger',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                    ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo e($it['product_name']); ?></td>
                                        <td><?php echo e($it['quantity']); ?></td>
                                        <td>
                                            <span class="badge <?php echo e($badge); ?>"><?php echo e($cond); ?></span>
                                        </td>
                                        <td class="text-muted">
                                            <?php echo e($it['notes'] ?? ''); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(!empty($pkg['notes'])): ?>
                        <div class="bg-light p-2 text-muted">
                            <strong>Notes:</strong> <?php echo e($pkg['notes']); ?>

                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="alert alert-danger mt-3 d-none" id="bulkDupWarning">
    Some packages already exist in your account. Remove them from the preview (X button) or change their references in the file.
</div>
<?php /**PATH C:\xampp\htdocs\returnpals\resources\views/dashboard/partials/bulk_upload_preview.blade.php ENDPATH**/ ?>