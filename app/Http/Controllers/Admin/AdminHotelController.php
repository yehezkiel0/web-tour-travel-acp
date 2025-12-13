<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelAmenity;
use App\Models\HotelRoom;
use App\Models\HotelPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminHotelController extends Controller
{
  public function index(Request $request)
  {
    $query = Hotel::withCount(['rooms', 'bookings', 'amenities']);

    // Search functionality
    if ($request->has('search') && $request->search != '') {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('city', 'like', '%' . $search . '%')
          ->orWhere('country', 'like', '%' . $search . '%')
          ->orWhere('slug', 'like', '%' . $search . '%');
      });
    }

    // Filter by status
    if ($request->has('status') && $request->status != '') {
      $query->where('is_active', $request->status);
    }

    // Filter by star rating
    if ($request->has('rating') && $request->rating != '') {
      $query->where('star_rating', $request->rating);
    }

    $hotels = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.hotel.index', compact('hotels'));
  }

  public function create()
  {
    return view('admin.hotel.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'country' => 'required|string|max:255',
      'city' => 'required|string|max:255',
      'address' => 'required|string',
      'star_rating' => 'required|integer|min:1|max:5',
      'featured_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
      'latitude' => 'nullable|numeric',
      'longitude' => 'nullable|numeric',
    ]);

    $hotel = new Hotel();
    $hotel->name = $request->name;
    $hotel->slug = Str::slug($request->name);
    $hotel->description = $request->description;
    $hotel->country = $request->country;
    $hotel->city = $request->city;
    $hotel->address = $request->address;
    $hotel->star_rating = $request->star_rating;
    $hotel->latitude = $request->latitude;
    $hotel->longitude = $request->longitude;
    $hotel->is_active = $request->has('is_active');

    if ($request->hasFile('featured_photo')) {
      $path = $request->file('featured_photo')->store('hotels', 'public');
      $hotel->featured_photo = $path;
    }

    $hotel->save();

    // Handle gallery photos upload
    if ($request->hasFile('gallery_photos')) {
      foreach ($request->file('gallery_photos') as $index => $file) {
        $path = $file->store('hotels/gallery', 'public');
        HotelPhoto::create([
          'hotel_id' => $hotel->id,
          'photo_path' => $path,
          'caption' => null,
          'order' => $index
        ]);
      }
    }

    return redirect()->route('admin_hotel_index')->with('success', 'Hotel created successfully!');
  }

  public function edit(Hotel $hotel)
  {
    return view('admin.hotel.edit', compact('hotel'));
  }

  public function update(Request $request, Hotel $hotel)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'country' => 'required|string|max:255',
      'city' => 'required|string|max:255',
      'address' => 'required|string',
      'star_rating' => 'required|integer|min:1|max:5',
      'featured_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
      'latitude' => 'nullable|numeric',
      'longitude' => 'nullable|numeric',
    ]);

    $hotel->name = $request->name;
    $hotel->slug = Str::slug($request->name);
    $hotel->description = $request->description;
    $hotel->country = $request->country;
    $hotel->city = $request->city;
    $hotel->address = $request->address;
    $hotel->star_rating = $request->star_rating;
    $hotel->latitude = $request->latitude;
    $hotel->longitude = $request->longitude;
    $hotel->is_active = $request->has('is_active');

    if ($request->hasFile('featured_photo')) {
      if ($hotel->featured_photo) {
        Storage::disk('public')->delete($hotel->featured_photo);
      }
      $path = $request->file('featured_photo')->store('hotels', 'public');
      $hotel->featured_photo = $path;
    }

    $hotel->save();

    // Handle gallery photos upload
    if ($request->hasFile('gallery_photos')) {
      foreach ($request->file('gallery_photos') as $index => $file) {
        $path = $file->store('hotels/gallery', 'public');
        HotelPhoto::create([
          'hotel_id' => $hotel->id,
          'photo_path' => $path,
          'caption' => null,
          'order' => $index
        ]);
      }
    }

    return redirect()->route('admin_hotel_index')->with('success', 'Hotel updated successfully!');
  }

  public function delete(Hotel $hotel)
  {

    if ($hotel->featured_photo) {
      Storage::disk('public')->delete($hotel->featured_photo);
    }

    $hotel->delete();

    return redirect()->route('admin_hotel_index')->with('success', 'Hotel deleted successfully!');
  }

  public function deletePhoto($id)
  {
    $photo = HotelPhoto::findOrFail($id);

    if ($photo->photo_path) {
      Storage::disk('public')->delete($photo->photo_path);
    }

    $photo->delete();

    return response()->json(['success' => true, 'message' => 'Photo deleted successfully!']);
  }

  // Rooms Management
  public function rooms(Hotel $hotel)
  {
    $hotel->load('rooms');
    return view('admin.hotel.rooms', compact('hotel'));
  }

  public function storeRoom(Request $request, Hotel $hotel)
  {
    $request->validate([
      'room_name' => 'required|string|max:255',
      'room_description' => 'nullable|string',
      'max_guests' => 'required|integer|min:1',
      'bed_count' => 'required|integer|min:1',
      'bed_type' => 'required|string|max:255',
      'price_without_breakfast' => 'required|numeric|min:0',
      'price_with_breakfast' => 'required|numeric|min:0',
      'room_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $room = new HotelRoom();
    $room->hotel_id = $hotel->id;
    $room->room_name = $request->room_name;
    $room->room_description = $request->room_description;
    $room->max_guests = $request->max_guests;
    $room->bed_count = $request->bed_count;
    $room->bed_type = $request->bed_type;
    $room->price_without_breakfast = $request->price_without_breakfast;
    $room->price_with_breakfast = $request->price_with_breakfast;
    $room->has_breakfast = $request->has('has_breakfast');
    $room->free_cancellation = $request->has('free_cancellation');
    $room->pay_at_hotel = $request->has('pay_at_hotel');
    $room->smoking_allowed = $request->has('smoking_allowed');
    $room->has_wifi = $request->has('has_wifi');
    $room->has_air_conditioning = $request->has('has_air_conditioning');

    if ($request->hasFile('room_photo')) {
      $path = $request->file('room_photo')->store('hotels/rooms', 'public');
      $room->room_photo = $path;
    }

    $room->save();

    return redirect()->route('admin_hotel_rooms', $hotel->slug)->with('success', 'Room added successfully!');
  }

  public function updateRoom(Request $request, Hotel $hotel, HotelRoom $room)
  {
    $request->validate([
      'room_name' => 'required|string|max:255',
      'room_description' => 'nullable|string',
      'max_guests' => 'required|integer|min:1',
      'bed_count' => 'required|integer|min:1',
      'bed_type' => 'required|string|max:255',
      'price_without_breakfast' => 'required|numeric|min:0',
      'price_with_breakfast' => 'required|numeric|min:0',
      'room_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $room->room_name = $request->room_name;
    $room->room_description = $request->room_description;
    $room->max_guests = $request->max_guests;
    $room->bed_count = $request->bed_count;
    $room->bed_type = $request->bed_type;
    $room->price_without_breakfast = $request->price_without_breakfast;
    $room->price_with_breakfast = $request->price_with_breakfast;
    // Checkbox handling: if not present in request, set to false
    $room->has_breakfast = $request->has('has_breakfast');
    $room->free_cancellation = $request->has('free_cancellation');
    $room->pay_at_hotel = $request->has('pay_at_hotel');
    $room->smoking_allowed = $request->has('smoking_allowed');
    $room->has_wifi = $request->has('has_wifi');
    $room->has_air_conditioning = $request->has('has_air_conditioning');

    if ($request->hasFile('room_photo')) {
      if ($room->room_photo) {
        Storage::disk('public')->delete($room->room_photo);
      }
      $path = $request->file('room_photo')->store('hotels/rooms', 'public');
      $room->room_photo = $path;
    }

    $room->save();

    return redirect()->route('admin_hotel_rooms', $hotel->slug)->with('success', 'Room updated successfully!');
  }

  public function deleteRoom(Hotel $hotel, HotelRoom $room)
  {
    if ($room->room_photo) {
      Storage::disk('public')->delete($room->room_photo);
    }

    $room->delete();

    return redirect()->route('admin_hotel_rooms', $hotel->slug)->with('success', 'Room deleted successfully!');
  }

  // Amenities Management
  public function amenities(Hotel $hotel)
  {
    $hotel->load('amenities');
    return view('admin.hotel.amenities', compact('hotel'));
  }

  public function storeAmenity(Request $request, Hotel $hotel)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'icon_class' => 'nullable|string|max:255',
      'category' => 'nullable|string|max:255',
    ]);

    HotelAmenity::create([
      'hotel_id' => $hotel->id,
      'name' => $request->name,
      'icon_class' => $request->icon_class,
      'category' => $request->category,
    ]);

    return redirect()->route('admin_hotel_amenities', $hotel->slug)->with('success', 'Amenity added successfully!');
  }

  public function deleteAmenity(Hotel $hotel, HotelAmenity $amenity)
  {
    $amenity->delete();

    return redirect()->route('admin_hotel_amenities', $hotel->slug)->with('success', 'Amenity deleted successfully!');
  }
}
