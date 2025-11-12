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
      ->where('status', $status)
      ->latest()
      ->get();
  }

  /**
   * Get total revenue
   */
  public function getTotalRevenue(): float
  {
    return $this->model->where('status', 'paid')->sum('total_price');
  }

  /**
   * Get total travellers (sum of adult_count + child_count)
   */
  public function getTotalTravellers(): int
  {
    return $this->model->where('status', 'paid')
      ->get()
      ->sum(function ($booking) {
        return $booking->adult_count + $booking->child_count;
      });
  }

  /**
   * Get revenue by date range
   */
  public function getRevenueByDateRange(string $startDate, string $endDate): float
  {
    return $this->model
      ->where('status', 'paid')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->sum('total_price');
  }

  /**
   * Get bookings count by status
   */
  public function countByStatus(string $status): int
  {
    return $this->model->where('status', $status)->count();
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
    return $booking->update(['status' => $status]);
  }

  /**
   * Get paginated bookings with relations and filters
   */
  public function paginateWithRelationsAndFilters(int $perPage = 15, string $search = '', string $status = ''): LengthAwarePaginator
  {
    $query = $this->model->with([
      'destination:id,title,slug,price',
      'destination.destinationPhotos:id,destination_id,photo',
      'user:id,name,email'
    ]);

    // Apply search filter
    if (!empty($search)) {
      $query->where(function ($q) use ($search) {
        $q->where('code', 'like', "%{$search}%")
          ->orWhere('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhereHas('destination', function ($subQuery) use ($search) {
            $subQuery->where('title', 'like', "%{$search}%");
          });
      });
    }

    // Apply status filter
    if (!empty($status)) {
      $query->where('status', $status);
    }

    return $query->latest()->paginate($perPage);
  }
}
