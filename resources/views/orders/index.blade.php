@extends('layouts.app')

@section('title', 'Daftar Pesanan - BersihQ Laundry')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 pb-20">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
            <h1 class="text-2xl font-bold text-white">Daftar Pesanan</h1>
            <a href="{{ route('orders.create') }}"
                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-white bg-green-600 hover:bg-green-700 shadow-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Pesanan Baru
            </a>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                    <div class="w-full sm:w-64">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status
                            Pesanan</label>
                        <div class="relative">
                            <select id="status-filter"
                                class="w-full rounded-lg bg-gray-50 border border-gray-200 text-gray-900 py-2.5 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none">
                                <option value="">Semua Status</option>
                                <option value="diterima">Diterima</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="diambil">Diambil</option>
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
                    <div class="w-full sm:flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pelanggan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="search" placeholder="Cari nama pelanggan..."
                                class="w-full py-2.5 pl-10 pr-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card View untuk Semua Ukuran -->
        <div class="space-y-4" id="order-list">
            @forelse ($orders as $order)
                <div class="bg-white rounded-xl p-4 shadow-md hover:shadow-lg space-y-3 transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-900">{{ $order->customer->nama }}</h3>
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap
                                    @if ($order->status === 'diterima') bg-green-100 text-green-700 
                                    @elseif($order->status === 'diproses') bg-orange-100 text-orange-700 
                                    @elseif($order->status === 'selesai') bg-teal-100 text-teal-700 
                                    @elseif($order->status === 'diambil') bg-purple-100 text-purple-700 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $order->service->nama_layanan }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-green-700 font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-xs">
                                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <div>
                            <p class="text-gray-600">Berat: <span class="font-medium">{{ $order->berat }} kg</span></p>
                            <p class="text-gray-600 text-xs">No: #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <button type="button" data-order-id="{{ $order->id }}"
                            class="detail-btn inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition-all">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-8 text-center text-gray-400 shadow-md">
                    Belum ada pesanan.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="mt-6">
                <div class="bg-white rounded-xl shadow-md">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay dengan animasi -->
            <div id="modal-backdrop"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 ease-out opacity-0"></div>

            <!-- Modal panel dengan animasi -->
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                id="modal-content">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Loading State -->
                    <div id="loading-state" class="hidden">
                        <div class="flex flex-col items-center justify-center py-10">
                            <div class="flex space-x-2 animate-pulse">
                                <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-600 rounded-full animation-delay-200"></div>
                                <div class="w-3 h-3 bg-green-600 rounded-full animation-delay-400"></div>
                            </div>
                            <p class="mt-4 text-sm text-gray-500">Memuat detail pesanan...</p>
                        </div>
                    </div>

                    <!-- Content State -->
                    <div id="content-state" class="hidden">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Detail Pesanan
                                    </h3>
                                    <div id="order-status" class="px-2 py-0.5 rounded-full text-xs font-semibold"></div>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                            <p class="font-medium text-gray-900" id="order-number"></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                                            <p class="font-medium text-gray-900" id="order-date"></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Pelanggan</p>
                                            <p class="font-medium text-gray-900" id="customer-name"></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Kontak</p>
                                            <p class="font-medium text-gray-900" id="customer-contact"></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Layanan</p>
                                            <p class="font-medium text-gray-900" id="service-name"></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Berat</p>
                                            <p class="font-medium text-gray-900" id="order-weight"></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Catatan</p>
                                        <p class="font-medium text-gray-900 italic" id="order-notes"></p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm font-medium text-gray-900">Total Harga</p>
                                            <p class="text-lg font-bold text-green-600" id="order-total"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6">
                    <!-- Status buttons -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Update Status:</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" data-status="diterima"
                                class="status-button inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded bg-green-100 text-green-800 hover:bg-green-200 focus:outline-none">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>
                                Diterima
                            </button>
                            <button type="button" data-status="diproses"
                                class="status-button inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded bg-orange-100 text-orange-800 hover:bg-orange-200 focus:outline-none">
                                <span class="w-2 h-2 rounded-full bg-orange-500 mr-1.5"></span>
                                Diproses
                            </button>
                            <button type="button" data-status="selesai"
                                class="status-button inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded bg-teal-100 text-teal-800 hover:bg-teal-200 focus:outline-none">
                                <span class="w-2 h-2 rounded-full bg-teal-500 mr-1.5"></span>
                                Selesai
                            </button>
                            <button type="button" data-status="diambil"
                                class="status-button inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded bg-purple-100 text-purple-800 hover:bg-purple-200 focus:outline-none">
                                <span class="w-2 h-2 rounded-full bg-purple-500 mr-1.5"></span>
                                Diambil
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="close-modal-btn"
                            class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        /* Modal animations */
        .modal-enter-active {
            transition: opacity 0.3s ease-out;
            opacity: 1 !important;
        }

        .modal-enter-active #modal-content {
            transition: all 0.3s ease-out;
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Setup CSRF token untuk semua request Ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Filter berdasarkan status
            $('#status-filter').on('change', function() {
                const status = $(this).val().toLowerCase();
                filterOrders();
            });

            // Pencarian berdasarkan nama pelanggan
            $('#search').on('keyup', function() {
                filterOrders();
            });

            function filterOrders() {
                const status = $('#status-filter').val().toLowerCase();
                const search = $('#search').val().toLowerCase();

                $('#order-list > div').each(function() {
                    const orderCard = $(this);
                    const orderStatus = orderCard.find('.rounded-full').text().trim().toLowerCase();
                    const customerName = orderCard.find('h3').text().trim().toLowerCase();

                    const statusMatch = status === '' || orderStatus === status;
                    const searchMatch = search === '' || customerName.includes(search);

                    if (statusMatch && searchMatch) {
                        orderCard.show();
                    } else {
                        orderCard.hide();
                    }
                });
            }

            // Modal Detail
            $('.detail-btn').on('click', function() {
                const orderId = $(this).data('order-id');

                // Show modal with animation
                $('#detail-modal').removeClass('hidden');
                setTimeout(() => {
                    $('#modal-backdrop').addClass('modal-enter-active');
                    $('#modal-content').addClass('modal-enter-active');
                }, 10);

                // Show loading state
                $('#loading-state').removeClass('hidden');
                $('#content-state').addClass('hidden');

                // Reset status classes
                $('#order-status').removeClass(
                    'bg-green-100 text-green-700 bg-orange-100 text-orange-700 bg-teal-100 text-teal-700 bg-purple-100 text-purple-700'
                );

                // Fetch order details via AJAX
                $.ajax({
                    url: '/orders/' + orderId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Simulate loading for better UX (minimal 500ms)
                        setTimeout(() => {
                            if (response.success && response.order) {
                                const order = response.order;

                                // Format tanggal
                                const orderDate = new Date(order.created_at);
                                const formattedDate = orderDate.toLocaleDateString(
                                    'id-ID', {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });

                                // Populate modal with order details
                                $('#order-number').text('#' + String(order.id).padStart(
                                    5, '0'));
                                $('#order-date').text(formattedDate);
                                $('#customer-name').text(order.customer.nama);
                                $('#customer-contact').text(order.customer.no_wa);
                                $('#service-name').text(order.service.nama_layanan);
                                $('#order-weight').text(order.berat + ' kg');
                                $('#order-notes').text(order.catatan || '-');
                                $('#order-total').text('Rp ' + parseInt(order
                                    .total_harga).toLocaleString('id-ID'));

                                // Set status badge
                                const statusElement = $('#order-status');
                                statusElement.text(order.status.charAt(0)
                                    .toUpperCase() + order.status.slice(1));

                                // Reset dan tambahkan kelas status yang sesuai
                                statusElement.removeClass(
                                    'bg-green-100 text-green-700 bg-orange-100 text-orange-700 bg-teal-100 text-teal-700 bg-purple-100 text-purple-700'
                                );

                                if (order.status === 'diterima') {
                                    statusElement.addClass(
                                        'bg-green-100 text-green-700');
                                } else if (order.status === 'diproses') {
                                    statusElement.addClass(
                                        'bg-orange-100 text-orange-700');
                                } else if (order.status === 'selesai') {
                                    statusElement.addClass('bg-teal-100 text-teal-700');
                                } else if (order.status === 'diambil') {
                                    statusElement.addClass(
                                        'bg-purple-100 text-purple-700');
                                }

                                // Set active status button
                                $('.status-button').each(function() {
                                    $(this).removeClass('ring-2 ring-offset-2');
                                    if ($(this).data('status') === order
                                        .status) {
                                        $(this).addClass(
                                            'ring-2 ring-offset-2');
                                    }
                                });

                                // Store order ID for status buttons
                                $('.status-button').data('order-id', order.id);

                                // Hide loading, show content with fade
                                $('#loading-state').fadeOut(300, function() {
                                    $('#content-state').fadeIn(300);
                                });
                            } else {
                                console.error('Invalid response format:', response);
                                alert(
                                    'Format response tidak valid. Silakan coba lagi.'
                                );
                                closeModal();
                            }
                        }, 500);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            xhr,
                            status,
                            error
                        });
                        alert('Gagal memuat detail pesanan. Silakan coba lagi. Error: ' +
                            error);
                        closeModal();
                    }
                });
            });

            function closeModal() {
                // Remove animation classes first
                $('#modal-backdrop').removeClass('modal-enter-active');
                $('#modal-content').removeClass('modal-enter-active');

                // Wait for animation to finish then hide modal
                setTimeout(() => {
                    $('#detail-modal').addClass('hidden');
                    // Reset states
                    $('#loading-state').addClass('hidden');
                    $('#content-state').addClass('hidden');
                    $('#order-status').removeClass(
                        'bg-green-100 text-green-700 bg-orange-100 text-orange-700 bg-teal-100 text-teal-700 bg-purple-100 text-purple-700'
                    );
                }, 300);
            }

            // Close modal when clicking the backdrop or close button
            $('#modal-backdrop, #close-modal-btn').on('click', function() {
                closeModal();
            });

            // Prevent closing when clicking inside the modal content
            $('#modal-content').on('click', function(e) {
                e.stopPropagation();
            });

            // Handle status button click
            $('.status-button').on('click', function() {
                const button = $(this);
                const newStatus = button.data('status');
                const orderId = button.data('order-id');

                // Disable all status buttons
                $('.status-button').prop('disabled', true);

                // Add loading state to clicked button
                const originalText = button.html();
                button.html(`
                    <svg class="animate-spin -ml-1 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `);

                // Send AJAX request to update status
                $.ajax({
                    url: `/orders/${orderId}/update-status`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        status: newStatus,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update status badge in modal
                            const statusElement = $('#order-status');
                            statusElement.removeClass(
                                'bg-green-100 text-green-700 bg-orange-100 text-orange-700 bg-teal-100 text-teal-700 bg-purple-100 text-purple-700'
                            );

                            let statusClass = '';
                            if (newStatus === 'diterima') {
                                statusClass = 'bg-green-100 text-green-700';
                            } else if (newStatus === 'diproses') {
                                statusClass = 'bg-orange-100 text-orange-700';
                            } else if (newStatus === 'selesai') {
                                statusClass = 'bg-teal-100 text-teal-700';
                            } else if (newStatus === 'diambil') {
                                statusClass = 'bg-purple-100 text-purple-700';
                            }

                            statusElement.addClass(statusClass)
                                .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                            // Update status badge in card list
                            const cardStatus = $(`.detail-btn[data-order-id="${orderId}"]`)
                                .closest('.bg-white')
                                .find('.rounded-full');

                            cardStatus.removeClass(
                                    'bg-green-100 text-green-700 bg-orange-100 text-orange-700 bg-teal-100 text-teal-700 bg-purple-100 text-purple-700'
                                )
                                .addClass(statusClass)
                                .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                            // Show success message
                            const successAlert = $(`
                                <div class="fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-lg z-50">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm">Status pesanan berhasil diperbarui!</p>
                                        </div>
                                    </div>
                                </div>
                            `).appendTo('body').fadeIn();

                            setTimeout(() => {
                                successAlert.fadeOut(() => successAlert.remove());
                            }, 3000);

                            // Update active status button
                            $('.status-button').removeClass('ring-2 ring-offset-2');
                            button.addClass('ring-2 ring-offset-2');
                        } else {
                            alert('Gagal mengubah status pesanan. Silakan coba lagi.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            xhr,
                            status,
                            error
                        });
                        alert('Gagal mengubah status pesanan. Silakan coba lagi. Error: ' +
                            error);
                    },
                    complete: function() {
                        // Reset button state
                        $('.status-button').prop('disabled', false);
                        button.html(originalText);
                    }
                });
            });
        });
    </script>
@endpush
