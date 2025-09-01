@extends('layouts.app')

@section('content')
@section('title', 'Menu Barang Masuk')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-gray-800 shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-green-500">Barang Masuk</h2>
            <a href="{{ route('barangmasuk') }}?tambah=true"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm font-semibold">
                + Tambah Barang Masuk
            </a>
        </div>
        <table class="min-w-full divide-y divide-gray-700 text-lg">
        <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-300">Nama Barang</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-300">Jumlah</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-300">Tanggal</th>
                    <th class="px-4 py-2 text-center font-semibold text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-500">
                @forelse ($barangMasuk as $item)
                <tr class="odd:bg-gray-800 even:bg-gray-900">
                    <td class="px-4 py-2 text-gray-200">{{ $item->barang->nama }}</td>
                    <td class="px-4 py-2 text-gray-200">{{ $item->jumlah }}</td>
                    <td class="px-4 py-2 text-gray-200">{{ $item->tanggal }}</td>
                    <td class="px-4 py-2 text-center">
                        <form action="{{ route('barang-masuk.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Yakin mau hapus?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">Tidak ada data barang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- FORM TAMBAH overlay --}}
@if(request('tambah') === 'true')
<div class="fixed inset-0 bg-black bg-opacity-40 z-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl relative z-50">
        <h3 class="text-xl font-semibold text-green-600 mb-4">Tambah Barang Masuk</h3>
        <form action="{{ route('barangmasuk.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="barang_id" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <select name="barang_id" id="barang_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $b)
                        <option value="{{ $b->id }}">{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" min="1"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                {{-- <div class="mb-4">
                    <label class="block text-gray-700">Kode Barang</label>
                    <input type="text" id="kode-barang" name="kode_barang"
                        class="w-full border border-gray-300 px-3 py-2 rounded">
                </div> --}}
            </div>
                {{-- <button type="button" onclick="startScanner()" class="bg-blue-500 text-white px-3 rounded hover:bg-blue-600">
                        Scan
                </button> --}}
                <a href="{{ route('barangmasuk') }}"
                    class="mr-2 px-4 py-2 text-gray-600 border rounded hover:bg-gray-100">Batal</a>
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endif
<div id="scannerModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white p-4 rounded-lg w-full max-w-md relative">
        <video id="scanner" class="w-full"></video>
        <button type="button" onclick="stopScanner()"
                class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded">
            X
        </button>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif
@endsection
