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
        //
        Schema::dropIfExists('baptist_classes'); // Hapus tabel baptist_classes
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         // Jika ingin mengembalikan tabel, buat ulang di sini.
         Schema::create('baptist_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_baptist')->constrained('baptists')->onDelete('cascade');
            $table->string('day');
            $table->time('start');
            $table->time('end');
            $table->string('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }
};
