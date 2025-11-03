<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
  public function __construct(User $model)
  {
    parent::__construct($model);
  }

  /**
   * Find user by email
   */
  public function findByEmail(string $email): ?User
  {
    return $this->model->where('email', $email)->first();
  }

  /**
   * Get users by role
   */
  public function getByRole(string $role): Collection
  {
    return $this->model->where('role', $role)->latest()->get();
  }

  /**
   * Get customers
   */
  public function getCustomers(): Collection
  {
    return $this->getByRole('customer');
  }

  /**
   * Get admins
   */
  public function getAdmins(): Collection
  {
    return $this->getByRole('admin');
  }

  /**
   * Count customers
   */
  public function countCustomers(): int
  {
    return $this->model->where('role', 'customer')->count();
  }

  /**
   * Get user with bookings
   */
  public function getUserWithBookings(int $id)
  {
    return $this->model->with([
      'bookingTransactions',
      'bookingTransactions.destination'
    ])->findOrFail($id);
  }

  /**
   * Update last login
   */
  public function updateLastLogin(int $id): bool
  {
    $user = $this->findOrFail($id);
    return $user->update(['last_login_at' => now()]);
  }

  /**
   * Activate user
   */
  public function activate(int $id): bool
  {
    $user = $this->findOrFail($id);
    return $user->update(['is_active' => true]);
  }

  /**
   * Deactivate user
   */
  public function deactivate(int $id): bool
  {
    $user = $this->findOrFail($id);
    return $user->update(['is_active' => false]);
  }
}
