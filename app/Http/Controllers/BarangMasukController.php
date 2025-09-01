<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    public function index()
{
    $barangMasuk = BarangMasuk::with('barang')->get();
    $barang = Barang::all();
    return view('barangmasuk', compact('barangMasuk', 'barang'));
}
    public function create()
{
    $barang = Barang::all();
    return view('barangmasuk.create', compact('barang'));
}
public function store(Request $request)
{
    $request->validate([
        'barang_id' => 'required|exists:barang,id',
        'jumlah' => 'required|integer|min:1',
        'tanggal' => 'required|date',
    ]);

    BarangMasuk::create($request->all());

    // Tambahkan jumlah ke stok barang
    $barang = Barang::findOrFail($request->barang_id);
    $barang->stok += $request->jumlah;
    $barang->save();

    return redirect()->route('barangmasuk')->with('success', 'Barang masuk berhasil ditambahkan, stok barang diperbarui.');
}

public function destroy($id)
{
    $barangMasuk = BarangMasuk::findOrFail($id);
    $barangMasuk->delete();

    return redirect()->back()->with('success', 'Data barang masuk berhasil dihapus.');
}


}
