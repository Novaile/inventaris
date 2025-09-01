@extends('layouts.app')

@section('content')
@section('title', 'Menu Laporan')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <div class="bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-green-600 mb-6">Laporan Barang Masuk & Keluar</h2>
                <form action="{{ route('laporan.export') }}" method="GET" class="space-x-2">
        <label for="bulan" class="bg-gray-700 border-gray-600 text-white rounded-md px-2 py-2">Pilih Bulan:</label>
        <select name="bulan" id="bulan" class="bg-gray-700 border-gray-600 text-white rounded-md required>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>

        <label for="tahun" class="bg-gray-700 border-gray-600 text-white rounded-md px-2 py-2">Pilih Tahun:</label>
        <select name="tahun" id="tahun" class="bg-gray-700 border-gray-600 text-white rounded-md" required>
            @for ($tahun = now()->year; $tahun >= 2025; $tahun--)
                <option value="{{ $tahun }}">{{ $tahun }}</option>
            @endfor
        </select>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded">
                    Export Excel
                </button>
    </form>


        <!-- Filter Tanggal -->
        <form method="GET" action="{{ url('laporan') }}" class="mb-6 flex flex-wrap gap-4 items-center">
            <div>
                <label for="dari" class="block font-medium text-gray-300">Dari Tanggal</label>
                <input type="date" name="dari" id="dari" class="bg-gray-700 border-gray-600 text-white rounded-md shadow-sm w-full" value="{{ request('dari') }}">
            </div>
            <div>
                <label for="sampai" class="block font-medium text-gray-300">Sampai Tanggal</label>
                <input type="date" name="sampai" id="sampai" class="bg-gray-700 border-gray-600 text-white rounded-md shadow-sm w-full" value="{{ request('sampai') }}">
            </div>
            <div class="pt-5">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Tampilkan
                </button>
                <button type="button" id="resetLaporan" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    Reset
                </button>
            </div>
        </form>


        <!-- Tabel Barang Masuk -->
        <h3 class="text-xl font-bold mt-6 mb-2 text-green-500">Barang Masuk</h3>
        <table class="w-full table-auto mb-8 text-base">
            <thead>
                <tr class="bg-green-600 text-gray-200">
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Nama Barang</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($barangMasuk as $masuk)
                    <tr class="odd:bg-gray-800 even:bg-gray-900">
                        <td class="px-4 py-2 text-gray-200">{{ $masuk->tanggal }}</td>
                        <td class="px-4 py-2 text-gray-200">{{ $masuk->barang->nama }}</td>
                        <td class="px-4 py-2 text-gray-200">{{ $masuk->jumlah }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-2 text-gray-500 italic">Tidak ada data barang masuk.</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tabel Barang Keluar -->
        <h3 class="text-xl font-bold mt-6 mb-2 text-red-500">Barang Keluar</h3>
        <table class="w-full table-auto text-base">
            <thead>
                <tr class="bg-red-600 text-white">
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Nama Barang</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($barangKeluar as $keluar)
                    <tr class="odd:bg-gray-800 even:bg-gray-900">
                        <td class="px-4 py-2 text-gray-200">{{ $keluar->tanggal }}</td>
                        <td class="px-4 py-2 text-gray-200">{{ $keluar->barang->nama }}</td>
                        <td class="px-4 py-2 text-gray-200">{{ $keluar->jumlah }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-2 text-gray-500 italic">Tidak ada data barang keluar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('resetLaporan').addEventListener('click', function() {
        document.getElementById('dari').value = '';
        document.getElementById('sampai').value = '';
        window.location.href = "{{ route('laporan') }}";
    });
});
</script>

@endsection
