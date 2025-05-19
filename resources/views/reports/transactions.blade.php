@extends('layouts.app')

@section('title', 'Laporan Transaksi - BersihQ Laundry')

@push('plugins')
    @include('layouts.plugins')
@endpush

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-semibold text-white">Laporan Transaksi</h1>
            <p class="mt-1 text-sm sm:text-base text-white/80">Lihat dan unduh laporan transaksi laundry</p>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <form action="{{ route('reports.transactions') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Date Range -->
                    <div class="w-full">
                        <label for="daterange" class="block text-sm font-medium text-gray-700 mb-1">Rentang Tanggal</label>
                        <div class="relative">
                            <input type="text" id="daterange" name="daterange"
                                class="w-full rounded-lg bg-gray-50 border border-gray-200 text-gray-900 py-2.5 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none text-sm sm:text-base"
                                placeholder="Pilih rentang tanggal" value="{{ request('daterange') }}" readonly>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="w-full">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="relative">
                            <select id="status" name="status"
                                class="w-full rounded-lg bg-gray-50 border border-gray-200 text-gray-900 py-2.5 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none text-sm sm:text-base">
                                <option value="">Semua Status</option>
                                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima
                                </option>
                                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="siap_diambil" {{ request('status') === 'siap_diambil' ? 'selected' : '' }}>
                                    Siap
                                    Diambil</option>
                                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 pt-2">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('reports.transactions.export', request()->query()) }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Laporan
                    </a>
                </div>
            </form>
        </div>

        <!-- Mobile View -->
        <div class="block lg:hidden space-y-4">
            @forelse ($transactions as $transaction)
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @switch($transaction->status)
                            @case('diterima')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Diterima
                                </span>
                            @break

                            @case('diproses')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Diproses
                                </span>
                            @break

                            @case('siap_diambil')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Siap Diambil
                                </span>
                            @break

                            @case('selesai')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Selesai
                                </span>
                            @break
                        @endswitch
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600">Pelanggan</p>
                            <p class="text-sm text-gray-900">{{ $transaction->customer->nama }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600">Layanan</p>
                            <p class="text-sm text-gray-900">{{ $transaction->service->nama_layanan }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-sm font-medium text-emerald-600">Rp
                                {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="bg-white rounded-xl p-8 text-center text-gray-400">
                        Tidak ada data transaksi
                    </div>
                @endforelse
            </div>

            <!-- Desktop View -->
            <div class="hidden lg:block bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    No. Order</th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Tanggal</th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Pelanggan</th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Layanan</th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Total</th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-medium text-gray-900">
                                        #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-500">
                                        {{ $transaction->customer->nama }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-500">
                                        {{ $transaction->service->nama_layanan }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-500 whitespace-nowrap">Rp
                                        {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4">
                                        @switch($transaction->status)
                                            @case('diterima')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 whitespace-nowrap">
                                                    Diterima
                                                </span>
                                            @break

                                            @case('diproses')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 whitespace-nowrap">
                                                    Diproses
                                                </span>
                                            @break

                                            @case('siap_diambil')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap">
                                                    Siap Diambil
                                                </span>
                                            @break

                                            @case('selesai')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 whitespace-nowrap">
                                                    Selesai
                                                </span>
                                            @break
                                        @endswitch
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 sm:px-6 py-8 text-sm text-gray-500 text-center">
                                            Tidak ada data transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($transactions->hasPages())
                    <div class="mt-4 sm:mt-6">
                        <div class="bg-white rounded-xl shadow-sm p-4">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="text-sm text-gray-600 text-center sm:text-left w-full sm:w-auto">
                                    Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari
                                    {{ $transactions->total() }} transaksi
                                </div>
                                <div class="flex items-center space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                                    @if ($transactions->onFirstPage())
                                        <span
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                            Sebelumnya
                                        </span>
                                    @else
                                        <a href="{{ $transactions->previousPageUrl() }}"
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                            Sebelumnya
                                        </a>
                                    @endif

                                    @if ($transactions->hasMorePages())
                                        <a href="{{ $transactions->nextPageUrl() }}"
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 transition duration-150 ease-in-out">
                                            Selanjutnya
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                            Selanjutnya
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endsection
