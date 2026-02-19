<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $invoice->invoice_number }} - ReturnPal Invoice</title>
    <style>
        body{font-family:Arial, sans-serif; padding:24px; color:#111;}
        .row{display:flex; justify-content:space-between; gap:24px;}
        .card{border:1px solid #ddd; border-radius:10px; padding:16px;}
        h1{margin:0 0 8px 0; font-size:22px;}
        .muted{color:#555;}
        table{width:100%; border-collapse:collapse; margin-top:16px;}
        th,td{border:1px solid #ddd; padding:10px; text-align:left;}
        th{background:#f5f5f5;}
    </style>
</head>
<body>
    <div class="row">
        <div>
            <h1>Invoice {{ $invoice->invoice_number }}</h1>
            <div class="muted">ReturnPal</div>
        </div>
        <div class="card">
            <div><strong>Customer:</strong> {{ $invoice->customer }}</div>
            <div><strong>Date:</strong> {{ optional($invoice->invoice_date)->format('n/j/Y') }}</div>
            <div><strong>Due:</strong> {{ optional($invoice->due_date)->format('n/j/Y') }}</div>
            <div><strong>Status:</strong> {{ $invoice->status }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th style="width:120px">Items</th>
                <th style="width:160px">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Liquidation invoice</td>
                <td>{{ $invoice->items }}</td>
                <td>${{ number_format((float)$invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top:16px; text-align:right; font-size:18px;">
        <strong>Total:</strong> ${{ number_format((float)$invoice->amount, 2) }}
    </div>

    <p class="muted" style="margin-top:24px;">Tip: open this file in your browser and use Print → Save as PDF if you need a PDF copy.</p>
</body>
</html>
