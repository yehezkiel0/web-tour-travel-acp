<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
  use HasFactory;

  protected $fillable = [
    'booking_code',
    'user_id',
    'hotel_id',
    'hotel_room_id',
    'check_in_date',
    'check_out_date',
    'number_of_nights',
    'number_of_rooms',
    'number_of_guests',
    'total_price',
    'guest_name',
    'guest_email',
    'guest_phone',
    'special_request',
    'status',
  ];

  protected $casts = [
    'check_in_date' => 'date',
    'check_out_date' => 'date',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function hotel()
  {
    return $this->belongsTo(Hotel::class);
  }

  public function room()
  {
    return $this->belongsTo(HotelRoom::class, 'hotel_room_id');
  }

  public static function generateBookingCode()
  {
    return 'HTL' . rand(100000, 999999);
  }
}
