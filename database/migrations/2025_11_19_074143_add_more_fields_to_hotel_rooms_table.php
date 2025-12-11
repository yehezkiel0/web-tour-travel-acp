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
        Schema::table('hotel_rooms', function (Blueprint $table) {
            $table->string('room_name')->after('hotel_id');
            $table->text('room_description')->nullable()->after('description');
            $table->integer('bed_count')->default(1)->after('bed_type');
            $table->string('room_photo')->nullable()->after('photo');
            $table->boolean('has_breakfast')->default(false)->after('is_available');
            $table->boolean('free_cancellation')->default(true)->after('has_breakfast');
            $table->boolean('pay_at_hotel')->default(false)->after('free_cancellation');
            $table->boolean('smoking_allowed')->default(false)->after('pay_at_hotel');
            $table->boolean('has_wifi')->default(true)->after('smoking_allowed');
            $table->boolean('has_air_conditioning')->default(true)->after('has_wifi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_rooms', function (Blueprint $table) {
            $table->dropColumn([
                'room_name',
                'room_description',
                'bed_count',
                'room_photo',
                'has_breakfast',
                'free_cancellation',
                'pay_at_hotel',
                'smoking_allowed',
                'has_wifi',
                'has_air_conditioning'
            ]);
        });
    }
};
