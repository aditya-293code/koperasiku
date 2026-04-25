<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    /**
     * Tampilkan halaman daftar siswa untuk top up.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswa = $query->paginate(12)->withQueryString();

        return view('admin.topup.index', compact('siswa'));
    }

    /**
     * Proses penambahan saldo siswa dari admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1000'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            
            if ($user->role !== 'siswa') {
                return back()->with('error', 'Hanya akun siswa yang dapat di top up.');
            }

            // Record top up
            Topup::create([
                'user_id' => $user->id,
                'amount' => $request->amount
            ]);

            // Add balance
            $user->balance += $request->amount;
            $user->save();

            DB::commit();

            return back()->with('success', 'Top Up Saldo untuk ' . $user->name . ' sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses top up: ' . $e->getMessage());
        }
    }
}
