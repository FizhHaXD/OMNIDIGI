<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'tariff_id',
        'id_pelanggan',
        'nama',
        'alamat',
        'nomor_telepon',
        'email',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReading::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Tagihan yang belum lunas
     */
    public function unpaidBills(): HasMany
    {
        return $this->hasMany(Bill::class)->where('status', 'unpaid');
    }

    /**
     * Total tagihan yang belum lunas
     */
    public function getTotalTagihanAttribute(): float
    {
        return $this->unpaidBills()->sum('total_biaya');
    }
}
