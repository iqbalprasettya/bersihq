@extends('layouts.app')

@section('title', 'Daftar Pengguna - BersihQ Laundry')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 pb-20">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
            <h1 class="text-2xl font-bold text-white">Daftar Pengguna</h1>
            <a href="{{ route('users.create') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-medium text-white bg-green-600 hover:bg-green-700 shadow-sm transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Pengguna
            </a>
        </div>

        <!-- Card View untuk Semua Ukuran -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Username
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Dibuat
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-base shadow-sm">
                                            {{ substr($user->nama, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->username }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="p-1.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4">
                                    <div class="text-center">
                                        <div
                                            class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-50 mb-3">
                                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-medium text-gray-900 mb-1">Belum ada pengguna</h3>
                                        <p class="text-sm text-gray-500 mb-3">Mulai tambahkan pengguna baru untuk mengelola
                                            laundry Anda.</p>
                                        <a href="{{ route('users.create') }}"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            Tambah Pengguna Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600 text-center sm:text-left">
                            Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari
                            {{ $users->total() }} pengguna
                        </div>
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <span
                                    class="inline-flex items-center px-2 sm:px-3 py-1.5 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}"
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
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if ($page == $users->currentPage())
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
                                Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}
                            </div>

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}"
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
            @endif
        </div>
    </div>
@endsection
