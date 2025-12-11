# Hotel Management System - Quick Reference

## Quick Start

### 1. Setup Database

```bash
php artisan migrate
php artisan db:seed --class=HotelSeeder
php artisan storage:link
```

### 2. Access URLs

**Front-End:**

-   Hotel Listing: `http://localhost/hotel`
-   Hotel Detail: `http://localhost/hotel/{slug}`

**Admin Panel:**

-   Hotel List: `http://localhost/admin/hotel`
-   Create Hotel: `http://localhost/admin/hotel/create`
-   Manage Rooms: `http://localhost/admin/hotel/{id}/rooms`
-   Manage Amenities: `http://localhost/admin/hotel/{id}/amenities`
-   View Bookings: `http://localhost/admin/hotel-bookings`

---

## Key Files

### Controllers

```
app/Http/Controllers/
├── Front/
│   └── HotelController.php          # User-facing hotel pages
└── Admin/
    ├── AdminHotelController.php     # Hotel CRUD, rooms, amenities
    ├── AdminHotelBookingController.php  # Booking management
    └── AdminDashboardController.php # Dashboard with hotel stats
```

### Models

```
app/Models/
├── Hotel.php          # Main hotel model
├── HotelPhoto.php     # Gallery photos
├── HotelAmenity.php   # Hotel facilities
├── HotelRoom.php      # Room types
└── HotelBooking.php   # Booking transactions
```

### Views

```
resources/views/
├── front/hotel/
│   ├── index.blade.php    # Listing page
│   ├── detail.blade.php   # Detail page
│   ├── checkout.blade.php # Checkout form
│   └── success.blade.php  # Success page
└── admin/hotel/
    ├── index.blade.php         # Hotel table
    ├── create.blade.php        # Create form
    ├── edit.blade.php          # Edit form
    ├── rooms.blade.php         # Room management
    ├── amenities.blade.php     # Amenity management
    ├── bookings.blade.php      # Booking list
    └── booking-detail.blade.php # Booking detail
```

### Migrations

```
database/migrations/
├── 2025_11_18_000001_create_hotels_table.php
├── 2025_11_18_000002_create_hotel_photos_table.php
├── 2025_11_18_000003_create_hotel_amenities_table.php
├── 2025_11_18_000004_create_hotel_rooms_table.php
└── 2025_11_18_000005_create_hotel_bookings_table.php
```

---

## Database Schema

### hotels

-   id, name, slug, description
-   country, city, address, latitude, longitude
-   star_rating (1-5), featured_photo
-   view_count, is_active, timestamps

### hotel_photos

-   id, hotel_id, photo_path, timestamps

### hotel_amenities

-   id, hotel_id, name, icon_class, category, timestamps

### hotel_rooms

-   id, hotel_id, room_type, bed_type, max_guests
-   room_size, price_without_breakfast, price_with_breakfast
-   available_rooms, description, photo, is_available, timestamps

### hotel_bookings

-   id, user_id, hotel_id, hotel_room_id
-   booking_code (HB-XXXXXX), check_in_date, check_out_date
-   number_of_guests, number_of_rooms
-   room_price, total_price, include_breakfast
-   special_requests, guest_phone
-   status (pending/confirmed/cancelled/completed)
-   payment_status (pending/paid/failed)
-   payment_method, midtrans_transaction_id, payment_date
-   timestamps

---

## Routes Summary

### Public

-   `GET /hotel` → Hotel listing
-   `GET /hotel/{slug}` → Hotel detail

### Authenticated (User)

-   `POST /hotel/{slug}/booking` → Process booking
-   `GET /hotel/{slug}/checkout` → Checkout page
-   `POST /hotel/{slug}/payment` → Midtrans payment
-   `GET /hotel-booking-success` → Success page

### Admin

**Hotel CRUD:**

-   `GET /admin/hotel` → List
-   `GET /admin/hotel/create` → Create form
-   `POST /admin/hotel` → Store
-   `GET /admin/hotel/edit/{id}` → Edit form
-   `PUT /admin/hotel/{id}` → Update
-   `DELETE /admin/hotel/{id}` → Delete
-   `DELETE /admin/hotel/photo/{id}` → Delete photo

**Room Management:**

-   `GET /admin/hotel/{id}/rooms` → Manage
-   `POST /admin/hotel/{id}/rooms` → Add
-   `DELETE /admin/hotel/{hotelId}/rooms/{roomId}` → Delete

**Amenity Management:**

-   `GET /admin/hotel/{id}/amenities` → Manage
-   `POST /admin/hotel/{id}/amenities` → Add
-   `DELETE /admin/hotel/{hotelId}/amenities/{amenityId}` → Delete

**Booking Management:**

-   `GET /admin/hotel-bookings` → List with stats
-   `GET /admin/hotel-bookings/{id}` → Detail
-   `PUT /admin/hotel-bookings/{id}/status` → Update status
-   `DELETE /admin/hotel-bookings/{id}` → Delete

