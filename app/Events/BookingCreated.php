<?php

namespace App\Events;

use App\Models\BookingTransaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingCreated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  /**
   * Create a new event instance.
   */
  public function __construct(
    public BookingTransaction $booking
  ) {}

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */
  public function broadcastOn(): array
  {
    return [
      new PrivateChannel('bookings'),
    ];
  }

  /**
   * The event's broadcast name.
   */
  public function broadcastAs(): string
  {
    return 'booking.created';
  }

  /**
   * Get the data to broadcast.
   */
  public function broadcastWith(): array
  {
    return [
      'booking_id' => $this->booking->id,
      'code' => $this->booking->code,
      'status' => $this->booking->status,
      'total_price' => $this->booking->total_price,
      'user_id' => $this->booking->user_id,
      'destination_id' => $this->booking->destination_id,
      'created_at' => $this->booking->created_at->toISOString(),
    ];
  }
}
