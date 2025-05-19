<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Filter berdasarkan pencarian
        if ($request->has('q') && $request->q !== '') {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_wa', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('nama')->paginate(10)->withQueryString();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'no_wa' => 'required|string|max:20',
                'alamat' => 'nullable|string|max:500',
                'email' => 'nullable|email|max:255',
            ]);

            // Tambahkan 62 di depan nomor WA jika belum ada
            if (!str_starts_with($validated['no_wa'], '62')) {
                $validated['no_wa'] = '62' . ltrim($validated['no_wa'], '0');
            }

            $customer = Customer::create($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pelanggan berhasil ditambahkan',
                    'customer' => $customer
                ]);
            }

            return redirect()
                ->route('customers.index')
                ->with('success', 'Pelanggan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menambahkan pelanggan'
                ], 500);
            }
            throw $e;
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
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
        ]);

        // Tambahkan 62 di depan nomor WA jika belum ada
        if (!str_starts_with($validated['no_wa'], '62')) {
            $validated['no_wa'] = '62' . ltrim($validated['no_wa'], '0');
        }

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data pelanggan berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pelanggan. Silakan coba lagi.'
            ], 500);
        }
    }
}
