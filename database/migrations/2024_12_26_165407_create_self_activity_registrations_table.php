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
        Schema::create('self_activity_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // FK ke activities
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade'); // FK ke members (anak)
            $table->foreignId('payment_id')->nullable()->constrained('activity_payments')->onDelete('cascade'); // FK ke activity payments
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_activity_registrations');
    }
};
