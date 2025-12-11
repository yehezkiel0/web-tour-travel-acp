# Hotel Feature Documentation

## Fitur Hotel - ACP Tours & Travel

Dokumentasi lengkap untuk fitur booking hotel yang telah ditambahkan ke website ACP Tours & Travel.

## 🎯 Fitur yang Telah Dibuat

### 1. Database Structure

-   **hotels** - Tabel utama untuk data hotel
-   **hotel_photos** - Tabel untuk foto-foto hotel
-   **hotel_amenities** - Tabel untuk fasilitas hotel
-   **hotel_rooms** - Tabel untuk tipe kamar hotel
-   **hotel_bookings** - Tabel untuk transaksi booking hotel

### 2. Backend Components

#### Models

-   `Hotel.php` - Model utama hotel dengan relasi ke photos, amenities, rooms, dan bookings
-   `HotelPhoto.php` - Model untuk foto hotel
-   `HotelAmenity.php` - Model untuk fasilitas hotel
-   `HotelRoom.php` - Model untuk tipe kamar
-   `HotelBooking.php` - Model untuk transaksi booking

#### Repositories

-   `HotelRepository.php` - Repository untuk operasi data hotel dengan fitur filter
-   `HotelBookingRepository.php` - Repository untuk operasi booking hotel

#### Services

-   `HotelService.php` - Service layer untuk business logic hotel

#### Controllers

-   `HotelController.php` - Controller untuk halaman hotel dengan methods:
    -   `index()` - Halaman listing hotel dengan filter
    -   `show()` - Halaman detail hotel
    -   `booking()` - Proses booking hotel
    -   `checkout()` - Halaman checkout
    -   `payment()` - Integrasi pembayaran dengan Midtrans
    -   `success()` - Halaman sukses booking

### 3. Views (Blade Templates)

#### Halaman Hotel Listing (`resources/views/front/hotel/index.blade.php`)

Menampilkan daftar hotel dengan fitur:

-   Filter berdasarkan lokasi/city
-   Filter berdasarkan star rating (3-5 bintang)
-   Filter berdasarkan harga (price range slider)
-   Responsive design (mobile & desktop)
-   Pagination
-   Card hotel dengan informasi lengkap

#### Halaman Hotel Detail (`resources/views/front/hotel/detail.blade.php`)

Menampilkan detail hotel dengan:

-   Gallery foto hotel
-   Booking form dengan date picker dan guest selection
-   Overview hotel
-   Daftar amenities/fasilitas
-   **Select Your Room** section dengan:
    -   Room options (with/without breakfast)
    -   Harga per malam
    -   Informasi bed type dan max guests
    -   Tombol "Book Now" untuk setiap room
-   Highlights section
-   Location map (Google Maps)
-   Nearby places

#### Halaman Checkout (`resources/views/front/hotel/checkout.blade.php`)

Form checkout dengan:

-   Guest details form (nama, email, phone)
-   Special requests textarea
-   Booking summary sidebar dengan:
    -   Info hotel
    -   Room details
    -   Stay duration
    -   Price breakdown
    -   Total price
-   Terms & conditions checkbox
-   Tombol "Proceed to Payment"

#### Halaman Success (`resources/views/front/hotel/success.blade.php`)

Halaman konfirmasi booking dengan:

-   Success icon
-   Booking code
-   Booking details lengkap
-   Important information
-   Action buttons (Browse More Hotels, Back to Home)

### 4. Routes

```php
// Public routes
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
Route::get('/hotel/{slug}', [HotelController::class, 'show'])->name('hotel.show');
Route::get('/hotel-booking-success', [HotelController::class, 'success'])->name('hotel.success');

// Authenticated routes
Route::middleware('user')->group(function () {
    Route::post('/hotel/{slug}/booking', [HotelController::class, 'booking'])->name('hotel.booking');
    Route::get('/hotel/{slug}/checkout', [HotelController::class, 'checkout'])->name('hotel.checkout');
    Route::post('/hotel/{slug}/payment', [HotelController::class, 'payment'])->name('hotel.payment');
});
```

### 5. Navbar Integration

Link "Hotel" telah ditambahkan di:

-   Desktop navbar
-   Mobile sidebar
-   Mengarah ke `route('hotel.index')`

## 📦 Instalasi dan Setup

### 1. Jalankan Migration

```bash
php artisan migrate
```

Migration akan membuat 5 tabel baru:

