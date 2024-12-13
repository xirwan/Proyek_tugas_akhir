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
        Schema::table('activities', function (Blueprint $table) {
            //
            $table->text('rejection_reason')->nullable()->after('approved_by'); // Kolom untuk alasan penolakan
            $table->string('poster_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //
            $table->dropColumn('rejection_reason');
            $table->dropColumn('poster_file');
        });
    }
};
