<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function home()
    {
        $popularDestinations = Destination::orderBy('view_count', 'desc')->take(10)->get();
        $openTrips = Destination::where('type', 'Open Trip')->take(8)->get();
        foreach ($openTrips as $trip) {
            $trip->formatted_start_date = Carbon::parse($trip->date_started)->format('d F');
            $trip->formatted_end_date = Carbon::parse($trip->date_ended)->format('d F');
        }
        $privateTrips = Destination::where('type', 'Private Trip')->take(6)->get();

        return view('front.home', compact('popularDestinations', 'openTrips', 'privateTrips'));
    }

    public function destination_detail($slug)
    {
        $destination = Destination::where('slug', $slug)->with('photos')->first();

        $destination_photos = $destination->photos;

        return view('front.destination-detail', compact('destination', 'destination_photos'));
    }
}
