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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description');
            $table->string('country');
            $table->string('city');
            $table->bigInteger('price');
            $table->date('date_started')->nullable();
            $table->date('date_ended')->nullable();
            $table->string('type');
            $table->integer('view_count');
            $table->text('featured_photo');
            $table->integer('min_people')->nullable();
            $table->integer('max_people')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
