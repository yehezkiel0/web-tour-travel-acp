<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class AdminDestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::get();
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
        $request->featured_photo->move(public_path('uploads'), $finalName);

        Destination::create([
            'featured_photo' => $finalName,
            'title' => $request->title,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'price' => $request->price,
            'date_started' => $request->date_started,
            'date_ended' => $request->date_ended,
            'type' => $request->type,
            'min_people' => $request->min_people,
            'max_people' => $request->max_people,
            'view_count' => 1,
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
                $photo->move(public_path('uploads'), $photoName);
                $destination->photos()->create([
                    'photo' => $photoName,
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
            $request->featured_photo->move(public_path('uploads'), $finalName);

            if (file_exists(public_path('uploads/' . $destination->featured_photo))) {
                unlink(public_path('uploads/' . $destination->featured_photo));
            }

            $destination->featured_photo = $finalName;
        }

        $destination->update([
            'title' => $request->title,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'price' => $request->price,
            'date_started' => $request->date_started,
            'date_ended' => $request->date_ended,
            'type' => $request->type,
            'min_people' => $request->min_people,
            'max_people' => $request->max_people,
        ]);

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
    }
}
