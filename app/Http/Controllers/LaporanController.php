<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $today = now()->toDateString();
        $range = $request->range ?? 7;

        // STAT CARDS
        $transaksiHariIni    = Transaction::whereDate('created_at', $today)->count();
        $pendapatanHariIni   = Transaction::whereDate('created_at', $today)->sum('total_price');
        $produkTerjualHariIni = TransactionItem::whereHas('transaction', function ($q) use ($today) {
            $q->whereDate('created_at', $today);
        })->sum('qty');

        // FILTER TRANSAKSI
        $query = Transaction::with('items.product', 'user');
        if ($request->start && $request->end) {
            $query->whereBetween('created_at', [
                $request->start . ' 00:00:00',
                $request->end . ' 23:59:59'
            ]);
        }
        $transactions = $query->latest()->get();
        $total = $transactions->sum('total_price');

        // GRAFIK
        $labels    = [];
        $chartData = [];
        for ($i = $range - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[]    = $date->format('d M');
            $chartData[] = Transaction::whereDate('created_at', $date->toDateString())->sum('total_price');
        }

        // PRODUK TERLARIS
        $produkTerlaris = TransactionItem::with('product')
            ->selectRaw('product_id, SUM(qty) as total_qty, SUM(qty * price) as total_revenue')
            ->when($request->start && $request->end, function ($q) use ($request) {
                $q->whereHas('transaction', function ($q2) use ($request) {
                    $q2->whereBetween('created_at', [
                        $request->start . ' 00:00:00',
                        $request->end . ' 23:59:59'
                    ]);
                });
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(7)
            ->get();

        // EXPORT
        if ($request->export === 'pdf') {
            return $this->exportPDF($transactions);
        }
        if ($request->export === 'excel') {
            return $this->exportExcel($transactions);
        }

        return view('laporan.index', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'produkTerjualHariIni',
            'transactions',
            'total',
            'labels',
            'chartData',
            'produkTerlaris',
            'range'
        ));
    }

    private function exportPDF($transactions)
    {
        $html = view('laporan.export-pdf', compact('transactions'))->render();
        $filename = 'laporan-' . now()->format('Y-m-d') . '.html';

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function exportExcel($transactions)
    {
        $filename = 'laporan-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Tanggal', 'Kasir', 'Total']);
            foreach ($transactions as $i => $trx) {
                fputcsv($file, [
                    $i + 1,
                    $trx->created_at->format('d-m-Y H:i'),
                    $trx->user->name ?? '-',
                    $trx->total_price,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
        //
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
