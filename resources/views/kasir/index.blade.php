@extends('layouts.master')
@section('title', 'Kasir')
@section('header', 'Kasir')
@section('content')
<div class="flex flex-col lg:flex-row gap-4">
    <div class="flex-1 flex flex-col">
        <div class="relative mb-4">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input
                type="text"
                id="searchInput"
                placeholder="Cari produk..."
                onkeyup="filterProduk()"
                class="w-full border rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
    <div class="grid grid-cols-2 sm:grid-cols-3  xl:grid-cols-4 gap-4" id="productGrid">
        @forelse ($products as $product)
            <div class="product-card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200 overflow-hidden flex flex-col"
                data-name="{{ strtolower($product->name) }}">
                <div class="h-44 bg-white flex items-center justify-center p-4 border-b border-gray-100">
                    <img
                        src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}"
                        alt="{{ $product->name }}"
                        style="max-height: 140px; max-width: 100%; object-fit: contain;"
                    >
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                    <p class="text-sky-500 text-sm mt-0.5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-400 text-xs mt-0.5">Stok: {{ $product->stock }}</p>
                    <button
                        onclick="tambahKeKeranjang({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}')"
                        class="mt-auto pt-2 w-full bg-sky-400 hover:bg-sky-500 active:scale-95 text-white text-sm py-2 rounded-lg transition duration-150 flex items-center justify-center gap-1
                        {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                        <i class="fa-solid fa-plus text-xs"></i> Tambah
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-gray-400">
                <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                Belum ada produk.
            </div>
        @endforelse
    </div>
        <div class="mt-4 text-xs text-gray-500">
            {{ $products->links() }}
        </div>
    </div>
    <div class="w-full lg:w-72 flex-shrink-0 flex flex-col bg-white rounded-xl shadow border border-gray-200">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <div class="flex items-center gap-2 text-gray-700 font-semibold text-sm">
                <i class="fa-solid fa-cart-shopping text-blue-500"></i>
                Keranjang
            </div>
            <button onclick="hapusSemua()"
                class="text-xs text-red-500 hover:text-red-600 font-medium flex items-center gap-1 transition">
                <i class="fa-solid fa-trash text-xs"></i> Hapus Semua
            </button>
        </div>
        <div class="flex-1 overflow-y-auto px-3 py-2" id="keranjangList">
            <div id="keranjangKosong" class="flex flex-col items-center justify-center h-40 text-gray-300">
                <i class="fa-solid fa-cart-shopping text-4xl mb-2"></i>
                <p class="text-xs">Keranjang kosong</p>
            </div>
        </div>
        <div class="border-t px-4 py-3">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm text-gray-600">Total</span>
                <span class="text-sm font-bold text-gray-800" id="totalHarga">Rp 0</span>
            </div>
            <button onclick="prosesTransaksi()"
                class="w-full bg-sky-400 hover:bg-sky-500 active:scale-95 text-white py-2 rounded-lg text-sm font-medium transition duration-150">
                Bayar
            </button>
        </div>
    </div>
    <div id="modalBayar" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
        <div class="bg-white w-[400px] rounded-2xl p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Pembayaran</h2>
                <button onclick="tutupModal()">✕</button>
            </div>
            <div class="bg-gray-100 rounded-xl p-4 mb-4">
                <p class="text-sm text-gray-500">Total Pembayaran</p>
                <p id="modalTotal" class="text-sm font-bold text-blue-500">Rp 0</p>
            </div>
            <div class="mb-4">
                <p class="text-sm mb-1">Jumlah Uang Tunai</p>
                <input
                    type="number"
                    id="inputBayar"
                    class="w-full border rounded-lg p-3 text-sm"
                    placeholder="Masukkan uang"
                    oninput="hitungKembalian()"
                >
            </div>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <button onclick="isiNominal(50000)" class="border rounded-lg p-2">Rp 50.000</button>
                <button onclick="isiNominal(100000)" class="border rounded-lg p-2">Rp 100.000</button>
                <button onclick="isiNominal(150000)" class="border rounded-lg p-2">Rp 150.000</button>
                <button onclick="isiNominal(200000)" class="border rounded-lg p-2">Rp 200.000</button>
            </div>
            <div class="bg-green-100 rounded-xl p-4 mb-4">
                <p class="text-sm text-gray-500">Kembalian</p>
                <p id="kembalian" class="text-lg font-bold text-green-600">Rp 0</p>
            </div>
            <button
                onclick="konfirmasiBayar()"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl font-semibold">
                Proses Pembayaran
            </button>
        </div>
    </div>
        <div id="modalSukses" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
            <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl overflow-hidden">
                <div class="flex justify-end px-4 pt-4">
                    <button onclick="tutupModalSukses()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
                </div>
                <div class="flex flex-col items-center pb-2 px-6">
                    <div class="w-14 h-14 rounded-full border-4 border-green-500 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Pembayaran Berhasil!</h2>
                </div>
                <div class="px-6 pb-4" id="strukArea">
                    <div class="text-center border-t border-b py-3 mb-4 mt-2">
                        <p class="font-bold text-gray-800 text-base">Kasir POS</p>
                        <p class="text-xs text-gray-400">Jl. Contoh No. 123, Jakarta</p>
                        <p class="text-xs text-gray-400">Telp: (021) 1234-5678</p>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">No. Transaksi</span>
                        <span class="font-medium text-gray-800 text-xs" id="noTransaksi">-</span>
                    </div>
                    <div class="flex justify-between text-sm mb-4">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="font-medium text-gray-800 text-xs" id="tanggalTransaksi">-</span>
                    </div>
                    <div class="border-t border-b py-3 mb-4">
                        <div class="grid grid-cols-12 text-xs font-bold text-gray-700 mb-2">
                            <span class="col-span-4">Item</span>
                            <span class="col-span-2 text-center">Qty</span>
                            <span class="col-span-3 text-center">Harga</span>
                            <span class="col-span-3 text-right">Total</span>
                        </div>
                        <div id="strukItems" class="space-y-1.5"></div>
                    </div>
                    <div class="space-y-1.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span id="suksesSubtotal" class="text-gray-800">Rp 0</span>
                        </div>
                        {{-- <div class="flex justify-between">
                            <span class="text-gray-500">Pajak (10%)</span>
                            <span id="suksesPajak" class="text-gray-800">Rp 0</span>
                        </div> --}}
                        <div class="flex justify-between border-t pt-2 mt-1">
                            <span class="font-bold text-gray-800">Total</span>
                            <span id="suksesTotal" class="font-bold text-gray-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Bayar</span>
                            <span id="suksesBayar" class="text-gray-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-green-500">Kembalian</span>
                            <span id="suksesKembalian" class="font-bold text-green-500">Rp 0</span>
                        </div>
                    </div>
                    <div class="text-center mt-4 border-t pt-3">
                        <p class="text-xs text-gray-400">Terima kasih atas kunjungan Anda!</p>
                        <p class="text-xs text-gray-400">Selamat berbelanja kembali</p>
                    </div>
                </div>
                <div class="flex border-t">
                    <button onclick="cetakStruk()"
                        class="flex-1 flex items-center justify-center gap-2 py-3 text-sm text-gray-600 hover:bg-gray-50 transition border-r">
                        <i class="fa-solid fa-print"></i> Print
                    </button>
                    <button onclick="tutupModalSukses()"
                        class="flex-1 py-3 text-sm font-semibold bg-gray-900 hover:bg-gray-800 text-white transition rounded-br-2xl">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let keranjang = [];
    function tambahKeKeranjang(id, nama, harga, stok, foto) {
        const existing = keranjang.find(item => item.id === id);
        if (existing) {
            if (existing.qty >= stok) {
                alert('Stok tidak mencukupi!');
                return;
            }
            existing.qty++;
        } else {
            keranjang.push({ id, nama, harga, qty: 1, stok, foto });
        }
        renderKeranjang();
    }
    function ubahQty(id, delta) {
        const item = keranjang.find(i => i.id === id);
        if (!item) return;
        item.qty += delta;
        if (item.qty <= 0) {
            keranjang = keranjang.filter(i => i.id !== id);
        } else if (item.qty > item.stok) {
            item.qty = item.stok;
            alert('Stok tidak mencukupi!');
        }
        renderKeranjang();
    }
    function hapusSemua() {
        if (keranjang.length === 0) return;
        if (confirm('Hapus semua item dari keranjang?')) {
            keranjang = [];
            renderKeranjang();
        }
    }
    function renderKeranjang() {
        const list = document.getElementById('keranjangList');
        const total = keranjang.reduce((sum, i) => sum + i.harga * i.qty, 0);
        document.getElementById('totalHarga').textContent =
            'Rp ' + total.toLocaleString('id-ID');
        if (keranjang.length === 0) {
            list.innerHTML = `
                <div class="flex flex-col items-center justify-center h-40 text-gray-300">
                    <i class="fa-solid fa-cart-shopping text-4xl mb-2"></i>
                    <p class="text-xs">Keranjang kosong</p>
                </div>`;
            return;
        }
        list.innerHTML = keranjang.map(item => `
            <div class="flex items-center gap-2 py-2 border-b border-gray-100 last:border-0">
                {{-- FOTO PRODUK --}}
                <div class="w-10 h-10 rounded-lg bg-gray-50 border flex items-center justify-center overflow-hidden flex-shrink-0">
                    <img
                        src="${item.foto}"
                        alt="${item.nama}"
                        style="max-width: 36px; max-height: 36px; object-fit: contain;"
                    >
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-800 truncate">${item.nama}</p>
                    <p class="text-xs text-sky-500">Rp ${item.harga.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center gap-1 flex-shrink-0">
                    <button onclick="ubahQty(${item.id}, -1)"
                        class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs flex items-center justify-center transition">
                        −
                    </button>
                    <span class="text-xs font-semibold w-5 text-center">${item.qty}</span>
                    <button onclick="ubahQty(${item.id}, 1)"
                        class="w-6 h-6 rounded bg-blue-500 hover:bg-blue-600 text-white text-xs flex items-center justify-center transition">
                        +
                    </button>
                </div>
                <p class="text-xs font-bold text-gray-700 w-16 text-right flex-shrink-0">
                    Rp ${(item.harga * item.qty).toLocaleString('id-ID')}
                </p>
            </div>
        `).join('');
    }

    function hapusItem(id) {
    keranjang = keranjang.filter(i => i.id !== id);
    renderKeranjang();
    }

    function filterProduk() {
        const keyword = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(keyword) ? '' : 'none';
        });
    }
    function prosesTransaksi() {
        if (keranjang.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        const total = keranjang.reduce((sum, i) => sum + i.harga * i.qty, 0);
        document.getElementById('modalTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('modalBayar').classList.remove('hidden');
        document.getElementById('inputBayar').value = '';
        document.getElementById('kembalian').textContent = 'Rp 0';
    }

    function tutupModal() {
        document.getElementById('modalBayar').classList.add('hidden');
    }

    function hitungKembalian() {
        const total = keranjang.reduce((sum, i) => sum + i.harga * i.qty, 0);
        const bayar = parseInt(document.getElementById('inputBayar').value) || 0;
        const kembalian = bayar - total;
        document.getElementById('kembalian').textContent =
            'Rp ' + (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');
    }

    function isiNominal(nominal) {
        document.getElementById('inputBayar').value = nominal;
        hitungKembalian();
    }

    function tutupModalBayar() {
        document.getElementById('modalBayar').classList.add('hidden');
        document.getElementById('modalBayar').classList.remove('flex');
    }

function konfirmasiBayar() {
    const total = keranjang.reduce((sum, i) => sum + i.harga * i.qty, 0);
    const bayar = parseInt(document.getElementById('inputBayar').value) || 0;

    if (bayar < total) {
        alert('Uang bayar kurang!');
        return;
    }

    const items = keranjang.map(i => ({ id: i.id, qty: i.qty }));

    fetch('{{ route('transactions.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items, total_price: total })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            tutupModalBayar();

            const now = new Date();
            const tanggal = now.toLocaleDateString('id-ID', {
                day: 'numeric', month: 'long', year: 'numeric'
            }) + ' pukul ' + now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit'
            });

            document.getElementById('noTransaksi').textContent = 'TRX' + Date.now();
            document.getElementById('tanggalTransaksi').textContent = tanggal;
            document.getElementById('suksesSubtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('suksesTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('suksesBayar').textContent = 'Rp ' + bayar.toLocaleString('id-ID');
            document.getElementById('suksesKembalian').textContent = 'Rp ' + (bayar - total).toLocaleString('id-ID');

            document.getElementById('strukItems').innerHTML = keranjang.map(item => `
                <div class="grid grid-cols-12 text-xs text-gray-700">
                    <span class="col-span-4 truncate">${item.nama}</span>
                    <span class="col-span-2 text-center">${item.qty}</span>
                    <span class="col-span-3 text-center">${item.harga.toLocaleString('id-ID')}</span>
                    <span class="col-span-3 text-right">${(item.harga * item.qty).toLocaleString('id-ID')}</span>
                </div>
            `).join('');

            document.getElementById('modalSukses').classList.remove('hidden');
            document.getElementById('modalSukses').classList.add('flex');

            keranjang = [];
            renderKeranjang();

        } else {
            alert(data.message);
        }
    })
    .catch(() => alert('Terjadi kesalahan, coba lagi.'));
}

function tutupModalSukses() {
    document.getElementById('modalSukses').classList.add('hidden');
    document.getElementById('modalSukses').classList.remove('flex');
    window.location.reload();
}

function cetakStruk() {
    const strukArea = document.getElementById('strukArea').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Struk Pembayaran</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
                .grid { display: grid; }
                .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
                .col-span-2 { grid-column: span 2; }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .text-green-500 { color: green; }
                .font-bold { font-weight: bold; }
                .border-t { border-top: 1px solid #ccc; padding-top: 8px; margin-top: 8px; }
                .border-b { border-bottom: 1px solid #ccc; padding-bottom: 8px; margin-bottom: 8px; }
            </style>
        </head>
        <body>${strukArea}</body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>
@endpush
