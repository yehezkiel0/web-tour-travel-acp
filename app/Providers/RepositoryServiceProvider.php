<?php

namespace App\Providers;

use App\Contracts\Repositories\BookingTransactionRepositoryInterface;
use App\Contracts\Repositories\DestinationRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\BookingTransactionRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\UserRepository;
use App\Repositories\HotelRepository;
use App\Repositories\HotelBookingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    // Bind repository interfaces to their implementations
    $this->app->bind(
      BookingTransactionRepositoryInterface::class,
      BookingTransactionRepository::class
    );

    $this->app->bind(
      DestinationRepositoryInterface::class,
      DestinationRepository::class
    );

    $this->app->bind(
      UserRepositoryInterface::class,
      UserRepository::class
    );

    // Bind Hotel repositories
    $this->app->singleton(HotelRepository::class);
    $this->app->singleton(HotelBookingRepository::class);
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}
