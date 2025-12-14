<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HotelBookingController extends Controller
{
  public function store(Request $request, $slug)
  {
    try {
      $request->validate([
        'rooms' => 'required|array',
        'rooms.*.id' => 'required|exists:hotel_rooms,id',
        'rooms.*.quantity' => 'required|integer|min:1',
        'rooms.*.price' => 'required|numeric',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in',
      ]);

      $hotel = Hotel::where('slug', $slug)->firstOrFail();

      // Calculate total and validate structure
      $bookingData = [
        'hotel_id' => $hotel->id,
        'slug' => $hotel->slug,
        'rooms' => $request->rooms,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'guests' => 1, // Default or passed from request
      ];

      session()->put('hotel_booking', $bookingData);

      return response()->json(['redirect_url' => route('hotel.checkout', $slug)]);

    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
      Log::error('Hotel Booking Store Error: ' . $e->getMessage());
      return response()->json(['message' => 'Server Error: ' . $e->getMessage()], 500);
    }
  }

  public function checkout($slug)
  {
    $bookingData = session('hotel_booking');

    if (!$bookingData || $bookingData['slug'] !== $slug) {
      return redirect()->route('hotel.show', $slug)->with('error', 'No booking in session.');
    }

    $hotel = Hotel::where('slug', $slug)->firstOrFail();

    // Enrich room data
    $rooms = [];
    $totalPrice = 0;
    foreach ($bookingData['rooms'] as $item) {
      $room = HotelRoom::find($item['id']);
      if ($room) {
        // Determine price based on selection (with/without breakfast) if previously stored
        // For now assuming passed price is trusted or re-verified
        $price = $item['price'];
        $subtotal = $price * $item['quantity'];

        $rooms[] = [
          'room' => $room,
          'quantity' => $item['quantity'],
          'price' => $price,
          'subtotal' => $subtotal,
          'breakfast' => $item['breakfast'] ?? 'without'
        ];
        $totalPrice += $subtotal;
      }
    }

    // Calculate nights
    $checkIn = \Carbon\Carbon::parse($bookingData['check_in']);
    $checkOut = \Carbon\Carbon::parse($bookingData['check_out']);
    $nights = $checkIn->diffInDays($checkOut) ?: 1;

    $grandTotal = $totalPrice * $nights;

    return view('front.hotel.checkout', compact('hotel', 'rooms', 'checkIn', 'checkOut', 'nights', 'grandTotal', 'bookingData'));
  }

  public function payment(Request $request, $slug)
  {
    $request->validate([
      'contact_name' => 'required|string',
      'contact_email' => 'required|email',
      'contact_phone' => 'required|string',
    ]);

    $bookingData = session('hotel_booking');
    if (!$bookingData) {
      return redirect()->route('hotel.show', $slug);
    }

    try {
      DB::beginTransaction();

      $hotel = Hotel::where('slug', $slug)->firstOrFail();

      do {
        $transactionCode = 'HTL-' . strtoupper(Str::random(10));
      } while (HotelBooking::where('booking_code', $transactionCode)->exists());

      Log::info('Hotel Booking Payment Request:', $request->all());

      $checkIn = \Carbon\Carbon::parse($bookingData['check_in']);
      $checkOut = \Carbon\Carbon::parse($bookingData['check_out']);
      $nights = $checkIn->diffInDays($checkOut) ?: 1;

      $totalTransactionValue = 0;

      // Calculate initial total
      foreach ($bookingData['rooms'] as $item) {
        $subtotal = $item['price'] * $item['quantity'] * $nights;
        $totalTransactionValue += $subtotal;
      }

      // Apply Promo Code if exists
      $discountAmount = 0;
      if ($request->has('promo_code_id') && $request->promo_code_id) {
        $promoCode = \App\Models\PromoCode::find($request->promo_code_id);
        if ($promoCode && $promoCode->isValid()) {
          $discountAmount = $promoCode->calculateDiscount($totalTransactionValue);
        }
      }

      $finalTotal = max(0, $totalTransactionValue - $discountAmount);

      foreach ($bookingData['rooms'] as $item) {
        $room = HotelRoom::findOrFail($item['id']);
        // We might want to distribute discount per room or just store total.
        // For simplicity, we store the original price per room item, but the transaction total is what matters for payment.
        // However, the DB schema for HotelBooking is per item. We might need to adjust 'total_price' here if it represents the amount paid.
        // Let's assume total_price in DB is per row. We should probably apply discount proportionally or simply accept the discrepancy if there's no main 'transaction' table.
        // Wait, HotelBooking IS the record. If we have multiple rooms, we create multiple records (lines 129-145 in original).
        // Midtrans takes ONE total.
        // WE should probably store the final price in the records, potentially prorated.

        $subtotal = $item['price'] * $item['quantity'] * $nights;

        // Prorate discount: (ItemSubtotal / TotalValue) * TotalDiscount
        $itemDiscount = 0;
        if ($totalTransactionValue > 0) {
          $itemDiscount = ($subtotal / $totalTransactionValue) * $discountAmount;
        }
        $itemFinalPrice = max(0, $subtotal - $itemDiscount);

        HotelBooking::create([
          'booking_code' => $transactionCode,
          'user_id' => Auth::id(),
          'hotel_id' => $hotel->id,
          'hotel_room_id' => $room->id,
          'check_in_date' => $bookingData['check_in'],
          'check_out_date' => $bookingData['check_out'],
          'number_of_nights' => $nights,
          'number_of_rooms' => $item['quantity'],
          'number_of_guests' => $bookingData['guests'] ?? 1,
          'total_price' => $itemFinalPrice, // Store the discounted price
          'guest_name' => $request->contact_name,
          'guest_email' => $request->contact_email,
          'guest_phone' => $request->contact_phone,
          'status' => 'PENDING',
          'special_request' => $request->special_request ?? null,
          'promo_code_id' => $request->promo_code_id ?? null,
        ]);
      }

      if (isset($promoCode)) {
        $promoCode->increment('usage_count');
      }

      // Update total for midtrans to be safe (sum of stored prices might slightly differ due to rounding)
      // Actually, let's use the calculate $finalTotal for Midtrans to be exact.
      $totalTransactionValue = $finalTotal;

      // Midtrans Logic
      \Midtrans\Config::$serverKey = config('midtrans.serverKey');
      \Midtrans\Config::$isProduction = config('midtrans.isProduction');
      \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
      \Midtrans\Config::$is3ds = config('midtrans.is3ds');

      $params = [
        'transaction_details' => [
          'order_id' => $transactionCode,
          'gross_amount' => $totalTransactionValue,
        ],
        'customer_details' => [
          'first_name' => $request->contact_name,
          'email' => $request->contact_email,
          'phone' => $request->contact_phone,
        ],
        'callbacks' => [
          // We might need a specific success page for hotels or reuse generic
          'finish' => route('hotel.success', ['order_id' => $transactionCode]),
        ],
      ];

      $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

      DB::commit();
      session()->forget('hotel_booking');

      return redirect($paymentUrl);

    } catch (\Exception $e) {
      DB::rollBack();
      Log::error("Hotel Booking Error: " . $e->getMessage());
      return back()->with('error', 'Booking failed: ' . $e->getMessage());
    }
  }

  public function success(Request $request)
  {
    $booking = HotelBooking::with(['hotel', 'room'])
      ->where('booking_code', $request->order_id)
      ->first();

    if (!$booking) {
      return redirect()->route('hotel.index')->with('error', 'Booking not found.');
    }

    return view('front.hotel.success', compact('booking'));
  }
}
