<?php

namespace App\Http\Controllers\API;

use App\Contracts\Repositories\DestinationRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DestinationController extends Controller
{
  use ApiResponse;

  protected $destinationRepo;

  /**
   * Constructor
   *
   * @param \App\Contracts\Repositories\DestinationRepositoryInterface $destinationRepo
   */
  public function __construct(DestinationRepositoryInterface $destinationRepo)
  {
    $this->destinationRepo = $destinationRepo;
  }

  /**
   * Display a listing of destinations with caching
   */
  /**
   * Display a listing of destinations with caching
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index($request)
  {
    $page = $request->get('page', 1);
    $perPage = $request->get('per_page', 15);
    $search = $request->get('search', '');
    $category = $request->get('category', '');
    $minPrice = $request->get('min_price', 0);
    $maxPrice = $request->get('max_price', 999999);

    // Create cache key based on filters
    $cacheKey = "destinations_index_" . md5(serialize([
      'page' => $page,
      'per_page' => $perPage,
      'search' => $search,
      'category' => $category,
      'min_price' => $minPrice,
      'max_price' => $maxPrice
    ]));

    // Cache for 30 minutes
    $destinations = Cache::remember($cacheKey, 1800, function () use ($perPage, $search, $category, $minPrice, $maxPrice) {
      $filters = [
        'search' => $search,
        'category' => $category,
        'min_price' => $minPrice,
        'max_price' => $maxPrice
      ];

      return $this->destinationRepo->paginateWithFilters($perPage, $filters);
    });

    return $this->paginatedResponse($destinations, 'Destinations retrieved successfully');
  }

  /**
   * Display popular destinations with caching
   */
  /**
   * Display popular destinations with caching
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function popular($request)
  {
    $limit = $request->get('limit', 6);

    // Cache for 1 hour
    $destinations = Cache::remember("popular_destinations_{$limit}", 3600, function () use ($limit) {
      return $this->destinationRepo->getPopular($limit);
    });

    return $this->successResponse($destinations, 'Popular destinations retrieved successfully');
  }

  /**
   * Display featured destinations with caching
   */
  /**
   * Display featured destinations with caching
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function featured($request)
  {
    $limit = $request->get('limit', 6);

    // Cache for 1 hour
    $destinations = Cache::remember("featured_destinations_{$limit}", 3600, function () use ($limit) {
      return $this->destinationRepo->getFeatured($limit);
    });

    return $this->successResponse($destinations, 'Featured destinations retrieved successfully');
  }

  /**
   * Display the specified destination with caching
   */
  /**
   * Display specified destination with caching
   *
   * @param string $slug
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($slug)
  {
    // Cache for 30 minutes
    $destination = Cache::remember("destination_{$slug}", 1800, function () use ($slug) {
      return $this->destinationRepo->findBySlugWithRelations($slug);
    });

    if (!$destination) {
      return $this->notFoundResponse('Destination not found');
    }

    // Increment view count asynchronously
    Cache::increment("destination_views_{$destination->id}");

    // Batch update view count to database every 10 views
    if (Cache::get("destination_views_{$destination->id}") % 10 === 0) {
      $this->destinationRepo->incrementViews($destination->id);
      Cache::forget("destination_views_{$destination->id}");
    }

    return $this->successResponse($destination, 'Destination retrieved successfully');
  }

  /**
   * Search destinations with caching
   */
  /**
   * Search destinations with caching
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function search($request)
  {
    $keyword = $request->get('q', '');

    if (empty($keyword)) {
      return $this->errorResponse('Search keyword is required', 400);
    }

    // Cache for 15 minutes
    $destinations = Cache::remember("search_destinations_" . md5($keyword), 900, function () use ($keyword) {
      return $this->destinationRepo->search($keyword);
    });

    return $this->successResponse($destinations, 'Search results retrieved successfully');
  }

  /**
   * Clear destination cache
   */
  public function clearCache()
  {
    $this->clearDestinationCache();

    return $this->successResponse(null, 'Destination cache cleared successfully');
  }

  /**
   * Clear all destination-related cache
   */
  private function clearDestinationCache()
  {
    $patterns = [
      'destinations_index_*',
      'popular_destinations_*',
      'featured_destinations_*',
      'destination_*',
      'search_destinations_*'
    ];

    foreach ($patterns as $pattern) {
      Cache::forget($pattern);
    }
  }
}
