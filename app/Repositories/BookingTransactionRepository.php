<?php

namespace App\Repositories;

use App\Models\BookingTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingTransactionRepository extends BaseRepository
{
  public function __construct(BookingTransaction $model)
  {
    parent::__construct($model);
  }

  /**
   * Get all bookings with relations
   */
  public function getAllWithRelations(): Collection
  {
    return $this->model->with([
      'destination:id,title,slug,price',
      'destination.destinationPhotos:id,destination_id,photo',
      'user:id,name,email'
    ])->latest()->get();
  }

  /**
   * Get paginated bookings with relations
   */
  public function paginateWithRelations(int $perPage = 15): LengthAwarePaginator
  {
    return $this->model->with([
      'destination:id,title,slug,price',
      'destination.destinationPhotos:id,destination_id,photo',
      'user:id,name,email'
    ])->latest()->paginate($perPage);
  }

  /**
   * Find booking with relations
   */
  public function findWithRelations(int $id)
  {
    return $this->model->with([
      'destination',
      'destination.destinationPhotos',
      'destination.destinationDetails',
      'user'
    ])->findOrFail($id);
  }

  /**
   * Get bookings by user
   */
  public function getByUser(int $userId): Collection
  {
    return $this->model->with([
      'destination:id,title,slug,price',
      'destination.destinationPhotos:id,destination_id,photo'
    ])
      ->where('user_id', $userId)
      ->latest()
      ->get();
  }

  /**
   * Get bookings by destination
   */
  public function getByDestination(int $destinationId): Collection
  {
    return $this->model->with('user:id,name,email')
      ->where('destination_id', $destinationId)
      ->latest()
      ->get();
  }

  /**
   * Get bookings by status
   */
  public function getByStatus(string $status): Collection
  {
    return $this->model->with([
      'destination:id,title,slug',
      'user:id,name,email'
    ])
      ->where('payment_status', $status)
      ->latest()
      ->get();
  }

  /**
   * Get total revenue
   */
  public function getTotalRevenue(): float
  {
    return $this->model->where('payment_status', 'success')->sum('total_amount');
  }

  /**
   * Get revenue by date range
   */
  public function getRevenueByDateRange(string $startDate, string $endDate): float
  {
    return $this->model
      ->where('payment_status', 'success')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->sum('total_amount');
  }

  /**
   * Get bookings count by status
   */
  public function countByStatus(string $status): int
  {
    return $this->model->where('payment_status', $status)->count();
  }

  /**
   * Get recent bookings
   */
  public function getRecentBookings(int $limit = 10): Collection
  {
    return $this->model->with([
      'destination:id,title,slug',
      'user:id,name,email'
    ])
      ->latest()
      ->limit($limit)
      ->get();
  }

  /**
   * Update payment status
   */
  public function updatePaymentStatus(int $id, string $status): bool
  {
    $booking = $this->findOrFail($id);
    return $booking->update(['payment_status' => $status]);
  }
}
