<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\CmsSettingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aktmint', function () {
    return Inertia::render('Admin/Pesanan/Pesanan');
});


Route::prefix('admin/transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('add-pesanan', [PesananController::class, 'addpesanan']);
Route::post('add-pesanan', [PesananController::class, 'store']);
Route::get('/pesanan', [PesananController::class, 'pesanan'])->name('pesanan.index');
Route::get('pesanan/{pesanan}/edit', [PesananController::class, 'editpesanan']);
Route::put('/pesanan/{pesanan}', [PesananController::class, 'update']);
Route::delete('/pesanan/{pesanan}', action: [PesananController::class, 'destroy']); 

 

Route::get('add-paket-wisata', [PaketWisataController::class, 'addpaketwisata']);
Route::post('add-paket-wisata', [PaketWisataController::class, 'store']);
Route::get('/paket-wisata', [PaketWisataController::class, 'paketwisata'])->name('paketwisata.index');
Route::get('paket-wisata/{paketwisata}/edit', [PaketWisataController::class, 'editpaketwisata']);
Route::put('/paket-wisata/{paketwisata}', [PaketWisataController::class, 'update']);
Route::delete('/paket-wisata/{paketwisata}', action: [PaketWisataController::class, 'destroy']); 

Route::get('add-mobil', [MobilController::class, 'addmobil']);
Route::post('add-mobil', [MobilController::class, 'store']);
Route::get('/mobil', [MobilController::class, 'mobil'])->name('mobil.index');
Route::get('mobil/{mobil}/edit', [MobilController::class, 'editmobil']);
Route::put('/mobil/{mobil}', [MobilController::class, 'update']);
Route::delete('/mobil/{mobil}', action: [MobilController::class, 'destroy']);

Route::get('/CMS/Setting/AddSetting', [CmsSettingController::class, 'addcmssetting'])->name('cmssetting.add');
Route::post('/cms-setting', [CmsSettingController::class, 'store']);
Route::get('/cms-setting', [CmsSettingController::class, 'cmssetting'])->name('cmssetting.index');
Route::get('cms-setting/{cmssetting}/edit', [CmsSettingController::class, 'edit'])->name('cmssetting.edit');
Route::put('/cms-setting/{cmssetting}', [CmsSettingController::class, 'update'])->name('cmssetting.update');
Route::delete('/cms-setting/{cmssetting}', [CmsSettingController::class, 'destroy'])->name('cmssetting.destroy');
