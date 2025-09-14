<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function addpesanan()
    {
        return Inertia::render('Admin/Pesanan/AddPesanan', []);
    }

    public function store(Request $request)
{
   $validated = $request->validate([
    'nama' => 'required|string|max:255',
    'waktu' => 'required|date',
    'total' => 'required|integer|min:0',
    'aksi' => 'nullable|string|max:255', // tergantung jenis datanya
]);

    Pesanan::create($validated);

    return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan.');
}


    public function update(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
    'nama' => 'required|string|max:255',
    'waktu' => 'required|date',
    'total' => 'required|integer|min:0',
    'aksi' => 'nullable|string|max:255', // tergantung jenis datanya
]);

        $pesanan->update($validated);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function pesanan()
    {
        $pesanan = Pesanan::all();
        return Inertia::render('Admin/Pesanan/Pesanan', [
            'pesanan' => $pesanan
        ]);
    }

    public function editPesanan(Pesanan $pesanan)
    {
        return Inertia::render('Admin/Pesanan/EditPesanan', [
            'pesanan' => $pesanan
        ]);
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
