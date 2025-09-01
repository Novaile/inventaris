<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;

class BarangKeluarController extends Controller
{
    public function index()
{
    $barangKeluar = BarangKeluar::with('barang')->get();
    $barang = Barang::all();
    return view('barangkeluar', compact('barangKeluar', 'barang'));
}
    public function create()
{
    $barang = Barang::all();
    return view('barangkeluar.create', compact('barang'));
}
public function store(Request $request)
{
    $request->validate([
        'barang_id' => 'required|exists:barang,id',
        'jumlah' => 'required|integer|min:1',
        'tanggal' => 'required|date',
    ]);

    $barang = Barang::findOrFail($request->barang_id);

    // Proteksi stok
    if ($barang->stok < $request->jumlah) {
    return redirect()->route('barangkeluar')->with('error', 'Stok tidak mencukupi');
    }

    // Kurangi stok
    $barang->stok -= $request->jumlah;
    $barang->save();

    // Simpan barang keluar
    BarangKeluar::create($request->all());

    return redirect()->route('barangkeluar')->with('success', 'Barang keluar berhasil ditambahkan, stok barang diperbarui.');
}

public function destroy($id)
{
    $barangKeluar = BarangKeluar::findOrFail($id);
    $barangKeluar->delete();

    return redirect()->back()->with('success', 'Data barang keluar berhasil dihapus.');
}

}
