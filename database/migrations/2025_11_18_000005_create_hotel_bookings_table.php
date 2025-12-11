<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('hotel_bookings', function (Blueprint $table) {
      $table->id();
      $table->string('booking_code')->unique();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
      $table->foreignId('hotel_room_id')->constrained()->onDelete('cascade');
      $table->date('check_in_date');
      $table->date('check_out_date');
      $table->integer('number_of_nights');
      $table->integer('number_of_rooms');
      $table->integer('number_of_guests');
      $table->bigInteger('total_price');
      $table->string('guest_name');
      $table->string('guest_email');
      $table->string('guest_phone');
      $table->text('special_request')->nullable();
      $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('hotel_bookings');
  }
};
