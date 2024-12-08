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
        Schema::create('member_schedule_monthly', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('schedules_sunday_school_class_id')->constrained('schedules_sunday_school_class')->onDelete('cascade');
            $table->foreignId('monthly_schedule_id')->constrained('monthly_schedules')->onDelete('cascade');
            $table->date('schedule_date'); // Tanggal spesifik penjadwalan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_schedule_monthly');
    }
};
