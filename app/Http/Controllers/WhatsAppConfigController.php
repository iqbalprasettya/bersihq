<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppConfig;
use Illuminate\Http\Request;

class WhatsAppConfigController extends Controller
{
    public function index()
    {
        $config = WhatsAppConfig::first() ?? new WhatsAppConfig();
        return view('whatsapp.config', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
            'bot_number' => 'required|string',
        ]);

        $config = WhatsAppConfig::first();
        if (!$config) {
            $config = new WhatsAppConfig();
        }

        $config->api_key = $request->api_key;
        $config->bot_number = $request->bot_number;
        $config->is_active = $request->has('is_active');
        $config->save();

        return redirect()->route('whatsapp.config')->with('success', 'Konfigurasi WhatsApp berhasil diperbarui');
    }
}
