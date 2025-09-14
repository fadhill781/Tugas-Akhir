<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\PaketWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaketWisataController extends Controller
{
    public function addpaketwisata()
    {
        return Inertia::render('Admin/PaketWisata/AddPaketWisata', []);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'nullable|string',
            'active_days' => 'nullable|string',
            'max_personil' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            $path = storage_path('app/public/uploads/admin/paket_wisata');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            $imagePath = $image->storeAs('uploads/admin/paket_wisata', $imageName, 'public');
            
            if (Storage::disk('public')->exists($imagePath)) {
                Log::info('File stored successfully at: ' . $imagePath);
            } else {
                Log::error('Failed to store file at: ' . $imagePath);
            }
            
            $validated['image'] = $imageName;
        }

        PaketWisata::create($validated);
        return Redirect::route('paketwisata.index');
    }

    public function paketwisata()
    {
        $paketwisata = PaketWisata::all();
        return Inertia::render('Admin/PaketWisata/PaketWisata', [     
            'paketwisata' => $paketwisata
        ]);
    }
    
    public function editpaketwisata(PaketWisata $paketwisata)
    {
        return Inertia::render('Admin/PaketWisata/EditPaketWisata', [
            'paketwisata' => $paketwisata
        ]);
    }
    
    public function update(Request $request, PaketWisata $paketwisata)
    {
        $validations = [
            'nama_wisata' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'harga' => 'nullable|string',
            'active_days' => 'nullable|string',
            'max_personil' => 'nullable|string',
        ];

        if ($request->hasFile('image')) {
            $validations['image'] = 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validated = $request->validate($validations);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($paketwisata->image) {
                $oldImagePath = 'uploads/admin/paket_wisata/' . $paketwisata->image;
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            $path = storage_path('app/public/uploads/admin/paket_wisata');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $imagePath = $image->storeAs('uploads/admin/paket_wisata', $imageName, 'public');
  
            if (Storage::disk('public')->exists($imagePath)) {
                Log::info('Updated file stored successfully at: ' . $imagePath);
            } else {
                Log::error('Failed to store updated file at: ' . $imagePath);
            }
            
            $validated['image'] = $imageName;
        }
        
        $paketwisata->update($validated);
        return Redirect::route('paketwisata.index');
    }

    public function destroy(PaketWisata $paketwisata)
    {
        if ($paketwisata->image) {
            $imagePath = 'uploads/admin/paket_wisata/' . $paketwisata->image;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        
        $paketwisata->delete();
        return Redirect::route('paketwisata.index');
    }
}