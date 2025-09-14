<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MobilController extends Controller
{
    public function addmobil()
    {
        return Inertia::render('Admin/Mobil/AddMobil', []);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'durasi' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            $path = storage_path('app/public/uploads/admin/mobil');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            $imagePath = $image->storeAs('uploads/admin/mobil', $imageName, 'public');
            
            if (Storage::disk('public')->exists($imagePath)) {
                Log::info('File stored successfully at: ' . $imagePath);
            } else {
                Log::error('Failed to store file at: ' . $imagePath);
            }
            
            $validated['image'] = $imageName;
        }

        Mobil::create($validated);
        return Redirect::route('mobil.index');
    }

    public function mobil()
    {
        $mobil = Mobil::all();
        return Inertia::render('Admin/Mobil/Mobil', [     
            'mobil' => $mobil
        ]);
    }
    
    public function editmobil(Mobil $mobil)
    {
        return Inertia::render('Admin/Mobil/EditMobil', [
            'mobil' => $mobil
        ]);
    }
    
    public function update(Request $request, Mobil $mobil)
    {
        $validations = [
            'nama' => 'required|string|max:255',
            'harga' => 'nullable|string',
            'durasi' => 'nullable|string',
        ];

        if ($request->hasFile('image')) {
            $validations['image'] = 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validated = $request->validate($validations);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($mobil->image) {
                $oldImagePath = 'uploads/admin/mobil/' . $mobil->image;
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            $path = storage_path('app/public/uploads/admin/mobil');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $imagePath = $image->storeAs('uploads/admin/mobil', $imageName, 'public');
  
            if (Storage::disk('public')->exists($imagePath)) {
                Log::info('Updated file stored successfully at: ' . $imagePath);
            } else {
                Log::error('Failed to store updated file at: ' . $imagePath);
            }
            
            $validated['image'] = $imageName;
        }
        
        $mobil->update($validated);
        return Redirect::route('mobil.index');
    }

    public function destroy(Mobil $mobil)
    {
        if ($mobil->image) {
            $imagePath = 'uploads/admin/mobil/' . $mobil->image;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        
        $mobil->delete();
        return Redirect::route('mobil.index');
    }
}