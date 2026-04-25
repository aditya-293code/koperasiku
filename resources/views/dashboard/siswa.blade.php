@extends('layouts.master')
@section('title', 'Dashboard Siswa')
@section('header', 'Mading Koperasi')

@section('content')
<div class="space-y-6" x-data="koperasiSiswa({{ $user->balance }})">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-check-circle"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-medium text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- HEADER INFO --}}
    <div class="bg-gradient-to-r from-sky-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl shadow-sky-500/20 flex flex-col sm:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                <i class="fa-solid fa-wallet text-2xl"></i>
            </div>
            <div>
                <p class="text-sky-100 text-sm font-medium mb-1">Saldo Koperasi Anda</p>
                <div class="flex items-end gap-2">
                    <span class="text-3xl font-bold tracking-tight">Rp <span x-text="formatRupiah(balance)"></span></span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        {{-- PRODUK LIST --}}
        <div class="lg:col-span-2 space-y-4">
            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-store text-sky-500"></i> Katalog Koperasi
            </h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @forelse($products as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="aspect-square bg-slate-50 rounded-xl mb-3 overflow-hidden border border-slate-100 relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i class="fa-solid fa-box-open text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-lg text-slate-600 shadow-sm">
                            Stok: {{ $product->stock }}
                        </div>
                    </div>
                    <h4 class="font-semibold text-slate-800 text-sm mb-1 truncate">{{ $product->name }}</h4>
                    <p class="text-sky-600 font-bold text-sm mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <button @click="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})" 
                        class="w-full py-2 bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-600 text-sm font-semibold rounded-xl transition active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i> Beli
                    </button>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                    <i class="fa-solid fa-box text-3xl text-slate-300 mb-3"></i>
                    <p class="text-slate-500 text-sm">Belum ada produk tersedia</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- KERANJANG --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
            <h3 class="font-bold text-gray-800 text-base mb-4 flex items-center gap-2">
                <i class="fa-solid fa-basket-shopping text-sky-500"></i> Keranjang Belanja
            </h3>
            
            <template x-if="cart.length === 0">
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-cart-arrow-down text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-sm text-slate-400">Keranjang masih kosong</p>
                </div>
            </template>

            <div class="space-y-3 mb-4 max-h-60 overflow-y-auto pr-1">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex-1 min-w-0 pr-3">
                            <h5 class="text-sm font-semibold text-slate-800 truncate" x-text="item.name"></h5>
                            <p class="text-xs text-slate-500" x-text="'Rp ' + formatRupiah(item.price)"></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 bg-white rounded-lg border border-slate-200 p-1">
                                <button @click="updateQty(index, -1)" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-red-500 rounded hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                                <span class="text-xs font-bold w-4 text-center" x-text="item.qty"></span>
                                <button @click="updateQty(index, 1)" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-sky-500 rounded hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <template x-if="cart.length > 0">
                <div class="border-t border-dashed border-slate-200 pt-4 mt-2">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-semibold text-slate-500">Total Harga</span>
                        <span class="text-lg font-bold text-sky-600" x-text="'Rp ' + formatRupiah(totalPrice)"></span>
                    </div>
                    
                    <button @click="checkout" :disabled="isLoading || totalPrice > balance" 
                        class="w-full py-3 rounded-xl font-bold text-white transition flex justify-center items-center gap-2"
                        :class="totalPrice > balance ? 'bg-slate-300 cursor-not-allowed' : 'bg-sky-500 hover:bg-sky-600 shadow-lg shadow-sky-500/30 active:scale-95'">
                        
                        <span x-show="!isLoading && totalPrice <= balance">Bayar Sekarang</span>
                        <span x-show="!isLoading && totalPrice > balance">Saldo Kurang</span>
                        <span x-show="isLoading"><i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...</span>
                    </button>
                    
                    <template x-if="totalPrice > balance">
                        <p class="text-[11px] text-red-500 text-center mt-2 font-medium">Top Up saldo Anda terlebih dahulu untuk membeli ini.</p>
                    </template>
                </div>
            </template>
        </div>
    </div>



</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('koperasiSiswa', (initialBalance) => ({
            balance: initialBalance,
            cart: [],
            isLoading: false,
            
            get totalPrice() {
                return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
            },
            
            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            },
            
            addToCart(id, name, price, stock) {
                const existingIndex = this.cart.findIndex(i => i.id === id);
                if (existingIndex > -1) {
                    if (this.cart[existingIndex].qty < stock) {
                        this.cart[existingIndex].qty++;
                    } else {
                        alert('Stok tidak mencukupi!');
                    }
                } else {
                    if (stock > 0) {
                        this.cart.push({ id, name, price, qty: 1, stock });
                    } else {
                        alert('Produk habis!');
                    }
                }
            },
            
            updateQty(index, change) {
                const item = this.cart[index];
                const newQty = item.qty + change;
                
                if (newQty > 0 && newQty <= item.stock) {
                    item.qty = newQty;
                } else if (newQty === 0) {
                    this.cart.splice(index, 1);
                }
            },
            
            async checkout() {
                if (this.cart.length === 0) return;
                
                if (this.totalPrice > this.balance) {
                    alert('Saldo Anda tidak mencukupi! Silakan top up terlebih dahulu.');
                    return;
                }
                
                this.isLoading = true;
                
                try {
                    const response = await fetch('{{ route("transactions.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: this.cart,
                            total_price: this.totalPrice
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        window.location.href = data.receipt_url;
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                } catch (error) {
                    alert('Gagal memproses transaksi');
                } finally {
                    this.isLoading = false;
                }
            }
        }));
    });
</script>
@endpush
