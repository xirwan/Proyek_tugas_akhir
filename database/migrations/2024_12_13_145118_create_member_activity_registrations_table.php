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
        Schema::create('member_activity_registrations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // FK ke activities
            $table->foreignId('child_id')->constrained('members')->onDelete('cascade'); // FK ke members (anak)
            $table->foreignId('registered_by')->constrained('members')->onDelete('cascade'); // FK ke members (orang tua)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_activity_registrations');
    }
};
