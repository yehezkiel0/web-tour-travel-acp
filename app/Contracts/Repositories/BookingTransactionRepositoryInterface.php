<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BookingTransaction;

interface BookingTransactionRepositoryInterface
{
  /**
   * Get all bookings with relations
   */
  public function getAllWithRelations(): Collection;

  /**
   * Get paginated bookings with relations
   */
  public function paginateWithRelations(int $perPage = 15): LengthAwarePaginator;

  /**
   * Get paginated bookings with relations and filters
   */
  public function paginateWithRelationsAndFilters(int $perPage = 15, string $search = '', string $status = ''): LengthAwarePaginator;

  /**
   * Find booking with relations
   */
  public function findWithRelations(int $id): BookingTransaction;

  /**
   * Get bookings by user
   */
  public function getByUser(int $userId): Collection;

  /**
   * Get bookings by destination
   */
  public function getByDestination(int $destinationId): Collection;

  /**
   * Get bookings by status
   */
  public function getByStatus(string $status): Collection;

  /**
   * Get total revenue
   */
  public function getTotalRevenue(): float;

  /**
   * Get total travellers
   */
  public function getTotalTravellers(): int;

  /**
   * Get revenue by date range
   */
  public function getRevenueByDateRange(string $startDate, string $endDate): float;

  /**
   * Get bookings count by status
   */
  public function countByStatus(string $status): int;

  /**
   * Get recent bookings
   */
  public function getRecentBookings(int $limit = 10): Collection;

  /**
   * Update payment status
   */
  public function updatePaymentStatus(int $id, string $status): bool;

  /**
   * Create new booking
   */
  public function create(array $data): BookingTransaction;

  /**
   * Update booking
   */
  public function update(int $id, array $data): bool;

  /**
   * Delete booking
   */
  public function delete(int $id): bool;

  /**
   * Find booking by ID
   */
  public function find(int $id): ?BookingTransaction;

  /**
   * Find booking by ID or fail
   */
  public function findOrFail(int $id): BookingTransaction;

  /**
   * Count all bookings
   */
  public function count(): int;
}
