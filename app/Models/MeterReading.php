<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MeterReading extends Model
{
    protected $fillable = [
        'customer_id',
        'bulan',
        'tahun',
        'meteran_awal',
        'meteran_akhir',
        'status',
    ];

    protected $casts = [
        'bulan'         => 'integer',
        'tahun'         => 'integer',
        'meteran_awal'  => 'integer',
        'meteran_akhir' => 'integer',
        'total_kwh'     => 'integer',  // stored computed column
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function bill(): HasOne
    {
        return $this->hasOne(Bill::class);
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
}
