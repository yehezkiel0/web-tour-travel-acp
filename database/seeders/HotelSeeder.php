<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\HotelAmenity;
use App\Models\HotelRoom;

class HotelSeeder extends Seeder
{
  public function run(): void
  {
    $grandHyatt = Hotel::create([
      'name' => 'Grand Hyatt Hotel',
      'slug' => 'grand-hyatt-hotel',
      'description' => 'Grand Hyatt sits in the largest Grand Hyatt in Asia Pacific, opening as part of Abu Dhabi new downtown. It features unparalleled convention and leisure facilities. Grand Hyatt excels in quality, hospitality and distinction in Asia Pacific.',
      'country' => 'South Korea',
      'city' => 'Seoul',
      'address' => 'Jl. Hayaden no.Kecir, Abu Pahes Jalan Kebun, Kangjo 15290 South Korea',
      'latitude' => 37.5326,
      'longitude' => 127.0246,
      'star_rating' => 5,
      'featured_photo' => 'hotels/grand-hyatt-featured.jpg',
      'view_count' => 150,
      'is_active' => true,
    ]);

    $amenities = [
      ['name' => 'Air Conditioning', 'icon_class' => 'fa-solid fa-snowflake', 'category' => 'Room'],
      ['name' => 'Hair Dryer', 'icon_class' => 'fa-solid fa-wind', 'category' => 'Bathroom'],
      ['name' => 'Meeting Rooms', 'icon_class' => 'fa-solid fa-users', 'category' => 'Business'],
      ['name' => 'Outdoor Pool', 'icon_class' => 'fa-solid fa-person-swimming', 'category' => 'Sports & Wellness'],
      ['name' => 'Business Center', 'icon_class' => 'fa-solid fa-briefcase', 'category' => 'Business'],
      ['name' => 'TV in Room', 'icon_class' => 'fa-solid fa-tv', 'category' => 'Room'],
      ['name' => 'Room Service', 'icon_class' => 'fa-solid fa-bell-concierge', 'category' => 'Service'],
      ['name' => 'Safe', 'icon_class' => 'fa-solid fa-lock', 'category' => 'Room'],
    ];

    foreach ($amenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $grandHyatt->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $grandHyatt->id,
      'room_type' => 'Premier Smoking',
      'bed_type' => 'King Bed',
      'max_guests' => 2,
      'room_size' => 35,
      'price_without_breakfast' => 2495296,
      'price_with_breakfast' => 2795296,
      'available_rooms' => 5,
      'description' => 'Spacious room with premium amenities and city view',
      'photo' => 'hotels/rooms/premier-smoking.jpg',
      'is_available' => true,
    ]);

    HotelRoom::create([
      'hotel_id' => $grandHyatt->id,
      'room_type' => 'Premier Non-Smoking',
      'bed_type' => 'Twin Beds',
      'max_guests' => 2,
      'room_size' => 35,
      'price_without_breakfast' => 3859436,
      'price_with_breakfast' => 4159436,
      'available_rooms' => 8,
      'description' => 'Elegant non-smoking room with modern facilities',
      'photo' => 'hotels/rooms/premier.jpg',
      'is_available' => true,
    ]);

    $royalSeoul = Hotel::create([
      'name' => 'Royal Hotel Seoul',
      'slug' => 'royal-hotel-seoul',
      'description' => 'Located in the heart of Seoul, Royal Hotel offers luxury accommodation with stunning views of the city skyline. Experience Korean hospitality at its finest with world-class amenities and services.',
      'country' => 'South Korea',
      'city' => 'Seoul',
      'address' => '123 Gangnam-daero, Gangnam-gu, Seoul',
      'latitude' => 37.4979,
      'longitude' => 127.0276,
      'star_rating' => 4,
      'featured_photo' => 'hotels/royal-seoul-featured.jpg',
      'view_count' => 120,
      'is_active' => true,
    ]);

