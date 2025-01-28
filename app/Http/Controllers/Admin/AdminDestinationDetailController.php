<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class AdminDestinationDetailController extends Controller
{
  public function details($slug)
  {
    $destination_details = Destination::where('slug', $slug)->firstOrFail();
    return view('admin.destination-details.create', compact('destination_details'));
  }

  public function details_store(Request $request, $slug)
  {
    $destination = Destination::where('slug', $slug)->firstOrFail();

    $validated = $request->validate([
      'destination_id' => 'required|exists:destinations,id',
      'itinerary' => 'required|json',
      'arrival' => 'nullable|string',
      'departure' => 'nullable|string',
      'tnc' => 'nullable|string',
      'include' => 'nullable|string',
      'exclude' => 'nullable|string',
      'nearby_hotel' => 'nullable|string|max:255',
      'map_url' => 'nullable'
    ]);

    $destination->destination_detail()->create($validated);

    return redirect()
      ->route('admin_destination_index')
      ->with('success', 'Destination details created successfully')
      ->setStatusCode(201);
  }
}
