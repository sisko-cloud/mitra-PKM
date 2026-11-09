<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'alamat',
        'telepon',
        'whatsapp',
        'email',
        'instagram',
        'facebook',
        'tiktok',
        'jam_operasional',
        'maps_embed',
    ];

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }
}
