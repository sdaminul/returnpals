<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SoldItemsController extends Controller
{
    public function index(): View
    {
        $items = SoldItem::where('user_id', Auth::id())
            ->latest('sold_at')
            ->get();

        $totalEarnings = (float) $items->sum('profit');
        $itemsSold = (int) $items->sum('quantity');
        $averageEarnings = $itemsSold > 0 ? $totalEarnings / $itemsSold : 0;
        $avgMargin = $items->count() > 0 ? round($items->avg('margin')) : 0;

        return view('dashboard.sold-items', compact('items', 'totalEarnings', 'itemsSold', 'averageEarnings', 'avgMargin'));
    }
}
