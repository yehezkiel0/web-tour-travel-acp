<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hotel extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
    'description',
    'country',
    'city',
    'address',
    'latitude',
    'longitude',
    'star_rating',
    'featured_photo',
    'view_count',
    'is_active',
  ];

  protected $casts = [
    'latitude' => 'decimal:8',
    'longitude' => 'decimal:8',
    'is_active' => 'boolean',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($hotel) {
      if (empty($hotel->slug)) {
        $hotel->slug = Str::slug($hotel->name);
      }
    });
  }

  public function photos()
  {
    return $this->hasMany(HotelPhoto::class)->orderBy('order');
  }

  public function amenities()
  {
    return $this->hasMany(HotelAmenity::class);
  }

  public function rooms()
  {
    return $this->hasMany(HotelRoom::class);
  }

  public function bookings()
  {
    return $this->hasMany(HotelBooking::class);
  }

  public function getMinPriceAttribute()
  {
    return $this->rooms()->min('price_without_breakfast') ?? 0;
  }

  public function getAverageRatingAttribute()
  {
    // Placeholder for future rating implementation
    return 4.5;
  }

  public function incrementViewCount()
  {
    $this->increment('view_count');
  }
}
