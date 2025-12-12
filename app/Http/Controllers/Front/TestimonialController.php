<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ServiceTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'service_type' => 'required|in:medical,recruitment,entertainment',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('testimonials', 'public');
            $validated['photo'] = $photoPath;
        }

        // Add user_id if logged in
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        // Set default rating if not provided
        $validated['rating'] = $validated['rating'] ?? 5;

        // Auto-approve testimonial for immediate display
        $validated['is_approved'] = true;

        // Create testimonial
        ServiceTestimonial::create($validated);

        return redirect()->back()->with('success', 'Thank you for your testimonial! Your experience has been shared successfully.');
    }

    public function getApproved($serviceType)
    {
        $testimonials = ServiceTestimonial::where('service_type', $serviceType)
            ->where('is_approved', true)
            ->latest()
            ->get();

        return response()->json($testimonials);
    }
}

