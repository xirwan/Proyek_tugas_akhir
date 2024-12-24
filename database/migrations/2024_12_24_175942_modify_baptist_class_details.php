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
        Schema::table('baptist_class_details', function (Blueprint $table) {
            $table->dropForeign(['id_baptist_class']); // Hapus FK ke baptist_classes
            $table->dropColumn('id_baptist_class'); // Hapus kolom id_baptist_class
            $table->foreignId('id_baptist')->constrained('baptists')->onDelete('cascade'); // Tambahkan FK ke baptists
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('baptist_class_details', function (Blueprint $table) {
            $table->dropForeign(['id_baptist']);
            $table->dropColumn('id_baptist');
            $table->foreignId('id_baptist_class')->constrained('baptist_classes')->onDelete('cascade');
        });
    }
};
