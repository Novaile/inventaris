<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="//unpkg.com/alpinejs" ></script>
    @stack('head')
</head>
<body class="bg-gray-900 flex" x-data="{ sidebarOpen: false }">
    <aside class="hidden md:flex flex-col justify-between w-64 bg-gray-800 h-screen shadow-md border-r border-gray-700">
    <div>
        <!-- Header -->
        <div class="p-4 text-xl font-bold border-b border-gray-700 text-center text-white">Inventaris</div>

        <!-- Menu -->
        <nav class="p-4">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="block px-3 py-2 rounded text-gray-300 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white' : '' }}">
                        Dashboard
                    </a>
                </li>

                <!-- Barang & Kategori -->
                <li>
                    <a href="{{ route('barang') }}"
                       class="block px-3 py-2 rounded text-gray-300 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('barang') ? 'bg-blue-800 text-white' : '' }}">
                        Barang & Kategori
                    </a>
                </li>

                <!-- Barang Masuk -->
                <li>
                    <a href="{{ route('barangmasuk') }}"
                       class="block px-3 py-2 rounded text-gray-300 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('barangmasuk') ? 'bg-blue-800 text-white' : '' }}">
                        Barang Masuk
                    </a>
                </li>

                <!-- Barang Keluar -->
                <li>
                    <a href="{{ route('barangkeluar') }}"
                       class="block px-3 py-2 rounded text-gray-300 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('barangkeluar') ? 'bg-blue-800 text-white' : '' }}">
                        Barang Keluar
                    </a>
                </li>

                <!-- Laporan -->
                <li>
                    <a href="{{ route('laporan') }}"
                       class="block px-3 py-2 rounded text-gray-300 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('laporan') ? 'bg-blue-800 text-white' : '' }}">
                        Laporan
                    </a>
                </li>

                <!-- Logout -->
                <li class="mt-8">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 py-2 rounded text-red-500 font-bold hover:bg-red-600 hover:text-white transition">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Bagian bawah sidebar -->
    @auth
        <div class="p-4 border-t border-gray-700 text-center">
            <p class="text-gray-400 text-sm">Anda login sebagai</p>
            <p class="text-white text-lg font-bold">
                {{ Auth::user()->role === 'admin' ? 'Admin' : 'Karyawan' }}
            </p>
        </div>
    @endauth
</aside>




    {{-- <div class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
         x-show="sidebarOpen"
         x-transition
         @click="sidebarOpen = false">
    </div>
    <aside class="fixed inset-y-0 left-0 w-64 bg-zinc-700 shadow-md z-50 transform -translate-x-full md:hidden"
           x-show="sidebarOpen"
           x-transition
           @click.away="sidebarOpen = false">
        <div class="p-4 text-xl font-bold border-b-2 border-white text-center text-white">Inventaris</div>
        <nav class="p-4">

            <ul class="space-y-2 text-white">
                <li>
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-yellow-400">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('barang') }}" class="block px-3 py-2 rounded hover:bg-yellow-400">
                        Barang & Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('barangmasuk') }}" class="block px-3 py-2 rounded hover:bg-yellow-400">
                        Barang Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('barangkeluar') }}" class="block px-3 py-2 rounded hover:bg-yellow-400">
                        Barang Keluar
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan') }}" class="block px-3 py-2 rounded hover:bg-yellow-400">
                        Laporan
                    </a>
                </li>
                <li class="mt-8">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-red-400 text-red-700 font-bold">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside> --}}

    {{-- Content --}}
    <main class="flex-1 p-6 overflow-y-auto w-full">
        {{-- Navbar top untuk mobile --}}
        <div class="flex items-center md:hidden mb-4">
            <button @click="sidebarOpen = true" class="text-gray-700 focus:outline-none">
                <!-- Hamburger icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="ml-4 text-lg font-bold">Inventaris</h1>
        </div>

        @yield('content')
    </main>

<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script>
function startScanner() {
    const modal = document.getElementById('scannerModal');
    modal.classList.remove('hidden');

    const video = document.getElementById('scanner');
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(stream => {
            video.srcObject = stream;
            video.setAttribute("playsinline", true);
            video.play();

            // Jalankan Quagga2
            Quagga.init({
                inputStream: {
                    type: "LiveStream",
                    target: video,
                    constraints: {
                        facingMode: "environment"
                    }
                },
                decoder: {
                    readers: [
                        "ean_reader",        // EAN-13 (makanan/minuman)
                        "ean_8_reader",      // EAN-8
                        "code_128_reader",
                        "code_39_reader",
                        "upc_reader"
                    ]
                },
                locate: true, // bantu deteksi posisi barcode
                frequency: 10 // percepat refresh
            }, function(err) {
                if (err) {
                    console.error(err);
                    return;
                }
                Quagga.start();
            });

            let lastResult = null;
            let sameResultCount = 0;

            Quagga.onDetected(data => {
                const code = data.codeResult.code;

                if (code === lastResult) {
                    sameResultCount++;
                } else {
                    lastResult = code;
                    sameResultCount = 1;
                }

                if (sameResultCount >= 2) { // harus 3x berturut-turut
                    document.querySelector('[name="kode_barang"]').value = code;
                    stopScanner();
                }
            });
        })
        .catch(err => {
            console.error("Gagal akses kamera:", err);
        });
}

function stopScanner() {
    const modal = document.getElementById('scannerModal');
    modal.classList.add('hidden');

    const video = document.getElementById('scanner');
    const stream = video.srcObject;
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    video.srcObject = null;

    Quagga.stop();
}
</script>



</body>
</html>



