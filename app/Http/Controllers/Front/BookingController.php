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

        $adult_price = ($destination_price * $request->adult_count);
        $child_price =  ($destination_price * 0.5 * $request->child_count);

        session()->put('booking', [
            'slug' => $slug,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'adult_count' => $request->adult_count,
            'child_count' => $request->child_count,
            'adult_price' => $adult_price,
            'child_price' => $child_price,
        ]);

        return redirect()->route('booking_show_detail', ['slug' => $slug]);
    }

    public function showBookingDetails($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();

        $bookingData = session('booking');

        if (!$bookingData) {
            return redirect()->route('destination_detail', ['slug' => $slug])->with('error', 'Booking data not found.');
        }

        return view('front.booking', compact('bookingData', 'destination'));
    }
}
