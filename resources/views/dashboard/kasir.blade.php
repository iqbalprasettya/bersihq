@extends('layouts.app')

@section('title', 'Dashboard - BersihQ Laundry')

@section('content')
    <div class="space-y-6">
        <!-- Header dengan Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div>
                    <h1
                        class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                        Selamat Datang, {{ auth()->user()->nama }}!</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ now()->format('l, d F Y') }} - <span class="font-medium" id="clock">00:00:00</span>
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('orders.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-all duration-150 ease-in-out transform hover:scale-105">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Pesanan Baru
                    </a>
                    <a href="{{ route('customers.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-green-600 rounded-xl text-sm font-medium text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-all duration-150 ease-in-out transform hover:scale-105">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Pelanggan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Pesanan Hari Ini -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div
                class="bg-white rounded-2xl shadow-sm p-6 transform transition-all duration-150 ease-in-out hover:scale-105">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-green-50">
                        <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Diterima Hari Ini</p>
                        <p class="mt-1 text-2xl font-semibold text-green-600">{{ $countDiterima }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm p-6 transform transition-all duration-150 ease-in-out hover:scale-105">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-orange-50">
                        <svg class="h-8 w-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Diproses Hari Ini</p>
                        <p class="mt-1 text-2xl font-semibold text-orange-600">{{ $countDiproses }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm p-6 transform transition-all duration-150 ease-in-out hover:scale-105">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-teal-50">
                        <svg class="h-8 w-8 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Siap Diambil</p>
                        <p class="mt-1 text-2xl font-semibold text-teal-600">{{ $countSiapDiambil }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm p-6 transform transition-all duration-150 ease-in-out hover:scale-105">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-purple-50">
                        <svg class="h-8 w-8 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Selesai Hari Ini</p>
                        <p class="mt-1 text-2xl font-semibold text-purple-600">{{ $countSelesai }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pesanan yang Perlu Diproses -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Perlu Diproses</h2>
                    <a href="{{ route('orders.index') }}"
                        class="text-sm text-green-600 hover:text-green-800 font-medium transition-colors duration-150 ease-in-out">
                        Lihat Semua
                    </a>
                </div>
                <div class="p-6">
                    @if ($needsAttention->count() > 0)
                        <div class="flex flex-col gap-4">
                            @foreach ($needsAttention as $order)
                                <div
                                    class="relative bg-white rounded-xl shadow-sm flex flex-col sm:flex-row items-start sm:items-center border-l-4 border-green-500 gap-3 sm:gap-0 hover:shadow-md transition-all duration-150 min-h-[56px] px-4 py-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span
                                                class="font-medium text-gray-900 truncate text-sm">{{ $order->customer->nama }}</span>
                                            <span
                                                class="px-2 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap bg-green-50 text-green-700">
                                                Diterima
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500 truncate mt-0.5">
                                            {{ $order->service->nama_layanan }}
                                        </div>
                                    </div>
                                    <div class="hidden sm:block mx-4 h-8 border-l border-gray-200"></div>
                                    <div
                                        class="flex sm:flex-col items-center sm:items-end gap-2 sm:gap-0 w-full sm:w-auto">
                                        <span class="text-xs text-gray-700">{{ $order->berat }} kg</span>
                                        <span class="text-sm font-bold text-green-700">Rp
                                            {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('orders.show', $order) }}" class="absolute inset-0 z-10"
                                        aria-label="Lihat detail pesanan"></a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4">
                                <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-gray-600">Tidak ada pesanan yang perlu diproses</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pesanan Hari Ini -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Pesanan Hari Ini</h2>
                    <a href="{{ route('orders.index') }}"
                        class="text-sm text-green-600 hover:text-green-800 font-medium transition-colors duration-150 ease-in-out">
                        Lihat Semua
                    </a>
                </div>
                <div class="p-6">
                    @if ($todayOrders->count() > 0)
                        <div class="flex flex-col gap-4">
                            @foreach ($todayOrders as $order)
                                <div
                                    class="relative bg-white rounded-xl shadow-sm flex flex-col sm:flex-row items-start sm:items-center border-l-4 gap-3 sm:gap-0
                                    @if ($order->status === 'diterima') border-green-500 @elseif($order->status === 'diproses') border-orange-500 @elseif($order->status === 'siap_diambil') border-teal-500 @elseif($order->status === 'selesai') border-purple-500 @endif
                                    hover:shadow-md transition-all duration-150 min-h-[56px] px-4 py-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span
                                                class="font-medium text-gray-900 truncate text-sm">{{ $order->customer->nama }}</span>
                                            <span
                                                class="px-2 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap
                                                @if ($order->status === 'diterima') bg-green-50 text-green-700 @elseif($order->status === 'diproses') bg-orange-50 text-orange-700 @elseif($order->status === 'siap_diambil') bg-teal-50 text-teal-700 @elseif($order->status === 'selesai') bg-purple-50 text-purple-700 @endif">
                                                {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500 truncate mt-0.5">
                                            {{ $order->service->nama_layanan }}
                                        </div>
                                    </div>
                                    <div class="hidden sm:block mx-4 h-8 border-l border-gray-200"></div>
                                    <div
                                        class="flex sm:flex-col items-center sm:items-end gap-2 sm:gap-0 w-full sm:w-auto">
                                        <span class="text-xs text-gray-700">{{ $order->berat }} kg</span>
                                        <span class="text-sm font-bold text-green-700">Rp
                                            {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('orders.show', $order) }}" class="absolute inset-0 z-10"
                                        aria-label="Lihat detail pesanan"></a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($todayOrders->hasPages())
                            <div class="mt-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-xs text-gray-600">
                                        Halaman {{ $todayOrders->currentPage() }} dari {{ $todayOrders->lastPage() }}
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        {{-- Previous Page Link --}}
                                        @if ($todayOrders->onFirstPage())
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </span>
                                        @else
                                            <a href="{{ $todayOrders->previousPageUrl() }}"
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-green-600 hover:border-green-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($todayOrders->hasMorePages())
                                            <a href="{{ $todayOrders->nextPageUrl() }}"
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-green-600 hover:border-green-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4">
                                <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-2">Belum ada pesanan hari ini</p>
                            <a href="{{ route('orders.create') }}"
                                class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800 transition-colors duration-150 ease-in-out">
                                Buat pesanan baru
                                <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Update jam real-time
            function updateClock() {
                const now = new Date();
                document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID');
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush
@endsection
