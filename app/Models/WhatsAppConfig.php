<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppConfig extends Model
{
    protected $table = 'whatsapp_configs';

    protected $fillable = [
        'api_key',
        'bot_number',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
