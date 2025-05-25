@extends('layouts.app')

@section('title', 'Template WhatsApp - BersihQ')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Template WhatsApp</h1>
                    <p class="text-white/60">Kelola template pesan WhatsApp untuk berbagai keperluan</p>
                </div>
            </div>

            <!-- Daftar Template -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($templates as $template)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $template->nama }}</h3>
                                    <p class="text-sm text-gray-500">Kode: {{ $template->kode }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('whatsapp.template.edit', $template->id) }}"
                                        class="p-1 text-gray-500 hover:text-emerald-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <pre class="text-sm text-gray-600 whitespace-pre-wrap font-mono">{{ $template->konten }}</pre>
                                </div>
                            </div>
                            @if ($template->variabel)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Variabel yang tersedia:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($template->variabel as $var)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $var }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="mt-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $template->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-xl p-6 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada template</h3>
                            <p class="text-gray-500">Silakan hubungi administrator untuk menambah template baru</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
