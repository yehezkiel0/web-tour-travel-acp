<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function storeBookingDetails(Request $request, $slug)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'adult_count' => 'required|integer|min:1',
            'child_count' => 'required|integer|min:0',
        ]);

        $destination_price = Destination::where('slug', $slug)->value('price');

        if (!$destination_price) {
            return redirect()->route('destination_detail')->with('error', 'Destination not found.');
        }

        $total_price = ($destination_price * $request->adult_count) + ($destination_price * 0.5 * $request->child_count);

        session()->put('booking', [
            'slug' => $slug,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'adult_count' => $request->adult_count,
            'child_count' => $request->child_count,
            'total_price' => $total_price,
        ]);

        return redirect()->route('booking_show_detail', ['slug' => $slug]);
    }

    public function showBookingDetails($slug)
    {
        $bookingData = session('booking');
        dd($bookingData);
        if (!$bookingData) {
            return redirect()->route('destination_detail', ['slug' => $slug])->with('error', 'Booking data not found.');
        }

        return view('front.booking', compact('bookingData'));
    }
}
