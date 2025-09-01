@extends('layouts.app')

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
@endpush

@section('content')
@section('title', 'Dashboard')


<div class="flex flex-wrap gap-6 justify-between items-start mt-4 relative ">
    <div class="flex gap-6">
    <!-- Total Barang -->
    <div class="bg-emerald-600 rounded shadow w-[282px] overflow-hidden">
        <div class="p-4 flex justify-between items-center">
            <div>
                <div class="text-sm text-white">Total Barang</div>
                <div class="text-xl font-bold text-white">{{ $totalBarang }}</div>
            </div>
            <div>
                <i class="fa-solid fa-box-open text-4xl text-white"></i>
            </div>
        </div>
        @auth
    @if(Auth::user()->role === 'admin')
        <a href="/barang" class="bg-green-600 hover:bg-green-700 block text-center text-white text-sm font-semibold py-2">
            Kelola Barang →
        </a>
    @else
        <a href="/barang" class="bg-green-600 hover:bg-green-700 block text-center text-white text-sm font-semibold py-2">
            Lihat Barang →
        </a>
    @endif
@endauth
    </div>

    <!-- Total Stok Barang -->
    <div class="bg-emerald-600 rounded shadow w-[282px] overflow-hidden">
        <div class="p-4 flex justify-between items-center">
            <div>
                <div class="text-sm text-white">Total Stok Barang</div>
                <div class="text-xl font-bold text-white">{{ $totalStok }}</div>
            </div>
            <div>
                <i class="fa-solid fa-cubes text-4xl text-white"></i>
            </div>
        </div>
        @auth
    @if(Auth::user()->role === 'admin')
        <a href="/barangmasuk" class="bg-green-600 hover:bg-green-700 block text-center text-white text-sm font-semibold py-2">
            Tambah Stok Barang →
        </a>
    @else
        <a href="/barangmasuk" class="bg-green-600 hover:bg-green-700 block text-center text-white text-sm font-semibold py-2">
            Lihat Stok Barang →
        </a>
    @endif
    @endauth
    </div>
</div>

 {{-- transaksi terakhir --}}
    <div class="bg-sky-900 p-4 rounded shadow w-full md:w-1/3 absolute top-0 right-4">
        <h2 class="text-lg text-white font-bold mb-2">Transaksi Terakhir</h2>
        @if($transaksiTerakhir->isEmpty())
            <p class="text-white">Belum ada transaksi</p>
        @else
            <ul class="text-s">
                @foreach ($transaksiTerakhir as $transaksi)
                        <li class="border-b py-1 flex justify-between items-center px-2">
                            <div>
                                <div class="font-semibold {{ $transaksi->tipe === 'Masuk' ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ ucfirst($transaksi->tipe) }}
                                </div>
                                <div class="text-xs text-white">
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-white">
                                    {{ $transaksi->barang->nama ?? '-' }}
                                </div>
                            </div>
                            <div class="text-right text-sm text-white font-bold">
                                {{ $transaksi->jumlah }} pcs
                            </div>
                        </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

{{-- stok menipis --}}
<div class="bg-teal-900 p-4 rounded shadow w-[500px] md:w-[590px] mt-4 border border-gray-700">
  <h2 class="text-white mb-3">Stok Menipis</h2>
  <ul class="text-white space-y-2">
    @foreach ($stokMenipis as $barang)
      <li class="flex justify-between border-b pb-1">
        <span>{{ $barang->nama }}</span>
        <span class="text-white font-semibold">{{ $barang->stok }} pcs</span>
      </li>
    @endforeach
  </ul>
</div>

<div class="w-full md:w-[50%] mt-4">
    <div class="bg-gray-800 border border-gray-700 p-4 rounded shadow text-white">
        <h2 class="text-xl text-white mb-4">Grafik Barang Masuk & Keluar ({{ now()->year }})</h2>
        <div class="relative h-64 w-full">
            <canvas id="grafikBarang" class="absolute inset-0 w-full h-full"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikBarang').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: {!! json_encode($masukData) !!},
                    backgroundColor:'#3B82F6',
                },
                {
                    label: 'Barang Keluar',
                    data: {!! json_encode($keluarData) !!},
                    backgroundColor: '#EF4444',
                }
            ]
        },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            ticks: {
                color: "white"
            },
            grid: {
                color: "white"
            }
        },
        y: {
            beginAtZero: true,
            ticks: {
                color: "white"
            },
            grid: {
                color: "white"
            }
        }
    },
    plugins: {
        legend: {
            labels: {
                color: "white" // warna teks legend
            }
        }
    }
}


    });
</script>
@endsection
