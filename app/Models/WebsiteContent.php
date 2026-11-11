<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'judul',
        'tagline',
        'hero_image',
        'deskripsi',
        'sejarah',
        'visi_misi',
        'struktur_organisasi',
        'is_draft',
        'draft_data',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
        'draft_data' => 'array',
    ];

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }
}
