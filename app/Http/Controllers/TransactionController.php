<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items'        => 'required|array',
            'items.*.id'   => 'required|exists:products,id',
            'items.*.qty'  => 'required|integer|min:1',
            'total_price'  => 'required|numeric',
        ]);

        try {
            // Cek stok semua item dulu
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                if ($product->stock < $item['qty']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} tidak mencukupi!"
                    ], 422);
                }
            }

            // Buat transaksi SEKALI di luar loop
            $transaction = Transaction::create([
                'user_id'     => Auth::id(),
                'total_price' => $request->total_price,
            ]);

            // Simpan item & kurangi stok
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'qty'            => $item['qty'],
                    'price'          => $product->price,
                    'subtotal'       => $product->price * $item['qty'],
                ]);

                $product->decrement('stock', $item['qty']);
            }

            return response()->json([
                'success'        => true,
                'message'        => 'Transaksi berhasil!',
                'transaction_id' => $transaction->id,
                'total_price'    => $request->total_price,
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal membuat transaksi', [
                'error_message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
