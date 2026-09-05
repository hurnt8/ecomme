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
    /**
     * Nothing on the site paints the logo above 56px, so anything past this is bytes with no
     * visible return. See downscaleLogo().
     */
    private const MAX_LOGO_PX = 512;

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

            $this->downscaleLogo($data['logo']);
        }

        $this->settings->update($data);

        return redirect()->route('admin.reglages.edit')->with('status', 'Réglages mis à jour.');
    }

    /**
     * Logos are stored at whatever resolution they were exported at — the first one uploaded was
     * 1254x1254 for 1 MB, downloaded on every page of the shop to be painted 56px tall. Aspect
     * ratio and PNG transparency are preserved; a file already within budget is left alone.
     */
    private function downscaleLogo(string $path): void
    {
        $disk = Storage::disk('public');
        $contents = $disk->get($path);

        $source = @imagecreatefromstring($contents);

        if ($source === false) {
            return; // Not a raster image GD understands (an SVG, say) — leave it untouched.
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $longest = max($width, $height);

        if ($longest <= self::MAX_LOGO_PX) {
            imagedestroy($source);

            return;
        }

        $ratio = self::MAX_LOGO_PX / $longest;
        $target = imagecreatetruecolor((int) round($width * $ratio), (int) round($height * $ratio));

        // Without these a transparent PNG comes back with a black background.
        imagealphablending($target, false);
        imagesavealpha($target, true);

        imagecopyresampled(
            $target, $source,
            0, 0, 0, 0,
            imagesx($target), imagesy($target),
            $width, $height
        );

        ob_start();
        str_ends_with(strtolower($path), '.png') ? imagepng($target, null, 8) : imagejpeg($target, null, 88);
        $resized = (string) ob_get_clean();

        imagedestroy($source);
        imagedestroy($target);

        if ($resized !== '') {
            $disk->put($path, $resized);
        }
    }
}
