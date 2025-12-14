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
        Schema::create('seasonal_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'High Season', 'Ramadan'
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('adjustment_type', ['markup', 'discount'])->default('markup');
            $table->decimal('percentage', 5, 2); // e.g., 10.00 for 10%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasonal_pricings');
    }
};
