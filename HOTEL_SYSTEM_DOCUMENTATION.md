# Hotel Management System - Documentation

## Overview

Sistem manajemen hotel terintegrasi untuk ACP Tours & Travel yang memungkinkan user untuk browse hotel, booking kamar, dan payment via Midtrans. Admin dapat manage hotel, room types, amenities, dan track bookings.

---

## Features Implemented

### Front-End (User Features)

1. **Hotel Listing Page** (`/hotel`)

    - Display semua hotel dengan pagination
    - Filter by:
        - City/Location
        - Star Rating (1-5 stars)
        - Price Range (slider)
    - Sort options
    - View count tracking
    - Responsive mobile & desktop design

2. **Hotel Detail Page** (`/hotel/{slug}`)

    - Hotel information lengkap dengan gallery photos
    - Star rating & reviews
    - Location with Google Maps integration
    - Amenities list dengan icons
    - Room selection dengan pricing options:
        - Without breakfast
        - With breakfast
    - Booking form:
        - Check-in/Check-out dates
        - Number of guests
        - Number of rooms
        - Special requests
    - "Highlights" sidebar dengan key features

3. **Checkout Page** (`/hotel/{slug}/checkout`)

    - Guest information form
    - Booking summary dengan breakdown harga
    - Terms & conditions
    - Payment button ke Midtrans

4. **Payment Integration**

    - Midtrans Snap payment gateway
    - Automatic booking status update
    - Transaction tracking dengan booking code

5. **Success Page** (`/hotel-booking-success`)
    - Booking confirmation
    - Transaction details
    - Booking code display

---

### Admin Panel Features

#### 1. Hotel Management (`/admin/hotel`)

-   **List Hotels**

    -   View all hotels dengan thumbnail
    -   Quick stats (rooms count, bookings count, amenities count)
    -   Status badges (Active/Inactive)
    -   Actions: Edit, Manage Rooms, Manage Amenities, Delete

-   **Create Hotel** (`/admin/hotel/create`)

    -   Hotel basic information
    -   Featured photo upload
    -   Gallery photos upload (multiple)
    -   Location details (address, city, country, lat/lng)
    -   Star rating (1-5)
    -   Description
    -   Status (Active/Inactive)

-   **Edit Hotel** (`/admin/hotel/edit/{id}`)
    -   Update semua hotel information
    -   Change featured photo
    -   Add more gallery photos
    -   Delete existing gallery photos
    -   Auto-slug generation dari hotel name

#### 2. Room Management (`/admin/hotel/{id}/rooms`)

-   **Add Room**

    -   Room type name
    -   Bed type (Single, Twin, Double, Queen, King)
    -   Max guests capacity
    -   Room size (sqm)
    -   Price without breakfast
    -   Price with breakfast
    -   Available rooms count
    -   Room description
    -   Room photo upload
    -   Availability status

-   **View Rooms**
    -   Table display dengan room details
    -   Photo thumbnail
    -   Pricing information
    -   Status badges
    -   Delete room action

#### 3. Amenities Management (`/admin/hotel/{id}/amenities`)

-   **Add Amenity**

    -   Amenity name
    -   Font Awesome icon class
    -   Category selection:
        -   General
        -   Room
        -   Bathroom
        -   Service
        -   Food & Drink
        -   Entertainment
        -   Business
        -   Sports & Wellness

-   **Quick Add Common Amenities**

    -   Pre-defined amenities dengan icons:
        -   Free WiFi
        -   Air Conditioning
        -   Swimming Pool
        -   Fitness Center
        -   24/7 Reception
        -   Restaurant
        -   Bar
        -   Room Service
        -   Parking
        -   Spa
        -   Airport Shuttle
        -   Pet Friendly
    -   One-click add untuk common amenities

-   **View Amenities**
    -   Grouped by category
    -   Icon display
    -   Delete amenity action

#### 4. Booking Management (`/admin/hotel-bookings`)

-   **Statistics Dashboard**

    -   Total bookings
    -   Pending bookings count
    -   Confirmed bookings count
    -   Cancelled bookings count
    -   Total revenue (KRW)

-   **Filter Bookings**

    -   By status (All, Pending, Confirmed, Cancelled, Completed)
    -   By booking code search
    -   By date range

-   **Booking List Table**

    -   Booking code
    -   Guest information
    -   Hotel & room details
    -   Check-in/out dates
    -   Total price
    -   Payment status badges
    -   Quick status update dropdown
    -   View detail & delete actions

