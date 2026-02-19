@extends('layouts.dashboard')

@section('title', 'Items Pending')

@section('content')
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ $pendingCount }}</h3>
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ $totalQty }}</h3>
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ $oldest?->received_at?->format('n/j/Y') ?? '--' }}</h3>
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
            <div class="seco-title">{{ $pendingCount }} Items Pending</div>
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
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->reference }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ optional($item->received_at)->format('n/j/Y') ?? '--' }}</td>
                                <td>
                                    @php
                                        $cls = match($item->stage){
                                            'Quality Check' => 'bg-info-subtle text-info',
                                            'Return Verification' => 'bg-danger-subtle text-danger',
                                            'Initial Inspection' => 'bg-success-subtle text-success',
                                            default => 'bg-warning-subtle text-warning'
                                        };
                                    @endphp
                                    <span class="badge {{ $cls }} py-1 px-2 fs-12">{{ $item->stage }}</span>
                                </td>
                                <td>{{ optional($item->est_completion)->format('n/j/Y') ?? '--' }}</td>
                                <td>{{ $item->note }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No pending items yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
