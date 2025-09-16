<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak!');
        }

        if (Kategori::where('nama', $request->nama)->exists()) {
            return back()->with('error', 'Kategori sudah ada, gunakan nama lain.');
        }

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
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak!');
        }

        $request->validate(['nama' => 'required|string|max:255']);

        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Akses ditolak!');
        }

        $kategori = Kategori::findOrFail($id);

        // lebih cepat pakai exists()
        if ($kategori->barang()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh barang.');
        }

        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
