<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.condition' => ['required', 'string', 'max:50'],
            'items.*.notes' => ['nullable', 'string'],
        ]);

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

    public function update(Request $request, Package $package): RedirectResponse
    {
        abort_unless($package->user_id === Auth::id(), 403);

        $data = $request->validate([
            'reference' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.condition' => ['required', 'string', 'max:50'],
            'items.*.notes' => ['nullable', 'string'],
        ]);

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
        abort_unless($package->user_id === Auth::id(), 403);
        $package->delete();
        return back()->with('success', 'Package deleted successfully.');
    }
}
