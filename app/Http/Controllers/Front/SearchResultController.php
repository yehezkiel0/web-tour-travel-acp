<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Str;

class SearchResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::query();

        // 1. Keyword Search (Title or Description)
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });
        }

        // 2. Location (City)
        if ($request->filled('location')) {
            $query->where('city', $request->location);
        }

        // 3. Date
        if ($request->filled('date')) {
            $query->whereDate('date_started', $request->date);
        }

        // 4. Trip Type (Array)
        if ($request->filled('trip_type')) {
            // Explode if it's a comma-separated string (from URL) or use as array
            $types = is_array($request->trip_type) ? $request->trip_type : explode(',', $request->trip_type);
            $query->whereIn('type', $types);
        }

        // 5. Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        // 6. Duration
        if ($request->filled('duration')) {
            $duration = $request->duration;
            if ($duration == '1-3') {
                $query->whereRaw('DATEDIFF(date_ended, date_started) + 1 BETWEEN 1 AND 3');
            } elseif ($duration == '4-7') {
                $query->whereRaw('DATEDIFF(date_ended, date_started) + 1 BETWEEN 4 AND 7');
            } elseif ($duration == '8+') {
                $query->whereRaw('DATEDIFF(date_ended, date_started) + 1 >= 8');
            }
        }

        // 7. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'popularity':
                    $query->orderBy('view_count', 'desc');
                    break;
                case 'rating':
                    $query->withCount([
                        'reviews as avg_rating' => function ($q) {
                            $q->select(DB::raw('coalesce(avg(rating),0)'));
                        }
                    ])->orderByDesc('avg_rating');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        // Execute Query
        $results = $query->paginate(5);

        // Transform the collection to add calculated properties
        $results->getCollection()->transform(function ($result) {
            $result->description_result = $result->description;
            $result->duration = calculateDuration($result->date_started, $result->date_ended);
            return $result;
        });

        // 8. Return Response
        // If AJAX, return strictly the partial view
        if ($request->ajax()) {
            return view('front.partials.search-result', compact('results'));
        }

        // Metadata for Filters
        $maxPrice = Destination::max('price');
        $cities = Destination::select('city')->distinct()->orderBy('city')->pluck('city');

        return view('front.destination.search-filter', compact('results', 'maxPrice', 'cities'));
    }
}
