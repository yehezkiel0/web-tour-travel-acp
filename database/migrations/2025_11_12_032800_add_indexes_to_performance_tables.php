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
    Schema::table('destinations', function (Blueprint $table) {
      $table->index(['title'], 'idx_destinations_title');
      $table->index(['slug'], 'idx_destinations_slug');
      $table->index(['is_active'], 'idx_destinations_is_active');
      $table->index(['is_featured'], 'idx_destinations_is_featured');
      $table->index(['price'], 'idx_destinations_price');
      $table->index(['created_at'], 'idx_destinations_created_at');
    });

    Schema::table('booking_transactions', function (Blueprint $table) {
      $table->index(['status'], 'idx_booking_transactions_status');
      $table->index(['user_id'], 'idx_booking_transactions_user_id');
      $table->index(['destination_id'], 'idx_booking_transactions_destination_id');
      $table->index(['code'], 'idx_booking_transactions_code');
      $table->index(['email'], 'idx_booking_transactions_email');
      $table->index(['created_at'], 'idx_booking_transactions_created_at');
      $table->index(['status', 'created_at'], 'idx_booking_transactions_status_created');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->index(['email'], 'idx_users_email');
      $table->index(['role'], 'idx_users_role');
      $table->index(['is_active'], 'idx_users_is_active');
      $table->index(['last_login_at'], 'idx_users_last_login');
    });

    Schema::table('destination_photos', function (Blueprint $table) {
      $table->index(['destination_id'], 'idx_destination_photos_destination_id');
    });

    Schema::table('destination_details', function (Blueprint $table) {
      $table->index(['destination_id'], 'idx_destination_details_destination_id');
      $table->index(['category'], 'idx_destination_details_category');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('destinations', function (Blueprint $table) {
      $table->dropIndex('idx_destinations_title');
      $table->dropIndex('idx_destinations_slug');
      $table->dropIndex('idx_destinations_is_active');
      $table->dropIndex('idx_destinations_is_featured');
      $table->dropIndex('idx_destinations_price');
      $table->dropIndex('idx_destinations_created_at');
    });

    Schema::table('booking_transactions', function (Blueprint $table) {
      $table->dropIndex('idx_booking_transactions_status');
      $table->dropIndex('idx_booking_transactions_user_id');
      $table->dropIndex('idx_booking_transactions_destination_id');
      $table->dropIndex('idx_booking_transactions_code');
      $table->dropIndex('idx_booking_transactions_email');
      $table->dropIndex('idx_booking_transactions_created_at');
      $table->dropIndex('idx_booking_transactions_status_created');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->dropIndex('idx_users_email');
      $table->dropIndex('idx_users_role');
      $table->dropIndex('idx_users_is_active');
      $table->dropIndex('idx_users_last_login');
    });

    Schema::table('destination_photos', function (Blueprint $table) {
      $table->dropIndex('idx_destination_photos_destination_id');
    });

    Schema::table('destination_details', function (Blueprint $table) {
      $table->dropIndex('idx_destination_details_destination_id');
      $table->dropIndex('idx_destination_details_category');
    });
  }
};
