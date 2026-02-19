<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Support\BulkPackageParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackagesBulkUploadController extends Controller
{
    public function preview(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:5120', 'mimes:csv,txt,xlsx'],
        ], [
            'file.mimes' => 'Please upload a CSV or XLSX file.',
            'file.max' => 'File is too large (max 5MB).',
        ]);

        $file = $request->file('file');
        $result = BulkPackageParser::parse($file->getPathname(), $file->getClientOriginalExtension());

        // Mark duplicates (already exist for this user)
        $refs = collect($result['packages'])->pluck('reference')->filter()->unique()->values();
        $existing = Package::where('user_id', Auth::id())
            ->whereIn('reference', $refs)
            ->pluck('reference')
            ->map(fn ($r) => (string) $r)
            ->all();
        $existingLookup = array_flip($existing);

        $packages = array_map(function ($p) use ($existingLookup) {
            $p['is_duplicate'] = isset($existingLookup[$p['reference']]);
            return $p;
        }, $result['packages']);

        $html = view('dashboard.partials.bulk_upload_preview', [
            'packages' => $packages,
            'summary' => $result['summary'],
        ])->render();

        return response()->json([
            'ok' => true,
            'html' => $html,
            'packages' => $packages,
            'summary' => $result['summary'],
        ]);
    }

    public function commit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'packages_json' => ['required', 'string'],
        ]);

        $packages = json_decode($data['packages_json'], true);
        if (!is_array($packages) || empty($packages)) {
            return back()->with('error', 'No packages to import. Please upload a file again.');
        }

        // Basic validation
        $refs = [];
        foreach ($packages as $idx => $p) {
            $ref = trim((string)($p['reference'] ?? ''));
            if ($ref === '') {
                return back()->with('error', 'One of the packages is missing a reference/tracking number.');
            }
            if (isset($refs[$ref])) {
                return back()->with('error', "Duplicate reference in file: {$ref}. Please fix and upload again.");
            }
            $refs[$ref] = true;

            $items = $p['items'] ?? [];
            if (!is_array($items) || count($items) < 1) {
                return back()->with('error', "Package {$ref} has no items.");
            }
        }

        // Prevent importing references that already exist
        $existing = Package::where('user_id', Auth::id())
            ->whereIn('reference', array_keys($refs))
            ->pluck('reference')
            ->all();
        if (!empty($existing)) {
            return back()->with('error', 'Some references already exist in your account: ' . implode(', ', $existing));
        }

        DB::transaction(function () use ($packages) {
            foreach ($packages as $p) {
                $package = Package::create([
                    'user_id' => Auth::id(),
                    'reference' => trim((string)$p['reference']),
                    'status' => 'In Transit',
                    'notes' => $p['notes'] ?? null,
                    'shipped_at' => now()->toDateString(),
                ]);

                $items = array_map(function ($i) {
                    return [
                        'product_name' => trim((string)($i['product_name'] ?? '')),
                        'quantity' => (int)($i['quantity'] ?? 1),
                        'condition' => trim((string)($i['condition'] ?? 'New')),
                        'notes' => isset($i['notes']) && trim((string)$i['notes']) !== '' ? trim((string)$i['notes']) : null,
                    ];
                }, $p['items'] ?? []);

                $package->items()->createMany($items);
            }
        });

        return redirect()->route('dashboard.overview')->with('success', 'Bulk upload completed successfully.');
    }
}
