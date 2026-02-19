@php
    $packageCount = $summary['package_count'] ?? 0;
    $itemCount = $summary['item_count'] ?? 0;
@endphp

<div class="mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <div class="fw-semibold">Preview: <span id="bulkPreviewPackageCount">{{ $packageCount }}</span> package{{ $packageCount === 1 ? '' : 's' }} found</div>
        </div>
        <span class="badge bg-warning-subtle text-warning px-3 py-2">
            <span id="bulkPreviewItemCount">{{ $itemCount }}</span> total item{{ $itemCount === 1 ? '' : 's' }}
        </span>
    </div>
</div>

<div class="accordion mtaccord accordion-flush" id="bulkUploadAccordion">
    @foreach($packages as $idx => $pkg)
        @php
            $ref = $pkg['reference'];
            $items = $pkg['items'] ?? [];
            $isDup = (bool)($pkg['is_duplicate'] ?? false);
        @endphp

        <div class="accordion-item" data-ref="{{ $ref }}">

            <h2 class="accordion-header d-flex align-items-center" id="bulkHeading{{ $idx }}">
                
                <button
                    type="button"
                    class="btn btn-sm btn-light me-0 bulk-remove"
                    title="Remove package"
                    onclick="event.stopPropagation();"
                >
                    <i class="ri-close-line fs-20"></i>
                </button>

                <button
                    class="accordion-button {{ $idx === 0 ? '' : 'collapsed' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#bulkCollapse{{ $idx }}"
                    aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                    aria-controls="bulkCollapse{{ $idx }}"
                >
                    <div class="d-flex align-items-center gap-2">

                        <i class="ri-box-3-line text-warning"></i>

                        <span class="fw-semibold">{{ $ref }}</span>

                        <span class="badge bg-secondary-subtle text-secondary">
                            {{ count($items) }} item{{ count($items) === 1 ? '' : 's' }}
                        </span>

                        @if($isDup)
                            <span class="badge bg-danger-subtle text-danger">
                                Already exists
                            </span>
                        @endif

                    </div>
                </button>

            </h2>

            <div
                id="bulkCollapse{{ $idx }}"
                class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}"
                aria-labelledby="bulkHeading{{ $idx }}"
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
                                @foreach($items as $it)
                                    @php
                                        $cond = $it['condition'] ?? 'New';
                                        $badge = match($cond){
                                            'New' => 'bg-success-subtle text-success',
                                            'Used' => 'bg-warning-subtle text-warning',
                                            'Return' => 'bg-info-subtle text-info',
                                            'Return Review' => 'bg-danger-subtle text-danger',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $it['product_name'] }}</td>
                                        <td>{{ $it['quantity'] }}</td>
                                        <td>
                                            <span class="badge {{ $badge }}">{{ $cond }}</span>
                                        </td>
                                        <td class="text-muted">
                                            {{ $it['notes'] ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(!empty($pkg['notes']))
                        <div class="bg-light p-2 text-muted">
                            <strong>Notes:</strong> {{ $pkg['notes'] }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    @endforeach
</div>


<div class="alert alert-danger mt-3 d-none" id="bulkDupWarning">
    Some packages already exist in your account. Remove them from the preview (X button) or change their references in the file.
</div>
