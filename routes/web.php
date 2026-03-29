<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransactionController;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    $range = request('range', '7');
    $totalProduk = Product::count();
    $stokMenipis = Product::where('stock','<',5)->count();
    $penjualanHariIni = Transaction::whereDate('created_at', now())
        ->sum('total_price');
    $penjualanBulanIni = Transaction::whereMonth('created_at', now()->month)
        ->sum('total_price');
    $produkMenipis = Product::where('stock','<',5)->take(5)->get();

    $chart = Transaction::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(total_price) as total')
        )
        ->where('created_at', '>=', now()->subDays(6))
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    $labels = $chart->pluck('tanggal')->map(function($date){
        return \Carbon\Carbon::parse($date)->format('d M');
    });

    $data = $chart->pluck('total');

    return view('dashboard.admin', compact(
        'totalProduk',
        'stokMenipis',
        'penjualanHariIni',
        'penjualanBulanIni',
        'labels',
        'data',
        'produkMenipis',
        'range'
    ));
    return view('dashboard.siswa');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');

// Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
