<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $query = Order::with(['customer', 'service'])
            ->latest();

        // Filter berdasarkan rentang tanggal
        if ($request->filled('daterange')) {
            $dates = explode(' - ', $request->daterange);
            if (count($dates) == 2) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $transactions = $query->paginate(10)
            ->withQueryString();

        return view('reports.transactions', compact('transactions'));
    }

    public function exportTransactions(Request $request)
    {
        $startDate = null;
        $endDate = null;

        if ($request->filled('daterange')) {
            $dates = explode(' - ', $request->daterange);
            if (count($dates) == 2) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
            }
        }

        $status = $request->status;

        $filename = 'Laporan_Transaksi_' . Carbon::now()->format('d-m-Y_H-i-s') . '.xlsx';

        return Excel::download(new TransactionsExport($startDate, $endDate, $status), $filename);
    }
}
