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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->index(); // Relasi ke tabel members
            $table->string('seminar_file')->nullable(); // Lokasi file sertifikat seminar
            $table->string('baptism_file')->nullable(); // Lokasi file sertifikat pembaptisan
            $table->boolean('seminar_certified')->default(false); // Status seminar
            $table->boolean('baptism_certified')->default(false); // Status pembaptisan
            $table->boolean('admin_override')->default(false); // Apakah sertifikasi diatur manual
            $table->text('rejection_reason')->nullable(); // Alasan penolakan
            $table->unsignedBigInteger('created_by')->nullable(); // Admin yang menetapkan
            $table->text('admin_note')->nullable(); // Catatan tambahan
            // Relasi
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
