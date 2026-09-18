<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tariff_category_id')->constrained('tariff_categories')->restrictOnDelete();
            $table->string('kode', 20)->unique();           // R1-450, B1-2200, dll
            $table->string('nama', 100);                    // Rumah Tangga 450VA
            $table->integer('daya_va');                     // 450, 900, 1300, 2200, dst
            $table->decimal('harga_per_kwh', 10, 2);       // Rp/kWh
            $table->decimal('biaya_beban', 12, 2)->default(0);    // biaya tetap per bulan
            $table->decimal('biaya_pasang', 12, 2)->default(0);   // biaya pemasangan baru
            $table->decimal('biaya_admin', 12, 2)->default(0);    // biaya administrasi
            $table->boolean('is_subsidi')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
