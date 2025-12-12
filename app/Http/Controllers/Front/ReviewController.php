<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DestinationReview;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, $destinationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string|max:1000',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $photos[] = $path;
            }
        }

        // Check if user has booked this destination
        $booking = User::find(Auth::id())->bookingTransactions()
            ->where('destination_id', $destinationId)
            ->where('status', 'paid')
            ->first();

        DestinationReview::create([
            'user_id' => Auth::id(),
            'destination_id' => $destinationId,
            'booking_transaction_id' => $booking?->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'review' => $request->review,
            'photos' => $photos,
            'is_verified' => $booking ? true : false,
            'is_approved' => true,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function getReviews($destinationId)
    {
        $reviews = DestinationReview::where('destination_id', $destinationId)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->get();

        return response()->json($reviews);
    }

    public function markHelpful($reviewId)
    {
        $review = DestinationReview::findOrFail($reviewId);
        $review->increment('helpful_count');

        return response()->json(['success' => true, 'count' => $review->helpful_count]);
    }
}