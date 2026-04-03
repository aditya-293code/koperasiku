<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $products = Product::where('stock', '>', 0)->get();
        $user = Auth::user();
        return view('dashboard.siswa', compact('products', 'user'));
    }

    public function pembelian()
    {
        $products = Product::where('stock', '>', 0)->paginate(12);
        return view('siswa.pembelian', compact('products'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail(Auth::id());
            
            // Record top up
            Topup::create([
                'user_id' => $user->id,
                'amount' => $request->amount
            ]);

            // Add balance
            $user->balance += $request->amount;
            $user->save();

            DB::commit();

            return back()->with('success', 'Top Up Saldo sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses top up: ' . $e->getMessage());
        }
    }
}
