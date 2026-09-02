<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('admin.banners.index', [
            'banners' => Banner::orderBy('position')->orderBy('sort_order')->get(),
            'positions' => Banner::POSITIONS,
        ]);
    }

    public function create(): View
    {
        return view('admin.banners.create', [
            'banner' => new Banner(),
            'positions' => Banner::POSITIONS,
        ]);
    }

    public function store(StoreBannerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Banner::create([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'image' => $request->file('image')->store('banners', 'public'),
            'link_url' => $data['link_url'] ?? null,
            'position' => $data['position'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.bannieres.index')->with('status', 'Bannière créée.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', [
            'banner' => $banner,
            'positions' => Banner::POSITIONS,
        ]);
    }

    public function update(UpdateBannerRequest $request, Banner $banner): RedirectResponse
    {
        $data = $request->validated();

        $banner->update([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'link_url' => $data['link_url'] ?? null,
            'position' => $data['position'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $banner->update(['image' => $request->file('image')->store('banners', 'public')]);
        }

        return redirect()->route('admin.bannieres.index')->with('status', 'Bannière mise à jour.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if (Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.bannieres.index')->with('status', 'Bannière supprimée.');
    }
}
