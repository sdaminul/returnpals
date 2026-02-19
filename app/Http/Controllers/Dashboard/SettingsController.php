<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = UserSetting::firstOrCreate(['user_id' => Auth::id()]);
        return view('dashboard.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vat_registered' => ['nullable', 'boolean'],
            'discord_webhook_url' => ['nullable', 'url', 'max:255'],
        ]);

        $settings = UserSetting::firstOrCreate(['user_id' => Auth::id()]);
        $settings->update([
            'vat_registered' => (bool) ($data['vat_registered'] ?? false),
            'discord_webhook_url' => $data['discord_webhook_url'] ?? null,
        ]);

        return back()->with('success', 'Settings saved successfully.');
    }
}
