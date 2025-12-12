<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationReview;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = DestinationReview::with(['user', 'destination']);

        if ($request->filled('status')) {
            $isApproved = $request->status === 'approved';
            $query->where('is_approved', $isApproved);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = DestinationReview::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    public function unapprove($id)
    {
        $review = DestinationReview::findOrFail($id);
        $review->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Review unapproved successfully!');
    }

    public function destroy($id)
    {
        $review = DestinationReview::findOrFail($id);

        // Delete photos
        if ($review->photos) {
            foreach ($review->photos as $photo) {
                \Storage::disk('public')->delete($photo);
            }
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
