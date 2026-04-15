@extends('layouts.master')
@section('title', 'Top Up Saldo Siswa')
@section('header', 'Top Up Saldo Siswa')

@section('content')
<div x-data="adminTopup()">
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-check-circle"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-medium text-sm">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Cari Akun Siswa</h3>
                <p class="text-sm text-slate-500">Cari berdasarkan Nama atau NISN Siswa</p>
            </div>
            
            <form action="{{ route('admin.topup.index') }}" method="GET" class="w-full md:w-96 flex relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." 
                    class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-sky-500 focus:border-sky-500 text-sm transition">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-100">
                        <th class="py-4 px-6 font-semibold">Nama Siswa</th>
                        <th class="py-4 px-6 font-semibold">NISN</th>
                        <th class="py-4 px-6 font-semibold">Saldo Saat Ini</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($siswa as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ $user->nisn ?? '-' }}</td>
                        <td class="py-4 px-6 font-bold text-sky-600">Rp {{ number_format($user->balance, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-right">
                            <button @click="openModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                class="px-4 py-2 bg-sky-100 text-sky-600 hover:bg-sky-500 hover:text-white rounded-lg font-semibold transition inline-flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Top Up
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500">
                            Tak ada data siswa ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $siswa->links() }}
        </div>
    </div>

    {{-- MODAL TOP UP --}}
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center">
        <div x-show="isModalOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="closeModal"></div>
        
        <div x-show="isModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
            
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-transfer text-sky-500"></i> Top Up Saldo
                </h3>
                <button @click="closeModal" class="text-slate-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.topup.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="user_id" x-model="selectedUserId">
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-600 mb-1">Siswa</label>
                    <p class="text-lg font-bold text-slate-800" x-text="selectedUserName"></p>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Pilih Nominal Top Up</label>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <button type="button" @click="amount = 10000" :class="amount == 10000 ? 'bg-sky-50 border-sky-500 text-sky-700' : 'bg-white border-slate-200 text-slate-600 hover:border-sky-300'" class="border rounded-xl py-2 font-semibold text-sm transition">Rp 10.000</button>
                        <button type="button" @click="amount = 20000" :class="amount == 20000 ? 'bg-sky-50 border-sky-500 text-sky-700' : 'bg-white border-slate-200 text-slate-600 hover:border-sky-300'" class="border rounded-xl py-2 font-semibold text-sm transition">Rp 20.000</button>
                        <button type="button" @click="amount = 50000" :class="amount == 50000 ? 'bg-sky-50 border-sky-500 text-sky-700' : 'bg-white border-slate-200 text-slate-600 hover:border-sky-300'" class="border rounded-xl py-2 font-semibold text-sm transition">Rp 50.000</button>
                        <button type="button" @click="amount = null" :class="amount != 10000 && amount != 20000 && amount != 50000 && amount != null ? 'bg-sky-50 border-sky-500 text-sky-700' : 'bg-white border-slate-200 text-slate-600 hover:border-sky-300'" class="border rounded-xl py-2 font-semibold text-sm transition">Nominal Lain</button>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-slate-500 font-semibold">Rp</span>
                        </div>
                        <input type="number" name="amount" x-model="amount" required min="1000" step="1000" placeholder="0" class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full pl-12 p-3 font-semibold transition" >
                    </div>
                    <p class="text-[11px] text-slate-400 mt-2">* Minimal top up Rp 1.000</p>
                </div>
                
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" @click="closeModal" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl transition shadow-lg shadow-sky-500/30">Proses Saldo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('adminTopup', () => ({
            isModalOpen: false,
            selectedUserId: null,
            selectedUserName: '',
            amount: 10000,
            
            openModal(id, name) {
                this.selectedUserId = id;
                this.selectedUserName = name;
                this.amount = 10000;
                this.isModalOpen = true;
            },
            
            closeModal() {
                this.isModalOpen = false;
            }
        }));
    });
</script>
@endpush
