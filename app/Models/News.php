<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'kategori',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Excerpt dari konten (150 karakter)
     */
    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->konten), 150);
    }

    /**
     * Label kategori
     */
    public function getLabelKategoriAttribute(): string
    {
        return match ($this->kategori) {
            'info'     => 'Informasi',
            'promo'    => 'Promo',
            'gangguan' => 'Gangguan',
            'tips'     => 'Tips & Trik',
            default    => 'Lainnya',
        };
    }
}
