<?php

namespace App\Http\Controllers;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $stokMenipis = Barang::where('stok', '<', 5)->orderBy('stok', 'asc')->get();
    $totalBarang = Barang::count();
    $totalStok = Barang::sum('stok');
    $bulanLabels = [];
    $masukData = [];
    $keluarData = [];
    $transaksiMasuk = BarangMasuk::with('barang')->whereYear('tanggal', now()->year)->get();
    $transaksiKeluar = BarangKeluar::with('barang')->whereYear('tanggal', now()->year)->get();

    $transaksiMasuk = BarangMasuk::with('barang') // pastikan relasi barang() ada di model
    ->orderBy('tanggal', 'desc')
    ->limit(7)
    ->get()
    ->map(function ($item) {
        $item->tipe = 'Masuk';
        return $item;
    });

    $transaksiKeluar = BarangKeluar::with('barang')
    ->orderBy('tanggal', 'desc')
    ->limit(7)
    ->get()
    ->map(function ($item) {
        $item->tipe = 'Keluar';
        return $item;
    });


$transaksiGabungan = $transaksiMasuk->merge($transaksiKeluar)
    ->sortByDesc('tanggal')
    ->take(limit: 7)
    ->values();

    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $bulanLabels[] = Carbon::create()->month($bulan)->format('F');

        $masuk = BarangMasuk::whereMonth('tanggal', $bulan)->whereYear('tanggal', now()->year)->sum('jumlah');
        $keluar = BarangKeluar::whereMonth('tanggal', $bulan)->whereYear('tanggal', now()->year)->sum('jumlah');

        $masukData[] = $masuk;
        $keluarData[] = $keluar;
    }

        return view('dashboard', [
        'bulanLabels' => $bulanLabels,
        'masukData' => $masukData,
        'keluarData' => $keluarData,
        'totalBarang' => $totalBarang,
        'totalStok' => $totalStok,
        'stokMenipis' => $stokMenipis,
        'transaksiTerakhir' => $transaksiGabungan,
    ]);
}
}
