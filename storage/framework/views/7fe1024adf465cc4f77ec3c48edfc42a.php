<?php $__env->startSection('title', 'Packages Sent'); ?>

<?php $__env->startSection('content'); ?>
    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h4 class="fw-semibold">Packages Sent</h4>
                    <p class="mb-0 text-muted">Track packages you've shipped for liquidation</p>
                </div>
                <div class="d-flex">
                    <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#bulkUpload">
                        <i class="ri-upload-2-line me-1"></i> Bulk Upload
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPackage">
                        <i class="ri-add-large-line me-1"></i> Add Package
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== Page Title End ========== -->

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>Your Packages</div>
            <div class="seco-title"><?php echo e($inTransitCount); ?> package<?php echo e($inTransitCount === 1 ? '' : 's'); ?> in transit</div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap table-hover table-centered mb-0">
                    <thead>
                        <tr>
                            <th class="py-55">Reference</th>
                            <th class="py-55">Products</th>
                            <th class="py-55">Total Qty</th>
                            <th class="py-55">Status</th>
                            <th class="py-55">Date Added</th>
                            <th class="py-55">Notes</th>
                            <th class="py-55"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($package->reference); ?></td>
                                <td>
                                    <?php
    $packages = $packages->map(function ($package) {
        $package->items_json = $package->items->map(function ($i) {
            return [
                'product_name' => $i->product_name,
                'quantity'     => $i->quantity,
                'condition'    => $i->condition,
                'notes'        => $i->notes,
            ];
        })->values();
        return $package;
    });
?>
                                    <?php $__currentLoopData = $package->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($item->product_name); ?> <span class="mx-1">x<?php echo e($item->quantity); ?></span>
                                        <?php
    $conditionClass = match($item->condition) {
        'New' => 'bg-success-subtle text-success',
        'Used' => 'bg-warning-subtle text-warning',
        'Return' => 'bg-info-subtle text-info',
        'Return Review' => 'bg-danger-subtle text-danger',
        default => 'bg-secondary-subtle text-secondary',
    };
?>

<span class="badge <?php echo e($conditionClass); ?> py-1 px-2 fs-12">
    <?php echo e($item->condition); ?>

