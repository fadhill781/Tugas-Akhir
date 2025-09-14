<?php

namespace App\Http\Controllers;

use App\Models\CmsSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CmsSettingController extends Controller
{
   public function landing()
    {
        $setting = CmsSetting::first();

        return Inertia::render('Landing', [
    'setting' => $setting ? array_merge($setting->toArray(), [
        'image_url' => $setting->image_url
    ]) : null,
]);

    }

    public function create()
    {
        return Inertia::render('Admin/CMS/Setting/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'footer' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cmssettings', 'public');
            $validated['image'] = $path;
        }

        CmsSetting::create($validated);

        return redirect()->route('cmssetting.index')->with('success', 'Setting berhasil dibuat.');
    }

    public function edit(CmsSetting $cmsSetting)
    {
        return Inertia::render('Admin/CMS/Setting/Edit', [
            'cmsSetting' => $cmsSetting,
        ]);
    }

    public function cmssetting()
{
    $settings = CmsSetting::all();

    return Inertia::render('Admin/CMS/Setting/Setting', [
        'settings' => $settings,
    ]);
}

    public function update(Request $request, CmsSetting $cmsSetting)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'footer' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if ($cmsSetting->image && Storage::disk('public')->exists($cmsSetting->image)) {
                Storage::disk('public')->delete($cmsSetting->image);
            }

            $path = $request->file('image')->store('cmssettings', 'public');
            $validated['image'] = $path;
        }

        $cmsSetting->update($validated);

        return redirect()->route('cmssetting.index')->with('success', 'Setting berhasil diperbarui.');
    }

    public function destroy(CmsSetting $cmsSetting)
    {
        if ($cmsSetting->image && Storage::disk('public')->exists($cmsSetting->image)) {
            Storage::disk('public')->delete($cmsSetting->image);
        }

        $cmsSetting->delete();

        return redirect()->route('cmssetting.index')->with('success', 'Setting berhasil dihapus.');
    }
}
