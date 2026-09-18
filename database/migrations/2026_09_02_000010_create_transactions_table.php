<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bill_id')->nullable()->constrained('bills')->nullOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->restrictOnDelete();
            $table->enum('type', ['tagihan', 'token', 'pasang_baru']);
            $table->decimal('amount', 15, 2);
            $table->string('nominal')->nullable();         // nominal token: 20000, 50000, dll
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('no_meter', 30)->nullable();
            $table->string('ref_number', 50)->unique();   // nomor referensi unik
            $table->string('token_listrik', 30)->nullable(); // token 20 digit
            $table->text('keterangan')->nullable();          // catatan tambahan
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
