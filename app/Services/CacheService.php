<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Repositories\BookingTransactionRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\UserRepository;

class CacheService
{
  protected const TTL = 3600; // 1 hour
  protected const DASHBOARD_STATS_KEY = 'dashboard_stats';
  protected const POPULAR_DESTINATIONS_KEY = 'popular_destinations';
  protected const FEATURED_DESTINATIONS_KEY = 'featured_destinations';

  protected $bookingRepo;
  protected $destinationRepo;
  protected $userRepo;

  public function __construct(
    BookingTransactionRepository $bookingRepo,
    DestinationRepository $destinationRepo,
    UserRepository $userRepo
  ) {
    $this->bookingRepo = $bookingRepo;
    $this->destinationRepo = $destinationRepo;
    $this->userRepo = $userRepo;
  }

  /**
   * Get or cache dashboard statistics
   */
  public function getDashboardStats(): array
  {
    return Cache::remember(self::DASHBOARD_STATS_KEY, self::TTL, function () {
      return [
        'total_revenue' => $this->bookingRepo->getTotalRevenue(),
        'total_bookings' => $this->bookingRepo->count(),
        'pending_bookings' => $this->bookingRepo->countByStatus('pending'),
        'success_bookings' => $this->bookingRepo->countByStatus('success'),
        'total_destinations' => $this->destinationRepo->count(),
        'total_customers' => $this->userRepo->countCustomers(),
      ];
    });
  }

  /**
   * Clear dashboard stats cache
   */
  public function clearDashboardStats(): void
  {
    Cache::forget(self::DASHBOARD_STATS_KEY);
  }

  /**
   * Get or cache popular destinations
   */
  public function getPopularDestinations(int $limit = 6)
  {
    $key = self::POPULAR_DESTINATIONS_KEY . "_{$limit}";

    return Cache::remember($key, self::TTL, function () use ($limit) {
      return $this->destinationRepo->getPopular($limit);
    });
  }

  /**
   * Clear popular destinations cache
   */
  public function clearPopularDestinations(): void
  {
    Cache::forget(self::POPULAR_DESTINATIONS_KEY);
    // Clear all variations
    for ($i = 1; $i <= 20; $i++) {
      Cache::forget(self::POPULAR_DESTINATIONS_KEY . "_{$i}");
    }
  }

  /**
   * Get or cache featured destinations
   */
  public function getFeaturedDestinations(int $limit = 6)
  {
    $key = self::FEATURED_DESTINATIONS_KEY . "_{$limit}";

    return Cache::remember($key, self::TTL, function () use ($limit) {
      return $this->destinationRepo->getFeatured($limit);
    });
  }

  /**
   * Clear featured destinations cache
   */
  public function clearFeaturedDestinations(): void
  {
    Cache::forget(self::FEATURED_DESTINATIONS_KEY);
    // Clear all variations
    for ($i = 1; $i <= 20; $i++) {
      Cache::forget(self::FEATURED_DESTINATIONS_KEY . "_{$i}");
    }
  }

  /**
   * Clear all destination caches
   */
  public function clearDestinationCaches(): void
  {
    $this->clearPopularDestinations();
    $this->clearFeaturedDestinations();
  }

  /**
   * Clear all caches
   */
  public function clearAllCaches(): void
  {
    $this->clearDashboardStats();
    $this->clearDestinationCaches();
  }

  /**
   * Get cache TTL
   */
  public function getTTL(): int
  {
    return self::TTL;
  }

  /**
   * Set custom cache with TTL
   */
  public function set(string $key, $value, ?int $ttl = null): bool
  {
    return Cache::put($key, $value, $ttl ?? self::TTL);
  }

  /**
   * Get custom cache
   */
  public function get(string $key, $default = null)
  {
    return Cache::get($key, $default);
  }

  /**
   * Forget custom cache
   */
  public function forget(string $key): bool
  {
    return Cache::forget($key);
  }

  /**
   * Check if cache exists
   */
  public function has(string $key): bool
  {
    return Cache::has($key);
  }
}
