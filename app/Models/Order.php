<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
        'user_id',
        'berat',
        'total_harga',
        'status',
        'tanggal_pesan',
        'tanggal_selesai',
        'catatan',
    ];

    protected $casts = [
        'berat' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'tanggal_pesan' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
