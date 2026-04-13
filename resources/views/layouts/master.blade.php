<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KoperasiKU')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 40;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.active { display: block; }
        #sidebar { transition: transform 0.3s ease; }
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 50;
                display: block !important;
                transform: translateX(-100%);
            }
            #sidebar.open { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <div id="sidebar-overlay" onclick="closeSidebar()"></div>

        <aside id="sidebar" class="w-64 bg-white border-r hidden md:flex flex-col flex-shrink-0">
            <div class="h-16 flex items-center justify-between px-6 border-b">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-store text-blue-500 text-lg"></i>
                    <h2 class="font-bold text-gray-800 text-lg">KOPERASIKU</h2>
                </div>
                <button onclick="closeSidebar()" class="md:hidden text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <nav class="mt-4 px-4">
                <div class="space-y-3">
                    <p class="text-xs text-gray-400 uppercase mb-2 font-medium">Menu Utama</p>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.6)]
                        {{ request()->routeIs('dashboard') || request()->routeIs('siswa.dashboard') || request()->routeIs('admin.dashboard') ? 'bg-sky-400 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-house w-4"></i>
                        Dashboard
                    </a>
                </div>

                @if(Auth::user()->role === 'siswa')
                <div class="space-y-3" style="margin-top: 1.5rem;">
                    <p class="text-xs text-gray-400 uppercase mb-2 font-medium">Layanan</p>
                    <a href="{{ route('pembelian.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('pembelian.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-cart-shopping w-4"></i>
                        Pembelian
                    </a>
                    <a href="{{ route('riwayat.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('riwayat.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-clock-rotate-left w-4"></i>
                        Riwayat
                    </a>
                </div>
                @endif
                @if(Auth::user()->role === 'admin')
                <div class="space-y-3" style="margin-top: 1.5rem;">
                    <p class="text-xs text-gray-400 uppercase mb-2 font-medium">Manajemen</p>
                    <a href="{{ route('products.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('products.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-box w-4"></i>
                        Produk
                    </a>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('laporan.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-chart-line w-4"></i>
                        Laporan
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white h-16 border-b px-4 md:px-6 flex items-center justify-between sticky top-0">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="md:hidden text-gray-500 hover:text-blue-500 transition text-xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-base md:text-lg font-semibold text-gray-700">
                        @yield('header', 'Dashboard')
                    </h1>
                </div>
                <div class="flex items-center gap-3 md:gap-5">
                    <button class="text-gray-500 hover:text-blue-500 transition">
                        <i class="fa-regular fa-bell text-lg"></i>
                    </button>
                    <div class="flex items-center gap-2">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.1755 3.50879C10.9755 3.50879 3.50879 10.9755 3.50879 20.1755C3.50879 29.3755 10.9755 36.8421 20.1755 36.8421C29.3755 36.8421 36.8421 29.3755 36.8421 20.1755C36.8421 10.9755 29.3755 3.50879 20.1755 3.50879ZM20.1755 10.1755C23.3921 10.1755 26.0088 12.7921 26.0088 16.0088C26.0088 19.2255 23.3921 21.8421 20.1755 21.8421C16.9588 21.8421 14.3421 19.2255 14.3421 16.0088C14.3421 12.7921 16.9588 10.1755 20.1755 10.1755ZM20.1755 33.5088C16.7921 33.5088 12.7921 32.1421 9.94212 28.7088C12.8618 26.4192 16.465 25.1748 20.1755 25.1748C23.8859 25.1748 27.4891 26.4192 30.4088 28.7088C27.5588 32.1421 23.5588 33.5088 20.1755 33.5088Z" fill="black"/>
                        </svg>
                        {{-- <div class="w-9 h-9 bg-blue-500 text-white flex items-center justify-center rounded-full text-sm font-semibold flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div> --}}
                        <span class="hidden sm:block text-sm font-medium text-gray-700 truncate max-w-[120px]">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-500 transition" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebar-overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>

    @stack('scripts')
</body>
</html>