    $royalAmenities = [
      ['name' => 'Air Conditioning', 'icon_class' => 'fa-solid fa-snowflake', 'category' => 'Room'],
      ['name' => 'WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
      ['name' => 'Restaurant', 'icon_class' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
      ['name' => 'Fitness Center', 'icon_class' => 'fa-solid fa-dumbbell', 'category' => 'Sports & Wellness'],
      ['name' => 'Room Service', 'icon_class' => 'fa-solid fa-bell-concierge', 'category' => 'Service'],
      ['name' => 'Parking', 'icon_class' => 'fa-solid fa-square-parking', 'category' => 'General'],
    ];

    foreach ($royalAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $royalSeoul->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $royalSeoul->id,
      'room_type' => 'Deluxe Room',
      'bed_type' => 'Queen Bed',
      'max_guests' => 2,
      'room_size' => 28,
      'price_without_breakfast' => 1682000,
      'price_with_breakfast' => 1982000,
      'available_rooms' => 10,
      'description' => 'Comfortable room with city view',
      'photo' => 'hotels/rooms/deluxe.jpg',
      'is_available' => true,
    ]);

    HotelRoom::create([
      'hotel_id' => $royalSeoul->id,
      'room_type' => 'Executive Suite',
      'bed_type' => 'King Bed',
      'max_guests' => 4,
      'room_size' => 55,
      'price_without_breakfast' => 2850000,
      'price_with_breakfast' => 3150000,
      'available_rooms' => 6,
      'description' => 'Luxurious suite with separate living area',
      'photo' => 'hotels/rooms/executive-suite.jpg',
      'is_available' => true,
    ]);

    $jejuParadise = Hotel::create([
      'name' => 'Jeju Paradise Hotel',
      'slug' => 'jeju-paradise-hotel',
      'description' => 'Experience paradise on Jeju Island. Our resort offers breathtaking ocean views, luxurious spa facilities, and direct beach access. Perfect for a romantic getaway or family vacation.',
      'country' => 'South Korea',
      'city' => 'Jeju',
      'address' => '456 Paradise Beach Road, Jeju Island',
      'latitude' => 33.4996,
      'longitude' => 126.5312,
      'star_rating' => 5,
      'featured_photo' => 'hotels/jeju-paradise-featured.jpg',
      'view_count' => 200,
      'is_active' => true,
    ]);

    $jejuAmenities = [
      ['name' => 'Free WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
      ['name' => 'Swimming Pool', 'icon_class' => 'fa-solid fa-person-swimming', 'category' => 'Sports & Wellness'],
      ['name' => 'Spa', 'icon_class' => 'fa-solid fa-spa', 'category' => 'Sports & Wellness'],
      ['name' => 'Beach Access', 'icon_class' => 'fa-solid fa-umbrella-beach', 'category' => 'General'],
      ['name' => 'Restaurant', 'icon_class' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
      ['name' => 'Bar', 'icon_class' => 'fa-solid fa-martini-glass', 'category' => 'Food & Drink'],
      ['name' => 'Room Service', 'icon_class' => 'fa-solid fa-bell-concierge', 'category' => 'Service'],
      ['name' => 'Parking', 'icon_class' => 'fa-solid fa-square-parking', 'category' => 'General'],
    ];

    foreach ($jejuAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $jejuParadise->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $jejuParadise->id,
      'room_type' => 'Ocean View Room',
      'bed_type' => 'King Bed',
      'max_guests' => 2,
      'room_size' => 40,
      'price_without_breakfast' => 3200000,
      'price_with_breakfast' => 3500000,
      'available_rooms' => 12,
      'description' => 'Stunning ocean view room with private balcony',
      'photo' => 'hotels/rooms/ocean-view.jpg',
      'is_available' => true,
    ]);

    HotelRoom::create([
      'hotel_id' => $jejuParadise->id,
      'room_type' => 'Family Suite',
      'bed_type' => 'Multiple Beds',
      'max_guests' => 6,
      'room_size' => 75,
      'price_without_breakfast' => 4500000,
      'price_with_breakfast' => 4950000,
      'available_rooms' => 5,
      'description' => 'Spacious suite perfect for families with connecting rooms',
      'photo' => 'hotels/rooms/family-suite.jpg',
      'is_available' => true,
    ]);

    $busanBeach = Hotel::create([
      'name' => 'Busan Beach Resort',
      'slug' => 'busan-beach-resort',
      'description' => 'Prime beachfront location in Busan featuring modern rooms with ocean views, rooftop pool, and direct access to Haeundae Beach. Perfect for beach lovers and city explorers.',
      'country' => 'South Korea',
      'city' => 'Busan',
      'address' => '789 Haeundae Beach Road, Busan',
      'latitude' => 35.1588,
      'longitude' => 129.1603,
      'star_rating' => 4,
      'featured_photo' => 'hotels/busan-beach-featured.jpg',
      'view_count' => 180,
      'is_active' => true,
    ]);

    $busanAmenities = [
      ['name' => 'WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
      ['name' => 'Rooftop Pool', 'icon_class' => 'fa-solid fa-person-swimming', 'category' => 'Sports & Wellness'],
      ['name' => 'Fitness Center', 'icon_class' => 'fa-solid fa-dumbbell', 'category' => 'Sports & Wellness'],
      ['name' => 'Restaurant', 'icon_class' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
      ['name' => 'Beach Access', 'icon_class' => 'fa-solid fa-umbrella-beach', 'category' => 'General'],
      ['name' => 'Room Service', 'icon_class' => 'fa-solid fa-bell-concierge', 'category' => 'Service'],
      ['name' => 'Parking', 'icon_class' => 'fa-solid fa-square-parking', 'category' => 'General'],
    ];

    foreach ($busanAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $busanBeach->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $busanBeach->id,
      'room_type' => 'Standard Room',
      'bed_type' => 'Queen Bed',
      'max_guests' => 2,
      'room_size' => 26,
      'price_without_breakfast' => 1500000,
      'price_with_breakfast' => 1750000,
      'available_rooms' => 15,
      'description' => 'Comfortable room with modern amenities',
      'photo' => 'hotels/rooms/standard.jpg',
      'is_available' => true,
    ]);

    HotelRoom::create([
      'hotel_id' => $busanBeach->id,
      'room_type' => 'Deluxe Sea View',
      'bed_type' => 'Twin Beds',
      'max_guests' => 3,
      'room_size' => 32,
      'price_without_breakfast' => 2300000,
      'price_with_breakfast' => 2600000,
      'available_rooms' => 10,
      'description' => 'Premium room with panoramic sea views',
      'photo' => 'hotels/rooms/deluxe-sea-view.jpg',
      'is_available' => true,
    ]);

    $incheonAirport = Hotel::create([
      'name' => 'Incheon Airport Hotel',
      'slug' => 'incheon-airport-hotel',
      'description' => 'Conveniently located near Incheon International Airport. Ideal for transit passengers and business travelers. Free airport shuttle service available 24/7.',
      'country' => 'South Korea',
      'city' => 'Incheon',
      'address' => '234 Airport Road, Incheon',
      'latitude' => 37.4602,
      'longitude' => 126.4407,
      'star_rating' => 3,
      'featured_photo' => 'hotels/incheon-airport-featured.jpg',
      'view_count' => 90,
      'is_active' => true,
    ]);

    $incheonAmenities = [
      ['name' => 'Free WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
      ['name' => 'Airport Shuttle', 'icon_class' => 'fa-solid fa-van-shuttle', 'category' => 'Service'],
      ['name' => '24/7 Reception', 'icon_class' => 'fa-solid fa-clock', 'category' => 'Service'],
      ['name' => 'Business Center', 'icon_class' => 'fa-solid fa-briefcase', 'category' => 'Business'],
      ['name' => 'Parking', 'icon_class' => 'fa-solid fa-square-parking', 'category' => 'General'],
    ];

    foreach ($incheonAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $incheonAirport->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $incheonAirport->id,
      'room_type' => 'Transit Room',
      'bed_type' => 'Double Bed',
      'max_guests' => 2,
      'room_size' => 22,
      'price_without_breakfast' => 950000,
      'price_with_breakfast' => 1100000,
      'available_rooms' => 20,
      'description' => 'Compact room for short stays and transit passengers',
      'photo' => 'hotels/rooms/transit.jpg',
      'is_available' => true,
    ]);

    $gangnamLuxury = Hotel::create([
      'name' => 'Gangnam Luxury Hotel',
      'slug' => 'gangnam-luxury-hotel',
      'description' => 'Ultra-modern luxury hotel in the heart of Gangnam district. Features rooftop bar, Michelin-star restaurant, and exclusive shopping access.',
      'country' => 'South Korea',
      'city' => 'Seoul',
      'address' => '88 Gangnam-daero, Gangnam-gu, Seoul',
      'latitude' => 37.5173,
      'longitude' => 127.0473,
      'star_rating' => 5,
      'featured_photo' => 'hotels/gangnam-luxury-featured.jpg',
      'view_count' => 250,
      'is_active' => true,
    ]);

    $gangnamAmenities = [
      ['name' => 'Rooftop Bar', 'icon_class' => 'fa-solid fa-martini-glass', 'category' => 'Food & Drink'],
      ['name' => 'Spa & Wellness', 'icon_class' => 'fa-solid fa-spa', 'category' => 'Sports & Wellness'],
      ['name' => 'Fine Dining', 'icon_class' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
      ['name' => 'Concierge Service', 'icon_class' => 'fa-solid fa-bell-concierge', 'category' => 'Service'],
      ['name' => 'Valet Parking', 'icon_class' => 'fa-solid fa-car', 'category' => 'Service'],
      ['name' => 'Business Center', 'icon_class' => 'fa-solid fa-briefcase', 'category' => 'Business'],
    ];

    foreach ($gangnamAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $gangnamLuxury->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $gangnamLuxury->id,
      'room_type' => 'Luxury Suite',
      'bed_type' => 'King Bed',
      'max_guests' => 2,
      'room_size' => 65,
      'price_without_breakfast' => 4500000,
      'price_with_breakfast' => 4850000,
      'available_rooms' => 8,
      'description' => 'Opulent suite with city skyline views and premium amenities',
      'photo' => 'hotels/rooms/luxury-suite.jpg',
      'is_available' => true,
    ]);

    $myeongdong = Hotel::create([
      'name' => 'Myeongdong Central Hotel',
      'slug' => 'myeongdong-central-hotel',
      'description' => 'Boutique hotel in the vibrant Myeongdong shopping district. Walking distance to major attractions, shopping streets, and subway stations.',
      'country' => 'South Korea',
      'city' => 'Seoul',
      'address' => '45 Myeongdong-gil, Jung-gu, Seoul',
      'latitude' => 37.5636,
      'longitude' => 126.9850,
      'star_rating' => 3,
      'featured_photo' => 'hotels/myeongdong-featured.jpg',
      'view_count' => 140,
      'is_active' => true,
    ]);

    $myeongdongAmenities = [
      ['name' => 'WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
      ['name' => 'Cafe', 'icon_class' => 'fa-solid fa-mug-hot', 'category' => 'Food & Drink'],
      ['name' => 'Luggage Storage', 'icon_class' => 'fa-solid fa-suitcase', 'category' => 'Service'],
      ['name' => 'Air Conditioning', 'icon_class' => 'fa-solid fa-snowflake', 'category' => 'Room'],
    ];

    foreach ($myeongdongAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $myeongdong->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $myeongdong->id,
      'room_type' => 'Cozy Double',
      'bed_type' => 'Double Bed',
      'max_guests' => 2,
      'room_size' => 20,
      'price_without_breakfast' => 1200000,
      'price_with_breakfast' => 1400000,
      'available_rooms' => 12,
      'description' => 'Comfortable room in the heart of shopping district',
      'photo' => 'hotels/rooms/cozy-double.jpg',
      'is_available' => true,
    ]);

    $jejuSeashore = Hotel::create([
      'name' => 'Jeju Seashore Resort',
      'slug' => 'jeju-seashore-resort',
      'description' => 'Family-friendly resort on Jeju Island with water park, kids club, and direct beach access. Perfect for memorable family vacations.',
      'country' => 'South Korea',
      'city' => 'Jeju',
      'address' => '777 Coastal Highway, Seogwipo, Jeju',
      'latitude' => 33.2541,
      'longitude' => 126.5601,
      'star_rating' => 4,
      'featured_photo' => 'hotels/jeju-seashore-featured.jpg',
      'view_count' => 175,
      'is_active' => true,
    ]);

    $jejuSeashoreAmenities = [
      ['name' => 'Water Park', 'icon_class' => 'fa-solid fa-water', 'category' => 'Sports & Wellness'],
      ['name' => 'Kids Club', 'icon_class' => 'fa-solid fa-child', 'category' => 'Service'],
      ['name' => 'Beach Access', 'icon_class' => 'fa-solid fa-umbrella-beach', 'category' => 'General'],
      ['name' => 'Multiple Restaurants', 'icon_class' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
      ['name' => 'Pool', 'icon_class' => 'fa-solid fa-person-swimming', 'category' => 'Sports & Wellness'],
    ];

    foreach ($jejuSeashoreAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $jejuSeashore->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $jejuSeashore->id,
      'room_type' => 'Family Ocean View',
      'bed_type' => 'Queen Beds',
      'max_guests' => 4,
      'room_size' => 48,
      'price_without_breakfast' => 2800000,
      'price_with_breakfast' => 3150000,
      'available_rooms' => 14,
      'description' => 'Spacious family room with beautiful ocean view',
      'photo' => 'hotels/rooms/family-ocean.jpg',
      'is_available' => true,
    ]);

    $daeguBusiness = Hotel::create([
      'name' => 'Daegu Business Hotel',
      'slug' => 'daegu-business-hotel',
      'description' => 'Modern business hotel in Daegu CBD with state-of-the-art conference facilities, executive lounge, and high-speed internet.',
      'country' => 'South Korea',
      'city' => 'Daegu',
      'address' => '200 Business Street, Suseong-gu, Daegu',
      'latitude' => 35.8714,
      'longitude' => 128.6014,
      'star_rating' => 4,
      'featured_photo' => 'hotels/daegu-business-featured.jpg',
      'view_count' => 85,
      'is_active' => true,
    ]);

    $daeguAmenities = [
      ['name' => 'Business Center', 'icon_class' => 'fa-solid fa-briefcase', 'category' => 'Business'],
      ['name' => 'Conference Rooms', 'icon_class' => 'fa-solid fa-users', 'category' => 'Business'],
      ['name' => 'Executive Lounge', 'icon_class' => 'fa-solid fa-champagne-glasses', 'category' => 'Service'],
      ['name' => 'Gym', 'icon_class' => 'fa-solid fa-dumbbell', 'category' => 'Sports & Wellness'],
      ['name' => 'WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
    ];

    foreach ($daeguAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $daeguBusiness->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $daeguBusiness->id,
      'room_type' => 'Executive Room',
      'bed_type' => 'King Bed',
      'max_guests' => 2,
      'room_size' => 30,
      'price_without_breakfast' => 1850000,
      'price_with_breakfast' => 2100000,
      'available_rooms' => 18,
      'description' => 'Professional room designed for business travelers',
      'photo' => 'hotels/rooms/executive.jpg',
      'is_available' => true,
    ]);

    $sokchoMountain = Hotel::create([
      'name' => 'Sokcho Mountain Lodge',
      'slug' => 'sokcho-mountain-lodge',
      'description' => 'Cozy mountain lodge near Seoraksan National Park. Ideal for nature lovers and hiking enthusiasts with stunning mountain views.',
      'country' => 'South Korea',
      'city' => 'Sokcho',
      'address' => '50 Mountain Road, Sokcho-si, Gangwon-do',
      'latitude' => 38.2070,
      'longitude' => 128.5918,
      'star_rating' => 3,
      'featured_photo' => 'hotels/sokcho-mountain-featured.jpg',
      'view_count' => 110,
      'is_active' => true,
    ]);

    $sokchoAmenities = [
      ['name' => 'Mountain View', 'icon_class' => 'fa-solid fa-mountain', 'category' => 'General'],
      ['name' => 'Hiking Tours', 'icon_class' => 'fa-solid fa-person-hiking', 'category' => 'Service'],
      ['name' => 'Restaurant', 'icon_class' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
      ['name' => 'Hot Spring Bath', 'icon_class' => 'fa-solid fa-hot-tub-person', 'category' => 'Sports & Wellness'],
      ['name' => 'WiFi', 'icon_class' => 'fa-solid fa-wifi', 'category' => 'General'],
    ];

    foreach ($sokchoAmenities as $amenity) {
      HotelAmenity::create([
        'hotel_id' => $sokchoMountain->id,
        'name' => $amenity['name'],
        'icon_class' => $amenity['icon_class'],
        'category' => $amenity['category'],
      ]);
    }

    HotelRoom::create([
      'hotel_id' => $sokchoMountain->id,
      'room_type' => 'Mountain View Room',
      'bed_type' => 'Queen Bed',
      'max_guests' => 2,
      'room_size' => 24,
      'price_without_breakfast' => 1350000,
      'price_with_breakfast' => 1550000,
      'available_rooms' => 16,
      'description' => 'Rustic room with panoramic mountain views',
      'photo' => 'hotels/rooms/mountain-view.jpg',
      'is_available' => true,
    ]);
  }
}
