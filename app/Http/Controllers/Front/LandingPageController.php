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

        $destination->duration = Carbon::parse($destination->date_started)->diffInDays($destination->date_ended);

        $destination_photos = $destination->photos;

        $itineraries = [
            [
                'title' => 'Manjanggul Cave, 182, Manjanggul-gil, Jeju, Jeju Island',
                'description' => "The World's Largest Known Lava Tube Formed By Volcanic Activity. Features Include A Unique Underground Landscape And The Stone Turtle Resembling Jeju Island.",
                'alternative' => 'Alternative: Jeju Haenyeo Museum (If Closed On The First Wednesday Of Each Month).'
            ],
            [
                'title' => 'Seongsan Ilchulbong',
                'description' => 'UNESCO Heritage, Situated on the eastern seaboard of Jeju island and said to resemble a gigantic ancient castle, This tuff cone is 182 meters High, has a preserved bowl-like Crater, and also displays diverse inner structures resulting from the sea cliff.'
            ],
            [
                'title' => 'Seopjikoji',
                'description' => 'Seopjikoji Is Located At The End Of The Eastern Shore Of Jeju Island And Boasts Fantastic Scenery, Especially In April When Yellow Canola Flowers Are In Full Bloom.'
            ],
            [
                'title' => 'Sangumburi Crater',
                'description' => 'Recommended for October and November. The best time to visit is October and November'
            ]
        ];

        return view('front.destination-detail', compact('destination', 'destination_photos', 'itineraries'));
    }
}
