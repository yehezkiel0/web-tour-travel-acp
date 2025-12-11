<?php

namespace App\Services;

use App\Repositories\HotelRepository;
use App\Repositories\HotelBookingRepository;
use Carbon\Carbon;

class HotelService
{
  protected $hotelRepository;
  protected $bookingRepository;

  public function __construct(
    HotelRepository $hotelRepository,
    HotelBookingRepository $bookingRepository
  ) {
    $this->hotelRepository = $hotelRepository;
    $this->bookingRepository = $bookingRepository;
  }

  public function getFilteredHotels(array $filters)
  {
    return $this->hotelRepository->getFilteredHotels($filters);
  }

  public function getHotelDetails($slug)
  {
    $hotel = $this->hotelRepository->getHotelBySlug($slug);
    $hotel->incrementViewCount();
    return $hotel;
  }

  public function calculateBookingPrice($roomPrice, $numberOfNights, $numberOfRooms)
  {
    return $roomPrice * $numberOfNights * $numberOfRooms;
  }

  public function calculateNumberOfNights($checkIn, $checkOut)
  {
    $checkInDate = Carbon::parse($checkIn);
    $checkOutDate = Carbon::parse($checkOut);
    return $checkInDate->diffInDays($checkOutDate);
  }

  public function createBooking(array $bookingData)
  {
    $bookingData['booking_code'] = 'HTL' . rand(100000, 999999);
    return $this->bookingRepository->createBooking($bookingData);
  }

  public function getBookingByCode($code)
  {
    return $this->bookingRepository->getBookingByCode($code);
  }

  public function updateBookingStatus($bookingCode, $status)
  {
    return $this->bookingRepository->updateBookingStatus($bookingCode, $status);
  }

  public function getPopularHotels($limit = 6)
  {
    return $this->hotelRepository->getPopularHotels($limit);
  }

  public function getMaxPrice()
  {
    return $this->hotelRepository->getMaxPrice();
  }

  public function getAllCities()
  {
    return $this->hotelRepository->getAllCities();
  }
}
