<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\HotelPhoto;

class HotelPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            // Add 3-4 photos per hotel
            for ($i = 1; $i <= 4; $i++) {
                HotelPhoto::create([
                    'hotel_id' => $hotel->id,
                    'photo_path' => 'hotels/' . $hotel->slug . '-' . $i . '.jpg',
                    'caption' => $hotel->name . ' - Photo ' . $i,
                    'order' => $i,
                ]);
            }
        }
    }
}