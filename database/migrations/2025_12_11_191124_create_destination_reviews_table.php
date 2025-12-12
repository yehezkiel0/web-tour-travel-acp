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
        Schema::create('destination_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_transaction_id')->nullable()->constrained('booking_transactions')->onDelete('set null');
            $table->integer('rating')->unsigned()->comment('1-5 stars');
            $table->string('title');
            $table->text('review');
            $table->json('photos')->nullable()->comment('Array of review photos');
            $table->boolean('is_verified')->default(false)->comment('Verified purchase');
            $table->boolean('is_approved')->default(true);
            $table->integer('helpful_count')->default(0);
            $table->timestamps();

            $table->index(['destination_id', 'is_approved']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_reviews');
    }
};
