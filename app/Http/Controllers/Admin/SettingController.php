<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private readonly SettingsService $settings) {}

    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => $this->settings->current()]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['notify_new_orders'] = $request->boolean('notify_new_orders');
        $data['sale_ends_at'] = $request->filled('sale_ends_at') ? $data['sale_ends_at'] : null;

        if ($request->hasFile('logo')) {
            $current = $this->settings->current();

            if ($current->logo && Storage::disk('public')->exists($current->logo)) {
                Storage::disk('public')->delete($current->logo);
            }

            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        $this->settings->update($data);

        return redirect()->route('admin.reglages.edit')->with('status', 'Réglages mis à jour.');
    }
}
