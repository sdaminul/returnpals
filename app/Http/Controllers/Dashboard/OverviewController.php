<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OverviewController extends Controller
{
    public function index(): View
    {
        $packages = Package::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $inTransitCount = $packages->where('status', 'In Transit')->count();

        return view('dashboard.overview', compact('packages', 'inTransitCount'));
    }

    public function store(StorePackageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $package = Package::create([
                'user_id' => Auth::id(),
                'reference' => $data['reference'],
                'status' => 'In Transit',
                'notes' => $data['notes'] ?? null,
                'shipped_at' => now()->toDateString(),
            ]);

            $package->items()->createMany($data['items']);
        });

        return back()->with('success', 'Package added successfully.');
    }

    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($package, $data) {
            $package->update([
                'reference' => $data['reference'],
                'notes' => $data['notes'] ?? null,
            ]);

            $package->items()->delete();
            $package->items()->createMany($data['items']);
        });

        return back()->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $this->authorize('delete', $package);
        $package->delete();
        return back()->with('success', 'Package deleted successfully.');
    }
}
