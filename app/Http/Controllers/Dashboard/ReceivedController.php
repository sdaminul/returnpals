<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReceivedController extends Controller
{
    public function index(): View
    {
        $packages = Package::with('items')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['Received', 'Processing', 'Processed'])
            ->latest('received_at')
            ->get();

        return view('dashboard.received', compact('packages'));
    }
}
