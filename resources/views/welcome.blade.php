<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'KoperasiKU') }} - Point of Sale Koperasi Sekolah</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6, .outfit { font-family: 'Outfit', sans-serif; }
        
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
        }
    </style>
</head>
<body class="bg-pattern antialiased text-slate-800 overflow-x-hidden relative min-h-screen flex flex-col selection:bg-sky-500 selection:text-white">

    <!-- Background Blobs -->
    <div class="blob bg-sky-300 w-96 h-96 rounded-full top-0 left-[-10%] mix-blend-multiply"></div>
    <div class="blob bg-indigo-300 w-96 h-96 rounded-full bottom-[-10%] right-[-10%] mix-blend-multiply"></div>
    <div class="blob bg-pink-200 w-80 h-80 rounded-full top-[20%] right-[10%] mix-blend-multiply delay-150"></div>

    <!-- Navigation -->
    <nav class="absolute w-full top-0 z-50 px-6 py-6 lg:px-12 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-indigo-600 flex items-center justify-center rounded-xl shadow-lg shadow-sky-500/30 text-white">
                <i class="fa-solid fa-store text-lg"></i>
            </div>
            <span class="text-xl font-bold outfit tracking-tight text-slate-800">Koperasi<span class="text-sky-600">KU</span></span>
        </div>
        
        <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
            <a href="#features" class="hover:text-sky-600 transition-colors">Fitur Unggulan</a>
            <a href="#about" class="hover:text-sky-600 transition-colors">Tentang Sistem</a>
            <a href="#testimonials" class="hover:text-sky-600 transition-colors">Testimoni</a>
        </div>
        
        <div class="flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl font-semibold text-sm bg-slate-800 text-white hover:bg-slate-700 transition shadow-lg hover:-translate-y-0.5 ease-out duration-200">
                        Ke Dashboard <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl font-semibold text-sm text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition shadow-sm hover:shadow hover:-translate-y-0.5 ease-out duration-200">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl font-semibold text-sm bg-gradient-to-r from-sky-500 to-indigo-600 text-white hover:from-sky-600 hover:to-indigo-700 transition shadow-lg shadow-sky-500/30 hover:shadow-sky-500/50 hover:-translate-y-0.5 ease-out duration-200 hidden sm:block">
                            Daftar Siswa
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 flex flex-col justify-center relative z-10 pt-20 lg:pt-0">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 w-full grid lg:grid-cols-2 gap-12 items-center min-h-[85vh]">
            
            <!-- Left Header -->
            <div class="flex flex-col items-start pt-16 lg:pt-0">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold mb-6 shadow-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Sistem POS Terbaru v2.0
                </div>
                
                <h1 class="outfit text-5xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-slate-900 mb-6 drop-shadow-sm">
                    Kelola Koperasi <br> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600">Lebih Modern</span> & Mudah<span class="text-sky-500">.</span>
                </h1>
                
                <p class="text-slate-600 text-lg leading-relaxed mb-10 max-w-lg font-medium">
                    Tingkatkan efisiensi koperasi sekolah dengan sistem Point of Sale terpadu. Transaksi cepat, pencatatan otomatis, dan laporan realtime dalam satu genggaman.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-bold text-base bg-gradient-to-r from-sky-500 to-indigo-600 text-white hover:from-sky-600 hover:to-indigo-700 transition shadow-[0_0_40px_-10px_rgba(14,165,233,0.5)] hover:shadow-[0_0_60px_-15px_rgba(14,165,233,0.7)] hover:-translate-y-1 ease-out duration-300">
                                Buka Dashboard <i class="fa-solid fa-rocket ml-1"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-bold text-base bg-white text-slate-800 border border-slate-200 hover:bg-slate-50 transition shadow-lg hover:shadow-xl hover:-translate-y-1 ease-out duration-300">
                                Masuk 
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-bold text-base bg-gradient-to-r from-sky-500 to-indigo-600 text-white hover:from-sky-600 hover:to-indigo-700 transition shadow-[0_0_40px_-10px_rgba(14,165,233,0.5)] hover:shadow-[0_0_60px_-15px_rgba(14,165,233,0.7)] hover:-translate-y-1 ease-out duration-300">
                                    Daftar 
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Small Info -->
                <div class="mt-12 flex items-center gap-6 text-sm font-semibold text-slate-500">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-check text-xs"></i>
                        </div>
                        Mudah Digunakan
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center">
                            <i class="fa-solid fa-bolt text-xs"></i>
                        </div>
                        Sangat Cepat
                    </div>
                </div>
            </div>

            <!-- Right Visuals -->
            <div class="relative hidden lg:block float-animation h-full flex items-center justify-center">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-gradient-to-br from-sky-400/20 to-indigo-500/20 rounded-[3rem] transform rotate-3 scale-105 filter blur-3xl"></div>
                
                <!-- Main Visual Container -->
                <div class="relative w-full aspect-square max-w-lg mx-auto bg-white/40 p-6 rounded-[2.5rem] border border-white/50 shadow-2xl glass-card z-10 flex flex-col items-center justify-center overflow-hidden">
                    
                    <!-- App Mockup UI -->
                    <div class="w-full bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden relative z-20 transform -rotate-2 hover:rotate-0 transition-transform duration-500 hover:scale-105 origin-bottom-right">
                        <!-- header -->
                        <div class="h-12 border-b border-slate-100 flex items-center px-4 justify-between bg-slate-50">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                            </div>
                            <div class="h-4 w-32 bg-slate-200 rounded-full"></div>
                        </div>
                        <!-- body -->
                        <div class="p-4 grid grid-cols-3 gap-4">
                            <div class="col-span-2 space-y-4">
                                <div class="h-24 bg-gradient-to-br from-sky-400 to-indigo-500 rounded-xl flex items-center px-4 text-white p-3">
                                    <div class="h-8 w-8 bg-white/20 rounded-lg backdrop-blur-md flex items-center justify-center">
                                       <i class="fa-solid fa-wallet text-sm pt-1"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="w-16 h-2 bg-white/50 rounded-full mb-2"></div>
                                        <div class="w-24 h-4 bg-white rounded-full"></div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                     <div class="h-20 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center p-2"><i class="fa-solid fa-burger text-sky-500 text-2xl opacity-80"></i></div>
                                     <div class="h-20 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center p-2"><i class="fa-solid fa-mug-hot text-amber-500 text-2xl opacity-80"></i></div>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-xl border border-slate-100 p-3 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="h-3 w-full bg-slate-200 rounded-full"></div>
                                    <div class="h-6 w-full bg-emerald-100 rounded-md"></div>
                                    <div class="h-6 w-full bg-sky-100 rounded-md"></div>
                                </div>
                                <div class="h-10 w-full bg-slate-800 rounded-lg mt-4 flex items-center justify-center">
                                    <div class="w-8 h-2 bg-white/50 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badges -->
                    <div class="absolute -right-6 top-20 bg-white px-4 py-3 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 animate-bounce shadow-sky-500/10 z-30 transform rotate-6">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 font-semibold mb-0.5">Penjualan</div>
                            <div class="font-bold text-slate-800 text-sm">+24% Hari ini</div>
                        </div>
                    </div>
                    
                    <div class="absolute -left-8 bottom-16 bg-white px-4 py-3 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 shadow-indigo-500/10 z-30 transform -rotate-3" style="animation: bounce 2s infinite 1s;">
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 font-semibold mb-0.5">Stok Pintar</div>
                            <div class="font-bold text-slate-800 text-sm">Otomatis</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-8 bg-white/50 backdrop-blur-md border-t border-slate-200/50 relative z-20 mt-12 lg:mt-0">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-store text-sky-500"></i>
                <span class="font-bold text-slate-800">KoperasiKU</span>
            </div>
            <p class="text-sm text-slate-500 font-medium">
                © {{ date('Y') }} Koperasi Sekolah Cerdas. All rights reserved.
            </p>
            <div class="flex items-center gap-4 text-slate-400">
                <a href="#" class="hover:text-sky-500 transition"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-sky-500 transition"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="hover:text-sky-500 transition"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
