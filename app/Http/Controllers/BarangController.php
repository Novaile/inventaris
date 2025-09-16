<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;


class BarangController extends Controller
{
    public function view()
    {
        $barang = Barang::with('kategori')->get();
        $kategori = Kategori::all();
        return view('barang', compact('barang', 'kategori'));
    }
    public function create(){
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak!');
        }
        $kategori = Kategori::all();
        return view('barang_create', compact('kategori'));

    }
    public function store(Request $request)
{
    if (Auth::user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak!');
        }
    $request->validate([
        'nama'=> 'required',
        'kategori_id'=> 'required|exists:kategori,id',
        'stok'=> 'required|integer|min:0',
        'kode_barang' => 'nullable|string|max:255',
    ]);

    if (Barang::where('nama', $request->nama)->exists()) {
        return back()->with('error', 'Nama barang sudah ada, tidak boleh duplikat!');
    }

    // Cek kode_barang duplikat (kalau user isi)
    if (!empty($request->kode_barang) && Barang::where('kode_barang', $request->kode_barang)->exists()) {
        return back()->with('error', 'Kode barang sudah digunakan, silakan pakai kode lain!');
    }

    Barang::create([
        'nama'=> $request->nama,
        'kategori_id'=> $request->kategori_id,
        'stok'=> $request->stok,
        'kode_barang' => $request->kode_barang,

    ]);

    return redirect()->route('barang')->with('success','barang berhasil ditambahkan');
}

    public function destroy($id){
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak!');
        }
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang')->with('success','sukses menghapus barang');
    }

        public function edit($id)
{
    if (Auth::user()->role !== 'admin') {
            return redirect()->route('barang')->with('error', 'Akses ditolak!');
        }
    $barang = Barang::with('kategori')->get();
    $barangToEdit = Barang::findOrFail($id);
    $kategori = Kategori::all();

    return view('barang', compact('barang', 'barangToEdit', 'kategori'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'kategori_id' => 'required|exists:kategori,id',
        'stok' => 'required|integer|min:0',
        'kode_barang' => 'nullable|string|max:255',
    ]);

    $stokBaru = $request->stok;
    if ($stokBaru < 0) {
        return back()->with('error', 'Stok tidak boleh kurang dari 0');
    }

    $barang = Barang::findOrFail($id);
    $barang->update([
        'nama' => $request->nama,
        'kategori_id' => $request->kategori_id,
        'stok' => $request->stok,
        'kode_barang' => $request->kode_barang,
    ]);

    return redirect()->route('barang')->with('success', 'Barang berhasil diedit.');
}

public function search(Request $request)
{
    $query = $request->query('q');

    if (empty($query)) {
        // Kalau query kosong, balikin semua data
        $barang = Barang::with('kategori')->get();
    } else {
        $barang = Barang::with('kategori')
            ->where('nama', 'LIKE', "%$query%")
            ->orWhereHas('kategori', function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%$query%");
            })
            ->get();
    }

    return response()->json($barang);
}

}
