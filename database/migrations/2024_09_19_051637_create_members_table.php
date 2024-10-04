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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->date('dateofbirth');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('address');
            $table->foreignId('branch_id') // Foreign key untuk tabel cabang
                ->constrained('branches', 'id') // Hubungkan ke primary key tabel cabang (id)
                ->onDelete('cascade');
            $table->foreignId('role_id') // Foreign key untuk tabel roles
                ->constrained('roles', 'id') // Hubungkan ke primary key tabel roles (id)
                ->onDelete('cascade');
            $table->foreignId('position_id') // Foreign key untuk tabel positions
                ->constrained('positions', 'id') // Hubungkan ke primary key tabel positions (id)
                ->onDelete('cascade');
            $table->foreignId('user_id') // Foreign key untuk tabel users
                ->nullable()
                ->constrained('users', 'id') // Hubungkan ke primary key tabel users (id)
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
