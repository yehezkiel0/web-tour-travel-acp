<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Itinerary;
use App\Models\ItineraryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ItineraryController extends Controller
{
  public function index()
  {
    $itineraries = Auth::user()->itineraries()->orderBy('created_at', 'desc')->get();
    return view('front.itinerary.index', compact('itineraries'));
  }

  public function create()
  {
    return view('front.itinerary.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'start_date' => 'nullable|date',
      'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    $itinerary = Auth::user()->itineraries()->create([
      'name' => $request->name,
      'description' => $request->description,
      'start_date' => $request->start_date,
      'end_date' => $request->end_date,
      'share_token' => Str::random(32),
    ]);

    return redirect()->route('itineraries.show', $itinerary->id)->with('success', 'Itinerary created successfully!');
  }

  public function show($id)
  {
    $itinerary = Auth::user()->itineraries()->with([
      'items.destination',
      'items' => function ($query) {
        $query->orderBy('order', 'asc');
      }
    ])->findOrFail($id);

    return view('front.itinerary.show', compact('itinerary'));
  }

  public function addItem(Request $request)
  {
    $request->validate([
      'itinerary_id' => 'required|exists:itineraries,id',
      'destination_id' => 'required|exists:destinations,id',
    ]);

    $itinerary = Auth::user()->itineraries()->findOrFail($request->itinerary_id);

    // Check if item already exists to avoid duplicates if needed, or allow multiple
    // For now, allow multiple visits? Maybe unique per day? Let's just append.

    $maxOrder = $itinerary->items()->max('order') ?? 0;

    $itinerary->items()->create([
      'destination_id' => $request->destination_id,
      'order' => $maxOrder + 1,
    ]);

    return response()->json(['message' => 'Destination added to itinerary!', 'status' => 'success']);
  }

  public function removeItem($id)
  {
    $item = ItineraryItem::whereHas('itinerary', function ($q) {
      $q->where('user_id', Auth::id());
    })->findOrFail($id);

    $item->delete();

    return response()->json(['message' => 'Item removed from itinerary', 'status' => 'success']);
  }

  public function updateOrder(Request $request)
  {
    $request->validate([
      'items' => 'required|array', // Array of {id: item_id, order: new_order}
    ]);

    foreach ($request->items as $itemData) {
      // Verify ownership
      $item = ItineraryItem::whereHas('itinerary', function ($q) {
        $q->where('user_id', Auth::id());
      })->find($itemData['id']);

      if ($item) {
        $item->update(['order' => $itemData['order']]);
      }
    }

    return response()->json(['message' => 'Order updated successfully', 'status' => 'success']);
  }
  public function shared($token)
  {
    $itinerary = Itinerary::where('share_token', $token)->with([
      'items.destination',
      'items' => function ($query) {
        $query->orderBy('order', 'asc');
      }
    ])->firstOrFail();

    return view('front.itinerary.show', compact('itinerary'));
  }
}