---

## Sample Data (Seeder)

**10 Hotels across 6 cities:**

1. Grand Hyatt Hotel (Seoul, 5★) - 2 rooms, 8 amenities
2. Royal Hotel Seoul (Seoul, 4★) - 1 room, 6 amenities
3. Jeju Paradise Hotel (Jeju, 5★) - 2 rooms, 8 amenities
4. Busan Beach Resort (Busan, 4★) - 1 room, 7 amenities
5. Incheon Airport Hotel (Incheon, 3★) - 1 room, 5 amenities
6. Gangnam Luxury Hotel (Seoul, 5★) - 2 rooms, 8 amenities
7. Myeongdong Central Hotel (Seoul, 3★) - 1 room, 5 amenities
8. Jeju Seashore Resort (Jeju, 4★) - 2 rooms, 7 amenities
9. Daegu Business Hotel (Daegu, 4★) - 1 room, 6 amenities
10. Sokcho Mountain Lodge (Sokcho, 3★) - 1 room, 5 amenities

**Total:** 14 rooms, 59 amenities

---

## Common Commands

```bash
# Clear caches
php artisan route:clear
php artisan config:clear
php artisan view:clear

# Rollback migrations
php artisan migrate:rollback --step=5

# Re-run migrations
php artisan migrate

# Re-seed hotels
php artisan db:seed --class=HotelSeeder

# Check routes
php artisan route:list --name=hotel

# Verify data
php artisan tinker
>>> App\Models\Hotel::count()
>>> App\Models\HotelRoom::count()
>>> App\Models\HotelAmenity::count()
```

---

## Filter Options

### Hotel Listing Filters

1. **City** - Dropdown select (all cities from database)
2. **Star Rating** - Checkbox (1-5 stars)
3. **Price Range** - Slider (0 - 1,000,000 KRW)

### Booking Filters (Admin)

1. **Status** - Dropdown (All, Pending, Confirmed, Cancelled, Completed)
2. **Booking Code** - Text search
3. **Date Range** - From/To date inputs

---

## Midtrans Configuration

**.env Settings:**

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

**Config file:** `config/midtrans.php`

---

## Storage Paths

```
storage/app/public/
├── hotels/           # Hotel featured photos
└── hotels/rooms/     # Room photos
```

**Public link:** `php artisan storage:link`

---

## Validation Rules

### Hotel Creation

-   name: required, max 255
-   description: required
-   country, city, address: required
-   star_rating: required, 1-5
-   featured_photo: required, image, max 2MB
-   latitude, longitude: nullable, numeric

### Room Creation

-   room_type: required, max 255
-   bed_type: required
-   max_guests: required, min 1
-   room_size: required, min 1
-   price_without_breakfast: required, min 0
-   price_with_breakfast: required, min 0
-   available_rooms: required, min 0

### Booking Creation

-   check_in_date: required, date
-   check_out_date: required, date, after check_in
-   number_of_guests: required, min 1
-   number_of_rooms: required, min 1

---

## Statistics Available

### Dashboard (Admin)

-   Total active hotels
-   Total hotel bookings
-   Pending bookings count
-   Confirmed bookings count
-   Total hotel revenue (KRW)

### Booking Page (Admin)

-   Total bookings
-   Pending count
-   Confirmed count
-   Cancelled count
-   Total revenue

---

## Relationships

```
Hotel
├── hasMany: photos, amenities, rooms, bookings

HotelPhoto
└── belongsTo: hotel

HotelAmenity
└── belongsTo: hotel

HotelRoom
├── belongsTo: hotel
└── hasMany: bookings

HotelBooking
├── belongsTo: user
├── belongsTo: hotel
└── belongsTo: room (HotelRoom)
```

---

## Status Enums

### Booking Status

-   `pending` - Awaiting payment
-   `confirmed` - Payment received
-   `cancelled` - Cancelled by user/admin
-   `completed` - Guest checked out

### Payment Status

-   `pending` - Not paid
-   `paid` - Payment successful
-   `failed` - Payment failed

---

## Feature Highlights

✅ Full CRUD for hotels, rooms, amenities  
✅ Gallery photo management  
✅ Multi-filter search  
✅ Responsive design (mobile & desktop)  
✅ Midtrans payment integration  
✅ Booking tracking with stats  
✅ Auto-generated booking codes  
✅ View count tracking  
✅ Status management  
✅ Admin dashboard integration  
✅ Repository pattern architecture  
✅ Service layer for business logic  
✅ Optimized queries (N+1 prevention)

---

## Next Steps (Optional Enhancements)

-   [ ] Email notifications
-   [ ] User booking history dashboard
-   [ ] Reviews & ratings system
-   [ ] Availability calendar
-   [ ] Multi-language support
-   [ ] Advanced reporting
-   [ ] Cancellation policy
-   [ ] Export bookings to Excel/PDF

---

For detailed documentation, see: `HOTEL_SYSTEM_DOCUMENTATION.md`
