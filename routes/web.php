<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/barang', function () {
    return view('barang');
})->middleware(['auth', 'verified'])->name('barang');
Route::get('/barangmasuk', function () {
    return view('barangmasuk');
})->middleware(['auth', 'verified'])->name('barangmasuk');
Route::get('/barangkeluar', function () {
    return view('barangkeluar');
})->middleware(['auth', 'verified'])->name('barangkeluar');
Route::get('/laporan', function () {
    return view('laporan');
})->middleware(['auth', 'verified'])->name('laporan');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/barang', [BarangController::class, 'view'])->name('barang');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

    Route::get('/barang/search', [BarangController::class, 'search'])->name('barang.search');

    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barangmasuk.create');
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barangmasuk.store');
    Route::get('/barangmasuk', [BarangMasukController::class, 'index'])->name('barangmasuk');

    Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');
    Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');


    Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barangkeluar.create');
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
    Route::get('/barangkeluar', [BarangKeluarController::class, 'index'])->name('barangkeluar');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


});

require __DIR__.'/auth.php';
