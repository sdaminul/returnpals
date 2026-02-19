@extends('layouts.dashboard')

@section('title', 'Invoices')

@section('content')
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
            <div class="seco-title">{{ $invoices->count() }} invoice{{ $invoices->count() === 1 ? '' : 's' }}</div>
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
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->customer }}</td>
                                <td>{{ optional($invoice->invoice_date)->format('n/j/Y') ?? '--' }}</td>
                                <td>{{ optional($invoice->due_date)->format('n/j/Y') ?? '--' }}</td>
                                <td class="text-success">${{ number_format((float)$invoice->amount, 2) }}</td>
                                <td>{{ $invoice->items }}</td>
                                <td>
                                    @php $cls = $invoice->status === 'Paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'; @endphp
                                    <span class="badge {{ $cls }} py-1 px-2 fs-12">{{ $invoice->status }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('dashboard.invoices.download', $invoice) }}" title="Download"><i class="ri-download-2-fill fs-18"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No invoices yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