-   `hotels`
-   `hotel_photos`
-   `hotel_amenities`
-   `hotel_rooms`
-   `hotel_bookings`

### 2. Jalankan Seeder (Optional)

```bash
php artisan db:seed --class=HotelSeeder
```

Seeder akan membuat sample data:

-   4 hotel (Grand Hyatt Seoul, Royal Hotel Seoul, Jeju Paradise Hotel, Busan Beach Resort)
-   Amenities untuk setiap hotel
-   2-3 room types untuk setiap hotel

### 3. Storage Setup

Pastikan symbolic link sudah dibuat untuk storage:

```bash
php artisan storage:link
```

### 4. Konfigurasi Midtrans

Pastikan file `config/midtrans.php` sudah ada dan terisi dengan benar:

```php
return [
    'serverKey' => env('MIDTRANS_SERVER_KEY'),
    'clientKey' => env('MIDTRANS_CLIENT_KEY'),
    'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),
    'isSanitized' => true,
    'is3ds' => true,
];
```

Tambahkan di `.env`:

```
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

## 🎨 Desain & UI

Desain mengikuti pattern yang sudah ada di website dengan:

-   Warna primary: `#4F46E5` (atau sesuai variabel Tailwind `primary`)
-   Background: `#EBF1FE` untuk section background
-   Cards: White dengan shadow dan rounded corners
-   Responsive design menggunakan Tailwind CSS
-   Icons dari Font Awesome 6

## 🔍 Fitur Filter

### Filter yang tersedia:

1. **Location/City** - Dropdown select city
2. **Star Rating** - Radio button (3-5 stars & up)
3. **Price Range** - Range slider dengan min-max price
4. **Clear All** - Button untuk reset semua filter

### Logic Filter (di HotelRepository):

```php
- Filter by city (like search)
- Filter by star_rating (greater than or equal)
- Filter by price range (min_price & max_price pada hotel_rooms)
- Search by hotel name
```

## 💳 Integrasi Midtrans

Payment flow:

1. User mengisi form checkout
2. Submit form → Controller creates booking di database
3. Generate Midtrans Snap token
4. Redirect ke Midtrans payment page
5. Setelah payment → Midtrans redirect ke success page

## 📱 Responsive Design

Semua halaman fully responsive:

-   Mobile: Single column, filter dalam overlay
-   Tablet: Grid 2 kolom
-   Desktop: Grid 3 kolom dengan sticky sidebar filter

## 🔐 Authentication

Routes yang memerlukan authentication (middleware 'user'):

-   `/hotel/{slug}/booking` (POST)
-   `/hotel/{slug}/checkout` (GET)
-   `/hotel/{slug}/payment` (POST)

Halaman public:

-   `/hotel` (listing)
-   `/hotel/{slug}` (detail)

## 📊 Database Relations

```
Hotel
├── hasMany → HotelPhoto
├── hasMany → HotelAmenity
├── hasMany → HotelRoom
└── hasMany → HotelBooking

HotelRoom
└── hasMany → HotelBooking

HotelBooking
├── belongsTo → User
├── belongsTo → Hotel
└── belongsTo → HotelRoom
```

## 🚀 Testing

### Manual Testing Steps:

1. ✅ Akses `/hotel` - Lihat daftar hotel
2. ✅ Test filter: city, star rating, price range
3. ✅ Klik hotel → Lihat detail hotel
4. ✅ Pilih dates, guests, rooms → Search hotel
5. ✅ Klik "Book Now" pada room (login required)
6. ✅ Isi form checkout
7. ✅ Submit → Redirect ke Midtrans
8. ✅ Complete payment → Success page

## 📝 Notes

-   Foto hotel menggunakan placeholder path, perlu upload foto actual ke `storage/app/public/hotels/`
-   Google Maps memerlukan API key untuk production
-   Midtrans dalam mode sandbox untuk testing
-   Status booking: pending, confirmed, cancelled, completed

## 🎯 Future Enhancements

Fitur yang bisa ditambahkan:

-   [ ] Rating & review system
-   [ ] Wishlist/favorite hotels
-   [ ] Price comparison
-   [ ] Room availability checker
-   [ ] Admin panel untuk manage hotels
-   [ ] Email notifications
-   [ ] Booking history di user dashboard
-   [ ] Cancellation policy
-   [ ] Multi-language support

## 📞 Support

Jika ada pertanyaan atau issues, silakan hubungi developer.

---

**Created by:** GitHub Copilot
**Date:** November 18, 2025
**Version:** 1.0
