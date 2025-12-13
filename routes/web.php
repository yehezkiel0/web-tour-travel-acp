<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDestinationController;
use App\Http\Controllers\Admin\AdminDestinationDetailController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminHotelBookingController;
use App\Http\Controllers\Front\HotelBookingController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\front\AboutController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\HotelController;
use App\Http\Controllers\Front\LandingPageController;
use App\Http\Controllers\Front\SearchResultController;
use App\Http\Controllers\Front\TestimonialController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\ProfileController;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        //LandingPage
        Route::get('/', [LandingPageController::class, 'home'])->name('home');

        //DestinationDetail
        Route::get('/destination/{slug}', [LandingPageController::class, 'destination_detail'])->name('destination_detail');

        //Services
        Route::get('/services/medical', [LandingPageController::class, 'servicesMedical'])->name('services_medical');
        Route::get('/services/recruitment', [LandingPageController::class, 'servicesRecruitment'])->name('services_recruitment');
        Route::get('/services/entertainment', [LandingPageController::class, 'servicesEntertainment'])->name('services_entertainment');

        //SearchPage
        Route::get('/destination', [SearchResultController::class, 'index'])->name('destination');

        Route::get('/search-result', [SearchResultController::class, 'index'])->name('search_result');
        Route::post('/currency/switch', function (\Illuminate\Http\Request $request) {
            $request->validate(['currency' => 'required|string|in:IDR,USD,KRW,SGD,MYR,EUR']);
            session(['currency' => $request->currency]);
            return redirect()->back();
        })->name('currency.switch');

        //HotelPages
        Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
        Route::get('/hotel/filter', [HotelController::class, 'filter'])->name('hotel.filter');
        Route::get('/hotel/{slug}', [HotelController::class, 'show'])->name('hotel.show');
        Route::get('/hotel-booking-success', [HotelBookingController::class, 'success'])->name('hotel.success');

        //BookingPage
        Route::post('/destination/{slug}/information', [BookingController::class, 'saveInformation'])->name('booking_form');
        Route::get('/destination/{slug}/booking', [BookingController::class, 'booking'])->name('booking_details');
        Route::get('/booking-success', [BookingController::class, 'success'])->name('booking_success');

        //InformationsPage
        Route::get('/about-us', [LandingPageController::class, 'about'])->name('about');
        Route::get('/contact-us', [LandingPageController::class, 'contact'])->name('contact');
        Route::post('/contact-us', [AboutController::class, 'store'])->name('contact_submit');

        //Testimonials
        Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('/testimonials/{serviceType}', [TestimonialController::class, 'getApproved'])->name('testimonial.get');

        // Reviews & Ratings
        Route::post('/destination/{destinationId}/review', [\App\Http\Controllers\Front\ReviewController::class, 'store'])->middleware('auth')->name('review.store');
        Route::get('/destination/{destinationId}/reviews', [\App\Http\Controllers\Front\ReviewController::class, 'getReviews'])->name('review.get');
        Route::post('/review/{reviewId}/helpful', [\App\Http\Controllers\Front\ReviewController::class, 'markHelpful'])->middleware('auth')->name('review.helpful');

        // Wishlist
        Route::middleware('auth')->group(function () {
            Route::get('/wishlist', [\App\Http\Controllers\Front\WishlistController::class, 'index'])->name('wishlist.index');
            Route::post('/wishlist/toggle', [\App\Http\Controllers\Front\WishlistController::class, 'toggle'])->name('wishlist.toggle');
            Route::post('/wishlist/check', [\App\Http\Controllers\Front\WishlistController::class, 'check'])->name('wishlist.check');
        });

        // Newsletter
        Route::post('/newsletter/subscribe', [\App\Http\Controllers\Front\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
        Route::get('/newsletter/unsubscribe/{token}', [\App\Http\Controllers\Front\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

        // Blog
        Route::get('/blog', [\App\Http\Controllers\Front\BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'show'])->name('blog.show');
        Route::post('/blog/{id}/comment', [\App\Http\Controllers\Front\BlogController::class, 'storeComment'])->middleware('auth')->name('blog.comment.store');

        Route::middleware('user')->group(function () {
            Route::post('/destination/{slug}/booking', [BookingController::class, 'storeBooking'])->name('booking_store');
            Route::get('/destination/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking_checkout');
            Route::post('/destination/{slug}/payment', [BookingController::class, 'payment'])->name('booking_payment');

            // Hotel booking routes (requires authentication)
            Route::post('/hotel/{slug}/booking', [HotelBookingController::class, 'store'])->name('hotel.booking.store');
            Route::get('/hotel/{slug}/checkout', [HotelBookingController::class, 'checkout'])->name('hotel.checkout');
            Route::post('/hotel/{slug}/payment', [HotelBookingController::class, 'payment'])->name('hotel.booking.payment');

            // User Profile routes
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('/my-bookings', [ProfileController::class, 'bookings'])->name('profile.bookings');
            Route::get('/my-points', [ProfileController::class, 'points'])->name('profile.points');
            Route::get('/my-bookings/{code}', [ProfileController::class, 'bookingDetail'])->name('profile.booking.detail');

            // Itinerary Routes
            Route::resource('itineraries', \App\Http\Controllers\Front\ItineraryController::class);
            Route::post('/itinerary/add-item', [\App\Http\Controllers\Front\ItineraryController::class, 'addItem'])->name('itinerary.add_item');
            Route::delete('/itinerary/remove-item/{id}', [\App\Http\Controllers\Front\ItineraryController::class, 'removeItem'])->name('itinerary.remove_item');
            Route::post('/itinerary/update-order', [\App\Http\Controllers\Front\ItineraryController::class, 'updateOrder'])->name('itinerary.update_order');
        });

        Route::get('/shared-itinerary/{token}', [\App\Http\Controllers\Front\ItineraryController::class, 'shared'])->name('itinerary.shared');


        //User Auth
        Route::prefix('user')->group(function () {
            Route::get('/login-register', [UserAuthController::class, 'login_register'])->name('login_register');
            Route::get('/login', [UserAuthController::class, 'login'])->name('login');
            Route::get('/register', [UserAuthController::class, 'register'])->name('register');
            Route::post('/login', [UserAuthController::class, 'login_submit'])->name('login_submit');
            Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
            Route::post('/register', [UserAuthController::class, 'register_submit'])->name('register_submit');
            Route::get('/register-verify', [UserAuthController::class, 'register_verify'])->name('register_verify');
            Route::get('/forget-password', [UserAuthController::class, 'forget_password'])->name('forget_password');
            Route::post('/forget-password', [UserAuthController::class, 'forget_password_submit'])->name('forget_password_submit');
            Route::get('/reset-password', [UserAuthController::class, 'reset_password'])->name('reset_password');
            Route::post('/reset-password', [UserAuthController::class, 'reset_password_submit'])->name('reset_password_submit');
        });
    }
);

//Admin dashboard
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin_dashboard');
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin_profile');
    Route::post('/profile', [AdminAuthController::class, 'profile_submit'])->name('admin_profile_submit');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin_logout');

    //Destination Section
    Route::get('/destination', [AdminDestinationController::class, 'index'])->name('admin_destination_index');
    Route::get('/destination/create', [AdminDestinationController::class, 'create'])->name('admin_destination_create');
    Route::post('/destination', [AdminDestinationController::class, 'store'])->name('admin_destination_store');
    Route::get('/destination/edit/{slug}', [AdminDestinationController::class, 'edit'])->name('admin_destination_edit');
    Route::put('/destination/{id}', [AdminDestinationController::class, 'update'])->name('admin_destination_update');
    Route::delete('/destination/{id}', [AdminDestinationController::class, 'delete'])->name('admin_destination_delete');
    Route::get('/destination/{slug}/photos', [AdminDestinationController::class, 'photos'])->name('destination_photos');
    Route::post('/destination/{slug}/photos', [AdminDestinationController::class, 'photos_store'])->name('destination_photos_store');

    //DestinationDetails Section
    Route::get('/destination/{slug}/details', [AdminDestinationDetailController::class, 'details'])->name('admin_destination_details');
    Route::post('/destination/{slug}/details', [AdminDestinationDetailController::class, 'details_store'])->name('admin_destination_details_store');
    Route::get('/destination/{slug}/details/edit', [AdminDestinationDetailController::class, 'edit'])->name('admin_destination_details_edit');
    Route::put('/destination/{slug}/details', [AdminDestinationDetailController::class, 'update'])->name('admin_destination_details_update');

    //Transactions Section
    Route::get('/transaction', [AdminTransactionController::class, 'index'])->name('admin_transaction_index');

    //Hotel Section
    Route::get('/hotel', [AdminHotelController::class, 'index'])->name('admin_hotel_index');
    Route::get('/hotel/create', [AdminHotelController::class, 'create'])->name('admin_hotel_create');
    Route::post('/hotel', [AdminHotelController::class, 'store'])->name('admin_hotel_store');
    Route::get('/hotel/edit/{hotel:slug}', [AdminHotelController::class, 'edit'])->name('admin_hotel_edit');
    Route::put('/hotel/{hotel:slug}', [AdminHotelController::class, 'update'])->name('admin_hotel_update');
    Route::delete('/hotel/{hotel:slug}', [AdminHotelController::class, 'delete'])->name('admin_hotel_delete');
    Route::delete('/hotel/photo/{id}', [AdminHotelController::class, 'deletePhoto'])->name('admin_hotel_delete_photo');

    // Hotel Rooms
    Route::get('/hotel/{hotel:slug}/rooms', [AdminHotelController::class, 'rooms'])->name('admin_hotel_rooms');
    Route::post('/hotel/{hotel:slug}/rooms', [AdminHotelController::class, 'storeRoom'])->name('admin_hotel_store_room');
    Route::put('/hotel/{hotel:slug}/rooms/{room}', [AdminHotelController::class, 'updateRoom'])->name('admin_hotel_update_room');
    Route::delete('/hotel/{hotel:slug}/rooms/{room}', [AdminHotelController::class, 'deleteRoom'])->name('admin_hotel_delete_room');

    // Hotel Amenities
    Route::get('/hotel/{hotel:slug}/amenities', [AdminHotelController::class, 'amenities'])->name('admin_hotel_amenities');
    Route::post('/hotel/{hotel:slug}/amenities', [AdminHotelController::class, 'storeAmenity'])->name('admin_hotel_store_amenity');
    Route::delete('/hotel/{hotel:slug}/amenities/{amenity}', [AdminHotelController::class, 'deleteAmenity'])->name('admin_hotel_delete_amenity');

    // Hotel Bookings
    Route::get('/hotel-bookings', [AdminHotelBookingController::class, 'index'])->name('admin_hotel_bookings');
    Route::get('/hotel-bookings/{id}', [AdminHotelBookingController::class, 'show'])->name('admin_hotel_booking_show');
    Route::put('/hotel-bookings/{id}/status', [AdminHotelBookingController::class, 'updateStatus'])->name('admin_hotel_booking_update_status');
    Route::delete('/hotel-bookings/{id}', [AdminHotelBookingController::class, 'delete'])->name('admin_hotel_booking_delete');

    // Testimonials Section
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('admin_testimonials_index');
    Route::post('/testimonials/{id}/approve', [AdminTestimonialController::class, 'approve'])->name('admin_testimonial_approve');
    Route::post('/testimonials/{id}/unapprove', [AdminTestimonialController::class, 'unapprove'])->name('admin_testimonial_unapprove');
    Route::delete('/testimonials/{id}', [AdminTestimonialController::class, 'destroy'])->name('admin_testimonial_delete');

    // Reviews Section  
    Route::get('/reviews', [\App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('admin_reviews_index');
    Route::post('/reviews/{id}/approve', [\App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('admin_review_approve');
    Route::post('/reviews/{id}/unapprove', [\App\Http\Controllers\Admin\AdminReviewController::class, 'unapprove'])->name('admin_review_unapprove');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\Admin\AdminReviewController::class, 'destroy'])->name('admin_review_delete');

    // Promo Codes Section
    Route::get('/promo-codes', [\App\Http\Controllers\Admin\AdminPromoCodeController::class, 'index'])->name('admin_promo_codes_index');
    Route::get('/promo-codes/create', [\App\Http\Controllers\Admin\AdminPromoCodeController::class, 'create'])->name('admin_promo_codes_create');
    Route::post('/promo-codes', [\App\Http\Controllers\Admin\AdminPromoCodeController::class, 'store'])->name('admin_promo_codes_store');
    Route::get('/promo-codes/{id}/edit', [\App\Http\Controllers\Admin\AdminPromoCodeController::class, 'edit'])->name('admin_promo_codes_edit');
    Route::put('/promo-codes/{id}', [\App\Http\Controllers\Admin\AdminPromoCodeController::class, 'update'])->name('admin_promo_codes_update');
    Route::delete('/promo-codes/{id}', [\App\Http\Controllers\Admin\AdminPromoCodeController::class, 'destroy'])->name('admin_promo_codes_delete');

    // Newsletter Section
    Route::get('/newsletters', function () {
        $subscribers = \App\Models\NewsletterSubscriber::latest()->paginate(15);
        return view('admin.newsletters.index', compact('subscribers'));
    })->name('admin_newsletters_index');

    // Blog Section
    Route::get('/blog', [\App\Http\Controllers\Admin\AdminBlogController::class, 'index'])->name('admin_blog_index');
    Route::get('/blog/create', [\App\Http\Controllers\Admin\AdminBlogController::class, 'create'])->name('admin_blog_create');
    Route::post('/blog', [\App\Http\Controllers\Admin\AdminBlogController::class, 'store'])->name('admin_blog_store');
    Route::get('/blog/categories', [\App\Http\Controllers\Admin\AdminBlogController::class, 'categories'])->name('admin_blog_categories');
    Route::post('/blog/categories', [\App\Http\Controllers\Admin\AdminBlogController::class, 'storeCategory'])->name('admin_blog_category_store');
    Route::delete('/blog/categories/{category}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'deleteCategory'])->name('admin_blog_category_delete');
    Route::get('/blog/{post}/edit', [\App\Http\Controllers\Admin\AdminBlogController::class, 'edit'])->name('admin_blog_edit');
    Route::put('/blog/{post}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'update'])->name('admin_blog_update');
    Route::delete('/blog/{post}', [\App\Http\Controllers\Admin\AdminBlogController::class, 'delete'])->name('admin_blog_delete');
});
// Admin Authentication
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin_login');
    Route::post('/login', [AdminAuthController::class, 'login_submit'])->name('admin_login_submit');
    Route::get('/forget-password', [AdminAuthController::class, 'forget_password'])->name('admin_forget_password');
    Route::post('/forget-password', [AdminAuthController::class, 'forget_password_submit'])->name('admin_forget_password_submit');
    Route::get('/reset-password', [AdminAuthController::class, 'reset_password'])->name('admin_reset_password');
    Route::post('/reset-password', [AdminAuthController::class, 'reset_password_submit'])->name('admin_reset_password_submit');
});

// Promo Code Check (Public/User)
Route::post('/promo-code/check', [\App\Http\Controllers\Front\PromoCodeController::class, 'check'])->name('promo_code_check');