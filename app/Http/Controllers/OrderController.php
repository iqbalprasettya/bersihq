<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'service'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('nama')->get();
        $services = Service::orderBy('nama_layanan')->get();
        return view('orders.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'berat' => 'required|numeric|min:0.1',
            'catatan' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($request->service_id);
        $total_harga = $service->harga * $request->berat;

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'service_id' => $request->service_id,
            'berat' => $request->berat,
            'total_harga' => $total_harga,
            'catatan' => $request->catatan,
            'status' => 'diterima',
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Order $order)
    {
        // Load relasi yang diperlukan
        $order->load(['customer', 'service']);

        // Cek apakah request AJAX
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        }

        // Untuk tampilan view normal
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:diterima,diproses,selesai,diambil'
        ]);

        // Validasi urutan status
        $statusOrder = [
            'diterima' => 1,
            'diproses' => 2,
            'selesai' => 3,
            'diambil' => 4
        ];

        $currentStatusOrder = $statusOrder[$order->status];
        $newStatusOrder = $statusOrder[$request->status];

        // Hanya boleh maju satu langkah atau kembali ke status sebelumnya
        if ($newStatusOrder > $currentStatusOrder + 1) {
            return response()->json([
                'success' => false,
                'message' => 'Status harus diubah secara berurutan'
            ], 422);
        }

        try {
            // Jika status baru adalah 'selesai', set tanggal_selesai
            if ($request->status === 'selesai') {
                $order->update([
                    'status' => $request->status,
                    'tanggal_selesai' => now()
                ]);
            }
            // Jika status baru adalah 'diambil', pertahankan tanggal_selesai
            else if ($request->status === 'diambil') {
                $order->update([
                    'status' => $request->status
                ]);
            }
            // Jika status kembali ke 'diterima' atau 'diproses', hapus tanggal_selesai
            else {
                $order->update([
                    'status' => $request->status,
                    'tanggal_selesai' => null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui',
                'order' => $order->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status pesanan'
            ], 500);
        }
    }
}
