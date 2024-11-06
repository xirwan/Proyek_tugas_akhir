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
        Schema::create('baptist_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_member')->constrained('members')->onDelete('cascade');
            $table->foreignId('id_baptist_class_detail')->constrained('baptist_class_details')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptist_attendances');
    }
};
