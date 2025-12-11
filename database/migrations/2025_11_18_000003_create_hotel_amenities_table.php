<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('hotel_amenities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
      $table->string('name');
      $table->string('icon_class');
      $table->string('category');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('hotel_amenities');
  }
};
