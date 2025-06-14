<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function index(Request $request)
    {
        $query = Order::with(['customer', 'service']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian
        if ($request->has('q') && $request->q !== '') {
            $search = $request->q;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
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
        try {
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

            // Kirim notifikasi WhatsApp pesanan diterima
            $variables = [
                'nama' => $order->customer->nama,
                'nomor_order' => str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'layanan' => $order->service->nama_layanan,
                'berat' => $order->berat,
                'total' => number_format($order->total_harga, 0, ',', '.')
            ];

            $result = $this->whatsapp->sendMessageWithTemplate($order->customer->no_wa, 'diterima', $variables);

            if (!$result['success'] && str_contains($result['message'], 'tidak aktif')) {
                Log::info('Template WhatsApp tidak aktif, pesan tidak dikirim', ['order_id' => $order->id]);
            }

            return redirect()
                ->route('orders.index')
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
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
        try {
            $request->validate([
                'status' => 'required|in:diterima,diproses,siap_diambil,selesai'
            ]);

            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Update status
            $order->status = $newStatus;

            // Jika status berubah menjadi selesai, set tanggal selesai
            if ($newStatus === 'selesai' && $oldStatus !== 'selesai') {
                $order->tanggal_selesai = now();
            }

            $order->save();

            // Variabel dasar untuk notifikasi
            $variables = [
                'nama' => $order->customer->nama,
                'nomor_order' => str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'layanan' => $order->service->nama_layanan,
                'berat' => $order->berat,
                'total' => number_format($order->total_harga, 0, ',', '.')
            ];

            // Kirim notifikasi berdasarkan status
            $templateSent = false;
            if ($newStatus === 'diproses' && $oldStatus !== 'diproses') {
                $result = $this->whatsapp->sendMessageWithTemplate($order->customer->no_wa, 'diproses', $variables);
                $templateSent = $result['success'];
            } elseif ($newStatus === 'siap_diambil' && $oldStatus !== 'siap_diambil') {
                $result = $this->whatsapp->sendMessageWithTemplate($order->customer->no_wa, 'siap_diambil', $variables);
                $templateSent = $result['success'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui' . (!$templateSent ? ' (notifikasi WhatsApp tidak dikirim karena template tidak aktif)' : '')
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
