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
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('created_by')->constrained('members')->onDelete('cascade'); // FK ke members
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // FK ke users
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('proposal_file');
            $table->boolean('is_paid')->default(false); // Apakah aktivitas berbayar
            $table->decimal('price', 10, 2)->default(0); // Biaya jika berbayar
            $table->date('start_date'); // Tanggal mulai kegiatan
            $table->date('registration_open_date'); // Tanggal pendaftaran dibuka
            $table->date('registration_close_date'); // Tanggal pendaftaran ditutup
            $table->date('payment_deadline')->nullable(); // Batas pembayaran (opsional)
            $table->string('status'); // Status aktivitas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
