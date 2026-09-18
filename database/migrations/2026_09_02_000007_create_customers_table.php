<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tariff_id')->constrained('tariffs')->restrictOnDelete();
            $table->string('id_pelanggan', 20)->unique();   // nomor ID pelanggan PLN
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
