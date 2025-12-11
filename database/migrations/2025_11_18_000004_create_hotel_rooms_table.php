<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('hotel_rooms', function (Blueprint $table) {
      $table->id();
      $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
      $table->string('room_type');
      $table->string('bed_type');
      $table->integer('max_guests');
      $table->integer('room_size');
      $table->bigInteger('price_without_breakfast');
      $table->bigInteger('price_with_breakfast');
      $table->integer('available_rooms')->default(10);
      $table->text('description')->nullable();
      $table->string('photo')->nullable();
      $table->boolean('is_available')->default(true);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('hotel_rooms');
  }
};
