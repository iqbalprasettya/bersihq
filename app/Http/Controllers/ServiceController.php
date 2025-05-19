<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Pastikan is_active memiliki nilai yang sesuai dengan input
        $validated['is_active'] = $request->boolean('is_active');

        Service::create($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Pastikan is_active memiliki nilai yang sesuai dengan input
        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Hapus layanan (ini akan memicu cascade delete ke orders)
            $service->delete();

            // Commit transaksi
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Layanan dan semua pesanan terkait berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus layanan. Silakan coba lagi.'
            ], 500);
        }
    }
}
