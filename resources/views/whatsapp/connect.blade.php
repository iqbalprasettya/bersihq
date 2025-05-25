@extends('layouts.app')

@section('title', 'Koneksi WhatsApp Bot - BersihQ')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-white">Koneksi WhatsApp Bot</h1>
                <p class="text-white/60">Hubungkan WhatsApp Bot dengan scan QR Code</p>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-2xl shadow-sm">
                <!-- Status Bar -->
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <span x-data="whatsappConnect()" x-show="connected"
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            <svg class="w-2 h-2 mr-1.5 text-emerald-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Terhubung
                        </span>
                        <span x-data="whatsappConnect()" x-show="!connected"
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <svg class="w-2 h-2 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Tidak Terhubung
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if (!$config || !$config->api_key || !$config->bot_number)
                        <div class="text-center py-8">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfigurasi Belum Lengkap</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Untuk menggunakan WhatsApp Bot, Anda perlu
                                melengkapi konfigurasi API Key dan nomor WhatsApp terlebih dahulu.</p>
                            <a href="{{ route('whatsapp.config') }}"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lengkapi Konfigurasi
                            </a>
                        </div>
                    @else
                        <div class="text-center" x-data="whatsappConnect()">
                            <div class="mb-6">
                                <template x-if="error">
                                    <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800" x-text="error"></h3>
                                                <div class="mt-2 text-sm text-red-700"
                                                    x-show="error.includes('Rate Limit')">
                                                    <p>Sistem mendeteksi terlalu banyak permintaan dalam waktu singkat.
                                                        Silakan tunggu beberapa saat sebelum mencoba kembali.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="connected">
                                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-8">
                                        <div
                                            class="mx-auto w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">WhatsApp Terhubung!</h3>
                                        <p class="text-gray-600 mb-6">Bot WhatsApp sudah aktif dan siap digunakan untuk
                                            mengirim notifikasi ke pelanggan</p>
                                        <button @click="disconnect" type="button"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-150"
                                            :disabled="disconnecting">
                                            <template x-if="disconnecting">
                                                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </template>
                                            <template x-if="!disconnecting">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                            </template>
                                            <span x-text="disconnecting ? 'Memutuskan...' : 'Putuskan Koneksi'"></span>
                                        </button>
                                    </div>
                                </template>

                                <template x-if="!connected && qrCode">
                                    <div>
                                        <div class="max-w-md mx-auto">
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-blue-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-blue-800">Cara Menghubungkan
                                                            WhatsApp</h3>
                                                        <div class="mt-2 text-sm text-blue-700">
                                                            <ol class="list-decimal list-inside space-y-1">
                                                                <li>Buka WhatsApp di ponsel Anda</li>
                                                                <li>Tap Menu (3 titik) > WhatsApp Web</li>
                                                                <li>Scan QR Code di bawah ini</li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-center mb-4">
                                            <div class="p-4 bg-white border rounded-lg shadow-sm">
                                                <img :src="'data:image/png;base64,' + qrCode" class="w-64 h-64">
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-500">QR Code akan diperbarui setiap <span
                                                class="font-medium">30 detik</span></p>
                                    </div>
                                </template>

                                <template x-if="!connected && !qrCode && !error">
                                    <div class="animate-pulse flex justify-center py-8">
                                        <div class="w-64 h-64 bg-gray-200 rounded-lg"></div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-center space-x-4">
                                <button @click="getQRCode" type="button"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors duration-150"
                                    :disabled="loading || error?.includes('Rate Limit')">
                                    <template x-if="loading">
                                        <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </template>
                                    <template x-if="!loading">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </template>
                                    <span x-text="loading ? 'Memuat...' : 'Refresh QR Code'"></span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function whatsappConnect() {
                return {
                    qrCode: null,
                    error: null,
                    loading: false,
                    connected: false,
                    disconnecting: false,
                    timer: null,
                    retryCount: 0,
                    maxRetries: 3,

                    init() {
                        this.getQRCode();
                        this.startAutoRefresh();
                    },

                    startAutoRefresh() {
                        // Clear existing timer if any
                        if (this.timer) {
                            clearInterval(this.timer);
                        }

                        this.timer = setInterval(() => {
                            // Reset retry count on new interval
                            this.retryCount = 0;
                            this.getQRCode();
                        }, 30000); // Refresh setiap 30 detik
                    },

                    async disconnect() {
                        try {
                            this.disconnecting = true;
                            this.error = null;

                            const response = await fetch('{{ route('whatsapp.connect.disconnect') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });

                            const data = await response.json();

                            if (response.status === 429) {
                                this.error = 'Mohon tunggu beberapa saat sebelum mencoba kembali (Rate Limit)';
                                return;
                            }

                            if (data.status === true) {
                                this.connected = false;
                                this.startAutoRefresh();
                            } else {
                                this.error = data.detail;
                            }
                        } catch (error) {
                            this.error = 'Terjadi kesalahan saat memutuskan koneksi';
                            console.error('Error:', error);
                        } finally {
                            this.disconnecting = false;
                        }
                    },

                    async getQRCode() {
                        try {
                            // Check if we've exceeded retry attempts
                            if (this.retryCount >= this.maxRetries) {
                                this.error = 'Terlalu banyak percobaan gagal. Silakan coba lagi nanti.';
                                clearInterval(this.timer);
                                return;
                            }

                            this.loading = true;
                            this.error = null;

                            const response = await fetch('{{ route('whatsapp.connect.qr') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });

                            const data = await response.json();

                            if (response.status === 429) {
                                this.error = 'Mohon tunggu beberapa saat sebelum mencoba kembali (Rate Limit)';
                                this.retryCount++;
                                return;
                            }

                            if (data.status === false) {
                                if (data.reason === 'device already connect') {
                                    this.connected = true;
                                    clearInterval(this.timer);
                                } else {
                                    this.error = data.reason;
                                    this.retryCount++;
                                }
                                this.qrCode = null;
                            } else {
                                this.connected = false;
                                this.qrCode = data.url;
                                this.retryCount = 0; // Reset retry count on success
                            }
                        } catch (error) {
                            this.error = 'Terjadi kesalahan saat memuat QR Code';
                            this.retryCount++;
                            console.error('Error:', error);
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
