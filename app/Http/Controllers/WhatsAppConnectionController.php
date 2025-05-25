<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppConnectionController extends Controller
{
    public function index()
    {
        $config = WhatsAppConfig::where('is_active', 1)->first();
        return view('whatsapp.connect', compact('config'));
    }

    public function getQR()
    {
        try {
            $config = WhatsAppConfig::where('is_active', 1)->first();

            if (!$config || !$config->api_key || !$config->bot_number) {
                return response()->json([
                    'status' => false,
                    'reason' => 'Konfigurasi WhatsApp belum lengkap'
                ]);
            }

            $response = Http::withHeaders([
                'Authorization' => $config->api_key
            ])->post('https://api.fonnte.com/qr', [
                'type' => 'qr',
                'whatsapp' => $config->bot_number
            ]);

            // Cek jika response mengandung rate limit
            if ($response->status() === 429 || str_contains(strtolower($response->body()), 'rate limit')) {
                return response()->json([
                    'status' => false,
                    'reason' => 'Mohon tunggu beberapa saat sebelum mencoba kembali (Rate Limit)'
                ], 429);
            }

            return $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'reason' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function disconnect()
    {
        try {
            $config = WhatsAppConfig::where('is_active', 1)->first();

            if (!$config || !$config->api_key) {
                return response()->json([
                    'status' => false,
                    'detail' => 'Konfigurasi WhatsApp belum lengkap'
                ]);
            }

            $response = Http::withHeaders([
                'Authorization' => $config->api_key
            ])->post('https://api.fonnte.com/disconnect');

            // Cek jika response mengandung rate limit
            if ($response->status() === 429 || str_contains(strtolower($response->body()), 'rate limit')) {
                return response()->json([
                    'status' => false,
                    'detail' => 'Mohon tunggu beberapa saat sebelum mencoba kembali (Rate Limit)'
                ], 429);
            }

            return $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'detail' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
