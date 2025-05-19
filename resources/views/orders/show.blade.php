@extends('layouts.app')

@section('title', 'Detail Pesanan - BersihQ Laundry')

@section('content')
    <!-- Toast Notification -->
    <div id="toast-notification" class="hidden fixed bottom-4 right-4 z-50"></div>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Detail Pesanan</h1>
                <p class="mt-1 text-sm text-white/80">Informasi lengkap tentang pesanan ini</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-white bg-white/10 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-semibold text-gray-900">Status Pesanan</h2>
                            <span id="status-badge"
                                class="px-2.5 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap
                                @if ($order->status === 'diterima') bg-green-100 text-green-700 
                                @elseif($order->status === 'diproses') bg-orange-100 text-orange-700 
                                @elseif($order->status === 'siap_diambil') bg-teal-100 text-teal-700 
                                @elseif($order->status === 'selesai') bg-purple-100 text-purple-700 @endif">
                                {{ str_replace('_', ' ', ucfirst($order->status)) }}
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">Pesanan dibuat pada
                            {{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if ($order->status !== 'selesai')
                            @if ($order->status === 'diterima' || $order->status === 'diproses')
                                <button type="button" data-status="diproses" onclick="updateStatus('diproses')"
                                    class="status-button inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg bg-orange-100 text-orange-800 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                                    <span class="w-2 h-2 rounded-full bg-orange-500 mr-1.5"></span>
                                    Diproses
                                </button>
                            @else
                                <button type="button" disabled
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <span class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span>
                                    Diproses
                                </button>
                            @endif

                            @if ($order->status === 'diproses')
                                <button type="button" data-status="siap_diambil" onclick="updateStatus('siap_diambil')"
                                    class="status-button inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg bg-teal-100 text-teal-800 hover:bg-teal-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all">
                                    <span class="w-2 h-2 rounded-full bg-teal-500 mr-1.5"></span>
                                    Siap Diambil
                                </button>
                            @else
                                <button type="button" disabled
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <span class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span>
                                    Siap Diambil
                                </button>
                            @endif

                            @if ($order->status === 'siap_diambil')
                                <button type="button" data-status="selesai" onclick="updateStatus('selesai')"
                                    class="status-button inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg bg-purple-100 text-purple-800 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                                    <span class="w-2 h-2 rounded-full bg-purple-500 mr-1.5"></span>
                                    Selesai
                                </button>
                            @else
                                <button type="button" disabled
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <span class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span>
                                    Selesai
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Pesanan -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Pesanan -->
                <div class="bg-white rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Detail Pesanan</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nomor Pesanan</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tanggal Pesanan</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Layanan</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->service->nama_layanan }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Berat</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->berat }} kg</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Harga</p>
                                <p class="mt-1 text-base font-semibold text-green-600">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Catatan</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->catatan ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pelanggan -->
                <div class="bg-white rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Pelanggan</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nama</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->customer->nama }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">No. WhatsApp</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->customer->no_wa }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Alamat</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->customer->alamat ?: '-' }}
                                </p>
                            </div>
                            @if ($order->customer->email)
                                <div class="sm:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="mt-1 text-base font-semibold text-gray-900">{{ $order->customer->email }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Timeline Pesanan</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Pesanan Dibuat -->
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Pesanan Dibuat</div>
                                    <div class="mt-0.5 text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Tanggal Selesai -->
                            @if ($order->tanggal_selesai)
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <span class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-teal-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900">Pesanan Selesai</div>
                                        <div class="mt-0.5 text-sm text-gray-500">
                                            {{ $order->tanggal_selesai->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Fungsi untuk menampilkan toast notification
            function showToast(message, type = 'success') {
                console.log('Showing toast:', message, type); // Debug log
                const toast = $('#toast-notification');
                const bgColor = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' :
                    'bg-red-100 border-red-500 text-red-700';
                const icon = type === 'success' ?
                    `<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>` :
                    `<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>`;

                toast.html(`
                    <div class="rounded-xl border ${bgColor} p-4 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                ${icon}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">${message}</p>
                            </div>
                        </div>
                    </div>
                `).removeClass('hidden');

                setTimeout(() => {
                    toast.addClass('hidden');
                }, 3000);
            }

            // Fungsi untuk mengupdate status
            function updateStatus(newStatus) {

                // Disable semua tombol status
                $('.status-button').prop('disabled', true);

                // Ambil tombol yang diklik
                const button = $(`.status-button[data-status="${newStatus}"]`);
                const originalText = button.html();

                // Tampilkan loading state
                button.html(`
                    <svg class="animate-spin -ml-1 h-5 w-5 text-current" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `);

                // Kirim request AJAX
                $.ajax({
                    url: `/orders/{{ $order->id }}/update-status`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        status: newStatus
                    },
                    success: function(response) {
                        console.log('Success response:', response); // Debug log
                        if (response.success) {
                            showToast('Status pesanan berhasil diperbarui');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showToast(response.message || 'Gagal mengubah status pesanan', 'error');
                            // Reset tombol
                            button.html(originalText);
                            $('.status-button').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', {
                            xhr,
                            status,
                            error
                        }); // Debug log
                        const errorMessage = xhr.responseJSON?.message || 'Gagal mengubah status pesanan';
                        showToast(errorMessage, 'error');
                        // Reset tombol
                        button.html(originalText);
                        $('.status-button').prop('disabled', false);
                    }
                });
            }
        </script>
    @endpush
@endsection
