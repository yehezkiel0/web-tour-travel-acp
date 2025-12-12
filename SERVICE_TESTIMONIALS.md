# Service Testimonials Feature

## Overview

Sistem testimoni interaktif untuk halaman services (Medical, Recruitment, Entertainment) dengan Swiper carousel dan form input untuk user.

## Features

✅ **Swiper Carousel** - Smooth sliding testimonials dengan autoplay
✅ **User Input Form** - Modal form untuk submit testimoni baru
✅ **Photo Upload** - Support upload foto testimoni
✅ **Rating System** - 5-star rating system
✅ **Admin Approval** - Testimoni baru perlu approval sebelum ditampilkan
✅ **Service-specific** - Testimoni terpisah untuk tiap service (medical, recruitment, entertainment)
✅ **Responsive Design** - Mobile-friendly dengan gradient background

## Files Created/Modified

### Database

-   **Migration**: `2025_12_11_144924_create_service_testimonials_table.php`
    -   Fields: name, location, photo, title, message, service_type, rating, is_approved, user_id
-   **Model**: `app/Models/ServiceTestimonial.php`

    -   Relations: belongsTo User
    -   Fillable fields dengan validation

-   **Seeder**: `database/seeders/ServiceTestimonialSeeder.php`
    -   9 sample testimonials (3 per service)

### Controllers

-   **TestimonialController**: `app/Http/Controllers/Front/TestimonialController.php`

    -   `store()` - Handle testimonial submission
    -   `getApproved()` - Fetch approved testimonials by service type

-   **LandingPageController**: Updated to pass testimonials to service views

### Routes

```php
// Testimonial routes
Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
Route::get('/testimonials/{serviceType}', [TestimonialController::class, 'getApproved'])->name('testimonial.get');
```

### Views

-   **Modal Component**: `resources/views/front/components/testimonial-modal.blade.php`
    -   Photo preview
    -   5-star rating selector
    -   Form validation
-   **Updated Pages**:
    -   `resources/views/front/our-services/medical.blade.php`
    -   `resources/views/front/our-services/recruitment.blade.php`
    -   `resources/views/front/our-services/entertainment.blade.php`

## How to Use

### User Side

1. Visit any service page (Medical/Recruitment/Entertainment)
2. Click **"Share Your Experience"** button
3. Fill testimonial form:
    - Name
    - Location
    - Photo (optional)
    - Rating (1-5 stars)
    - Title
    - Message (max 1000 chars)
4. Submit - will show success message
5. Testimonial will be **pending approval** by admin

### Admin Side (Future Implementation)

Admin can approve/reject testimonials via admin panel:

```php
// Example admin route
Route::middleware('admin')->group(function() {
    Route::get('/admin/testimonials', [AdminTestimonialController::class, 'index']);
    Route::post('/admin/testimonials/{id}/approve', [AdminTestimonialController::class, 'approve']);
    Route::delete('/admin/testimonials/{id}', [AdminTestimonialController::class, 'destroy']);
});
```

## Swiper Configuration

```javascript
const swiper = new Swiper(".testimonialSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next-custom",
        prevEl: ".swiper-button-prev-custom",
    },
});
```

## Database Schema

```sql
CREATE TABLE service_testimonials (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    service_type ENUM('medical', 'recruitment', 'entertainment') NOT NULL,
    rating INT DEFAULT 5,
    is_approved BOOLEAN DEFAULT FALSE,
    user_id BIGINT NULL REFERENCES users(id),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## CDN Dependencies

```html
<!-- Swiper CSS -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
```

## Validation Rules

```php
'name' => 'required|string|max:255',
'location' => 'required|string|max:255',
'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
'title' => 'required|string|max:255',
'message' => 'required|string|max:1000',
'service_type' => 'required|in:medical,recruitment,entertainment',
'rating' => 'nullable|integer|min:1|max:5'
```

## Sample Testimonial Display

-   **Avatar fallback**: Uses UI Avatars API jika tidak ada foto
-   **Rating stars**: ★★★★★ (filled) vs ☆ (empty)
-   **Gradient background**: Blue to Indigo (#1E4690 to #3477F6)
-   **Quote icons**: SVG decorative quotes
-   **Empty state**: CTA button jika belum ada testimoni

## To-Do (Admin Panel)

-   [ ] Create AdminTestimonialController
-   [ ] Add testimonial management page in admin
-   [ ] Bulk approve/reject functionality
-   [ ] Email notification on approval
-   [ ] Featured testimonial selection

## Commands Run

```bash
php artisan make:model ServiceTestimonial -m
php artisan make:controller Front/TestimonialController
php artisan make:seeder ServiceTestimonialSeeder
php artisan migrate
php artisan db:seed --class=ServiceTestimonialSeeder
npm run build
```
