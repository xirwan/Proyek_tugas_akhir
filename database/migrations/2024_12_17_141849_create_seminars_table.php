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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama seminar
            $table->text('description')->nullable(); // Deskripsi seminar
            $table->enum('status', ['open', 'closed', 'completed'])->default('open'); // Status seminar
            $table->integer('max_participants'); // Maksimal peserta
            $table->string('poster')->nullable(); // URL/filepath poster
            $table->date('event_date'); // Tanggal seminar
            $table->date('registration_start'); // Tanggal pendaftaran dibuka
            $table->date('registration_end'); // Tanggal pendaftaran ditutup
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
