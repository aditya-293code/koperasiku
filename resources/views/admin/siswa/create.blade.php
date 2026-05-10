@extends('layouts.master')
@section('title', 'Tambah Siswa')
@section('header', 'Tambah Data Siswa')
@section('content')

<div class="mb-5">
    <a href="{{ route('admin.siswa.index') }}" class="text-sm text-gray-500 hover:text-sky-500 transition flex items-center gap-2 w-fit">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-bold text-gray-800">Form Tambah Siswa</h2>
        <p class="text-xs text-gray-500 mt-1">Lengkapi form di bawah ini untuk menambahkan akun siswa baru.</p>
    </div>

    @if ($errors->any())
    <div class="p-6 pb-0">
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="p-6">
        <form action="{{ route('admin.siswa.store') }}" method="POST">
            @csrf
            
            <div class="space-y-5">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        NISN
                    </label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN siswa"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="siswa@example.com" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                            focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                            focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('admin.siswa.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-sky-400 hover:bg-sky-500 active:scale-95 text-white px-6 py-2.5
                    rounded-xl text-sm font-medium transition shadow-sm">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
