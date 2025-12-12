<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function edit()
  {
    $user = Auth::user();
    return view('front.profile.edit', compact('user'));
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'phone' => 'nullable|string|max:20',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'current_password' => 'nullable|required_with:new_password',
      'new_password' => 'nullable|min:8|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('photo')) {
      // Delete old photo if exists
      if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        Storage::disk('public')->delete($user->photo);
      }
      $user->photo = $request->file('photo')->store('users', 'public');
    }

    // Update password if provided
    if ($request->filled('current_password')) {
      if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Current password is incorrect');
      }
      $user->password = Hash::make($request->new_password);
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully!');
  }

  public function bookings()
  {
    $user = Auth::user();

    // Get destination bookings
    $destinationBookings = BookingTransaction::where('user_id', $user->id)
      ->with('destination')
      ->orderBy('created_at', 'desc')
      ->get();

    // Get hotel bookings
    $hotelBookings = HotelBooking::where('user_id', $user->id)
      ->with(['hotel', 'room'])
      ->orderBy('created_at', 'desc')
      ->get();

    return view('front.profile.bookings', compact('destinationBookings', 'hotelBookings'));
  }

  public function bookingDetail($code)
  {
    $user = Auth::user();

    // Try to find destination booking
    $booking = BookingTransaction::where('code', $code)
      ->where('user_id', $user->id)
      ->with('destination')
      ->first();

    if ($booking) {
      return view('front.profile.booking-detail', compact('booking'));
    }

    // Try to find hotel booking
    $hotelBooking = HotelBooking::where('booking_code', $code)
      ->where('user_id', $user->id)
      ->with(['hotel', 'room'])
      ->first();

    if ($hotelBooking) {
      return view('front.profile.hotel-booking-detail', compact('hotelBooking'));
    }

    abort(404, 'Booking not found');
  }
}