<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutageReport extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'kategori',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'catatan_petugas',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeDilaporkan($query)
    {
        return $query->where('status', 'dilaporkan');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Label kategori yang ramah pengguna
     */
    public function getLabelKategoriAttribute(): string
    {
        return match ($this->kategori) {
            'padam_total'     => 'Padam Total',
            'tegangan_rendah' => 'Tegangan Rendah',
            'korsleting'      => 'Korsleting',
            'meteran_rusak'   => 'Meteran Rusak',
            default           => 'Lainnya',
        };
    }
}
