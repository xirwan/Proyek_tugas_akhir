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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->date('tanggal_lahir');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->string('deskripsi');
            $table->foreignId('cabang_id') // Foreign key untuk tabel cabang
                ->constrained('cabang', 'id') // Hubungkan ke primary key tabel cabang (id)
                ->onDelete('cascade');
            $table->foreignId('roles_id') // Foreign key untuk tabel cabang
                ->constrained('roles', 'id') // Hubungkan ke primary key tabel roles (id)
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