-   **Booking Detail** (`/admin/hotel-bookings/{id}`)
    -   Booking status card dengan update form
    -   Payment status
    -   Hotel & room information dengan photo
    -   Stay details (nights, guests, special requests)
    -   Guest information (name, email, phone)
    -   Payment summary dengan breakdown
    -   Midtrans transaction ID
    -   Actions:
        -   Send email to guest
        -   Delete booking

#### 5. Dashboard Integration

-   **Hotel Statistics Widget**

    -   Total active hotels count
    -   Total hotel bookings
    -   Pending bookings
    -   Confirmed bookings
    -   Total hotel revenue (KRW)
    -   Link to view all bookings

-   **Sidebar Navigation**
    -   "Hotel Management" menu dengan dropdown:
        -   Hotels (list/create/edit)
        -   Bookings (view/manage)

---

## Database Structure

### Tables Created

1. **hotels**

    - id, name, slug (unique)
    - description (text)
    - country, city, address
    - latitude, longitude (nullable)
    - star_rating (1-5)
    - featured_photo
    - view_count (default 0)
    - is_active (boolean, default true)
    - timestamps

2. **hotel_photos**

    - id, hotel_id (foreign key)
    - photo_path
    - timestamps
    - Foreign key: CASCADE delete on hotel delete

3. **hotel_amenities**

    - id, hotel_id (foreign key)
    - name
    - icon_class (nullable)
    - category (nullable)
    - timestamps
    - Foreign key: CASCADE delete on hotel delete

4. **hotel_rooms**

    - id, hotel_id (foreign key)
    - room_type
    - bed_type
    - max_guests
    - room_size (sqm)
    - price_without_breakfast
    - price_with_breakfast
    - available_rooms
    - description (nullable)
    - photo (nullable)
    - is_available (boolean, default true)
    - timestamps
    - Foreign key: CASCADE delete on hotel delete

5. **hotel_bookings**
    - id, user_id (foreign key)
    - hotel_id (foreign key)
    - hotel_room_id (foreign key)
    - booking_code (unique, format: HB-XXXXXX)
    - check_in_date, check_out_date
    - number_of_guests
    - number_of_rooms
    - room_price (per night)
    - total_price
    - include_breakfast (boolean)
    - special_requests (text, nullable)
    - guest_phone (nullable)
    - status (enum: pending, confirmed, cancelled, completed)
    - payment_status (enum: pending, paid, failed)
    - payment_method (nullable)
    - midtrans_transaction_id (nullable)
    - payment_date (nullable)
    - timestamps
    - Foreign keys: CASCADE on hotel/room delete, RESTRICT on user delete

---

## Models & Relationships

### Hotel Model

```php
// Relationships
hasMany: photos, amenities, rooms, bookings

// Custom Attributes
- min_price: Minimum room price (without breakfast)
- average_rating: Future rating implementation placeholder

// Methods
- incrementViewCount(): Increment view counter
```

### HotelPhoto Model

```php
belongsTo: hotel
```

### HotelAmenity Model

```php
belongsTo: hotel
```

### HotelRoom Model

```php
belongsTo: hotel
hasMany: bookings
```

### HotelBooking Model

```php
belongsTo: user, hotel, room (HotelRoom)

// Boot method
- Auto-generate booking_code on create: HB-XXXXXX
```

---

## Repository Pattern

### HotelRepository

Extends BaseRepository

**Methods:**

-   `getAllWithFilters($filters, $perPage)`: Get hotels dengan filter dan pagination
-   `getBySlug($slug)`: Get hotel dengan semua relations (photos, amenities, rooms)

### HotelBookingRepository

Extends BaseRepository

**Methods:**

-   `getByUserId($userId)`: Get bookings by user
-   `getByHotelId($hotelId)`: Get bookings by hotel
-   `getWithFilters($filters)`: Get bookings dengan filter (status, booking_code, date_from, date_to)
-   `getStatistics()`: Get booking statistics (total, pending, confirmed, cancelled, revenue)

---

## Service Layer

### HotelService

**Methods:**

-   `createBooking($data)`: Create hotel booking dengan validation
-   `cancelBooking($bookingId)`: Cancel booking
-   `updateBookingStatus($bookingId, $status)`: Update booking status
-   `getBookingByCode($code)`: Get booking by code

---

## Routes

### Public Routes

```
GET  /hotel                    - Hotel listing page
GET  /hotel/{slug}             - Hotel detail page
```

### Authenticated User Routes

```
POST /hotel/{slug}/booking     - Process booking (store in session)
GET  /hotel/{slug}/checkout    - Checkout page
POST /hotel/{slug}/payment     - Process payment via Midtrans
GET  /hotel-booking-success    - Success confirmation page
```

