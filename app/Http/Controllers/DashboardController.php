<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'kasir') {
            return $this->kasirDashboard();
        }

        return $this->adminDashboard();
    }

    private function kasirDashboard()
    {
        // Pesanan hari ini
        $today = now()->startOfDay();
        $endToday = now()->endOfDay();

        $todayOrders = Order::with(['customer', 'service'])
            ->whereBetween('created_at', [$today, $endToday])
            ->whereIn('status', ['diterima', 'diproses'])
            ->latest()
            ->get();

        // Pesanan yang perlu diproses
        $needsAttention = Order::with(['customer', 'service'])
            ->where('status', 'diterima')
            ->latest()
            ->take(5)
            ->get();

        // Status pesanan hari ini
        $countDiterima = Order::whereBetween('created_at', [$today, $endToday])
            ->where('status', 'diterima')->count();
        $countDiproses = Order::whereBetween('created_at', [$today, $endToday])
            ->where('status', 'diproses')->count();
        $countSelesai = Order::whereBetween('created_at', [$today, $endToday])
            ->where('status', 'selesai')->count();
        $countDiambil = Order::whereBetween('created_at', [$today, $endToday])
            ->where('status', 'diambil')->count();

        return view('dashboard.kasir', compact(
            'todayOrders',
            'needsAttention',
            'countDiterima',
            'countDiproses',
            'countSelesai',
            'countDiambil'
        ));
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
        $countSelesai = Order::where('status', 'selesai')->count();
        $countDiambil = Order::where('status', 'diambil')->count();

        // Ringkasan pendapatan
        $today = now()->startOfDay();
        $endToday = now()->endOfDay();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $pendapatanHariIni = Order::whereBetween('created_at', [$today, $endToday])->sum('total_harga');
        $jumlahPesananHariIni = Order::whereBetween('created_at', [$today, $endToday])->count();
        $pendapatanBulanIni = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_harga');
        $jumlahPesananBulanIni = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

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
            'countSelesai',
            'countDiambil',
            'pendapatanHariIni',
            'jumlahPesananHariIni',
            'pendapatanBulanIni',
            'jumlahPesananBulanIni',
            'labelsPendapatan',
            'dataPendapatan'
        ));
    }
}
