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
    Schema::table('hotel_bookings', function (Blueprint $table) {
      $table->dropUnique('hotel_bookings_booking_code_unique');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('hotel_bookings', function (Blueprint $table) {
      $table->unique('booking_code');
    });
  }
};
