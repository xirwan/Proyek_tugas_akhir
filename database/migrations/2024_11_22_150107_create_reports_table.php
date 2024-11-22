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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('week_of'); // Reference to the week in the attendance table
            $table->foreignId('sunday_school_class_id')->constrained('sunday_school_classes')->onDelete('cascade');
            $table->string('title'); // Title of the report
            $table->text('description')->nullable(); // Optional description
            $table->string('file_path')->nullable(); // Optional file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
