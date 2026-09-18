<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model
{
    protected $fillable = [
        'tariff_category_id',
        'kode',
        'nama',
        'daya_va',
        'harga_per_kwh',
        'biaya_beban',
        'biaya_pasang',
        'biaya_admin',
        'is_subsidi',
    ];

    protected $casts = [
        'daya_va'       => 'integer',
        'harga_per_kwh' => 'decimal:2',
        'biaya_beban'   => 'decimal:2',
        'biaya_pasang'  => 'decimal:2',
        'biaya_admin'   => 'decimal:2',
        'is_subsidi'    => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TariffCategory::class, 'tariff_category_id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Hitung estimasi tagihan bulanan berdasarkan total kWh
     */
    public function hitungTagihan(float $totalKwh): float
    {
        return ($totalKwh * $this->harga_per_kwh) + $this->biaya_beban;
    }
}
