<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:100'
    ]);

    Kategori::create([
        'nama' => $request->nama
    ]);

    return redirect()->route('barang')->with('success', 'Kategori berhasil ditambahkan');
}

public function update(Request $request, $id)
{
    $request->validate(['nama' => 'required|string|max:255']);

    $kategori = Kategori::findOrFail($id);
    $kategori->update(['nama' => $request->nama]);

    return back()->with('success', 'Kategori berhasil diupdate');
}

public function destroy($id)
{
    $kategori = Kategori::findOrFail($id);

    // lebih cepat pakai exists()
    if ($kategori->barang()->exists()) {
        return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh barang.');
    }

    $kategori->delete();
    return back()->with('success', 'Kategori berhasil dihapus.');
}



}

