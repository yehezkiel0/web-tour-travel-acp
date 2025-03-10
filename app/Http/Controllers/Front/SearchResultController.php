<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Str;

class SearchResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::query();
        $maxPrice = Destination::max('price');

        if ($request->filled('type')) {
            $databaseType = Str::title(str_replace('-', ' ', $request->type));
            $query->where('type', $databaseType);
        }

        $results = $query->get()->each(function ($result) {
            $result->description_result = $result->description;
            $result->duration = calculateDuration($result->date_started, $result->date_ended);
        });

        return view('front.destination.search-filter', compact('results', 'maxPrice'));
    }

    public function searchResult(Request $request)
    {
        $request->validate([
            'destination_input' => 'nullable|string|max:255',
            'destination_date' => 'nullable|date',
            'destination_type' => 'nullable|string'
        ]);

        $query = Destination::query();
        $maxPrice = Destination::max('price');

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
            $result->description_result = $result->description;
            $result->duration = calculateDuration($result->date_started, $result->date_ended);
        });

        $request->replace([]);

        return view('front.destination.search-filter', compact('results', 'maxPrice'));
    }

    public function filterSearch(Request $request)
    {
        $request->validate([
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'price_range' => 'nullable|numeric',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'trip_type' => 'nullable|array'
        ]);
        $query = Destination::query();

        if ($request->filled(['min_price', 'max_price'])) {
            $minPrice = (int) $request->min_price;
            $maxPrice = (int) $request->max_price;
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($request->filled('price_range')) {
            $priceRange = (int) $request->price_range;
            $query->where('price', '>=', $priceRange);
        }

        if ($request->filled('location') && $request->location !== '') {
            $query->where('city', $request->location);
        }

        if ($request->filled('date') && $request->date !== '') {
            $query->whereDate('date_started', $request->date);
        }

        if ($request->filled('trip_type') && is_array($request->trip_type) && count($request->trip_type) > 0) {
            $query->whereIn('type', $request->trip_type);
        }

        $results = $query->get()->each(function ($result) {
            $result->description_result = $result->description;
            $result->duration = calculateDuration($result->date_started, $result->date_ended);
        });

        return view('front.partials.search-result', compact('results'));
    }
}
