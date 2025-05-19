@extends('layouts.app')

@section('title', 'Daftar Pelanggan - BersihQ Laundry')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 pb-20">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h1 class="text-2xl font-bold text-white">Daftar Pelanggan</h1>
            <a href="{{ route('customers.create') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-medium text-white bg-green-600 hover:bg-green-700 shadow-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Pelanggan Baru
            </a>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-4">
                <form id="search-form">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="search" name="q" value="{{ request('q') }}"
                            placeholder="Cari nama pelanggan..."
                            class="w-full py-2.5 pl-10 pr-4 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900">
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="customer-list">
            @forelse ($customers as $customer)
                <div data-customer-id="{{ $customer->id }}"
                    class="bg-white rounded-xl p-4 shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-base shadow-sm">
                                {{ strtoupper(substr($customer->nama, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-base font-semibold text-gray-900 truncate">{{ $customer->nama }}</h3>
                                <div class="flex items-center mt-0.5 space-x-1">
                                    <svg class="w-3.5 h-3.5 text-green-600 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <p class="text-xs font-medium text-gray-600 truncate">+{{ $customer->no_wa }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-1 ml-2">
                            <a href="{{ route('customers.edit', $customer) }}"
                                class="p-1.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button" onclick="confirmDelete({{ $customer->id }})"
                                class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 space-y-1.5 border-t border-gray-100 pt-2">
                        @if ($customer->alamat)
                            <div class="flex items-start space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-xs text-gray-600 break-words">{{ $customer->alamat }}</p>
                            </div>
                        @endif
                        @if ($customer->email)
                            <div class="flex items-start space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs text-gray-600 break-all">{{ $customer->email }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl p-6 text-center border border-gray-100">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-50 mb-3">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 mb-1">Belum ada pelanggan</h3>
                        <p class="text-sm text-gray-500 mb-3">Mulai tambahkan pelanggan baru untuk mengelola laundry Anda.
                        </p>
                        <a href="{{ route('customers.create') }}"
                            class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Tambah Pelanggan Baru
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($customers->hasPages())
            <div class="mt-6">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600 text-center sm:text-left">
                            Menampilkan {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} dari
                            {{ $customers->total() }} pelanggan
                        </div>
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($customers->onFirstPage())
                                <span
                                    class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </span>
                            @else
                                <a href="{{ $customers->previousPageUrl() }}"
                                    class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-green-600 hover:border-green-200 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            <div class="hidden sm:flex items-center space-x-2">
                                @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                    @if ($page == $customers->currentPage())
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
                                Halaman {{ $customers->currentPage() }} dari {{ $customers->lastPage() }}
                            </div>

                            {{-- Next Page Link --}}
                            @if ($customers->hasMorePages())
                                <a href="{{ $customers->nextPageUrl() }}"
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

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Hapus Pelanggan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus data pelanggan ini? Tindakan ini tidak dapat
                                    dibatalkan.<br>
                                    <span class="text-red-500 font-semibold">Semua pesanan yang terkait dengan pelanggan
                                        ini juga akan dihapus secara permanen.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Hapus
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()"
                        class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast-notification" class="fixed bottom-4 right-4 z-50 hidden"></div>
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

            // Pencarian dengan debounce
            let searchTimeout;
            $('#search').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    $('#search-form').submit();
                }, 500);
            });
        });

        // Fungsi untuk menampilkan toast notification
        function showToast(message, type = 'success') {
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

        // Fungsi untuk menampilkan modal konfirmasi hapus
        function confirmDelete(customerId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/customers/${customerId}`;
            modal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal konfirmasi hapus
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Event listener untuk form delete
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const customerId = form.action.split('/').pop();

            $.ajax({
                url: form.action,
                type: 'POST',
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showToast('Data pelanggan berhasil dihapus!');
                        closeDeleteModal();

                        // Hapus card pelanggan dari DOM
                        const customerCard = $(`[data-customer-id="${customerId}"]`);
                        customerCard.fadeOut(300, function() {
                            $(this).remove();

                            // Jika tidak ada card lagi, reload halaman
                            if ($('#customer-list > div').length === 0) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message ||
                        'Terjadi kesalahan saat menghapus data pelanggan.';
                    showToast(message, 'error');
                    closeDeleteModal();
                }
            });
        });
    </script>
@endpush
