<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PendingItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PendingController extends Controller
{
    public function index(): View
    {
        $items = PendingItem::where('user_id', Auth::id())
            ->latest('received_at')
            ->get();

        $pendingCount = $items->count();
        $totalQty = (int) $items->sum('quantity');
        $oldest = $items->filter(fn($i) => $i->received_at)->sortBy('received_at')->first();

        return view('dashboard.item-pending', compact('items', 'pendingCount', 'totalQty', 'oldest'));
    }
}
