<?php

namespace App\Jobs;

use App\Models\BookingTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Log;

class SendBookingConfirmationEmail implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * The number of times the job may be attempted.
   *
   * @var int
   */
  public $tries = 3;

  /**
   * The number of seconds to wait before retrying the job.
   *
   * @var int
   */
  public $retryAfter = 60;

  /**
   * The booking transaction instance.
   *
   * @var \App\Models\BookingTransaction
   */
  protected $booking;

  /**
   * Create a new job instance.
   *
   * @param \App\Models\BookingTransaction $booking
   * @return void
   */
  public function __construct(BookingTransaction $booking)
  {
    $this->booking = $booking;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle(): void
  {
    try {
      // Load user and destination relations if not loaded
      if (!$this->booking->relationLoaded('user')) {
        $this->booking->load('user');
      }
      if (!$this->booking->relationLoaded('destination')) {
        $this->booking->load('destination');
      }

      Mail::to($this->booking->email)->send(
        new TicketMail(
          $this->booking->user,
          $this->booking,
          $this->booking->destination
        )
      );

      Log::info('Booking confirmation email sent successfully', [
        'booking_id' => $this->booking->id,
        'email' => $this->booking->email
      ]);
    } catch (\Exception $e) {
      Log::error('Failed to send booking confirmation email', [
        'booking_id' => $this->booking->id,
        'email' => $this->booking->email,
        'error' => $e->getMessage()
      ]);

      // Re-throw the exception to trigger job retry
      throw $e;
    }
  }

  /**
   * Handle a job failure.
   *
   * @param \Throwable $exception
   * @return void
   */
  public function failed(\Throwable $exception): void
  {
    Log::error('SendBookingConfirmationEmail job failed permanently', [
      'booking_id' => $this->booking->id,
      'email' => $this->booking->email,
      'error' => $exception->getMessage(),
      'attempts' => $this->attempts()
    ]);
  }
}
