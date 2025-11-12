<?php

namespace App\Services;

use App\Repositories\BookingTransactionRepository;
use App\Repositories\DestinationRepository;
use App\Models\BookingTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TicketMail;
use App\Jobs\SendBookingConfirmationEmail;

class BookingService
{
  protected $bookingRepo;
  protected $destinationRepo;

  public function __construct(
    BookingTransactionRepository $bookingRepo,
    DestinationRepository $destinationRepo
  ) {
    $this->bookingRepo = $bookingRepo;
    $this->destinationRepo = $destinationRepo;
  }

  /**
   * Create new booking
   */
  public function createBooking(array $data): BookingTransaction
  {
    DB::beginTransaction();

    try {
      // Get destination details
      $destination = $this->destinationRepo->findOrFail($data['destination_id']);

      // Calculate total amount
      $totalAmount = $this->calculateTotalAmount(
        $destination->price,
        $data['quantity'] ?? 1
      );

      // Create booking
      $booking = $this->bookingRepo->create([
        'user_id' => $data['user_id'],
        'destination_id' => $data['destination_id'],
        'booking_trx_id' => $this->generateTransactionId(),
        'name' => $data['name'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'quantity' => $data['quantity'] ?? 1,
        'total_price' => $totalAmount,
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'] ?? null,
        'status' => 'pending',
        'notes' => $data['notes'] ?? null,
      ]);

      DB::commit();

      return $booking;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Update booking
   */
  public function updateBooking(int $id, array $data): bool
  {
    DB::beginTransaction();

    try {
      $booking = $this->bookingRepo->findOrFail($id);

      // Recalculate if quantity changed
      if (isset($data['quantity']) && $data['quantity'] != $booking->quantity) {
        $destination = $this->destinationRepo->findOrFail($booking->destination_id);
        $data['total_price'] = $this->calculateTotalAmount(
          $destination->price,
          $data['quantity']
        );
      }

      $result = $this->bookingRepo->update($id, $data);

      DB::commit();

      return $result;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Update payment status
   */
  public function updatePaymentStatus(int $id, string $status): bool
  {
    DB::beginTransaction();

    try {
      $result = $this->bookingRepo->updatePaymentStatus($id, $status);

      // Send email if payment successful
      if ($status === 'success') {
        $booking = $this->bookingRepo->findWithRelations($id);
        $this->sendBookingConfirmation($booking);
      }

      DB::commit();

      return $result;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Cancel booking
   */
  public function cancelBooking(int $id): bool
  {
    return $this->updatePaymentStatus($id, 'cancelled');
  }

  /**
   * Get booking statistics
   */
  public function getStatistics(): array
  {
    return [
      'total_bookings' => $this->bookingRepo->count(),
      'pending_bookings' => $this->bookingRepo->countByStatus('pending'),
      'success_bookings' => $this->bookingRepo->countByStatus('success'),
      'cancelled_bookings' => $this->bookingRepo->countByStatus('cancelled'),
      'total_revenue' => $this->bookingRepo->getTotalRevenue(),
    ];
  }

  /**
   * Get revenue by period
   */
  public function getRevenueByPeriod(string $period = 'month'): float
  {
    $startDate = match ($period) {
      'today' => now()->startOfDay(),
      'week' => now()->startOfWeek(),
      'month' => now()->startOfMonth(),
      'year' => now()->startOfYear(),
      default => now()->startOfMonth(),
    };

    return $this->bookingRepo->getRevenueByDateRange(
      $startDate->toDateString(),
      now()->toDateString()
    );
  }

  /**
   * Calculate total amount
   */
  protected function calculateTotalAmount(float $price, int $quantity): float
  {
    return $price * $quantity;
  }

  /**
   * Generate unique transaction ID
   */
  protected function generateTransactionId(): string
  {
    return 'TRX-' . strtoupper(uniqid()) . '-' . date('Ymd');
  }

  /**
   * Send booking confirmation email using queue
   */
  protected function sendBookingConfirmation(BookingTransaction $booking): void
  {
    try {
      // Dispatch job to queue for async processing
      SendBookingConfirmationEmail::dispatch($booking);
      
      Log::info('Booking confirmation email job dispatched', [
        'booking_id' => $booking->id,
        'email' => $booking->email
      ]);
    } catch (\Exception $e) {
      // Log error but don't throw exception
      Log::error('Failed to dispatch booking confirmation email job: ' . $e->getMessage());
    }
  }
}
