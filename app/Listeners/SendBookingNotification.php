<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Jobs\SendBookingConfirmationEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingNotification implements ShouldQueue
{
  /**
   * The name of the connection the job should be sent to.
   *
   * @var string|null
   */
  public $connection = 'redis';

  /**
   * The name of the queue the job should be sent to.
   *
   * @var string|null
   */
  public $queue = 'notifications';

  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(BookingCreated $event): void
  {
    try {
      // Check if booking exists
      if (!$event->booking) {
        Log::error('BookingCreated event received without booking data');
        return;
      }

      // Log the booking creation
      Log::info('New booking created', [
        'booking_id' => $event->booking->id,
        'code' => $event->booking->code,
        'user_id' => $event->booking->user_id,
        'destination_id' => $event->booking->destination_id,
        'total_price' => $event->booking->total_price,
      ]);

      // Send confirmation email via queue
      SendBookingConfirmationEmail::dispatch($event->booking);

      // Additional notification logic can be added here
      // - Push notifications
      // - SMS notifications
      // - Admin notifications

    } catch (\Exception $e) {
      Log::error('Failed to handle booking created event', [
        'booking_id' => $event->booking ? $event->booking->id : 'unknown',
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);
    }
  }

  /**
   * Handle a job failure.
   */
  public function failed(BookingCreated $event, \Throwable $exception): void
  {
    Log::error('SendBookingNotification listener failed', [
      'booking_id' => $event->booking ? $event->booking->id : 'unknown',
      'error' => $exception->getMessage(),
      'trace' => $exception->getTraceAsString()
    ]);
  }
}
