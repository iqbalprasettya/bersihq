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
                                class="appearance-none w-full rounded-xl bg-gray-50 border-2 border-transparent text-base focus:border-green-500 focus:bg-white focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200 pl-5 pr-12 py-4 cursor-pointer hover:bg-gray-100">
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
        </script>
    @endpush
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
</style>
