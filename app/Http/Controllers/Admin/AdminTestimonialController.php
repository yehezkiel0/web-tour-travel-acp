<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTestimonialController extends Controller
{
    public function index(Request $request)
    {
        $serviceType = $request->get('service_type', '');
        $status = $request->get('status', '');

        $query = ServiceTestimonial::with('user')->latest();

        if ($serviceType) {
            $query->where('service_type', $serviceType);
        }

        if ($status === 'approved') {
            $query->where('is_approved', true);
        } elseif ($status === 'pending') {
            $query->where('is_approved', false);
        }

        $testimonials = $query->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approve($id)
    {
        $testimonial = ServiceTestimonial::findOrFail($id);
        $testimonial->is_approved = true;
        $testimonial->save();

        return redirect()->back()->with('success', 'Testimonial approved successfully!');
    }

    public function unapprove($id)
    {
        $testimonial = ServiceTestimonial::findOrFail($id);
        $testimonial->is_approved = false;
        $testimonial->save();

        return redirect()->back()->with('success', 'Testimonial unapproved successfully!');
    }

    public function destroy($id)
    {
        $testimonial = ServiceTestimonial::findOrFail($id);

        // Delete photo if exists
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully!');
    }
}

