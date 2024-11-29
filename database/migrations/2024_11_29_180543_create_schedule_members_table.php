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
        Schema::create('schedule_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('schedule_id');
            $table->date('schedule_date'); // Tanggal penjadwalan untuk member
            $table->timestamps();

            // Menambahkan foreign key untuk hubungan ke tabel members
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            // Menambahkan foreign key untuk hubungan ke tabel jadwals
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_members');
    }
};
