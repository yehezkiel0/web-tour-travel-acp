<?php

namespace App\Repositories;

use App\Models\HotelBooking;

class HotelBookingRepository extends BaseRepository
{
  public function __construct(HotelBooking $hotelBooking)
  {
    parent::__construct($hotelBooking);
  }

  public function createBooking(array $data)
  {
    return $this->model->create($data);
  }

  public function getBookingByCode($code)
  {
    return $this->model->with(['hotel', 'room', 'user'])
      ->where('booking_code', $code)
      ->firstOrFail();
  }

  public function getUserBookings($userId)
  {
    return $this->model->with(['hotel', 'room'])
      ->where('user_id', $userId)
      ->orderBy('created_at', 'desc')
      ->paginate(10);
  }

  public function updateBookingStatus($bookingCode, $status)
  {
    return $this->model->where('booking_code', $bookingCode)
      ->update(['status' => $status]);
  }
}
