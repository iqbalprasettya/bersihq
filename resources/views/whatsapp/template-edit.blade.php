@extends('layouts.app')

@section('title', 'Edit Template WhatsApp - BersihQ')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Edit Template WhatsApp</h1>
                    <p class="text-white/60">Ubah pengaturan template pesan WhatsApp</p>
                </div>
                <a href="{{ route('whatsapp.template') }}"
                    class="inline-flex items-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/20 focus:ring-offset-2 focus:ring-offset-emerald-800 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Form Edit -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <form action="{{ route('whatsapp.template.update', $template->id) }}" method="POST"
                    x-data="templateForm()">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Info Template -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <span class="font-medium">Kode Template:</span>
                                <code class="px-2 py-1 bg-gray-100 rounded">{{ $template->kode }}</code>
                            </div>
                        </div>

                        <!-- Nama Template -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Template
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" x-model="form.nama"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="Contoh: Notifikasi Pesanan Siap">
                            <p class="mt-1 text-xs text-gray-500">Berikan nama yang deskriptif untuk template ini</p>
                            @error('nama')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konten Template -->
                        <div>
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <label for="konten" class="block text-base font-medium text-gray-900 mb-1">
                                        Konten Template
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-sm text-gray-600">Tulis pesan template WhatsApp Anda di sini</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <!-- Format Guide -->
                                    <div class="bg-white rounded-lg p-4 border-2 border-emerald-200">
                                        <p class="font-medium text-gray-900 mb-3 flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 mr-2"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            Format WhatsApp yang Tersedia:
                                        </p>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex items-center bg-gray-50 p-2 rounded">
                                                <code class="text-emerald-600">*teks*</code>
                                                <span class="mx-2">→</span>
                                                <strong class="text-gray-900">teks tebal</strong>
                                            </div>
                                            <div class="flex items-center bg-gray-50 p-2 rounded">
                                                <code class="text-emerald-600">_teks_</code>
                                                <span class="mx-2">→</span>
                                                <em class="text-gray-900">teks miring</em>
                                            </div>
                                            <div class="flex items-center bg-gray-50 p-2 rounded">
                                                <code class="text-emerald-600">~teks~</code>
                                                <span class="mx-2">→</span>
                                                <strike class="text-gray-900">teks dicoret</strike>
                                            </div>
                                            <div class="flex items-center bg-gray-50 p-2 rounded">
                                                <code class="text-emerald-600">```teks```</code>
                                                <span class="mx-2">→</span>
                                                <code class="text-gray-900 bg-gray-100 px-1">teks monospace</code>
                                            </div>
                                            <div class="flex items-center bg-gray-50 p-2 rounded">
                                                <code class="text-emerald-600">{nama}</code>
                                                <span class="mx-2">→</span>
                                                <span class="text-gray-900">variabel yang akan diganti</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Textarea -->
                                    <div class="relative">
                                        <div
                                            class="absolute right-3 top-3 flex items-center space-x-1 px-2 py-1 bg-gray-100 rounded text-xs text-gray-500 z-10">
                                            <span x-text="form.konten.length"></span>
                                            <span>/</span>
                                            <span>4096</span>
                                        </div>
                                        <textarea name="konten" id="konten" x-model="form.konten" rows="14" maxlength="4096"
                                            class="w-full rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring focus:ring-emerald-100 focus:ring-opacity-50 font-mono text-sm resize-none p-4 leading-relaxed transition-all duration-150 ease-in-out placeholder-gray-400"
                                            style="min-height: 360px;"
                                            placeholder="Contoh format pesan:

*BersihQ Laundry*

Halo {nama}!
Pesanan laundry Anda dengan nomor *#{nomor_order}* telah siap untuk diambil.

_Detail Pesanan:_
• Layanan: {layanan}
• Berat: {berat} kg
• Total: Rp {total}

