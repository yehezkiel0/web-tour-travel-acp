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
        Schema::create('service_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('photo')->nullable();
            $table->string('title');
            $table->text('message');
            $table->enum('service_type', ['medical', 'recruitment', 'entertainment']);
            $table->integer('rating')->default(5);
            $table->boolean('is_approved')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_testimonials');
    }
};
