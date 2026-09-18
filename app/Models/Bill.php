<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    protected $fillable = [
        'customer_id',
        'meter_reading_id',
        'bulan',
        'tahun',
        'total_kwh',
        'total_biaya',
        'denda',
        'status',
        'tanggal_jatuh_tempo',
        'tanggal_bayar',
    ];

    protected $casts = [
        'bulan'               => 'integer',
        'tahun'               => 'integer',
        'total_kwh'           => 'decimal:2',
        'total_biaya'         => 'decimal:2',
        'denda'               => 'decimal:2',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar'       => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function meterReading(): BelongsTo
    {
        return $this->belongsTo(MeterReading::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Total yang harus dibayar (tagihan + denda)
     */
    public function getTotalBayarAttribute(): float
    {
        return (float) $this->total_biaya + (float) $this->denda;
    }

    /**
     * Apakah tagihan sudah jatuh tempo?
     */
    public function getIsJatuhTempoAttribute(): bool
    {
        return $this->status === 'unpaid' && now()->gt($this->tanggal_jatuh_tempo);
    }

    /**
     * Label bulan dalam Bahasa Indonesia
     */
    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        return $bulan[$this->bulan] ?? '-';
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
