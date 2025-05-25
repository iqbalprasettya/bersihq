@extends('layouts.app')

@section('title', 'Buat Pesanan Baru - BersihQ Laundry')

@section('content')
    <div class="max-w-5xl mx-auto space-y-4 pb-20">
        <!-- Breadcrumb -->
        <nav class="bg-white shadow-sm rounded-2xl p-4 flex items-center space-x-3 text-base">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </a>
            <span class="text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Pesanan</a>
            <span class="text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <span class="text-green-600 font-semibold">Buat Pesanan</span>
        </nav>

        <!-- Form Container -->
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Kolom Kiri: Informasi Pelanggan & Layanan -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Card Pelanggan -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-base font-medium text-gray-900">Pilih Pelanggan</span>
                            <button type="button" id="btnTambahPelanggan"
                                class="group relative inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 hover:text-white focus:outline-none">
                                <span
                                    class="absolute inset-0 rounded-full bg-green-50 group-hover:bg-green-600 transition-colors duration-200"></span>
                                <svg class="relative w-5 h-5 mr-2 transition-transform group-hover:rotate-180 duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="relative">Pelanggan Baru</span>
                            </button>
                        </div>
                        <div class="relative">
                            <select name="customer_id" id="customer_id"
                                class="select2-customer w-full rounded-xl bg-gray-50 border-2 border-transparent text-base focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 pl-5 pr-12 py-4 cursor-pointer hover:bg-gray-100">
                                <option value="">Pilih pelanggan</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama }} ({{ $customer->no_wa }})
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('customer_id')
                            <p class="mt-2 text-sm text-red-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Card Layanan -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <span class="text-base font-medium text-gray-900 block mb-4">Pilih Layanan</span>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($services as $service)
                                <label class="relative block cursor-pointer service-option">
                                    <input type="radio" name="service_id" value="{{ $service->id }}"
                                        data-price="{{ $service->harga }}"
                                        {{ old('service_id') == $service->id ? 'checked' : '' }}
                                        class="hidden service-radio" onchange="updateServiceSelection(this)">
                                    <div
                                        class="relative overflow-hidden rounded-xl border-2 border-gray-200 hover:border-green-200 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg service-card">
                                        <div class="p-5">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h3
                                                        class="text-lg font-semibold text-gray-900 transition-colors duration-300">
                                                        {{ $service->nama_layanan }}
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500 transition-colors duration-300">
                                                        {{ $service->deskripsi }}
                                                    </p>
                                                </div>
                                                <div class="ml-4">
                                                    <div
                                                        class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-300 radio-circle">
                                                        <svg class="w-3.5 h-3.5 text-white check-icon" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex items-baseline">
                                                <span
                                                    class="text-2xl font-bold text-green-600 transition-colors duration-300">
                                                    Rp {{ number_format($service->harga, 0, ',', '.') }}
                                                </span>
                                                <span class="ml-1 text-gray-500">/kg</span>
                                            </div>
                                        </div>
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-green-100/0 via-green-100/0 to-green-100/0 opacity-0 transition-all duration-500 pointer-events-none gradient-overlay">
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('service_id')
                            <p class="mt-2 text-sm text-red-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Card Catatan -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <span class="text-base font-medium text-gray-900 block mb-4">Catatan</span>
                        <div class="relative">
                            <textarea name="catatan" rows="3"
                                class="block w-full rounded-xl bg-gray-50 border-2 border-transparent focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 text-base pl-5 pr-12 py-4 resize-none"
                                placeholder="Tambahkan catatan khusus untuk pesanan ini...">{{ old('catatan') }}</textarea>
                            <div class="absolute right-4 top-4 text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan Pesanan -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6 lg:sticky lg:top-20">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                        <!-- Input Berat -->
                        <div class="mb-6">
                            <span class="text-base font-medium text-gray-900 block mb-3">Berat Cucian</span>
                            <div class="relative">
                                <input type="number" name="berat" id="berat"
                                    class="block w-full rounded-xl bg-gray-50 border-2 border-transparent focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 text-3xl font-semibold pl-5 pr-16 py-4"
                                    placeholder="0.0" step="0.1" min="0" value="{{ old('berat') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-5">
                                    <span class="text-2xl font-medium text-gray-400">kg</span>
                                </div>
                            </div>
                            @error('berat')
                                <p class="mt-2 text-sm text-red-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Garis Pembatas -->
                        <div class="border-t-2 border-dashed border-gray-200 my-6"></div>

                        <!-- Total Harga -->
                        <div class="flex items-center justify-between mb-8">
                            <span class="text-base font-medium text-gray-900">Total Harga</span>
                            <span class="text-3xl font-bold text-green-600" id="totalHarga">Rp 0</span>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="relative w-full h-14 rounded-xl bg-green-600 text-white text-base font-medium overflow-hidden group focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 hover:bg-green-700 transition-all duration-200">
                            <span
                                class="absolute inset-0 w-full h-full transition-all duration-300 ease-out transform translate-y-0 bg-green-600 group-hover:-translate-y-full"></span>
                            <span
                                class="absolute inset-0 w-full h-full transition-all duration-300 ease-out transform translate-y-full bg-green-700 group-hover:translate-y-0"></span>
                            <span
                                class="relative group-hover:translate-x-2 transition-transform duration-200 flex items-center justify-center">
                                Buat Pesanan
                                <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Inisialisasi Select2
            $(document).ready(function() {
                $('.select2-customer').select2({
                    theme: 'classic',
                    width: '100%',
                    placeholder: 'Cari nama pelanggan...',
                    allowClear: true,
                    language: {
                        noResults: function() {
                            return "Pelanggan tidak ditemukan";
                        },
                        searching: function() {
                            return "Mencari...";
                        }
                    }
                });

                // Styling untuk Select2
                $('.select2-container--classic .select2-selection--single').addClass(
                    'rounded-xl bg-gray-50 border-2 border-transparent text-base focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 pl-5 pr-12 py-4 cursor-pointer hover:bg-gray-100'
                );
                $('.select2-container--classic .select2-selection--single .select2-selection__rendered').addClass(
                    'text-gray-900');
                $('.select2-container--classic .select2-selection--single .select2-selection__arrow').addClass(
                    'text-gray-500');
            });

            // Hitung total harga
            function hitungTotalHarga() {
                const selectedService = document.querySelector('input[name="service_id"]:checked');
                const beratInput = document.getElementById('berat');
                const totalHargaElement = document.getElementById('totalHarga');

                const harga = selectedService ? parseFloat(selectedService.dataset.price) : 0;
                const berat = beratInput.value ? parseFloat(beratInput.value) : 0;

                const totalHarga = harga * berat;
                totalHargaElement.textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
            }

            // Event listeners
            document.querySelectorAll('input[name="service_id"]').forEach(radio => {
                radio.addEventListener('change', hitungTotalHarga);
            });
            document.getElementById('berat').addEventListener('input', hitungTotalHarga);

            // Hitung total harga saat halaman dimuat
            document.addEventListener('DOMContentLoaded', hitungTotalHarga);

            function updateServiceSelection(radio) {
                // Hapus class selected dari semua opsi
                document.querySelectorAll('.service-option').forEach(option => {
                    option.classList.remove('selected');
                });

                // Tambahkan class selected ke opsi yang dipilih
                if (radio.checked) {
                    radio.closest('.service-option').classList.add('selected');
                }
            }

            // Inisialisasi status awal
            document.addEventListener('DOMContentLoaded', function() {
                const checkedRadio = document.querySelector('.service-radio:checked');
                if (checkedRadio) {
                    updateServiceSelection(checkedRadio);
                }
            });

            // Format nomor WhatsApp
            const noWaInput = document.getElementById('no_wa');
            noWaInput.addEventListener('input', function(e) {
                // Hapus semua karakter non-digit
                let value = e.target.value.replace(/\D/g, '');

                // Hapus angka 0 di depan jika ada
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }

                // Hapus angka 62 di depan jika ada
                if (value.startsWith('62')) {
                    value = value.substring(2);
                }

                // Set nilai input tanpa format
                e.target.value = value;
            });

            // Modal Tambah Pelanggan
            const modal = document.getElementById('modalTambahPelanggan');
            const btnTambahPelanggan = document.getElementById('btnTambahPelanggan');
            const btnBatalTambahPelanggan = document.getElementById('btnBatalTambahPelanggan');
            const formTambahPelanggan = document.getElementById('formTambahPelanggan');
            const selectPelanggan = document.getElementById('customer_id');

            // Buka modal
            btnTambahPelanggan.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Tutup modal
            function tutupModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                formTambahPelanggan.reset();
            }

            btnBatalTambahPelanggan.addEventListener('click', tutupModal);

            // Tutup modal ketika klik di luar modal
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    tutupModal();
                }
            });

            // Handle form submission
            formTambahPelanggan.addEventListener('submit', async (e) => {
                e.preventDefault();

                try {
                    // Format nomor WhatsApp sebelum submit
                    const noWaInput = document.getElementById('no_wa');
                    let noWaValue = noWaInput.value.replace(/\D/g, '');

                    // Hapus 0 atau 62 di depan jika ada
                    if (noWaValue.startsWith('0')) {
                        noWaValue = noWaValue.substring(1);
                    }
                    if (noWaValue.startsWith('62')) {
                        noWaValue = noWaValue.substring(2);
                    }

                    const formData = {
                        nama: document.getElementById('nama').value,
                        no_wa: '62' + noWaValue,
                        alamat: document.getElementById('alamat').value,
                        email: document.getElementById('email').value
                    };

                    const response = await fetch('/customers', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(formData)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        if (errorData.errors && errorData.errors.no_wa) {
                            throw new Error(errorData.errors.no_wa[0]);
                        } else {
                            throw new Error(errorData.message || 'Terjadi kesalahan saat menambahkan pelanggan');
                        }
                    }

                    const data = await response.json();

                    // Tambahkan opsi baru ke select
                    const option = new Option(data.customer.nama + ' (' + data.customer.no_wa + ')', data.customer
                        .id);
                    selectPelanggan.add(option);
                    selectPelanggan.value = data.customer.id;

                    // Tutup modal
                    tutupModal();

                    // Tampilkan notifikasi sukses
                    const alert = document.createElement('div');
                    alert.className =
                        'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
                    alert.innerHTML = `
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline"> ${data.message}</span>
                    `;
                    document.body.appendChild(alert);

                    // Hapus notifikasi setelah 3 detik
                    setTimeout(() => {
                        alert.remove();
                    }, 3000);

                } catch (error) {
                    console.error('Error:', error);

                    // Tampilkan notifikasi error
                    const alert = document.createElement('div');
                    alert.className =
                        'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
                    alert.innerHTML = `
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"> ${error.message}</span>
                    `;
                    document.body.appendChild(alert);

                    // Hapus notifikasi setelah 3 detik
                    setTimeout(() => {
                        alert.remove();
                    }, 3000);
                }
            });
        </script>
    @endpush

    <!-- Modal Tambah Pelanggan -->
    <div id="modalTambahPelanggan" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="formTambahPelanggan" class="p-6">
                    @csrf
                    <div class="mb-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Tambah Pelanggan Baru
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">
                                Nama
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" required
                                class="mt-1 block w-full rounded-xl bg-gray-50 border-2 border-transparent focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 text-base pl-5 pr-12 py-4">
                        </div>

                        <div>
                            <label for="no_wa" class="block text-sm font-medium text-gray-700">
                                Nomor WhatsApp
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span class="text-gray-500">+62</span>
                                </div>
                                <input type="tel" name="no_wa" id="no_wa" required
                                    class="mt-1 block w-full rounded-xl bg-gray-50 border-2 border-transparent focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 text-base pl-14 pr-12 py-4"
                                    placeholder="8xxxxxxxxxx">
                            </div>
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="mt-1 block w-full rounded-xl bg-gray-50 border-2 border-transparent focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 text-base pl-5 pr-12 py-4 resize-none"></textarea>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email"
                                class="mt-1 block w-full rounded-xl bg-gray-50 border-2 border-transparent focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 text-base pl-5 pr-12 py-4">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" id="btnBatalTambahPelanggan"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .service-option.selected .service-card {
        border-color: #22c55e;
        background-color: rgba(240, 253, 244, 0.5);
    }

    .service-option.selected .radio-circle {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    .service-option .check-icon {
        opacity: 0;
    }

    .service-option.selected .check-icon {
        opacity: 1;
    }

    /* Select2 Minimalis Super Clean - Arrow Fix Only One */
    .select2-container--classic .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        width: 2rem !important;
        right: 0.5rem !important;
        top: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: absolute !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__arrow * {
        display: none !important;
        background: none !important;
        content: none !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__arrow::before {
        display: none !important;
        content: none !important;
        background: none !important;
    }

    /* Select2 Minimalis Super Clean */
    .select2-container--classic .select2-selection--single {
        min-height: 2.5rem !important;
        background: #fff !important;
        background-image: none !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.75rem !important;
        padding: 0.5rem 2rem 0.5rem 1rem !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: none !important;
        transition: border 0.2s !important;
        position: relative !important;
        font-size: 1rem !important;
    }

    .select2-container--classic .select2-selection--single:hover,
    .select2-container--classic .select2-selection--single:focus,
    .select2-container--classic.select2-container--open .select2-selection--single {
        border-color: #22c55e !important;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.10) !important;
        background: #fff !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__rendered {
        color: #222 !important;
        padding: 0 !important;
        line-height: 1.5 !important;
        background: none !important;
        font-size: 1rem !important;
    }

    .select2-container--classic .select2-selection--single .select2-selection__placeholder {
        color: #cbd5e1 !important;
        opacity: 1 !important;
        font-size: 0.95rem !important;
    }

    /* Tombol X (clear) custom */
    .select2-container--classic .select2-selection__clear {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 1.5rem !important;
        height: 1.5rem !important;
        margin-left: 0.5rem !important;
        margin-right: 0.25rem !important;
        cursor: pointer !important;
        border-radius: 9999px !important;
        background: none !important;
        font-size: 0 !important;
        transition: background 0.2s;
        position: relative;
    }

    .select2-container--classic .select2-selection__clear::before {
        content: '';
        display: block;
        width: 1.1rem;
        height: 1.1rem;
        background: url('data:image/svg+xml;utf8,<svg fill="none" stroke="%239ca3af" stroke-width="2.2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><line x1="7" y1="7" x2="17" y2="17" stroke-linecap="round"/><line x1="17" y1="7" x2="7" y2="17" stroke-linecap="round"/></svg>') center/1.1rem no-repeat;
        transition: background 0.2s;
    }

    .select2-container--classic .select2-selection__clear:hover::before {
        background: url('data:image/svg+xml;utf8,<svg fill="none" stroke="%2322c55e" stroke-width="2.2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><line x1="7" y1="7" x2="17" y2="17" stroke-linecap="round"/><line x1="17" y1="7" x2="7" y2="17" stroke-linecap="round"/></svg>') center/1.1rem no-repeat;
    }

    .select2-container--classic .select2-selection__clear * {
        display: none !important;
    }
</style>
