<?php

namespace App\Services;

use App\Models\WhatsAppConfig;
use App\Models\WhatsAppTemplate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $config;

    public function __construct()
    {
        $this->config = WhatsAppConfig::where('is_active', 1)->first();
    }

    public function sendMessage($target, $message)
    {
        try {
            if (!$this->config || !$this->config->api_key) {
                throw new \Exception('Konfigurasi WhatsApp tidak ditemukan atau tidak aktif');
            }

            $response = Http::withHeaders([
                'Authorization' => $this->config->api_key
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Kode negara Indonesia
                'delay' => '2',
            ]);

            $result = $response->json();

            if (!$response->successful() || ($result['status'] ?? false) === false) {
                throw new \Exception($result['reason'] ?? 'Gagal mengirim pesan WhatsApp');
            }

            return [
                'success' => true,
                'data' => $result
            ];
        } catch (\Exception $e) {
            Log::error('WhatsApp Send Message Error: ' . $e->getMessage(), [
                'target' => $target,
                'message' => $message
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function sendMessageWithTemplate($target, $templateCode, $variables = [])
    {
        try {
            $template = WhatsAppTemplate::getByKode($templateCode);

            if (!$template) {
                throw new \Exception("Template dengan kode '{$templateCode}' tidak ditemukan");
            }

            // Cek apakah template aktif
            if (!$template->is_active) {
                Log::info("Template '{$templateCode}' tidak aktif, pesan tidak akan dikirim", [
                    'template_code' => $templateCode,
                    'target' => $target
                ]);
                return [
                    'success' => false,
                    'message' => "Template '{$templateCode}' tidak aktif"
                ];
            }

            $message = $template->fillTemplate($variables);
            return $this->sendMessage($target, $message);
        } catch (\Exception $e) {
            Log::error('WhatsApp Template Error: ' . $e->getMessage(), [
                'template_code' => $templateCode,
                'variables' => $variables
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function sendReadyForPickupNotification($order)
    {
        try {
            $variables = [
                'nama' => $order->customer->nama,
                'nomor_order' => str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'layanan' => $order->service->nama_layanan,
                'berat' => $order->berat,
                'total' => number_format($order->total_harga, 0, ',', '.')
            ];

            return $this->sendMessageWithTemplate($order->customer->no_wa, 'ready_pickup', $variables);
        } catch (\Exception $e) {
            Log::error('WhatsApp Ready Pickup Notification Error: ' . $e->getMessage(), [
                'order_id' => $order->id
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
