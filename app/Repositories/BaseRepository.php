<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  /**
   * Get all records
   */
  public function all(): Collection
  {
    return $this->model->all();
  }

  /**
   * Find record by ID
   */
  public function find(int $id): ?Model
  {
    return $this->model->find($id);
  }

  /**
   * Find record by ID or fail
   */
  public function findOrFail(int $id): Model
  {
    return $this->model->findOrFail($id);
  }

  /**
   * Find record by specific column
   */
  public function findBy(string $column, $value): ?Model
  {
    return $this->model->where($column, $value)->first();
  }

  /**
   * Get records by specific column
   */
  public function getBy(string $column, $value): Collection
  {
    return $this->model->where($column, $value)->get();
  }

  /**
   * Create new record
   */
  public function create(array $data): Model
  {
    return $this->model->create($data);
  }

  /**
   * Update record
   */
  public function update(int $id, array $data): bool
  {
    $record = $this->findOrFail($id);
    return $record->update($data);
  }

  /**
   * Delete record
   */
  public function delete(int $id): bool
  {
    $record = $this->findOrFail($id);
    return $record->delete();
  }

  /**
   * Get paginated records
   */
  public function paginate(int $perPage = 15): LengthAwarePaginator
  {
    return $this->model->paginate($perPage);
  }

  /**
   * Count records
   */
  public function count(): int
  {
    return $this->model->count();
  }

  /**
   * Check if record exists
   */
  public function exists(int $id): bool
  {
    return $this->model->where('id', $id)->exists();
  }

  /**
   * Get latest records
   */
  public function latest(int $limit = 10): Collection
  {
    return $this->model->latest()->limit($limit)->get();
  }

  /**
   * Get oldest records
   */
  public function oldest(int $limit = 10): Collection
  {
    return $this->model->oldest()->limit($limit)->get();
  }
}
