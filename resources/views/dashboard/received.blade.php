@extends('layouts.dashboard')

@section('title', 'Received')

@section('content')
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
            <div class="seco-title">{{ $packages->count() }} Total Received</div>
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
                        @forelse($packages as $package)
                            <tr>
                                <td>{{ $package->reference }}</td>
                                <td>
                                    @foreach($package->items as $item)
                                        {{ $item->product_name }} (x{{ $item->quantity }})@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>{{ $package->total_quantity }}</td>
                                <td>
                                    @php
                                        $cls = match($package->status){
                                            'Processed' => 'bg-success-subtle text-success',
                                            'Processing' => 'bg-warning-subtle text-warning',
                                            'Received' => 'bg-info-subtle text-info',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $cls }} py-1 px-2 fs-12">{{ $package->status }}</span>
                                </td>
                                <td>{{ optional($package->received_at)->format('n/j/Y') ?? '--' }}</td>
                                <td>{{ $package->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No received packages yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
