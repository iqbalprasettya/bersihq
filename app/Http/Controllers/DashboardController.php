<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'kasir') {
            // Hitung jumlah pesanan berdasarkan status untuk hari ini
            $today = now()->startOfDay();
            $countDiterima = Order::whereDate('created_at', $today)->where('status', 'diterima')->count();
            $countDiproses = Order::whereDate('created_at', $today)->where('status', 'diproses')->count();
            $countSiapDiambil = Order::whereDate('created_at', $today)->where('status', 'siap_diambil')->count();
            $countSelesai = Order::whereDate('created_at', $today)->where('status', 'selesai')->count();

            // Ambil pesanan yang perlu diperhatikan (status diterima)
            $needsAttention = Order::with(['customer', 'service'])
                ->whereIn('status', ['diterima', 'diproses', 'siap_diambil'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Ambil pesanan hari ini dengan pagination
            $todayOrders = Order::with(['customer', 'service'])
                ->whereDate('created_at', $today)
                // ->whereIn('status', ['selesai', 'siap_diambil'])
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            return view('dashboard.kasir', compact(
                'countDiterima',
                'countDiproses',
                'countSiapDiambil',
                'countSelesai',
                'needsAttention',
                'todayOrders'
            ));
        }

        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $latestOrders = Order::with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        // Hitung jumlah pesanan per status
        $countDiterima = Order::where('status', 'diterima')->count();
        $countDiproses = Order::where('status', 'diproses')->count();
        $countSiapDiambil = Order::where('status', 'siap_diambil')->count();
        $countSelesai = Order::where('status', 'selesai')->count();

        // Ringkasan pendapatan
        $today = now()->startOfDay();
        $endToday = now()->endOfDay();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $pendapatanHariIni = Order::whereBetween('created_at', [$today, $endToday])->whereIn('status', ['selesai'])->sum('total_harga');
        $jumlahPesananHariIni = Order::whereBetween('created_at', [$today, $endToday])->whereIn('status', ['selesai'])->count();
        $pendapatanBulanIni = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->whereIn('status', ['selesai'])->sum('total_harga');
        $jumlahPesananBulanIni = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->whereIn('status', ['selesai'])->count();

        // Data chart pendapatan 7 hari terakhir
        $labelsPendapatan = [];
        $dataPendapatan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $labelsPendapatan[] = $tanggal->isoFormat('ddd');
            $total = Order::whereDate('created_at', $tanggal->toDateString())->sum('total_harga');
            $dataPendapatan[] = $total;
        }

        return view('dashboard.admin', compact(
            'latestOrders',
            'countDiterima',
            'countDiproses',
            'countSiapDiambil',
            'countSelesai',
            'pendapatanHariIni',
            'jumlahPesananHariIni',
            'pendapatanBulanIni',
            'jumlahPesananBulanIni',
            'labelsPendapatan',
            'dataPendapatan'
        ));
    }
}
