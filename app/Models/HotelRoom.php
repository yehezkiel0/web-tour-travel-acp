<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
  use HasFactory;

  protected $fillable = [
    'hotel_id',
    'room_name',
    'room_description',
    'max_guests',
    'bed_count',
    'bed_type',
    'price_without_breakfast',
    'price_with_breakfast',
    'room_photo',
    'has_breakfast',
    'free_cancellation',
    'pay_at_hotel',
    'smoking_allowed',
    'has_wifi',
    'has_air_conditioning',
  ];

  protected $casts = [
    'has_breakfast' => 'boolean',
    'free_cancellation' => 'boolean',
    'pay_at_hotel' => 'boolean',
    'smoking_allowed' => 'boolean',
    'has_wifi' => 'boolean',
    'has_air_conditioning' => 'boolean',
  ];

  public function hotel()
  {
    return $this->belongsTo(Hotel::class);
  }

  public function bookings()
  {
    return $this->hasMany(HotelBooking::class);
  }
}
