<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package;
use App\Models\PendingItem;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $newUsersLast7Days = User::where('created_at', '>=', now()->subDays(7))->count();
        $totalPackages = Package::count();
        $totalPendingItems = PendingItem::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'newUsersLast7Days',
            'totalPackages',
            'totalPendingItems'
        ));
    }
}
