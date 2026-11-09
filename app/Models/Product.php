<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'nama',
        'deskripsi',
        'harga',
        'foto',
        'urutan',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'urutan' => 'integer',
    ];

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }
}
