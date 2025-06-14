@extends('layouts.app')

@section('title', 'Konfigurasi WhatsApp Bot - BersihQ')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-white">Konfigurasi WhatsApp Bot</h1>
                <p class="text-white/60">Kelola pengaturan WhatsApp Bot untuk BersihQ</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <form action="{{ route('whatsapp.config.update') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- API Key -->
                        <div>
                            <label for="api_key" class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                            <div class="relative">
                                <input type="text" name="api_key" id="api_key"
                                    class="w-full pl-4 pr-10 py-2 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                    value="{{ old('api_key', $config->api_key) }}"
                                    placeholder="Contoh: dw4masMRssdfu8JWJG24j2">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Masukkan API Key dari <a target="_blank"
                                    href="https://fonnte.com/"
                                    class="text-emerald-500 hover:text-emerald-600 font-bold underline">Fonnte.com</a></p>
                            @error('api_key')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bot Number -->
                        <div>
                            <label for="bot_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Bot</label>
                            <div class="relative">
                                <input type="text" name="bot_number" id="bot_number"
                                    class="w-full pl-4 pr-10 py-2 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                    value="{{ old('bot_number', $config->bot_number) }}"
                                    placeholder="Contoh: 6289608780861">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Masukkan nomor WhatsApp yang terdaftar di <a target="_blank"
                                    href="https://fonnte.com/"
                                    class="text-emerald-500 hover:text-emerald-600 font-bold underline">Fonnte.com</a></p>
                            @error('bot_number')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Status Bot</p>
                                    <p class="text-xs text-gray-500">Aktifkan atau nonaktifkan WhatsApp Bot</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" class="sr-only peer"
                                    {{ $config->is_active ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                                </div>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Konfigurasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
