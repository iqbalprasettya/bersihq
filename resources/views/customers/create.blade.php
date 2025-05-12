@extends('layouts.app')

@section('title', 'Tambah Pelanggan Baru - BersihQ Laundry')

@section('content')
    <div class="max-w-3xl mx-auto space-y-4 pb-20">
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
            <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Pelanggan</a>
            <span class="text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <span class="text-green-600 font-semibold">Tambah Pelanggan</span>
        </nav>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-sm">
            <div class="p-6">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="nama" id="nama"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                value="{{ old('nama') }}" placeholder="Masukkan nama pelanggan" required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div>
                            <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp <span
                                    class="text-red-600">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span class="text-gray-500">+62</span>
                                </div>
                                <input type="tel" name="no_wa" id="no_wa"
                                    class="block w-full rounded-lg bg-gray-50 border-gray-200 pl-14 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                    value="{{ old('no_wa') }}" placeholder="8xxxxxxxxxx" required>
                            </div>
                            @error('no_wa')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base resize-none placeholder:text-gray-400"
                                placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                value="{{ old('email') }}" placeholder="contoh@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <a href="{{ route('customers.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
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

        // Saat form disubmit
        document.querySelector('form').addEventListener('submit', function(e) {
            const noWaInput = document.getElementById('no_wa');
            let value = noWaInput.value.replace(/\D/g, '');

            // Hapus 0 atau 62 di depan jika ada
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            if (value.startsWith('62')) {
                value = value.substring(2);
            }

            // Tambahkan 62 di depan
            noWaInput.value = '62' + value;
        });
    </script>
@endpush
