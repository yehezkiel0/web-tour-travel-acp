<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\BlogPost;

class LandingPageController extends Controller
{
    public function home()
    {
        $popularDestinations = Destination::orderBy('view_count', 'desc')->take(10)->get();
        $openTrips = Destination::where('type', 'Open Trip')->take(8)->get();
        $privateTrips = Destination::where('type', 'Private Trip')->take(4)->get();
        $latestBlogs = BlogPost::where('is_published', true)->latest()->take(3)->get();

        return view('front.home', compact('popularDestinations', 'openTrips', 'privateTrips', 'latestBlogs'));
    }

    public function destination_detail($slug)
    {
        $destination = Destination::where('slug', $slug)->with('photos', 'destination_detail')->first();

        $destination->duration = calculateDuration($destination->date_started, $destination->date_ended);

        $destination_photos = $destination->photos;
        $itineraries = json_decode($destination->destination_detail->itinerary, true);

        if (is_array($itineraries)) {
            usort($itineraries, function ($a, $b) {
                return ($a['day'] ?? 0) <=> ($b['day'] ?? 0);
            });
        }

        $userItineraries = [];
        if (auth()->check()) {
            $userItineraries = auth()->user()->itineraries()->orderBy('created_at', 'desc')->get();
        }

        return view('front.destination.destination-detail', compact('destination', 'destination_photos', 'itineraries', 'userItineraries'));
    }

    public function servicesMedical()
    {
        $data = include resource_path('views/front/data/medical.php');
        $features = $data['medical'];
        $testimonials = \App\Models\ServiceTestimonial::where('service_type', 'medical')
            ->where('is_approved', true)
            ->latest()
            ->get();
        return view('front.our-services.medical', compact('features', 'testimonials'));
    }

    public function servicesRecruitment()
    {
        $testimonials = \App\Models\ServiceTestimonial::where('service_type', 'recruitment')
            ->where('is_approved', true)
            ->latest()
            ->get();
        return view('front.our-services.recruitment', compact('testimonials'));
    }

    public function servicesEntertainment()
    {
        $testimonials = \App\Models\ServiceTestimonial::where('service_type', 'entertainment')
            ->where('is_approved', true)
            ->latest()
            ->get();
        return view('front.our-services.entertainment', compact('testimonials'));
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }
}
