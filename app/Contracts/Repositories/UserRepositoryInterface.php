<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UserRepositoryInterface
{
  /**
   * Find user by email
   */
  public function findByEmail(string $email): ?User;

  /**
   * Get users by role
   */
  public function getByRole(string $role): Collection;

  /**
   * Get customers
   */
  public function getCustomers(): Collection;

  /**
   * Get admins
   */
  public function getAdmins(): Collection;

  /**
   * Count customers
   */
  public function countCustomers(): int;

  /**
   * Get user with bookings
   */
  public function getUserWithBookings(int $id): User;

  /**
   * Update last login
   */
  public function updateLastLogin(int $id): bool;

  /**
   * Activate user
   */
  public function activate(int $id): bool;

  /**
   * Deactivate user
   */
  public function deactivate(int $id): bool;

  /**
   * Create new user
   */
  public function create(array $data): User;

  /**
   * Update user
   */
  public function update(int $id, array $data): bool;

  /**
   * Delete user
   */
  public function delete(int $id): bool;

  /**
   * Find user by ID
   */
  public function find(int $id): ?User;

  /**
   * Find user by ID or fail
   */
  public function findOrFail(int $id): User;

  /**
   * Count all users
   */
  public function count(): int;

  /**
   * Get paginated users
   */
  public function paginate(int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator;

  /**
   * Get paginated users with filters
   */
  public function paginateWithFilters(int $perPage = 15, array $filters = []): \Illuminate\Pagination\LengthAwarePaginator;
}
