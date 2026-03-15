@extends('layouts.master')
@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
    <p class="text-gray-500 mb-6 text-base">
        Selamat datang di sistem KoperasiKu
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-500 hover:bg-blue-600 text-white rounded-xl p-5 shadow-md transition duration-300">
            <p class="text-sm opacity-80">Total Penjualan Hari Ini</p>
            <h2 class="text-xl font-bold mt-2">Rp 0</h2>
        </div>
        <div class="bg-blue-500 hover:bg-blue-600 text-white rounded-xl p-5 shadow-md transition duration-300">
            <p class="text-sm opacity-80">Total Penjualan Bulan Ini</p>
            <h2 class="text-xl font-bold mt-2">Rp 0</h2>
        </div>
        <div class="bg-blue-500 hover:bg-blue-600 text-white rounded-xl p-5 shadow-md transition duration-300">
            <p class="text-sm opacity-80">Total Produk</p>
            <h2 class="text-xl font-bold mt-2">0</h2>
        </div>
        <div class="bg-blue-500 hover:bg-blue-600 text-white rounded-xl p-5 shadow-md transition duration-300">
            <p class="text-sm opacity-80">Produk Stok Menipis</p>
            <h2 class="text-xl font-bold mt-2">0</h2>
        </div>
    </div>
@endsection
