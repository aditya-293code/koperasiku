@extends('layouts.master')
<<<<<<< HEAD
@section('title', 'Laporan')
@section('header', 'Laporan Penjualan')

@section('content')

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-receipt text-sky-400 text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total Transaksi</p>
                <p class="text-xs text-gray-400">Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $transaksiHariIni }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-money-bill-wave text-green-400 text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total Pendapatan</p>
                <p class="text-xs text-gray-400">Hari Ini</p>
                <p class="text-lg font-bold text-gray-800 mt-1">
                    Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-box text-orange-400 text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400">Produk Terjual</p>
                <p class="text-xs text-gray-400">Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $produkTerjualHariIni }}</p>
=======
@section('title', 'Laporan Penjualan')
@section('header', 'Laporan Penjualan')

@section('content')
<div class="space-y-6">

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>
            <div class="flex flex-col gap-1 flex-1 min-w-[180px]">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cari Pembeli</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Nama pembeli..."
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all shadow-md hover:shadow-sky-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> Filter
                </button>
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold transition active:scale-95">
                    <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg shadow-sky-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sky-100 text-xs font-semibold uppercase tracking-wider mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider mb-1">Total Transaksi</p>
                    <p class="text-2xl font-bold">{{ number_format($totalTransaksi) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl p-5 text-white shadow-lg shadow-violet-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-violet-100 text-xs font-semibold uppercase tracking-wider mb-1">Rata-rata / Transaksi</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-chart-bar text-xl"></i>
                </div>
>>>>>>> teman/main
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- KIRI: TRANSAKSI + FILTER --}}
        <div class="lg:col-span-2 flex flex-col gap-5">

            {{-- GRAFIK --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-bold text-gray-800">Grafik Penjualan</p>
                        <p class="text-xs text-gray-400 mt-0.5">Tren pendapatan harian</p>
                    </div>
                    <form method="GET">
                        @if (request('start'))
                            <input type="hidden" name="start" value="{{ request('start') }}">
                        @endif
                        @if (request('end'))
                            <input type="hidden" name="end" value="{{ request('end') }}">
                        @endif
                        <select name="range" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-xl px-3 py-2 text-xs
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300
                        transition bg-white text-gray-600">
                            <option value="7" {{ $range == 7 ? 'selected' : '' }}>7 Hari</option>
                            <option value="30" {{ $range == 30 ? 'selected' : '' }}>30 Hari</option>
                        </select>
                    </form>
                </div>
                <div class="relative h-52">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <form method="GET" class="flex flex-col gap-3 items-end">
                    <input type="hidden" name="range" value="{{ $range }}">
                    <div class="w-full flex gap-3 sm:flex-row flex-col">
                        <div class="w-full">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1.5">
                                Dari Tanggal
                            </label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs"></i>
                                <input type="date" name="start" value="{{ request('start') }}"
                                    class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1.5">
                                Sampai Tanggal
                            </label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs"></i>
                                <input type="date" name="end" value="{{ request('end') }}"
                                    class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 w-full justify-end lg:flex flex-rows">
                        <button type="submit"
                            class="bg-sky-400 hover:bg-sky-500 active:scale-95 text-white px-4 py-2.5
                        rounded-xl text-sm font-medium transition shadow-sm whitespace-nowrap">
                            <i class="fa-solid fa-magnifying-glass mr-1 text-xs"></i> Filter
                        </button>
                        @if (request('start') || request('end'))
                            <a href="{{ route('laporan.index') }}"
                                class="border border-gray-200 hover:bg-gray-50 text-gray-500 px-4 py-2.5
                            rounded-xl text-sm transition whitespace-nowrap flex items-center">
                                <i class="fa-solid fa-xmark mr-1 text-xs"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- RIWAYAT TRANSAKSI --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                    <div>
                        <p class="text-sm font-bold text-gray-800">Riwayat Transaksi</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $transactions->count() }} transaksi ditemukan
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="exportPDF()"
                            class="inline-flex items-center gap-1.5 border border-gray-200 hover:bg-gray-50
                        text-gray-500 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            <i class="fa-solid fa-file-pdf text-red-400 text-xs"></i> PDF
                        </button>
                        <button onclick="exportExcel()"
                            class="inline-flex items-center gap-1.5 border border-gray-200 hover:bg-gray-50
                        text-gray-500 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            <i class="fa-solid fa-file-excel text-green-500 text-xs"></i> Excel
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                                <th class="px-5 py-3.5 text-left font-semibold" style="width: 50px;">#</th>
                                <th class="px-5 py-3.5 text-left font-semibold">Tanggal</th>
                                <th class="px-5 py-3.5 text-left font-semibold">Kasir</th>
                                <th class="px-5 py-3.5 text-center font-semibold">Total</th>
                                <th class="px-5 py-3.5 text-center font-semibold" style="width: 90px;">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($transactions as $index => $trx)
                                <tr class="hover:bg-sky-50/30 transition duration-150">
                                    <td class="px-5 py-4 text-gray-400 text-xs" style="vertical-align: middle;">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-5 py-4" style="vertical-align: middle;">
                                        <p class="font-medium text-gray-800 text-sm">
                                            {{ $trx->created_at->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $trx->created_at->format('H:i') }} WIB
                                        </p>
                                    </td>
                                    <td class="px-5 py-4" style="vertical-align: middle;">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 bg-sky-400 rounded-full flex items-center
                                            justify-center text-white text-xs font-semibold flex-shrink-0">
                                                {{ strtoupper(substr($trx->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="text-sm text-gray-700">
                                                {{ $trx->user->name ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center" style="vertical-align: middle;">
                                        <span class="font-semibold text-gray-800">
                                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center" style="vertical-align: middle;">
                                        <button onclick="toggleDetail({{ $trx->id }})"
                                            class="inline-flex items-center gap-1 border border-sky-200
                                        bg-sky-50 hover:bg-sky-400 hover:text-white text-sky-500
                                        active:scale-95 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span id="btn-{{ $trx->id }}">Lihat</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="detail-{{ $trx->id }}" class="hidden bg-gray-50/50">
                                    <td colspan="5" class="px-5 pb-4 pt-1">
                                        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">
                                                Detail Item
                                            </p>
                                            <div class="space-y-2">
                                                @foreach ($trx->items as $item)
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-sky-400"></div>
                                                            <span class="text-sm text-gray-700">
                                                                {{ $item->product->name ?? '-' }}
                                                            </span>
                                                            <span class="text-xs text-gray-400">
                                                                {{ $item->qty }}x
                                                            </span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-800">
                                                            Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div
                                                class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                                    Total
                                                </span>
                                                <span class="font-bold text-sky-500">
                                                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-14 text-gray-400">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center">
                                                <i class="fa-solid fa-receipt text-2xl text-gray-300"></i>
                                            </div>
                                            <p class="text-sm text-gray-500 font-medium">Belum ada transaksi</p>
                                            <p class="text-xs text-gray-400">Data akan muncul setelah ada transaksi</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- KANAN: PRODUK TERLARIS --}}
        <div class="flex flex-col gap-5">

            {{-- TOTAL KESELURUHAN --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-3">
                    Total Periode Ini
                </p>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Transaksi</span>
                        <span class="text-sm font-bold text-gray-800">{{ $transactions->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Produk Terjual</span>
                        <span class="text-sm font-bold text-gray-800">
                            {{ $transactions->sum(fn($t) => $t->items->sum('qty')) }} pcs
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                        <span class="text-sm font-semibold text-gray-700">Total Pendapatan</span>
                        <span class="text-sm font-bold text-sky-500">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- PRODUK TERLARIS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50">
                    <p class="text-sm font-bold text-gray-800">Produk Terlaris</p>
                    <p class="text-xs text-gray-400 mt-0.5">Periode ini</p>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($produkTerlaris as $i => $item)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-6 h-6 rounded-lg flex items-center justify-center
                            text-xs font-bold flex-shrink-0
                            @if ($i == 0) bg-yellow-50 text-yellow-600
                            @elseif($i == 1) bg-gray-100 text-gray-500
                            @elseif($i == 2) bg-orange-50 text-orange-500
                            @else bg-gray-50 text-gray-400 @endif">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-800 truncate">
                                    {{ $item->product->name ?? '-' }}
                                </p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-sky-400 rounded-full"
                                            style="width: {{ $produkTerlaris->first()->total_qty > 0 ? ($item->total_qty / $produkTerlaris->first()->total_qty) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $item->total_qty }}x</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs font-semibold text-gray-800">
                                    Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400">
                            <i class="fa-solid fa-box text-2xl text-gray-200 block mb-2"></i>
                            <p class="text-xs">Belum ada data</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        {{-- GRAFIK --}}
        const ctx = document.getElementById('salesChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(56, 189, 248, 0.3)');
        gradient.addColorStop(1, 'rgba(56, 189, 248, 0.02)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($chartData),
                    borderColor: '#38bdf8',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#38bdf8',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            borderDash: [4, 4]
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 11
                            },
                            callback: v => 'Rp ' + (v / 1000).toLocaleString('id-ID') + 'k'
                        }
                    }
                }
            }
        });

        {{-- TOGGLE DETAIL --}}

        function toggleDetail(id) {
            const row = document.getElementById('detail-' + id);
            const btn = document.getElementById('btn-' + id);
            const isHidden = row.classList.contains('hidden');
            row.classList.toggle('hidden');
            btn.textContent = isHidden ? 'Tutup' : 'Lihat';
        }

        {{-- EXPORT PDF --}}

        function exportPDF() {
            const params = new URLSearchParams(window.location.search);
            params.set('export', 'pdf');
            window.location.href = '{{ route('laporan.index') }}?' + params.toString();
        }

        {{-- EXPORT EXCEL --}}

        function exportExcel() {
            const params = new URLSearchParams(window.location.search);
            params.set('export', 'excel');
            window.location.href = '{{ route('laporan.index') }}?' + params.toString();
        }
    </script>
=======
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- CHART PENJUALAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-sky-500"></i> Grafik Penjualan Harian
                </h3>
                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} – {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
            </div>
            <div class="relative h-60">
                <canvas id="laporanChart"></canvas>
            </div>
        </div>

        {{-- PRODUK TERLARIS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2 mb-4">
                <i class="fa-solid fa-fire text-orange-400"></i> Produk Terlaris
            </h3>
            @forelse($produkTerlaris as $index => $item)
            <div class="flex items-center gap-3 mb-3">
                <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                    {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-gray-700' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-500')) }}">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-700 truncate">{{ $item->product->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ number_format($item->total_qty) }} terjual</p>
                </div>
                <span class="text-xs font-semibold text-sky-600 whitespace-nowrap">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
            </div>
            @empty
            <p class="text-xs text-gray-400 text-center py-6">Belum ada data</p>
            @endforelse
        </div>
    </div>

    {{-- TABEL TRANSAKSI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                <i class="fa-solid fa-list-ul text-sky-500"></i> Riwayat Transaksi
            </h3>
            <span class="text-xs text-gray-400">{{ $transactions->total() }} transaksi ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-3 text-left font-semibold">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Pembeli</th>
                        <th class="px-5 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-5 py-3 text-left font-semibold">Jumlah Item</th>
                        <th class="px-5 py-3 text-left font-semibold">Total</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $index => $trx)
                    <tr class="hover:bg-sky-50/40 transition-colors">
                        <td class="px-5 py-3 text-gray-400">{{ $transactions->firstItem() + $index }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($trx->user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-gray-700 font-medium truncate max-w-[120px]">{{ $trx->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">
                            <div>{{ $trx->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $trx->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                {{ $trx->items->count() }} item
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="font-semibold text-gray-800">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('laporan.detail', $trx->id) }}"
                                    class="inline-flex items-center gap-1 text-xs bg-sky-50 hover:bg-sky-100 text-sky-600 font-semibold px-3 py-1.5 rounded-lg transition active:scale-95">
                                    <i class="fa-solid fa-eye text-[10px]"></i> Detail
                                </a>
                                <a href="{{ route('laporan.print', $trx->id) }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-xs bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-semibold px-3 py-1.5 rounded-lg transition active:scale-95">
                                    <i class="fa-solid fa-print text-[10px]"></i> Cetak
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-solid fa-receipt text-4xl opacity-30"></i>
                                <p class="text-sm">Tidak ada transaksi pada periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('laporanChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.3)');
    gradient.addColorStop(1, 'rgba(14, 165, 233, 0)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartTotals) !!},
                backgroundColor: gradient,
                borderColor: 'rgb(14, 165, 233)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        callback: v => 'Rp ' + (v >= 1000 ? (v/1000)+'rb' : v),
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script>
>>>>>>> teman/main
@endpush
