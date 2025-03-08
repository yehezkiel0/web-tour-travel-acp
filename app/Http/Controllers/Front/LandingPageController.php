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
        $privateTrips = Destination::where('type', 'Private Trip')->take(6)->get();

        return view('front.home', compact('popularDestinations', 'openTrips', 'privateTrips'));
    }

    public function destination_detail($slug)
    {
        $destination = Destination::where('slug', $slug)->with('photos', 'destination_detail')->first();

        $destination->duration = calculateDuration($destination->date_started, $destination->date_ended);

        $destination_photos = $destination->photos;
        $itineraries = json_decode($destination->destination_detail->itinerary);


        return view('front.destination.destination-detail', compact('destination', 'destination_photos', 'itineraries'));
    }

    public function servicesMedical()
    {
        $data = include resource_path('views/front/data/medical.php');
        $features = $data['medical'];
        return view('front.our-services.medical', compact('features'));
    }

    public function servicesRecruitment()
    {
        return view('front.our-services.recruitment');
    }
}