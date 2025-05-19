@extends('layouts.app')

@section('title', 'Laporan Transaksi - BersihQ Laundry')

@push('plugins')
    @include('layouts.plugins')
@endpush

@section('content')
    <div class="p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-white">Laporan Transaksi</h1>
            <p class="mt-1 text-white/80">Lihat dan unduh laporan transaksi laundry</p>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <form action="{{ route('reports.transactions') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date Range -->
                    <div>
                        <label for="daterange" class="block text-sm font-medium text-gray-700 mb-1">Rentang Tanggal</label>
                        <div class="relative">
                            <input type="text" id="daterange" name="daterange"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm pl-10"
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
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            <option value="">Semua Status</option>
                            <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="siap_diambil" {{ request('status') === 'siap_diambil' ? 'selected' : '' }}>Siap
                                Diambil</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('reports.transactions.export', request()->query()) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
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

        <!-- Transactions Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.
                                Order</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Layanan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->customer->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->service->nama_layanan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                    {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada data transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transactions->hasPages())
                    <div class="mt-6">
                        <div class="bg-white rounded-xl shadow-sm p-4">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="text-sm text-gray-600 text-center sm:text-left">
                                    Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }}
                                    dari
                                    {{ $transactions->total() }} transaksi
                                </div>
                                <div class="flex items-center space-x-2">
                                    {{-- Previous Page Link --}}
                                    @if ($transactions->onFirstPage())
                                        <span
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                            <span class="hidden sm:inline">Sebelumnya</span>
                                        </span>
                                    @else
                                        <a href="{{ $transactions->previousPageUrl() }}"
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-green-600 hover:border-green-200 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                            <span class="hidden sm:inline">Sebelumnya</span>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    <div class="hidden sm:flex items-center space-x-2">
                                        @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                            @if ($page == $transactions->currentPage())
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-medium text-white bg-green-600">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 transition-colors">{{ $page }}</a>
                                            @endif
                                        @endforeach
                                    </div>

                                    {{-- Mobile Pagination Info --}}
                                    <div class="sm:hidden text-sm font-medium text-gray-600">
                                        Halaman {{ $transactions->currentPage() }} dari {{ $transactions->lastPage() }}
                                    </div>

                                    {{-- Next Page Link --}}
                                    @if ($transactions->hasMorePages())
                                        <a href="{{ $transactions->nextPageUrl() }}"
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-green-600 hover:border-green-200 transition-colors">
                                            <span class="hidden sm:inline">Selanjutnya</span>
                                            <svg class="w-4 h-4 sm:ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                            <span class="hidden sm:inline">Selanjutnya</span>
                                            <svg class="w-4 h-4 sm:ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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
        </div>
    @endsection
