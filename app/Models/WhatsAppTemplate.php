<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WhatsAppTemplate extends Model
{
    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'nama',
        'kode',
        'konten',
        'variabel',
        'is_active'
    ];

    protected $casts = [
        'variabel' => 'array',
        'is_active' => 'boolean'
    ];

    // Accessor untuk menormalisasi konten
    protected function konten(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // Normalisasi line breaks
                return preg_replace('/\R/u', "\n", $value);
            }
        );
    }

    // Mendapatkan template berdasarkan kode
    public static function getByKode($kode)
    {
        return static::where('kode', $kode)
            ->where('is_active', true)
            ->first();
    }

    // Mengisi template dengan variabel
    public function fillTemplate($variables = [])
    {
        $content = $this->konten;

        foreach ($variables as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }

        return $content;
    }
}
