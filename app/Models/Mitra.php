<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_usaha',
        'jenis',
        'alamat',
        'kontak',
        'logo',
        'dokumen_pendukung',
        'slug',
        'is_active',
        'is_published',
        'is_visible_on_home',
        'urutan_tampil',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'is_visible_on_home' => 'boolean',
        'urutan_tampil' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function websiteContent(): HasOne
    {
        return $this->hasOne(WebsiteContent::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('urutan', 'asc');
    }

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class);
    }

    public function isPubliclyAccessible(): bool
    {
        return $this->is_active
            && $this->is_published
            && $this->user
            && $this->user->isApproved();
    }
}
