@extends('layouts.dashboard')

@section('title', 'Sold Items')

@section('content')
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">£{{ number_format($totalEarnings, 2) }}</h3>
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ $itemsSold }}</h3>
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">£{{ number_format($averageEarnings, 2) }}</h3>
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
                            <h3 class="text-dark fw-bold d-flex align-items-center gap-2 mb-0">{{ $avgMargin }}%</h3>
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
            <div class="seco-title">{{ $items->count() }} Total Sold</div>
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
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->reference }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format((float)$item->unit_price, 2) }}</td>
                                <td class="text-success">${{ number_format((float)$item->total_revenue, 2) }}</td>
                                <td class="text-success">${{ number_format((float)$item->profit, 2) }}</td>
                                <td class="text-primary">{{ $item->margin }}%</td>
                                <td>{{ optional($item->sold_at)->format('n/j/Y') ?? '--' }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success py-1 px-2 fs-12">{{ $item->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">No sold items yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
