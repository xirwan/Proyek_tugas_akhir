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
        Schema::table('activity_payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('total_amount'); // 'manual' atau 'midtrans'        
            $table->string('midtrans_order_id')->nullable()->after('verified_by'); // Untuk Midtrans
            $table->string('midtrans_transaction_status')->nullable()->after('midtrans_order_id'); // Status transaksi
            $table->string('payment_token')->nullable()->after('midtrans_transaction_status'); // Token dari Midtrans
            $table->string('payment_url')->nullable()->after('payment_token'); // URL pembayaran dari Midtrans
            $table->json('child_ids')->nullable()->after('payment_url'); // Array ID anak
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('activity_payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_proof', 'midtrans_order_id', 'midtrans_transaction_status', 'payment_token', 'payment_url', 'child_ids']);
        });
    }
};
