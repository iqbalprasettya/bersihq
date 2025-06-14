<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppTemplateController extends Controller
{
    public function index()
    {
        try {
            $templates = WhatsAppTemplate::latest()->get();
            return view('whatsapp.template', compact('templates'));
        } catch (\Exception $e) {
            Log::error('Error fetching templates: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat daftar template');
        }
    }

    public function edit($id)
    {
        try {
            $template = WhatsAppTemplate::findOrFail($id);
            return view('whatsapp.template-edit', compact('template'));
        } catch (\Exception $e) {
            Log::error('Error fetching template: ' . $e->getMessage());
            return redirect()->route('whatsapp.template')->with('error', 'Template tidak ditemukan');
        }
    }

    public function show($id)
    {
        try {
            $template = WhatsAppTemplate::findOrFail($id);
            return response()->json([
                'success' => true,
                'template' => $template
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching template: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Template tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $template = WhatsAppTemplate::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'konten' => 'required|string',
                'is_active' => 'required|boolean'
            ]);

            // Pastikan variabel selalu array atau null
            $template->nama = $validated['nama'];
            $template->konten = $validated['konten'];
            $template->is_active = $validated['is_active'];
            // Variabel tidak diupdate, tetap menggunakan nilai yang ada di database

            $template->save();

            return redirect()
                ->route('whatsapp.template')
                ->with('success', 'Template berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating template: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui template: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function preview($id)
    {
        try {
            $template = WhatsAppTemplate::findOrFail($id);

            // Buat contoh data untuk preview
            $sampleData = [];
            if ($template->variabel) {
                foreach ($template->variabel as $var) {
                    $sampleData[$var] = "[contoh_{$var}]";
                }
            }

            $preview = $template->fillTemplate($sampleData);

            return response()->json([
                'success' => true,
                'preview' => $preview
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating preview: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat preview: ' . $e->getMessage()
            ], 500);
        }
    }
}
