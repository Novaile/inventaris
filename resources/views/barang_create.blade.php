@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>

        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Barang</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="kategori_id" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Stok</label>
                <input type="number" name="stok" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('barang') }}" class="bg-red-200 text-sm text mr-4 px-4 py-2 rounded hover:bg-red-600">Batal</a>
                <button type="submit" class="bg-blue-200 text px-4 py-2 rounded hover:bg-blue-600 text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
