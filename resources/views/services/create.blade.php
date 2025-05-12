@extends('layouts.app')

@section('title', 'Tambah Layanan Baru - BersihQ Laundry')

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
            <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Layanan</a>
            <span class="text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <span class="text-green-600 font-semibold">Tambah Layanan</span>
        </nav>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-sm">
            <div class="p-6">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Nama Layanan -->
                        <div>
                            <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan
                                <span class="text-red-600">*</span></label>
                            <input type="text" name="nama_layanan" id="nama_layanan"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                value="{{ old('nama_layanan') }}" placeholder="Masukkan nama layanan" required>
                            @error('nama_layanan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga per Kg <span
                                    class="text-red-600">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                                <input type="number" name="harga" id="harga"
                                    class="block w-full rounded-lg bg-gray-50 border-gray-200 pl-12 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                    value="{{ old('harga') }}" placeholder="0" min="0" required>
                            </div>
                            @error('harga')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base resize-none placeholder:text-gray-400"
                                placeholder="Masukkan deskripsi layanan">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500"
                                {{ old('is_active') ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Layanan Aktif</label>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <a href="{{ route('services.index') }}"
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
