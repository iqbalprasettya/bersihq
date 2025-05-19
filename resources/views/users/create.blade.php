@extends('layouts.app')

@section('title', 'Tambah Pengguna - BersihQ Laundry')

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
            <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Pengguna</a>
            <span class="text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <span class="text-green-600 font-semibold">Tambah Pengguna</span>
        </nav>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-sm">
            <div class="p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="nama" id="nama"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                value="{{ old('nama') }}" placeholder="Masukkan nama pengguna" required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="username" id="username"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                value="{{ old('username') }}" placeholder="Masukkan username" required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span
                                    class="text-red-600">*</span></label>
                            <input type="password" name="password" id="password"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base placeholder:text-gray-400"
                                placeholder="Masukkan password" required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span
                                    class="text-red-600">*</span></label>
                            <select name="role" id="role"
                                class="block w-full rounded-lg bg-gray-50 border-gray-200 px-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base"
                                required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-end space-x-3 pt-2">
                            <a href="{{ route('users.index') }}"
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
