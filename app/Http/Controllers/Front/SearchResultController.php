<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mews\Purifier\Facades\Purifier;

class SearchResultController extends Controller
{
    public function searchResult(Request $request)
    {
        // Tambahkan validasi
        $validated = $request->validate([
            'destination_input' => 'nullable|string|max:255',
            'destination_date' => 'nullable|date',
            'destination_type' => 'nullable|string|'
        ]);

        $query = Destination::query();

        if ($request->filled('destination_input')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->destination_input . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->destination_input . '%');
            });
        }

        if ($request->filled('destination_date')) {
            $query->whereDate('date_started', $request->destination_date);
        }

        if ($request->filled('destination_type')) {
            $query->where('type', $request->destination_type);
        }

        $results = $query->get()->each(function ($result) {
            $result->description_result = Purifier::clean($result->description, [
                'HTML.Allowed' => 'strong,em,ul,ol,li,p,br'
            ]);
            $result->duration = Carbon::parse($result->date_started)->diffInDays(Carbon::parse($result->date_ended)) . ' days';
        });

        return view('front.search-filter', compact('results'));
    }

    public function filterSearch(Request $request)
    {
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
        $location = $request->input('location');
        $date = $request->input('date');
        $trip_type = $request->input('tripType', []);

        $query = Destination::query();

        // Price filter
        if ($price_min && $price_max) {
            $query->whereBetween('price', [$price_min, $price_max]);
        }
        // Date filter
        if (!empty($date)) {
            $query->whereDate('date_started', $date);
        }

        if (!empty($trip_type)) {
            $query->whereIn('type', $trip_type);
        }

        $results = $query->get()->each(function ($result) {
            $result->description_result = Purifier::clean($result->description);
            $result->duration = Carbon::parse($result->date_started)->diffInDays(Carbon::parse($result->date_ended)) . ' days';
        });

        return view('front.partials.search-result', compact('results'));
    }
}
