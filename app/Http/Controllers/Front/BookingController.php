<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use App\Models\Destination;
use App\Models\PricingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function saveInformation(Request $request, $slug)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'adult_count' => 'required|integer|min:1',
            'child_count' => 'required|integer|min:0',
        ]);

        $pricing_settings = PricingSetting::latest()->first();
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
            'individual_visa_rate' => $pricing_settings->individual_visa_rate,
            'group_visa_rate' => $pricing_settings->group_visa_rate,
            'tax_percentage' => $pricing_settings->tax_percentage,
        ]);

        return redirect()->route('booking_details', ['slug' => $slug]);
    }

    public function booking($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();

        $bookingData = session('booking');


        if (!$bookingData) {
            return redirect()->route('destination_detail', ['slug' => $slug])->with('error', 'Booking data not found.');
        }

        return view('front.booking', compact('bookingData', 'destination'));
    }

    public function storeBooking(Request $request, $slug)
    {
        $request->validate([
            'travellers' => 'required|array',
            'travellers.*' => 'required|array',
            'travellers.*.title' => 'required|in:Mr.,Mrs.,Ms.',
            'travellers.*.first_name' => 'required|string|max:255',
            'travellers.*.last_name' => 'required|string|max:255',
            'travellers.*.age' => 'required|integer|min:1',
            'travellers.*.nationality' => 'required|string|max:255',
            'travellers.*.passport_number' => 'required|regex:/^[A-Z0-9]{8,9}$/i',
            'travellers.*.passport_expiry' => 'required|date|after:today',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        $bookingData = session('booking');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'Booking session expired. Please try again.');
        }

        $totalTravelers = count($request->travellers);
        $expectedTravelers = $bookingData['adult_count'] + $bookingData['child_count'];
        if ($totalTravelers !== $expectedTravelers) {
            return back()->with('error', 'Number of travelers does not match the booking details.');
        }

        session()->put('booking.travellers', $request->travellers);
        session()->put('booking.contact_phone', $request->contact_phone);
        session()->put('booking.contact_email', $request->contact_email);
        session()->put('booking.total_price', $request->total_price);
        session()->put('booking.notes', $request->notes);

        return redirect()->route('booking_checkout', ['slug' => $slug]);
    }

    public function checkout($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        $bookingData = session('booking');

        if (!$bookingData) {
            return redirect()->route('destination_detail', ['slug' => $slug])->with('error', 'Booking data not found.');
        }

        $travellers = $bookingData['travellers'] ?? [];

        return view('front.checkout', compact('bookingData', 'destination', 'travellers'));
    }

    public function payment($slug)
    {
        $bookingData = session('booking');
        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'Booking session expired. Please try again.');
        }

        try {
            DB::beginTransaction();

            $destination = Destination::where('slug', $slug)->firstOrFail();

            $booking = BookingTransaction::create([
                'user_id' => Auth::user()->id,
                'destination_id' => $destination->id,
                'from_date' => $bookingData['from_date'],
                'to_date' => $bookingData['to_date'],
                'adult_count' => $bookingData['adult_count'],
                'child_count' => $bookingData['child_count'],
                'total_price' => $bookingData['total_price'],
                'traveller_details' => json_encode($bookingData['travellers']),
                'contact_phone' => $bookingData['contact_phone'],
                'contact_email' => $bookingData['contact_email'],
                'notes' => $bookingData['notes'],
                'status' => 'pending'
            ]);

            session()->forget('booking');

            DB::commit();

            dd($booking);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error creating booking: " . $e->getMessage());
            return redirect()->route('booking_details')->with('error', 'Failed to create booking. Please try again.')->withInput();
        }
    }
}
