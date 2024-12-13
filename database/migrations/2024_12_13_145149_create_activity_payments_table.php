<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('parent_id')->constrained('members')->onDelete('cascade'); // FK ke members (orang tua)
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // FK ke activities
            $table->integer('total_children')->default(1); // Jumlah anak yang dicakup
            $table->decimal('total_amount', 10, 2); // Jumlah biaya total
            $table->string('payment_proof')->nullable(); // File bukti pembayaran
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null'); // FK ke members (admin yang verifikasi)
            $table->enum('payment_status', ['Belum Diunggah', 'Diproses', 'Berhasil', 'Ditolak'])->default('Belum Diunggah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_payments');
    }
};
