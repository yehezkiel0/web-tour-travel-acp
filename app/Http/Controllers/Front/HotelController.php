<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\HotelService;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
  protected $hotelService;

  public function __construct(HotelService $hotelService)
  {
    $this->hotelService = $hotelService;
  }

  public function index(Request $request)
  {
    // Get search parameters
    $searchParams = [
      'check_in' => $request->input('check_in'),
      'check_out' => $request->input('check_out'),
      'rooms' => $request->input('rooms', 1),
      'adults' => $request->input('adults', 2),
      'children' => $request->input('children', 0),
    ];

    // Calculate nights if dates are provided
    $nights = null;
    if ($searchParams['check_in'] && $searchParams['check_out']) {
      $checkIn = \Carbon\Carbon::parse($searchParams['check_in']);
      $checkOut = \Carbon\Carbon::parse($searchParams['check_out']);
      $nights = $checkIn->diffInDays($checkOut);
    }

    // Prepare filters
    $filters = [
      'city' => $request->input('city'),
      'country' => $request->input('country'),
      'star_rating' => $request->input('star_rating'),
      'min_price' => $request->input('min_price'),
      'max_price' => $request->input('max_price'),
      'search' => $request->input('search'),
    ];

    // Add guest capacity filter
    $totalGuests = $searchParams['adults'] + $searchParams['children'];
    if ($totalGuests > 0) {
      $filters['total_guests'] = $totalGuests;
    }

    // Add rooms needed filter
    if ($searchParams['rooms'] > 0) {
      $filters['rooms_needed'] = $searchParams['rooms'];
    }

    $hotels = $this->hotelService->getFilteredHotels($filters);
    $maxPrice = $this->hotelService->getMaxPrice();
    $cities = $this->hotelService->getAllCities();

    return view('front.hotel.index', compact('hotels', 'maxPrice', 'cities', 'filters', 'searchParams', 'nights'));
  }

  public function filter(Request $request)
  {
    $filters = [
      'city' => $request->input('city'),
      'star_rating' => $request->input('star_rating', []), // Array for multiple ratings
      'min_price' => $request->input('min_price'),
      'max_price' => $request->input('max_price'),
    ];

    $hotels = $this->hotelService->getFilteredHotels($filters);

    return view('front.hotel.partials.hotel-results', compact('hotels'));
  }

  public function show($slug, Request $request)
  {
    $hotel = $this->hotelService->getHotelDetails($slug);

    $checkIn = $request->input('check_in');
    $checkOut = $request->input('check_out');
    $guests = $request->input('guests', 2);
    $rooms = $request->input('rooms', 1);

    return view('front.hotel.show', compact('hotel', 'checkIn', 'checkOut', 'guests', 'rooms'));
  }

  public function booking(Request $request, $slug)
  {
    $request->validate([
      'check_in' => 'required|date|after_or_equal:today',
      'check_out' => 'required|date|after:check_in',
      'guests' => 'required|integer|min:1',
      'rooms' => 'required|integer|min:1',
      'room_id' => 'required|exists:hotel_rooms,id',
    ]);

    $room = HotelRoom::with('hotel')->findOrFail($request->room_id);
    $numberOfNights = $this->hotelService->calculateNumberOfNights(
      $request->check_in,
      $request->check_out
    );

    $totalPrice = $this->hotelService->calculateBookingPrice(
      $room->price_without_breakfast,
      $numberOfNights,
      $request->rooms
    );

    session()->put('hotel_booking', [
      'hotel_id' => $room->hotel->id,
      'hotel_slug' => $slug,
      'room_id' => $request->room_id,
      'check_in' => $request->check_in,
      'check_out' => $request->check_out,
      'number_of_nights' => $numberOfNights,
      'number_of_guests' => $request->guests,
      'number_of_rooms' => $request->rooms,
      'total_price' => $totalPrice,
      'room_price' => $room->price_without_breakfast,
    ]);

    return redirect()->route('hotel.checkout', ['slug' => $slug]);
  }

  public function checkout($slug)
  {
    $bookingData = session('hotel_booking');

    if (!$bookingData || $bookingData['hotel_slug'] !== $slug) {
      return redirect()->route('hotel.show', ['slug' => $slug])
        ->with('error', 'Booking data not found. Please try again.');
    }

    $hotel = $this->hotelService->getHotelDetails($slug);
    $room = HotelRoom::findOrFail($bookingData['room_id']);

    return view('front.hotel.checkout', compact('hotel', 'room', 'bookingData'));
  }

  public function payment(Request $request, $slug)
  {
    $request->validate([
      'guest_name' => 'required|string|max:255',
      'guest_email' => 'required|email|max:255',
      'guest_phone' => 'required|string|max:20',
      'special_request' => 'nullable|string|max:1000',
    ]);

    $bookingData = session('hotel_booking');

    if (!$bookingData) {
      return redirect()->route('hotel.index')
        ->with('error', 'Booking session expired. Please try again.');
    }

    try {
      DB::beginTransaction();

      $booking = $this->hotelService->createBooking([
        'user_id' => Auth::id(),
        'hotel_id' => $bookingData['hotel_id'],
        'hotel_room_id' => $bookingData['room_id'],
        'check_in_date' => $bookingData['check_in'],
        'check_out_date' => $bookingData['check_out'],
        'number_of_nights' => $bookingData['number_of_nights'],
        'number_of_rooms' => $bookingData['number_of_rooms'],
        'number_of_guests' => $bookingData['number_of_guests'],
        'total_price' => $bookingData['total_price'],
        'guest_name' => $request->guest_name,
        'guest_email' => $request->guest_email,
        'guest_phone' => $request->guest_phone,
        'special_request' => $request->special_request,
        'status' => 'pending',
      ]);

      session()->forget('hotel_booking');

      DB::commit();

      // Midtrans Configuration
      \Midtrans\Config::$serverKey = config('midtrans.serverKey');
      \Midtrans\Config::$isProduction = config('midtrans.isProduction');
      \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
      \Midtrans\Config::$is3ds = config('midtrans.is3ds');

      $params = [
        'transaction_details' => [
          'order_id' => $booking->booking_code,
          'gross_amount' => $booking->total_price,
        ],
        'customer_details' => [
          'first_name' => $booking->guest_name,
          'email' => $booking->guest_email,
          'phone' => $booking->guest_phone,
        ],
      ];

      $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

      return redirect($paymentUrl);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error("Error creating hotel booking: " . $e->getMessage());
      return redirect()->route('hotel.checkout', ['slug' => $slug])
        ->with('error', 'Failed to create booking. Please try again.')
        ->withInput();
    }
  }

  public function success(Request $request)
  {
    $booking = $this->hotelService->getBookingByCode($request->order_id);

    if (!$booking) {
      return redirect()->route('hotel.index')
        ->with('error', 'Booking not found.');
    }

    return view('front.hotel.success', compact('booking'));
  }
}
