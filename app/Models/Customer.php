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
     * Tagihan yang belum lunas (unpaid + overdue)
     */
    public function unpaidBills(): HasMany
    {
        return $this->hasMany(Bill::class)->whereIn('status', ['unpaid', 'overdue']);
    }

    /**
     * Total tagihan yang belum lunas (tagihan + denda)
     */
    public function getTotalTagihanAttribute(): float
    {
        $bills = $this->unpaidBills()->get();
        return (float) $bills->sum('total_biaya') + (float) $bills->sum('denda');
    }
}
