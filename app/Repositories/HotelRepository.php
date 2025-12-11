<?php

namespace App\Repositories;

use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class HotelRepository extends BaseRepository
{
  public function __construct(Hotel $hotel)
  {
    parent::__construct($hotel);
  }

  public function getFilteredHotels(array $filters = [])
  {
    $query = $this->model->with(['photos', 'amenities', 'rooms'])
      ->where('is_active', true);

    // Filter by city
    if (!empty($filters['city'])) {
      $query->where('city', 'like', '%' . $filters['city'] . '%');
    }

    // Filter by country
    if (!empty($filters['country'])) {
      $query->where('country', $filters['country']);
    }

    // Filter by star rating (support multiple)
    if (!empty($filters['star_rating'])) {
      if (is_array($filters['star_rating'])) {
        $query->whereIn('star_rating', $filters['star_rating']);
      } else {
        $query->where('star_rating', '>=', $filters['star_rating']);
      }
    }

    // Filter by price range
    if (!empty($filters['min_price']) || !empty($filters['max_price'])) {
      $query->whereHas('rooms', function ($q) use ($filters) {
        if (!empty($filters['min_price'])) {
          $q->where(function ($subQ) use ($filters) {
            $subQ->where('price_without_breakfast', '>=', $filters['min_price'])
              ->orWhere('price_with_breakfast', '>=', $filters['min_price']);
          });
        }
        if (!empty($filters['max_price'])) {
          $q->where(function ($subQ) use ($filters) {
            $subQ->where('price_without_breakfast', '<=', $filters['max_price'])
              ->orWhere('price_with_breakfast', '<=', $filters['max_price']);
          });
        }
      });
    }

    // Filter by guest capacity (adults + children)
    if (!empty($filters['total_guests'])) {
      $query->whereHas('rooms', function ($q) use ($filters) {
        $q->where('max_guests', '>=', $filters['total_guests']);
      });
    }

    // Filter by number of rooms availability
    if (!empty($filters['rooms_needed'])) {
      $query->whereHas('rooms', function ($q) use ($filters) {
        // Check if hotel has enough rooms
        $q->select(DB::raw('COUNT(*)'))
          ->having(DB::raw('COUNT(*)'), '>=', $filters['rooms_needed']);
      });
    }

    // Search by name
    if (!empty($filters['search'])) {
      $query->where('name', 'like', '%' . $filters['search'] . '%');
    }

    return $query->paginate(12);
  }

  public function getHotelBySlug($slug)
  {
    return $this->model->with(['photos', 'amenities', 'rooms'])
      ->where('slug', $slug)
      ->where('is_active', true)
      ->firstOrFail();
  }

  public function getPopularHotels($limit = 6)
  {
    return $this->model->with(['photos', 'rooms'])
      ->where('is_active', true)
      ->orderBy('view_count', 'desc')
      ->limit($limit)
      ->get();
  }

  public function getMaxPrice()
  {
    $maxWithoutBreakfast = DB::table('hotel_rooms')->max('price_without_breakfast') ?? 0;
    $maxWithBreakfast = DB::table('hotel_rooms')->max('price_with_breakfast') ?? 0;
    return max($maxWithoutBreakfast, $maxWithBreakfast, 10000000);
  }

  public function getAllCities()
  {
    return $this->model->where('is_active', true)
      ->select('city')
      ->distinct()
      ->orderBy('city')
      ->pluck('city');
  }
}
