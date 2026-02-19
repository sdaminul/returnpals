<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvoicesController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::where('user_id', Auth::id())->latest('invoice_date')->get();
        return view('dashboard.invoices', compact('invoices'));
    }

    public function download(Invoice $invoice): StreamedResponse
    {
        abort_unless($invoice->user_id === Auth::id(), 403);

        $filename = $invoice->invoice_number . '.html';

        $html = view('dashboard.invoice-download', ['invoice' => $invoice])->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, ['Content-Type' => 'text/html; charset=UTF-8']);
    }
}
