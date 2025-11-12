<?php

namespace App\Repositories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DestinationRepository extends BaseRepository
{
  public function __construct(Destination $model)
  {
    parent::__construct($model);
  }

  /**
   * Get all destinations with relations
   */
  public function getAllWithRelations(): Collection
  {
    return $this->model->with([
      'destinationPhotos:id,destination_id,photo',
      'destinationDetails:id,destination_id,category'
    ])->latest()->get();
  }

  /**
   * Get paginated destinations with relations
   */
  public function paginateWithRelations(int $perPage = 15): LengthAwarePaginator
  {
    return $this->model->with([
      'destinationPhotos',
      'destinationDetails'
    ])->latest()->paginate($perPage);
  }

  /**
   * Find destination by slug with relations
   */
  public function findBySlugWithRelations(string $slug)
  {
    return $this->model->with([
      'destinationPhotos',
      'destinationDetails',
      'bookingTransactions'
    ])->where('slug', $slug)->firstOrFail();
  }

  /**
   * Get active destinations
   */
  public function getActive(): Collection
  {
    return $this->model->with('destinationPhotos')
      ->where('is_active', true)
      ->latest()
      ->get();
  }

  /**
   * Search destinations
   */
  public function search(string $keyword): Collection
  {
    return $this->model->with('destinationPhotos')
      ->where(function ($query) use ($keyword) {
        $query->where('title', 'like', "%{$keyword}%")
          ->orWhere('description', 'like', "%{$keyword}%");
      })
      ->latest()
      ->get();
  }

  /**
   * Filter by price range
   */
  public function filterByPriceRange(float $minPrice, float $maxPrice): Collection
  {
    return $this->model->with('destinationPhotos')
      ->whereBetween('price', [$minPrice, $maxPrice])
      ->latest()
      ->get();
  }

  /**
   * Get popular destinations
   */
  public function getPopular(int $limit = 6): Collection
  {
    return $this->model->with('destinationPhotos')
      ->withCount('bookingTransactions')
      ->orderBy('booking_transactions_count', 'desc')
      ->limit($limit)
      ->get();
  }

  /**
   * Get featured destinations
   */
  public function getFeatured(int $limit = 6): Collection
  {
    return $this->model->with('destinationPhotos')
      ->where('is_featured', true)
      ->latest()
      ->limit($limit)
      ->get();
  }

  /**
   * Get destinations by category
   */
  public function getByCategory(string $category): Collection
  {
    return $this->model->with('destinationPhotos')
      ->whereHas('destinationDetails', function ($query) use ($category) {
        $query->where('category', $category);
      })
      ->latest()
      ->get();
  }

  /**
   * Increment view count
   */
  public function incrementViews(int $id): bool
  {
    $destination = $this->findOrFail($id);
    $destination->views = ($destination->views ?? 0) + 1;
    return $destination->save();
  }

  /**
   * Get paginated destinations with filters
   */
  public function paginateWithFilters(int $perPage = 15, array $filters = []): LengthAwarePaginator
  {
    $query = $this->model->with([
      'destinationPhotos',
      'destinationDetails'
    ]);

    // Apply search filter
    if (!empty($filters['search'])) {
      $query->where(function ($q) use ($filters) {
        $q->where('title', 'like', "%{$filters['search']}%")
          ->orWhere('description', 'like', "%{$filters['search']}%");
      });
    }

    // Apply category filter
    if (!empty($filters['category'])) {
      $query->whereHas('destinationDetails', function ($subQuery) use ($filters) {
        $subQuery->where('category', $filters['category']);
      });
    }

    // Apply price range filter
    if (isset($filters['min_price']) && isset($filters['max_price'])) {
      $query->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
    }

    // Apply active filter
    $query->where('is_active', true);

    return $query->latest()->paginate($perPage);
  }
}