### Admin Routes (Middleware: admin)

```
# Hotel CRUD
GET    /admin/hotel                              - List hotels
GET    /admin/hotel/create                       - Create form
POST   /admin/hotel                              - Store hotel
GET    /admin/hotel/edit/{id}                    - Edit form
PUT    /admin/hotel/{id}                         - Update hotel
DELETE /admin/hotel/{id}                         - Delete hotel
DELETE /admin/hotel/photo/{id}                   - Delete gallery photo

# Room Management
GET    /admin/hotel/{id}/rooms                   - Manage rooms page
POST   /admin/hotel/{id}/rooms                   - Add room
DELETE /admin/hotel/{hotelId}/rooms/{roomId}     - Delete room

# Amenity Management
GET    /admin/hotel/{id}/amenities               - Manage amenities page
POST   /admin/hotel/{id}/amenities               - Add amenity
DELETE /admin/hotel/{hotelId}/amenities/{amenityId} - Delete amenity

# Booking Management
GET    /admin/hotel-bookings                     - List bookings with stats
GET    /admin/hotel-bookings/{id}                - Booking detail
PUT    /admin/hotel-bookings/{id}/status         - Update booking status
DELETE /admin/hotel-bookings/{id}                - Delete booking
```

---

## Views Structure

```
resources/views/
├── front/hotel/
│   ├── index.blade.php          # Hotel listing with filters
│   ├── detail.blade.php         # Hotel detail & room selection
│   ├── checkout.blade.php       # Checkout form
│   └── success.blade.php        # Booking confirmation
│
└── admin/hotel/
    ├── index.blade.php          # Hotel list table
    ├── create.blade.php         # Create hotel form
    ├── edit.blade.php           # Edit hotel form
    ├── rooms.blade.php          # Room management
    ├── amenities.blade.php      # Amenity management
    ├── bookings.blade.php       # Booking list with filters
    └── booking-detail.blade.php # Detailed booking view
```

---

## Sample Data (Seeder)

### Hotels Created (10 hotels)

1. **Grand Hyatt Hotel** - Seoul, 5★

    - 2 rooms (Deluxe Double, Executive Suite)
    - 8 amenities

2. **Royal Hotel Seoul** - Seoul, 4★

    - 1 room (Superior Twin Room)
    - 6 amenities

3. **Jeju Paradise Hotel** - Jeju, 5★

    - 2 rooms (Ocean View Room, Garden Villa)
    - 8 amenities

4. **Busan Beach Resort** - Busan, 4★

    - 1 room (Beach Front Room)
    - 7 amenities

5. **Incheon Airport Hotel** - Incheon, 3★

    - 1 room (Standard Room)
    - 5 amenities

6. **Gangnam Luxury Hotel** - Seoul, 5★

    - 2 rooms (Premium Suite, Presidential Suite)
    - 8 amenities

7. **Myeongdong Central Hotel** - Seoul, 3★

    - 1 room (Standard Double)
    - 5 amenities

8. **Jeju Seashore Resort** - Jeju, 4★

    - 2 rooms (Sea View Suite, Mountain View Room)
    - 7 amenities

9. **Daegu Business Hotel** - Daegu, 4★

    - 1 room (Business Room)
    - 6 amenities

10. **Sokcho Mountain Lodge** - Sokcho, 3★
    - 1 room (Mountain View Room)
    - 5 amenities

**Total:**

-   10 Hotels
-   14 Room types
-   59 Amenities

---

## Payment Integration

### Midtrans Setup

-   Uses Snap API
-   Sandbox mode configured
-   Server Key & Client Key in `.env`:
    ```
    MIDTRANS_SERVER_KEY=your_server_key
    MIDTRANS_CLIENT_KEY=your_client_key
    MIDTRANS_IS_PRODUCTION=false
    ```

### Payment Flow

1. User completes booking form
2. Data stored in session
3. Checkout page displays summary
4. Click "Pay Now" triggers Midtrans Snap
5. Popup payment modal appears
6. After payment:
    - Success: Status updated to "paid", redirect to success page
    - Failed: Status remains "pending"
    - Pending: Status stays "pending"

---

## Design Features

### UI Components

-   Tailwind CSS utility classes
-   Font Awesome 6 icons
-   Responsive grid layouts
-   Card-based design matching existing ACP style
-   Primary color: `#4F46E5` (Indigo)

### Filter Implementation

