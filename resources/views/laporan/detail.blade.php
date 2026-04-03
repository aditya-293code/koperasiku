@extends('layouts.master')
@section('title', 'Detail Transaksi #' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT))
@section('header', 'Detail Transaksi')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('laporan.index') }}" class="hover:text-sky-500 transition">Laporan</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span class="text-gray-600 font-medium">Detail #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- HEADER CARD --}}
    <div class="bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-sky-200">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-sky-200 text-xs font-semibold uppercase tracking-wider mb-1">ID Transaksi</p>
                <p class="text-3xl font-bold font-mono">#{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-sky-200 text-sm mt-2 flex items-center gap-2">
                    <i class="fa-regular fa-calendar"></i>
                    {{ $transaction->created_at->format('l, d F Y — H:i') }} WIB
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('laporan.print', $transaction->id) }}" target="_blank"
                    class="flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur text-white px-4 py-2 rounded-xl text-sm font-semibold transition active:scale-95">
                    <i class="fa-solid fa-print"></i> Cetak Struk
                </a>
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur text-white px-4 py-2 rounded-xl text-sm font-semibold transition active:scale-95">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        {{-- INFO PEMBELI --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Informasi Pembeli</h3>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center text-lg font-bold">
                    {{ strtoupper(substr($transaction->user->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $transaction->user->name ?? '-' }}</p>
                    <p class="text-sm text-gray-400">{{ $transaction->user->email ?? '-' }}</p>
                    <span class="text-xs bg-sky-100 text-sky-600 px-2 py-0.5 rounded-full font-semibold">
                        {{ ucfirst($transaction->user->role ?? '-') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- RINGKASAN PEMBAYARAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Ringkasan Pembayaran</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Jumlah Item</span>
                    <span class="font-semibold text-gray-700">{{ $transaction->items->count() }} jenis produk</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Qty</span>
                    <span class="font-semibold text-gray-700">{{ $transaction->items->sum('qty') }} pcs</span>
                </div>
                <div class="border-t border-dashed pt-2 mt-2 flex justify-between">
                    <span class="font-bold text-gray-700">Total Bayar</span>
                    <span class="font-bold text-lg text-sky-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL ITEM --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                <i class="fa-solid fa-bag-shopping text-sky-500"></i> Item Dibeli
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-3 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3 text-center font-semibold">Qty</th>
                        <th class="px-5 py-3 text-right font-semibold">Harga Satuan</th>
                        <th class="px-5 py-3 text-right font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($transaction->items as $item)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                    class="w-9 h-9 rounded-lg object-cover border border-gray-100 flex-shrink-0">
                                @else
                                <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-box text-gray-400 text-xs"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-700">{{ $item->product->name ?? '-' }}</p>
                                    @if($item->product && $item->product->category)
                                    <p class="text-xs text-gray-400">{{ $item->product->category }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="bg-sky-50 text-sky-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $item->qty }} pcs</span>
                        </td>
                        <td class="px-5 py-3 text-right text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-right font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-sky-50">
                        <td colspan="3" class="px-5 py-3 text-right font-bold text-gray-700">Total</td>
                        <td class="px-5 py-3 text-right font-bold text-lg text-sky-600">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
