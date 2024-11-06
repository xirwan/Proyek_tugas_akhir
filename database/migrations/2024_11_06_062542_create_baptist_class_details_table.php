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
        Schema::create('baptist_class_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_baptist_class')->constrained('baptist_classes')->onDelete('cascade');
            $table->date('date');
            $table->string('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->boolean('is_rescheduled')->default(false);
            $table->date('reschedule_date')->nullable();
            $table->foreignId('original_class_detail_id')->nullable()->constrained('baptist_class_details')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptist_class_details');
    }
};
