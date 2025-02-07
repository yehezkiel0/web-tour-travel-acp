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
        Schema::create('booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('adult_count');
            $table->integer('child_count');
            $table->decimal('total_price', 10, 2);
            $table->json('traveller_details');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->text('notes');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_transactions');
    }
};
