<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::with('destination_detail');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        // Filter by country
        if ($request->has('country') && $request->country != '') {
            $query->where('country', $request->country);
        }

        $destinations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.destination.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destination.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:destinations',
            'description' => 'required',
            'featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $finalName = 'destination_featured_' . time() . '.' . $request->featured_photo->extension();
        $path = $request->file('featured_photo')->storeAs('destinations', $finalName, 'public');

        Destination::create([
            'featured_photo' => $path,
            'title' => $request->title,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price' => $request->price,
            'date_started' => $request->date_started,
            'date_ended' => $request->date_ended,
            'type' => $request->type,
            'min_people' => $request->min_people,
            'max_people' => $request->max_people,
            'view_count' => 1,
            'virtual_tour_images' => $this->uploadVirtualTourImages($request),
        ]);

        return redirect()
            ->route('admin_destination_index')
            ->with('success', 'Destination created successfully!')
            ->setStatusCode(201);
    }

    public function photos($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        return view('admin.destination.photos', compact('destination'));
    }

    public function photos_store(Request $request, $slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoName = 'destination_photo_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('destination_photos', $photoName, 'public');
                $destination->photos()->create([
                    'photo' => $path,
                ]);
            }
        }

        return redirect()
            ->route('destination_photos', $destination->slug)
            ->with('success', 'Photo added successfully!')
            ->setStatusCode(201);
    }

    public function edit($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();

        return view('admin.destination.update', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $request->validate([
            'title' => 'required|unique:destinations,title,' . $destination->id,
            'description' => 'required',
        ]);

        if ($request->hasFile('featured_photo')) {
            $request->validate([
                'featured_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);

            $finalName = 'destination_featured_' . time() . '.' . $request->featured_photo->extension();
            $path = $request->file('featured_photo')->storeAs('destinations', $finalName, 'public');

            if ($destination->featured_photo && Storage::disk('public')->exists($destination->featured_photo)) {
                Storage::disk('public')->delete($destination->featured_photo);
            }

            $destination->featured_photo = $path;
        }

        $destination->update([
            'title' => $request->title,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price' => $request->price,
            'date_started' => $request->date_started,
            'date_ended' => $request->date_ended,
            'type' => $request->type,
            'min_people' => $request->min_people,
            'max_people' => $request->max_people,
        ]);

        if ($request->hasFile('virtual_tour_images')) {
            $existingImages = $destination->virtual_tour_images ?? [];
            $newImages = $this->uploadVirtualTourImages($request);
            $destination->update([
                'virtual_tour_images' => array_merge($existingImages, $newImages)
            ]);
        }

        return response()
            ->redirectToRoute('admin_destination_index')
            ->with('success', 'Destination updated successfully!')
            ->setStatusCode(200);
    }

    public function delete($id)
    {
        $destination = Destination::findOrFail($id);
        if ($destination->photos()->exists()) {
            foreach ($destination->photos as $photo) {
                // Hapus file foto di server
                if (file_exists(public_path('uploads/' . $photo->photo))) {
                    unlink(public_path('uploads/' . $photo->photo));
                }
            }
        }
        if (file_exists(public_path('uploads/' . $destination->featured_photo))) {
            unlink(public_path('uploads/' . $destination->featured_photo));
        }
        $destination->delete();
        return response()
            ->redirectToRoute('admin_destination_index')
            ->with('success', 'Destination deleted successfully!')
            ->setStatusCode(200);
    } // Corrected closing brace for method delete

    private function uploadVirtualTourImages(Request $request): array
    {
        $paths = [];
        if ($request->hasFile('virtual_tour_images')) {
            foreach ($request->file('virtual_tour_images') as $image) {
                $name = 'virtual_tour_' . time() . '_' . uniqid() . '.' . $image->extension();
                $paths[] = $image->storeAs('virtual_tours', $name, 'public');
            }
        }
        return $paths;
    }
}