</span>
                                        <?php if(!$loop->last): ?> <br> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td><?php echo e($package->total_quantity); ?></td>
                                <td>
                                    <?php
                                        $statusClass = match($package->status){
                                            'In Transit' => 'bg-primary-subtle text-primary',
                                            'Received' => 'bg-info-subtle text-info',
                                            'Processing' => 'bg-warning-subtle text-warning',
                                            'Processed' => 'bg-success-subtle text-success',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                    ?>
                                    <span class="badge <?php echo e($statusClass); ?> py-1 px-2 fs-12"><?php echo e($package->status); ?></span>
                                </td>
                                <td><?php echo e($package->created_at?->format('n/j/Y')); ?></td>
                                <td><?php echo e($package->notes); ?></td>
                                <td>
                                    <a href="#" class="edit-package"
                                       data-bs-toggle="modal" data-bs-target="#editPackage"
                                       data-id="<?php echo e($package->id); ?>"
                                       data-reference="<?php echo e($package->reference); ?>"
                                       data-notes="<?php echo e(e($package->notes ?? '')); ?>"
                                       data-items="<?php echo e(json_encode($package->items_json)); ?>">
                                        <i class="ri-edit-line fs-18"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No packages yet. Click “Add Package” to create one.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div class="modal fade" id="bulkUpload" tabindex="-1" aria-labelledby="bulkUploadTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkUploadTitle">Bulk Upload Packages</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded mb-3">
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="ri-download-2-line fs-24 text-primary"></i>
                                    <div class="ms-3">
                                        <div class="fs-19 fw-semibold">Download Template</div>
                                        <p class="mb-0 text-muted">Get the branded Excel template to fill in</p>
                                    </div>
                                </div>
                                <a href="<?php echo e(asset('dashboard/assets/ReturnPal_Package_Template.xlsx')); ?>" class="btn btn-success"><i class="ri-download-2-line me-1 fs-18"></i>Download</a>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded mb-3">
                        <div class="p-3">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <div class="fw-semibold">Upload a CSV or XLSX file</div>
                                    <div class="text-muted">We’ll parse your file and show a preview before creating packages.</div>
                                </div>
                                <div class="d-flex align-items-center w-100 gap-2">
                                    <input type="file" class="form-control" id="bulkFile" accept=".csv,.xlsx">
                                    <button type="button" class="btn btn-primary" id="bulkPreviewBtn" style="white-space: nowrap;">
                                        <i class="ri-upload-2-line me-1"></i>Upload a file
                                    </button>
                                </div>
                            </div>
                            <div class="small text-muted mt-1" id="bulkFileHelp">Max 5MB.</div>
                        </div>
                    </div>

                    <div class="alert alert-danger d-none" id="bulkUploadError"></div>

                    <form method="POST" action="<?php echo e(route('dashboard.packages.bulk.commit')); ?>" id="bulkCommitForm" class="d-none">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="packages_json" id="bulk_packages_json" value="">
                        <div id="bulkPreviewContainer"></div>

                        <div class="d-flex justify-content-end mt-3 gap-2">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" id="bulkCreateBtn">Create Packages</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Package Modal -->
    <div class="modal fade" id="addPackage" tabindex="-1" aria-labelledby="addPackageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPackageTitle">Add New Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('dashboard.packages.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Package Reference / Tracking Number</label>
                            <input name="reference" type="text" class="form-control" placeholder="e.g., TRACK-12345 or Royal Mail reference" required>
                        </div>

                        <div class="pb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-label mb-0">Products in Package</label>
                                <button type="button" class="btn btn-outline-primary btn-sm px-4 add-new" data-target="#addPackage">
                                    <i class="ri-add-large-line me-1"></i>Add New
                                </button>
                            </div>

                            <div class="product-wrapper" data-target="#addPackage">
                                <div class="product-row bg-light rounded p-2 grid grid-cols-12 gap-2 align-items-end mb-1">
                                    <div class="g-col-5 space-y-1">
                                        <label class="form-label">Product Name / SKU</label>
                                        <input name="items[0][product_name]" type="text" class="form-control" placeholder="e.g., iPhone Case" required>
                                    </div>

                                    <div class="g-col-2 space-y-1">
                                        <label class="form-label">Qty</label>
                                        <input name="items[0][quantity]" type="number" class="form-control" value="1" min="1" required>
                                    </div>

                                    <div class="g-col-4 space-y-1">
                                        <label class="form-label">Condition</label>
                                        <select name="items[0][condition]" class="form-select" required>
                                            <option>New</option>
                                            <option>Used</option>
                                            <option>Return</option>
                                            <option>Return Review</option>
                                        </select>
                                    </div>

                                    <div class="g-col-11 space-y-1">
                                        <input name="items[0][notes]" type="text" class="form-control item-note" placeholder="Add a note for this item (optional)">
                                    </div>

                                    <div class="g-col-1 d-flex justify-content-end">
                                        <button type="button" class="btn btn-sm btn-light remove-row" disabled>
                                            <i class="ri-delete-bin-line fs-18"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="notes" class="form-control" id="add_package_notes" placeholder="Any additional information..." style="height: 100px;"></textarea>
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-dark me-1" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Package</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Package Modal -->
    <div class="modal fade" id="editPackage" tabindex="-1" aria-labelledby="editPackageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageTitle">Edit Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="editPackageForm" method="POST" action="#">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label">Package Reference / Tracking Number</label>
                            <input name="reference" id="edit_reference" type="text" class="form-control" required>
                        </div>

                        <div class="pb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-label mb-0">Products in Package</label>
                                <button type="button" class="btn btn-outline-primary btn-sm px-4 add-new" data-target="#editPackage">
                                    <i class="ri-add-large-line me-1"></i>Add New
                                </button>
                            </div>

                            <div class="product-wrapper" id="edit_items" data-target="#editPackage"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="notes" id="edit_notes" class="form-control" placeholder="Any additional information..." style="height: 100px;"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" id="deletePackageBtn"><i class="ri-delete-bin-line me-1 fs-17 align-middle"></i>Delete Package</button>
                            <div>
                                <button type="button" class="btn btn-dark me-1" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>

                    <form id="deletePackageForm" method="POST" action="#" class="d-none">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden template row (used by JS) -->
    <template id="productRowTemplate">
        <div class="product-row bg-light rounded p-2 grid grid-cols-12 gap-2 align-items-end mb-1">
            <div class="g-col-5 space-y-1">
                <label class="form-label">Product Name / SKU</label>
                <input type="text" class="form-control" required>
            </div>
            <div class="g-col-2 space-y-1">
                <label class="form-label">Qty</label>
                <input type="number" class="form-control" value="1" min="1" required>
            </div>
            <div class="g-col-4 space-y-1">
                <label class="form-label">Condition</label>
                <select class="form-select" required>
                    <option>New</option>
                    <option>Used</option>
                    <option>Return</option>
                    <option>Return Review</option>
                </select>
            </div>

            <div class="g-col-11 space-y-1">
                <input type="text" class="form-control item-note" placeholder="Add a note for this item (optional)">
            </div>
            <div class="g-col-1 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-light remove-row">
                    <i class="ri-delete-bin-line fs-18"></i>
                </button>
            </div>
        </div>
    </template>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
(function(){
    function renumberRows(wrapper){
        const rows = wrapper.querySelectorAll('.product-row');
        rows.forEach((row, idx) => {
            row.querySelector('input[type="text"]').setAttribute('name', `items[${idx}][product_name]`);
            row.querySelector('input[type="number"]').setAttribute('name', `items[${idx}][quantity]`);
            row.querySelector('select').setAttribute('name', `items[${idx}][condition]`);
            const noteInput = row.querySelectorAll('input[type="text"]')[1];
            if(noteInput){
                noteInput.setAttribute('name', `items[${idx}][notes]`);
            }
            const removeBtn = row.querySelector('.remove-row');
            if(removeBtn){
                removeBtn.disabled = rows.length === 1;
            }
        });
    }

    function addRow(wrapper, values){
        const tpl = document.getElementById('productRowTemplate');
        const node = tpl.content.firstElementChild.cloneNode(true);
        if(values){
            node.querySelector('input[type="text"]').value = values.product_name || '';
            node.querySelector('input[type="number"]').value = values.quantity || 1;
            node.querySelector('select').value = values.condition || 'New';
            const noteInput = node.querySelectorAll('input[type="text"]')[1];
            if(noteInput){
                noteInput.value = values.notes || '';
            }
        }
        // delegated remove handler attached once per wrapper
        
        wrapper.appendChild(node);
        renumberRows(wrapper);
    }

    document.querySelectorAll('.product-wrapper').forEach(wrapper=>{
        wrapper.addEventListener('click', function(e){
            const btn = e.target.closest('.remove-row');
            if(!btn) return;
            const row = btn.closest('.product-row');
            if(!row || btn.disabled) return;
            row.remove();
            renumberRows(wrapper);
        });
    });

    document.querySelectorAll('.add-new').forEach(btn => {
        btn.addEventListener('click', function(){
            const target = document.querySelector(btn.getAttribute('data-target') + ' .product-wrapper');
            addRow(target);
        });
    });

    // Edit modal populate
    document.querySelectorAll('.edit-package').forEach(link => {
        link.addEventListener('click', function(){
            const id = link.getAttribute('data-id');
            const reference = link.getAttribute('data-reference');
            const notes = link.getAttribute('data-notes') || '';
            const items = JSON.parse(link.getAttribute('data-items') || '[]');

            document.getElementById('edit_reference').value = reference;
            document.getElementById('edit_notes').value = notes;

            const form = document.getElementById('editPackageForm');
            form.action = `<?php echo e(url('/dashboard/packages')); ?>/${id}`;

            const deleteForm = document.getElementById('deletePackageForm');
            deleteForm.action = `<?php echo e(url('/dashboard/packages')); ?>/${id}`;

            // Delete package
            const deleteBtn = document.getElementById('deletePackageBtn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function () {
                    if (!confirm('Are you sure you want to delete this package?')) {
                        return;
                    }

                    const deleteForm = document.getElementById('deletePackageForm');
                    if (deleteForm && deleteForm.action && deleteForm.action !== '#') {
                        deleteForm.submit();
                    }
                });
            }

            const wrapper = document.getElementById('edit_items');
            wrapper.innerHTML = '';
            if(items.length === 0){
                addRow(wrapper);
            } else {
                items.forEach(i => addRow(wrapper, i));
            }
        });
    });

    // Enable remove on initial row in Add modal
    document.querySelectorAll('#addPackage .product-row .remove-row').forEach(btn => {
        btn.addEventListener('click', function(){
            // handled by template rows; initial row is disabled
        });
    });

    // Bulk upload
    const bulkFileInput = document.getElementById('bulkFile');
    const bulkPreviewBtn = document.getElementById('bulkPreviewBtn');
    const bulkError = document.getElementById('bulkUploadError');
    const bulkCommitForm = document.getElementById('bulkCommitForm');
    const bulkPreviewContainer = document.getElementById('bulkPreviewContainer');
    const bulkPackagesJson = document.getElementById('bulk_packages_json');
    const bulkCreateBtn = document.getElementById('bulkCreateBtn');

    let bulkPackages = [];

    function showBulkError(msg){
        bulkError.textContent = msg;
        bulkError.classList.remove('d-none');
    }
    function clearBulkError(){
        bulkError.classList.add('d-none');
        bulkError.textContent = '';
    }

    function recalcBulkSummary(){
        const pkgCount = bulkPackages.length;
        const itemCount = bulkPackages.reduce((sum, p) => sum + (p.items ? p.items.length : 0), 0);
        const pkgEl = document.getElementById('bulkPreviewPackageCount');
        const itemEl = document.getElementById('bulkPreviewItemCount');
        if(pkgEl) pkgEl.textContent = pkgCount;
        if(itemEl) itemEl.textContent = itemCount;

        bulkCreateBtn.textContent = `Create ${pkgCount} Package${pkgCount===1?'':'s'}`;
        bulkCreateBtn.disabled = pkgCount === 0;

        // Warn if any duplicate remains
        const dupWarning = document.getElementById('bulkDupWarning');
        const hasDup = bulkPackages.some(p => p.is_duplicate);
        if(dupWarning){
            dupWarning.classList.toggle('d-none', !hasDup);
        }
    }

    function syncBulkJson(){
        bulkPackagesJson.value = JSON.stringify(bulkPackages.map(p => ({
            reference: p.reference,
            notes: p.notes ?? null,
            items: (p.items || []).map(i => ({
                product_name: i.product_name,
                quantity: i.quantity,
                condition: i.condition,
                notes: i.notes ?? null,
            }))
        })));
    }

    function bindBulkRemoveButtons(){
        bulkPreviewContainer.querySelectorAll('.bulk-remove').forEach(btn => {
            btn.addEventListener('click', function(e){
                e.preventDefault();
                const item = btn.closest('.accordion-item');
                if(!item) return;
                const ref = item.getAttribute('data-ref');
                item.remove();
                bulkPackages = bulkPackages.filter(p => p.reference !== ref);
                syncBulkJson();
                recalcBulkSummary();
            });
        });
    }

    if(bulkPreviewBtn){
        bulkPreviewBtn.addEventListener('click', async function(){
            clearBulkError();
            if(!bulkFileInput || !bulkFileInput.files || bulkFileInput.files.length === 0){
                showBulkError('Please choose a CSV or XLSX file first.');
                return;
            }

            const fd = new FormData();
            fd.append('file', bulkFileInput.files[0]);
            fd.append('_token', '<?php echo e(csrf_token()); ?>');

            bulkPreviewBtn.disabled = true;
            bulkPreviewBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Parsing...';

            try{
                const res = await fetch('<?php echo e(route('dashboard.packages.bulk.preview')); ?>', {
                    method: 'POST',
                    body: fd,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const json = await res.json();
                if(!json.ok){
                    showBulkError('Unable to parse file.');
                    return;
                }

                bulkPackages = json.packages || [];
                bulkPreviewContainer.innerHTML = json.html || '';
                bulkCommitForm.classList.remove('d-none');
                syncBulkJson();
                bindBulkRemoveButtons();
                recalcBulkSummary();
            } catch(err){
                showBulkError('Upload failed. Please try again.');
            } finally {
                bulkPreviewBtn.disabled = false;
                bulkPreviewBtn.innerHTML = '<i class="ri-upload-2-line me-1"></i>Upload a file';
            }
        });
    }
})();

(function () {
  function fillPackageNotesFromItemNotes(form, packageNotesSelector) {
    const packageNotesEl = form.querySelector(packageNotesSelector);
    if (!packageNotesEl) return;

    // If package notes already has something, do nothing
    if (packageNotesEl.value.trim() !== "") return;

    // Find first item-note input that has a value
    const itemNotes = form.querySelectorAll(".item-note");
    for (const input of itemNotes) {
      const v = (input.value || "").trim();
      if (v !== "") {
        packageNotesEl.value = v; // copy first non-empty note
        break;
      }
    }
  }

  // Add Package form
  const addForm = document.querySelector('#addPackage form');
  if (addForm) {
    addForm.addEventListener("submit", function () {
      fillPackageNotesFromItemNotes(addForm, "#add_package_notes");
    });
  }

  // Edit Package form
  const editForm = document.getElementById("editPackageForm");
  if (editForm) {
    editForm.addEventListener("submit", function () {
      fillPackageNotesFromItemNotes(editForm, "#edit_notes");
    });
  }
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/runner/work/returnpals/returnpals/resources/views/dashboard/overview.blade.php ENDPATH**/ ?>