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
            $table->foreignId('insurance_id')->nullable()->constrained('insurances')->onDelete('set null');
            $table->decimal('insurance_amount', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_transactions', function (Blueprint $table) {
            $table->dropForeign(['insurance_id']);
            $table->dropColumn(['insurance_id', 'insurance_amount']);
        });
    }
};