Silakan datang ke outlet kami untuk mengambil cucian Anda.
Terima kasih telah menggunakan jasa *BersihQ Laundry* 🙏"
                                            x-on:keydown.tab.prevent="
                                                const start = $el.selectionStart;
                                                const end = $el.selectionEnd;
                                                $el.value = $el.value.substring(0, start) + '    ' + $el.value.substring(end);
                                                $el.selectionStart = $el.selectionEnd = start + 4;
                                            "></textarea>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div
                                        class="flex items-center justify-between bg-gray-50 rounded-lg p-3 border border-gray-200">
                                        <div class="flex items-center space-x-1 text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Gunakan variabel yang tersedia di bawah</span>
                                        </div>
                                        <button type="button" @click="resetKonten"
                                            class="inline-flex items-center px-3 py-1.5 text-sm text-gray-700 hover:text-gray-900 bg-white hover:bg-gray-50 rounded-lg border border-gray-300 transition-colors duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Reset ke Default
                                        </button>
                                    </div>
                                </div>

                                <!-- Preview Section -->
                                <div>
                                    <div class="bg-white rounded-lg p-4 border-2 border-emerald-200 sticky top-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <h4 class="text-base font-medium text-gray-900">Preview Pesan</h4>
                                            </div>
                                            <span
                                                class="text-xs px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full">Format
                                                WhatsApp</span>
                                        </div>
                                        <div
                                            class="bg-gray-50 rounded-lg p-4 border border-gray-200 max-h-[500px] overflow-y-auto">
                                            <div x-html="getPreview()"
                                                class="text-sm text-gray-600 whitespace-pre-wrap leading-relaxed"
                                                style="letter-spacing: -0.1px;"></div>
                                        </div>
                                        <p class="mt-3 text-xs text-gray-500 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Preview akan diperbarui secara otomatis saat Anda mengetik
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Variabel Template -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Variabel Template
                            </label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex flex-wrap gap-2">
                                    @if (is_array($template->variabel) && count($template->variabel) > 0)
                                        @foreach ($template->variabel as $var)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-emerald-100 text-emerald-800">
                                                <code>{</code>{{ $var }}<code>}</code>
                                            </span>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500">Tidak ada variabel yang tersedia untuk template
                                            ini</p>
                                    @endif
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Variabel yang tersedia untuk template ini</p>
                            </div>
                        </div>

                        <!-- Status Template -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center space-x-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    x-model="form.is_active"
                                    class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <label for="is_active" class="block text-sm font-medium text-gray-900">Template
                                        Aktif</label>
                                    <p class="text-xs text-gray-500">Template yang tidak aktif tidak akan digunakan dalam
                                        sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('whatsapp.template') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function templateForm() {
                // Normalisasi line break dan hapus karakter whitespace yang tidak perlu
                const defaultKonten = @json($template->konten)
                    .replace(/\\n/g, '\n') // Ubah \\n menjadi \n
                    .replace(/\n\s*\n/g, '\n\n') // Normalisasi multiple line breaks dengan whitespace
                    .trim(); // Hapus whitespace di awal dan akhir

                return {
                    form: {
                        nama: @json($template->nama),
                        konten: defaultKonten,
                        is_active: @json($template->is_active)
                    },

                    resetKonten() {
                        if (confirm('Apakah Anda yakin ingin mereset konten ke default?')) {
                            this.form.konten = defaultKonten;
                        }
                    },

                    getPreview() {
                        // Normalisasi input terlebih dahulu
                        let preview = this.form.konten
                            .replace(/\n\s*\n/g, '\n\n') // Normalisasi multiple line breaks dengan whitespace
                            .trim();

                        // Contoh data untuk preview
                        const sampleData = {
                            nama: 'John Doe',
                            nomor_order: '00010',
                            layanan: 'Cuci Setrika Express',
                            berat: '2.5',
                            total: '50.000'
                        };

                        // Ganti variabel dengan contoh data
                        @if (is_array($template->variabel) && count($template->variabel) > 0)
                            @foreach ($template->variabel as $var)
                                const regex{{ $loop->index }} = new RegExp(`{!! '{' . $var . '}' !!}`, 'g');
                                preview = preview.replace(regex{{ $loop->index }}, sampleData['{{ $var }}'] ||
                                    '[{{ $var }}]');
                            @endforeach
                        @endif

                        // Format teks WhatsApp
                        preview = preview
                            .replace(/\*([^*]+)\*/g, '<strong class="text-gray-900">$1</strong>') // Bold
                            .replace(/_([^_]+)_/g, '<em class="text-gray-800">$1</em>') // Italic
                            .replace(/~([^~]+)~/g, '<strike class="text-gray-700">$1</strike>') // Strikethrough
                            .replace(/```([^`]+)```/g,
                                '<code class="text-gray-900 bg-gray-100 px-1 rounded">$1</code>') // Monospace
                            .replace(/\n/g, '<br>'); // Single line break

                        return preview;
                    }
                }
            }
        </script>
    @endpush
@endsection
