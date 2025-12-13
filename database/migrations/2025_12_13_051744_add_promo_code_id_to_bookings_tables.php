<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking_transactions', function (Blueprint $table) {
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->nullOnDelete();
        });

        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_transactions', function (Blueprint $table) {
            $table->dropForeign(['promo_code_id']);
            $table->dropColumn('promo_code_id');
        });

        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->dropForeign(['promo_code_id']);
            $table->dropColumn('promo_code_id');
        });
    }
};
