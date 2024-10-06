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
        Schema::create('member_relation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('related_member_id');
            $table->unsignedBigInteger('relation_id');
             // Foreign key ke tabel members
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('related_member_id')->references('id')->on('members')->onDelete('cascade');
    
            // Foreign key ke tabel relations
            $table->foreign('relation_id')->references('id')->on('relations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_relation');
    }
};
