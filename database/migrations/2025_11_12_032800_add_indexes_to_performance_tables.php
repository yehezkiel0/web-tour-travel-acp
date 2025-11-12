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
    // Destinations indexes - only add for existing columns
    $this->addIndexIfNotExists('destinations', 'title', 'idx_destinations_title');
    $this->addIndexIfNotExists('destinations', 'slug', 'idx_destinations_slug');
    $this->addIndexIfNotExists('destinations', 'price', 'idx_destinations_price');
    $this->addIndexIfNotExists('destinations', 'type', 'idx_destinations_type');
    $this->addIndexIfNotExists('destinations', 'created_at', 'idx_destinations_created_at');

    // Booking transactions indexes
    $this->addIndexIfNotExists('booking_transactions', 'status', 'idx_booking_transactions_status');
    $this->addIndexIfNotExists('booking_transactions', 'user_id', 'idx_booking_transactions_user_id');
    $this->addIndexIfNotExists('booking_transactions', 'destination_id', 'idx_booking_transactions_destination_id');
    $this->addIndexIfNotExists('booking_transactions', 'code', 'idx_booking_transactions_code');
    $this->addIndexIfNotExists('booking_transactions', 'contact_email', 'idx_booking_transactions_contact_email');
    $this->addIndexIfNotExists('booking_transactions', 'created_at', 'idx_booking_transactions_created_at');
    $this->addMultiColumnIndexIfNotExists('booking_transactions', ['status', 'created_at'], 'idx_booking_transactions_status_created');

    // Users indexes
    $this->addIndexIfNotExists('users', 'email', 'idx_users_email');
    $this->addIndexIfNotExists('users', 'role', 'idx_users_role');

    // Destination photos indexes
    $this->addIndexIfNotExists('destination_photos', 'destination_id', 'idx_destination_photos_destination_id');

    // Destination details indexes
    $this->addIndexIfNotExists('destination_details', 'destination_id', 'idx_destination_details_destination_id');
  }

  /**
   * Add index if it doesn't exist
   */
  private function addIndexIfNotExists(string $table, string $column, string $indexName): void
  {
    try {
      Schema::table($table, function (Blueprint $table) use ($column, $indexName) {
        $table->index([$column], $indexName);
      });
    } catch (\Exception $e) {
      // Index already exists, skip
      if (!str_contains($e->getMessage(), 'Duplicate key name')) {
        throw $e;
      }
    }
  }

  /**
   * Add multi-column index if it doesn't exist
   */
  private function addMultiColumnIndexIfNotExists(string $table, array $columns, string $indexName): void
  {
    try {
      Schema::table($table, function (Blueprint $table) use ($columns, $indexName) {
        $table->index($columns, $indexName);
      });
    } catch (\Exception $e) {
      // Index already exists, skip
      if (!str_contains($e->getMessage(), 'Duplicate key name')) {
        throw $e;
      }
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('destinations', function (Blueprint $table) {
      $table->dropIndex('idx_destinations_title');
      $table->dropIndex('idx_destinations_slug');
      $table->dropIndex('idx_destinations_price');
      $table->dropIndex('idx_destinations_type');
      $table->dropIndex('idx_destinations_created_at');
    });

    Schema::table('booking_transactions', function (Blueprint $table) {
      $table->dropIndex('idx_booking_transactions_status');
      $table->dropIndex('idx_booking_transactions_user_id');
      $table->dropIndex('idx_booking_transactions_destination_id');
      $table->dropIndex('idx_booking_transactions_code');
      $table->dropIndex('idx_booking_transactions_contact_email');
      $table->dropIndex('idx_booking_transactions_created_at');
      $table->dropIndex('idx_booking_transactions_status_created');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->dropIndex('idx_users_email');
      $table->dropIndex('idx_users_role');
    });

    Schema::table('destination_photos', function (Blueprint $table) {
      $table->dropIndex('idx_destination_photos_destination_id');
    });

    Schema::table('destination_details', function (Blueprint $table) {
      $table->dropIndex('idx_destination_details_destination_id');
    });
  }
};
