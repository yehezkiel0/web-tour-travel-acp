<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use Illuminate\Http\Request;

class AdminHotelBookingController extends Controller
{
  public function index(Request $request)
  {
    $query = HotelBooking::with(['hotel', 'room', 'user'])
      ->orderBy('created_at', 'desc');

    // Filter by status
    if ($request->has('status') && $request->status != '') {
      $query->where('status', $request->status);
    }

    // Search by booking code
    if ($request->has('search') && $request->search != '') {
      $query->where('booking_code', 'like', '%' . $request->search . '%');
    }

    // Filter by date range
    if ($request->has('from_date') && $request->from_date != '') {
      $query->whereDate('check_in_date', '>=', $request->from_date);
    }

    if ($request->has('to_date') && $request->to_date != '') {
      $query->whereDate('check_out_date', '<=', $request->to_date);
    }

    $bookings = $query->paginate(15);

    // Statistics
    $stats = [
      'total' => HotelBooking::count(),
      'pending' => HotelBooking::where('status', 'pending')->count(),
      'confirmed' => HotelBooking::where('status', 'confirmed')->count(),
      'cancelled' => HotelBooking::where('status', 'cancelled')->count(),
      'completed' => HotelBooking::where('status', 'completed')->count(),
      'total_revenue' => HotelBooking::whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
    ];

    return view('admin.hotel.bookings', compact('bookings', 'stats'));
  }

  public function show($id)
  {
    $booking = HotelBooking::with(['hotel', 'room', 'user'])->findOrFail($id);
    return view('admin.hotel.booking-detail', compact('booking'));
  }

  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|in:pending,confirmed,cancelled,completed',
    ]);

    $booking = HotelBooking::findOrFail($id);
    $booking->status = $request->status;
    $booking->save();

    return redirect()->back()->with('success', 'Booking status updated successfully!');
  }

  public function delete($id)
  {
    $booking = HotelBooking::findOrFail($id);
    $booking->delete();

    return redirect()->route('admin_hotel_bookings')->with('success', 'Booking deleted successfully!');
  }
}
