<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class LocationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample destinations with coordinates (South Korea locations)
        $destinations = [
            ['slug' => 'jeju-island-paradise-5d4n-nature-explorer', 'latitude' => 33.4890, 'longitude' => 126.4983, 'name' => 'Jeju Island'],
            ['slug' => 'seoul-metropolitan-experience-5d4n-culture-k-pop', 'latitude' => 37.5665, 'longitude' => 126.9780, 'name' => 'Seoul'],
            ['slug' => 'busan-coastal-paradise-5d4n-beach-temple', 'latitude' => 35.1796, 'longitude' => 129.0756, 'name' => 'Busan'],
            ['slug' => 'gyeongju-ancient-capital-4d3n-unesco-heritage', 'latitude' => 35.8562, 'longitude' => 129.2247, 'name' => 'Gyeongju'],
            ['slug' => 'incheon-gateway-explorer-3d2n-port-future-city', 'latitude' => 37.4563, 'longitude' => 126.7052, 'name' => 'Incheon'],
            ['slug' => 'sokcho-mountain-paradise-5d4n-seoraksan-hiking', 'latitude' => 38.2070, 'longitude' => 128.5918, 'name' => 'Sokcho'],
            ['slug' => 'daegu-modern-city-discovery-4d3n-urban-culture', 'latitude' => 35.8714, 'longitude' => 128.6014, 'name' => 'Daegu'],
            ['slug' => 'jeonju-hanok-heritage-3d2n-traditional-living', 'latitude' => 35.8242, 'longitude' => 127.1480, 'name' => 'Jeonju'],
        ];

        $updated = 0;
        foreach ($destinations as $data) {
            $result = Destination::where('slug', $data['slug'])->update([
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
            if ($result) {
                $updated++;
                $this->command->info("✓ Updated {$data['name']} destination");
            }
        }

        $this->command->info("Updated {$updated} destinations with location data.");

        // Sample hotels with coordinates (South Korea locations)
        $hotels = [
            ['slug' => 'grand-hyatt-hotel', 'latitude' => 37.5326, 'longitude' => 127.0030, 'name' => 'Grand Hyatt Hotel'],
            ['slug' => 'royal-hotel-seoul', 'latitude' => 37.5665, 'longitude' => 126.9780, 'name' => 'Royal Hotel Seoul'],
            ['slug' => 'jeju-paradise-hotel', 'latitude' => 33.4890, 'longitude' => 126.4983, 'name' => 'Jeju Paradise Hotel'],
            ['slug' => 'busan-beach-resort', 'latitude' => 35.1582, 'longitude' => 129.1604, 'name' => 'Busan Beach Resort'],
            ['slug' => 'incheon-airport-hotel', 'latitude' => 37.4563, 'longitude' => 126.4414, 'name' => 'Incheon Airport Hotel'],
            ['slug' => 'gangnam-luxury-hotel', 'latitude' => 37.5090, 'longitude' => 127.0606, 'name' => 'Gangnam Luxury Hotel'],
            ['slug' => 'myeongdong-central-hotel', 'latitude' => 37.5636, 'longitude' => 126.9865, 'name' => 'Myeongdong Central Hotel'],
            ['slug' => 'jeju-seashore-resort', 'latitude' => 33.5097, 'longitude' => 126.5219, 'name' => 'Jeju Seashore Resort'],
            ['slug' => 'daegu-business-hotel', 'latitude' => 35.8714, 'longitude' => 128.6014, 'name' => 'Daegu Business Hotel'],
            ['slug' => 'sokcho-mountain-lodge', 'latitude' => 38.2070, 'longitude' => 128.5918, 'name' => 'Sokcho Mountain Lodge'],
        ];

        $updatedHotels = 0;
        foreach ($hotels as $data) {
            $result = Hotel::where('slug', $data['slug'])->update([
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
            if ($result) {
                $updatedHotels++;
                $this->command->info("✓ Updated {$data['name']}");
            }
        }

        $this->command->info("Updated {$updatedHotels} hotels with location data.");
        $this->command->info('Location data seeding completed!');
    }
}