-   **City Filter**: Dropdown select
-   **Star Rating**: Checkbox multi-select (1-5 stars)
-   **Price Range**: JavaScript slider (range input)
-   **Mobile**: Overlay filter sidebar dengan toggle button

### Admin UI

-   Consistent dengan existing admin design
-   Data tables dengan sorting
-   Status badges (color-coded)
-   Action buttons (Edit, Delete, View)
-   Statistics cards dengan icons
-   Form validation dengan error messages

---

## Installation & Setup

### Run Migrations

```bash
php artisan migrate
```

### Run Seeder

```bash
php artisan db:seed --class=HotelSeeder
```

### Storage Link (for photos)

```bash
php artisan storage:link
```

### Clear Caches

```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

---

## File Upload Configuration

### Storage Structure

```
storage/app/public/
├── hotels/                    # Hotel featured photos
│   └── {filename}.jpg
└── hotels/rooms/              # Room photos
    └── {filename}.jpg
```

### Validation Rules

-   Max file size: 2MB
-   Allowed formats: JPG, PNG, WEBP
-   Featured photo: Required on create
-   Gallery photos: Multiple upload supported
-   Room photos: Optional

---

## Security Features

### Middleware Protection

-   User authentication: `auth:user`
-   Admin authentication: `auth:admin`
-   CSRF protection on forms
-   XSS prevention via Blade escaping

### Validation

-   Server-side validation for all forms
-   Unique slug generation
-   Foreign key constraints
-   Status enum validation
-   Date validation (check-in < check-out)
-   Price validation (positive numbers)

---

## Future Enhancements (Suggestions)

1. **Reviews & Ratings**

    - User can leave reviews after checkout
    - Average rating calculation
    - Review moderation system

2. **Availability Calendar**

    - Real-time room availability check
    - Disable fully booked dates
    - Booking conflict prevention

3. **Email Notifications**

    - Booking confirmation email
    - Payment receipt
    - Check-in reminders
    - Admin notification on new booking

4. **Advanced Filters**

    - Facilities filter (pool, spa, restaurant)
    - Distance from location
    - Customer ratings filter

5. **Multi-language Support**

    - English & Korean
    - Currency conversion (KRW, USD, IDR)

6. **Reporting**

    - Revenue reports by month/year
    - Occupancy rate statistics
    - Popular hotels analytics
    - Export to PDF/Excel

7. **Cancellation Policy**

    - Refund rules configuration
    - Cancellation deadline
    - Partial refund calculation

8. **Booking History (User)**
    - User dashboard to view bookings
    - Cancel booking from user panel
    - Download booking confirmation

---

## Testing Checklist

### Front-End Testing

-   [ ] Hotel listing page loads
-   [ ] Filters work correctly
-   [ ] Pagination works
-   [ ] Hotel detail page displays all info
-   [ ] Room selection form works
-   [ ] Checkout page shows correct summary
-   [ ] Midtrans payment popup appears
-   [ ] Success page displays after payment

### Admin Testing

-   [ ] Hotel CRUD operations
-   [ ] Photo upload & delete
-   [ ] Room management
-   [ ] Amenity management
-   [ ] Booking list with filters
-   [ ] Booking detail view
-   [ ] Status update functionality
-   [ ] Dashboard statistics display
-   [ ] Sidebar navigation links

### Data Validation

-   [ ] Empty form submission blocked
-   [ ] Invalid dates rejected
-   [ ] Negative prices rejected
-   [ ] File size limit enforced
-   [ ] Unique constraints work

---

## Troubleshooting

### Common Issues

**Issue: Photos not displaying**

-   Solution: Run `php artisan storage:link`
-   Check file permissions on storage folder

**Issue: Routes not found**

-   Solution: Clear route cache `php artisan route:clear`
-   Check middleware groups

**Issue: Midtrans not working**

-   Solution: Verify .env keys are correct
-   Check if sandbox mode is enabled
-   Ensure curl is enabled in PHP

**Issue: Duplicate slug error**

-   Solution: Rollback migrations and re-seed
-   Or manually delete existing hotels before seeding

---

## Credits

**Developed for:** ACP Tours & Travel  
**Framework:** Laravel (latest version)  
**Payment Gateway:** Midtrans  
**CSS Framework:** Tailwind CSS  
**Icons:** Font Awesome 6  
**Maps:** Google Maps API

---

## Support

For issues or questions, refer to:

-   Laravel Documentation: https://laravel.com/docs
-   Midtrans Documentation: https://docs.midtrans.com
-   Tailwind CSS: https://tailwindcss.com/docs

---

**Last Updated:** January 2025
