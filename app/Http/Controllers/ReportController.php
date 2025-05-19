<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // Logika untuk export Excel akan ditambahkan nanti
        return back()->with('error', 'Fitur export masih dalam pengembangan.');
    }
}
