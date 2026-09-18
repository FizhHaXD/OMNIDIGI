<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();   // qris, ewallet, transfer, cash
            $table->string('nama', 100);            // QRIS, E-Wallet, Transfer Bank, Tunai
            $table->string('icon')->nullable();     // path ikon / nama kelas ikon
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
