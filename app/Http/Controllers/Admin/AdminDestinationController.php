<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Services\DestinationService;
use Illuminate\Http\Request;

class AdminDestinationController extends Controller
{
    protected $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    public function index(Request $request)
    {
        $query = Destination::with('destination_detail');


        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }


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

        $this->destinationService->store($request->all(), $request);

        return redirect()
            ->route('admin.destinations.index')
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

        $this->destinationService->addPhotos($destination, $request);

        return redirect()
            ->route('admin.destinations.photos', $destination->slug)
            ->with('success', 'Photo added successfully!')
            ->setStatusCode(201);
    }

    public function edit($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();

        return view('admin.destination.edit', compact('destination'));
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
        }

        $this->destinationService->update($destination, $request->all(), $request);

        return response()
            ->redirectToRoute('admin.destinations.index')
            ->with('success', 'Destination updated successfully!')
            ->setStatusCode(200);
    }

    public function delete($id)
    {
        $destination = Destination::findOrFail($id);

        $this->destinationService->delete($destination);

        return response()
            ->redirectToRoute('admin.destinations.index')
            ->with('success', 'Destination deleted successfully!')
            ->setStatusCode(200);
    }
}
