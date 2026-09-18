<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('bulan');   // 1–12
            $table->unsignedSmallInteger('tahun');
            $table->unsignedInteger('meteran_awal');
            $table->unsignedInteger('meteran_akhir');
            $table->unsignedInteger('total_kwh')->storedAs('meteran_akhir - meteran_awal');
            $table->enum('status', ['pending', 'verified', 'billed'])->default('pending');
            $table->timestamps();

            // Satu baca meteran per pelanggan per bulan
            $table->unique(['customer_id', 'bulan', 'tahun']);
            $table->index(['customer_id', 'tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};
