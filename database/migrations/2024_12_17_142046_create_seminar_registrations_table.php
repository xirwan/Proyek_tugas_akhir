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
        Schema::create('seminar_registrations', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK ke tabel users
            $table->foreignId('seminar_id')->constrained('seminars')->onDelete('cascade'); // FK ke tabel seminars
            $table->boolean('is_attended')->default(false); // Status kehadiran
            $table->string('certificate_url')->nullable(); // Path sertifikat (jika tersedia)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_registrations');
    }
};
