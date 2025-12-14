<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class DestinationService
{
  public function store(array $data, Request $request): Destination
  {
    return DB::transaction(function () use ($data, $request) {
      if ($request->hasFile('featured_photo')) {
        $finalName = 'destination_featured_' . time() . '.' . $request->featured_photo->extension();
        $data['featured_photo'] = $request->file('featured_photo')->storeAs('destinations', $finalName, 'public');
      }

      if ($request->hasFile('virtual_tour_images')) {
        $data['virtual_tour_images'] = $this->uploadVirtualTourImages($request);
      }

      $data['view_count'] = 1;

      return Destination::create($data);
    });
  }

  public function update(Destination $destination, array $data, Request $request): Destination
  {
    return DB::transaction(function () use ($destination, $data, $request) {
      if ($request->hasFile('featured_photo')) {
        if ($destination->featured_photo && Storage::disk('public')->exists($destination->featured_photo)) {
          Storage::disk('public')->delete($destination->featured_photo);
        }

        $finalName = 'destination_featured_' . time() . '.' . $request->featured_photo->extension();
        $data['featured_photo'] = $request->file('featured_photo')->storeAs('destinations', $finalName, 'public');
      }

      if ($request->hasFile('virtual_tour_images')) {
        $existingImages = $destination->virtual_tour_images ?? [];
        $newImages = $this->uploadVirtualTourImages($request);
        $data['virtual_tour_images'] = array_merge($existingImages, $newImages);
      }

      $destination->update($data);

      return $destination;
    });
  }

  public function delete(Destination $destination): ?bool
  {
    return DB::transaction(function () use ($destination) {
      if ($destination->photos()->exists()) {
        foreach ($destination->photos as $photo) {
          if (Storage::disk('public')->exists('destination_photos/' . basename($photo->photo))) {
            Storage::disk('public')->delete('destination_photos/' . basename($photo->photo));
          }
          if (Storage::disk('public')->exists('destination_photos/' . basename($photo->photo))) {
            Storage::disk('public')->delete('destination_photos/' . basename($photo->photo));
          }
          if (file_exists(public_path('uploads/' . $photo->photo))) {
            unlink(public_path('uploads/' . $photo->photo));
          }
        }
      }

      if ($destination->featured_photo && Storage::disk('public')->exists($destination->featured_photo)) {
        Storage::disk('public')->delete($destination->featured_photo);
      }
      if (file_exists(public_path('uploads/' . $destination->featured_photo))) {
        unlink(public_path('uploads/' . $destination->featured_photo));
      }

      return $destination->delete();
    });
  }

  public function addPhotos(Destination $destination, Request $request): void
  {
    if ($request->hasFile('photos')) {
      foreach ($request->file('photos') as $photo) {
        $photoName = 'destination_photo_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
        $path = $photo->storeAs('destination_photos', $photoName, 'public');
        $destination->photos()->create([
          'photo' => $path,
        ]);
      }
    }
  }

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
