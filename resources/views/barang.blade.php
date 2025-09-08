@extends('layouts.app')

@section('content')
@section('title', 'Menu Barang')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-gray-800 shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-green-500">Data Barang</h2>
        <div class="relative">
            <input type="text" id="searchInput" name="search"
                placeholder="Cari nama barang..."
                class="bg-gray-800 border-gray-600 text-white rounded-md shadow-sm px-3 py-2 text-sm focus:ring-green-400 focus:border-green-400 w-64">
            <div id="searchLoading" class="absolute top-2 right-3 hidden text-xs text-green-500">🔍</div>
            <button id="resetSearch" class="bg-red-500 hover:bg-red-600 text-black px-4 py-2 rounded text-white">
            Reset
            </button>
        </div>


        <button onclick="toggleKategoriForm()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kelola Kategori
        </button>
        <button onclick="toggleAddForm()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah Barang

        </div>
        <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-300">No</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-300">Nama Barang</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-300">Kode Barang</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-300">Kategori</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-300">Stok</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody id="barangTableBody" class="divide-y divide-gray-500">
                @foreach ($barang as $index => $item)
                <tr class="odd:bg-gray-800 even:bg-gray-900">
                    <td class="px-4 py-2 text-gray-200">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-gray-200">{{ $item->nama }}</td>
                    <td class="px-4 py-2 text-gray-200">{{ $item->kode_barang }}</td>
                    <td class="px-4 py-2 text-gray-200">{{ $item->kategori->nama }}</td>
                    <td class="px-4 py-2 text-gray-200">{{ $item->stok }}</td>
                    <td class="px-4 py-2 text-gray-200">
                        <a href="{{ route('barang.edit', $item->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if ($barang->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-4">Tidak ada data barang.</td>
                </tr>
                @endif
            </tbody>
        </table>

        {{-- kategori --}}
<div id="formKategori" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[500px] relative">
        <h2 class="text-xl font-semibold mb-4">Kelola Kategori</h2>

        <!-- List Kategori -->
        <table class="w-full border border-gray-200 mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1 border text-sm">No</th>
                    <th class="px-2 py-1 border text-sm">Nama</th>
                    <th class="px-2 py-1 border text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $kat)
                    <tr>
                        <td class="border px-2 py-1 text-sm">{{ $index + 1 }}</td>
                        <td class="border px-2 py-1 text-sm">{{ $kat->nama }}</td>
                        <td class="border px-2 py-1 text-sm flex gap-1">
                            <!-- Form Edit -->
                            <form action="{{ route('kategori.update', $kat->id) }}" method="POST" class="flex gap-1">
                                @csrf
                                @method('PUT')
                                <input type="text" name="nama" value="{{ $kat->nama }}"
                                    class="border rounded px-1 py-0.5 text-sm w-[150px] h-[28px]">
                                <button type="submit"
                                        class="bg-yellow-500 text-white px-2 rounded text-xs h-[28px] flex items-center">
                                    Edit
                                </button>
                            </form>

                            <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus kategori ini?')" class="flex">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-2 rounded text-xs h-[28px] flex items-center">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-500 py-2 text-sm">Tidak ada kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Form Tambah Kategori -->
        <form action="{{ route('kategori.store') }}" method="POST" class="border-t pt-4">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="nama" id="nama" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleKategoriForm()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah Kategori</button>
            </div>
        </form>
    </div>
</div>

{{-- Tambah Barang --}}
<div id="addForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md relative">
        <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Nama Barang</label>
                <input type="text" name="nama" class="w-full border border-gray-300 px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Kode Barang</label>

                <input type="text" name="kode_barang" id="kode_barang" class="w-full border border-gray-300 px-3 py-2 rounded">
                <button type="button" onclick="startScanner()" class="bg-blue-500 text-white px-3 rounded hover:bg-blue-600">
                    Scan
                </button>

            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Stok</label>
                <input type="number" name="stok" class="w-full border border-gray-300 px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="kategori_id" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>

            </div>
            <div class="flex justify-end">
                <button type="button" onclick="toggleAddForm()" class="mr-2 text-gray-500 hover:text-gray-700">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
            </div>
        </form>
    </div>
</div>
<div id="scannerModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white p-4 rounded-lg w-full max-w-md relative">
        <video id="scanner" class="w-full"></video>
        <button type="button" onclick="stopScanner()"
                class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded">
            X
        </button>
    </div>
</div>
    </div>
</div>


{{-- Edit --}}
@if (isset($barangToEdit))
<div class="fixed inset-0 bg-black bg-opacity-40 z-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl relative z-50">
        <h3 class="text-xl font-semibold text-yellow-600 mb-4">Edit Barang</h3>
        <form action="{{ route('barang.update', $barangToEdit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="nama" id="nama" value="{{ $barangToEdit->nama }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="kode_barang" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" value="{{ $barangToEdit->kode_barang }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="kategori_id" id="kategori_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ $barangToEdit->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ $barangToEdit->stok }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <a href="{{ route('barang') }}" class="mr-2 px-4 py-2 text-gray-600 border rounded hover:bg-gray-100">Batal</a>
                <button type="submit"
                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    const csrfToken = '{{ csrf_token() }}';
    function toggleKategoriForm() {
        document.getElementById('formKategori').classList.toggle('hidden');
    }

    function toggleAddForm() {
        const form = document.getElementById('addForm');
        form.classList.toggle('hidden');
    }

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('barangTableBody');
    const loadingIcon = document.getElementById('searchLoading');
    const resetButton = document.getElementById('resetSearch');

    // Fungsi untuk fetch data
    function fetchData(query) {
    loadingIcon.classList.remove('hidden');

    fetch(`/barang/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('barangTableBody');

            // Tambahkan kembali class
            tableBody.className = 'divide-y divide-gray-200';
            tableBody.innerHTML = '';

            if (data.length === 0) {
                const noDataRow = document.createElement('tr');
                noDataRow.innerHTML = `
                    <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data barang.</td>
                `;
                tableBody.appendChild(noDataRow);
                return;
            }

            data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200';

                row.innerHTML = `
                    <td class="px-4 py-2 text-sm text-gray-900">${index + 1}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">${item.nama}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">${item.kategori.nama}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">${item.stok}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">
                    <div class="flex flex-col space-y-1">
                        <a href="/barang/${item.id}/edit" class="text-blue-600 hover:underline">Edit</a>
                        <form action="/barang/${item.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Search error:', error);
        })
        .finally(() => {
            loadingIcon.classList.add('hidden');
        });
}

    // Listener pencarian
    searchInput.addEventListener('keyup', function () {
    const query = this.value.trim();
    if (query === '') {
        location.reload(); // biar tampilan rapi balik seperti awal
    } else {
        fetchData(query); // hanya fetch kalau memang ada query
    }
});

    // Tombol reset
    resetButton.addEventListener('click', function () {
        location.reload();
    });
});

</script>

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


