<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Destination;

interface DestinationRepositoryInterface
{
  /**
   * Get all destinations with relations
   */
  public function getAllWithRelations(): Collection;

  /**
   * Get paginated destinations with relations
   */
  public function paginateWithRelations(int $perPage = 15): LengthAwarePaginator;

  /**
   * Find destination by slug with relations
   */
  public function findBySlugWithRelations(string $slug): Destination;

  /**
   * Get active destinations
   */
  public function getActive(): Collection;

  /**
   * Search destinations
   */
  public function search(string $keyword): Collection;

  /**
   * Filter by price range
   */
  public function filterByPriceRange(float $minPrice, float $maxPrice): Collection;

  /**
   * Get popular destinations
   */
  public function getPopular(int $limit = 6): Collection;

  /**
   * Get featured destinations
   */
  public function getFeatured(int $limit = 6): Collection;

  /**
   * Get destinations by category
   */
  public function getByCategory(string $category): Collection;

  /**
   * Increment view count
   */
  public function incrementViews(int $id): bool;

  /**
   * Create new destination
   */
  public function create(array $data): Destination;

  /**
   * Update destination
   */
  public function update(int $id, array $data): bool;

  /**
   * Delete destination
   */
  public function delete(int $id): bool;

  /**
   * Find destination by ID
   */
  public function find(int $id): ?Destination;

  /**
   * Find destination by ID or fail
   */
  public function findOrFail(int $id): Destination;

  /**
   * Find destination by slug
   */
  public function findBySlug(string $slug): ?Destination;

  /**
   * Count all destinations
   */
  public function count(): int;

  /**
   * Get paginated destinations with filters
   */
  public function paginateWithFilters(int $perPage = 15, array $filters = []): LengthAwarePaginator;
}
