<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if($role == 'admin'){
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalKasir = User::where('role', 'kasir')->count();
        $totalSaldo = User::where('role', 'siswa')->sum('balance');
        $usersTerbaru = User::latest()->take(5)->get();

        $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $data = [1000000, 2000000, 1500000, 3000000, 1800000, 2500000, 2200000];
        return view('dashboard.admin', compact(
            'totalSiswa',
            'totalKasir',
            'totalSaldo',
            'labels',
            'data',
            'usersTerbaru'
        ));

    }
    return view('dashboard.siswa');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
