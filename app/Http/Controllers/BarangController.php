<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Barang;


class BarangController extends Controller
{
    public function view()
    {
        $barang = Barang::with('kategori')->get();
        $kategori = Kategori::all();
        return view('barang', compact('barang', 'kategori'));

    }
    public function create(){
        $kategori = Kategori::all();
        return view('barang_create', compact('kategori'));
    }
    public function store(Request $request)
{
    $request->validate([
        'nama'=> 'required',
        'kategori_id'=> 'required|exists:kategori,id',
        'stok'=> 'required|integer|min:0',
        'kode_barang' => 'nullable|string|max:255|unique:barang,kode_barang',
    ]);

    Barang::create([
        'nama'=> $request->nama,
        'kategori_id'=> $request->kategori_id,
        'stok'=> $request->stok,
        'kode_barang' => $request->kode_barang,

    ]);

    return redirect()->route('barang')->with('success','barang berhasil ditambahkan');
}

    public function destroy($id){
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang')->with('success','sukses menghapus barang');
    }

        public function edit($id)
{
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
        'kode_barang' => 'nullable|string|max:255|unique:barang,kode_barang,' . $id,
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
