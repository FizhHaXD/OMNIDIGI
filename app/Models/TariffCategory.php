<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TariffCategory extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
    ];

    public function tariffs(): HasMany
    {
        return $this->hasMany(Tariff::class);
    }
}
