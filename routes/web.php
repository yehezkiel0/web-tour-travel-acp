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
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\HotelController;
use App\Http\Controllers\Front\LandingPageController;
use App\Http\Controllers\Front\SearchResultController;
use App\Http\Controllers\Front\TestimonialController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Front\PromoCodeController;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::get('/', [LandingPageController::class, 'home'])->name('home');


        Route::get('/destination/{slug}', [LandingPageController::class, 'destination_detail'])->name('destination_detail');


        Route::get('/services/medical', [LandingPageController::class, 'servicesMedical'])->name('services_medical');
        Route::get('/services/recruitment', [LandingPageController::class, 'servicesRecruitment'])->name('services_recruitment');
        Route::get('/services/entertainment', [LandingPageController::class, 'servicesEntertainment'])->name('services_entertainment');


        Route::get('/destination', [SearchResultController::class, 'index'])->name('destination');

        Route::get('/search-result', [SearchResultController::class, 'index'])->name('search_result');
        Route::post('/currency/switch', function (\Illuminate\Http\Request $request) {
            $request->validate(['currency' => 'required|string|in:IDR,USD,KRW,SGD,MYR,EUR']);
            session(['currency' => $request->currency]);
            return redirect()->back();
        })->name('currency.switch');


        Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
        Route::get('/hotel/filter', [HotelController::class, 'filter'])->name('hotel.filter');
        Route::get('/hotel/{slug}', [HotelController::class, 'show'])->name('hotel.show');
        Route::get('/hotel-booking-success', [HotelBookingController::class, 'success'])->name('hotel.success');


        Route::post('/destination/{slug}/information', [BookingController::class, 'saveInformation'])->name('booking_form');
        Route::get('/destination/{slug}/booking', [BookingController::class, 'booking'])->name('booking_details');
        Route::get('/booking-success', [BookingController::class, 'success'])->name('booking_success');


        Route::get('/about-us', [LandingPageController::class, 'about'])->name('about');
        Route::get('/contact-us', [LandingPageController::class, 'contact'])->name('contact');
        Route::post('/contact-us', [AboutController::class, 'store'])->name('contact_submit');


        Route::get('/corporate-booking', [\App\Http\Controllers\Front\CorporateBookingController::class, 'index'])->name('corporate_index');
        Route::post('/corporate-booking', [\App\Http\Controllers\Front\CorporateBookingController::class, 'store'])->name('corporate_store');


        Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('/testimonials/{serviceType}', [TestimonialController::class, 'getApproved'])->name('testimonial.get');


        Route::post('/destination/{destinationId}/review', [\App\Http\Controllers\Front\ReviewController::class, 'store'])->middleware('auth')->name('review.store');
        Route::get('/destination/{destinationId}/reviews', [\App\Http\Controllers\Front\ReviewController::class, 'getReviews'])->name('review.get');
        Route::post('/review/{reviewId}/helpful', [\App\Http\Controllers\Front\ReviewController::class, 'markHelpful'])->middleware('auth')->name('review.helpful');


        Route::middleware('auth')->group(function () {
            Route::get('/wishlist', [\App\Http\Controllers\Front\WishlistController::class, 'index'])->name('wishlist.index');
            Route::post('/wishlist/toggle', [\App\Http\Controllers\Front\WishlistController::class, 'toggle'])->name('wishlist.toggle');
            Route::post('/wishlist/check', [\App\Http\Controllers\Front\WishlistController::class, 'check'])->name('wishlist.check');
        });


        Route::post('/newsletter/subscribe', [\App\Http\Controllers\Front\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
        Route::get('/newsletter/unsubscribe/{token}', [\App\Http\Controllers\Front\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');


        Route::get('/blog', [\App\Http\Controllers\Front\BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'show'])->name('blog.show');
        Route::post('/blog/{id}/comment', [\App\Http\Controllers\Front\BlogController::class, 'storeComment'])->middleware('auth')->name('blog.comment.store');

        Route::middleware('user')->group(function () {
            Route::post('/destination/{slug}/booking', [BookingController::class, 'storeBooking'])->name('booking_store');
            Route::get('/destination/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking_checkout');
            Route::post('/destination/{slug}/payment', [BookingController::class, 'payment'])->name('booking_payment');


            Route::post('/hotel/{slug}/booking', [HotelBookingController::class, 'store'])->name('hotel.booking.store');
            Route::get('/hotel/{slug}/checkout', [HotelBookingController::class, 'checkout'])->name('hotel.checkout');
            Route::post('/hotel/{slug}/payment', [HotelBookingController::class, 'payment'])->name('hotel.booking.payment');


            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('/my-bookings', [ProfileController::class, 'bookings'])->name('profile.bookings');
            Route::get('/my-points', [ProfileController::class, 'points'])->name('profile.points');
            Route::get('/my-bookings/{code}', [ProfileController::class, 'bookingDetail'])->name('profile.booking.detail');
            Route::get('/my-referrals', [ProfileController::class, 'referrals'])->name('profile.referrals');


            Route::resource('itineraries', \App\Http\Controllers\Front\ItineraryController::class);
            Route::post('/itinerary/add-item', [\App\Http\Controllers\Front\ItineraryController::class, 'addItem'])->name('itinerary.add_item');
            Route::delete('/itinerary/remove-item/{id}', [\App\Http\Controllers\Front\ItineraryController::class, 'removeItem'])->name('itinerary.remove_item');
            Route::post('/itinerary/update-order', [\App\Http\Controllers\Front\ItineraryController::class, 'updateOrder'])->name('itinerary.update_order');


            Route::get('/visa-assistance', [\App\Http\Controllers\Front\VisaController::class, 'index'])->name('visa.index');
            Route::get('/visa-assistance/apply', [\App\Http\Controllers\Front\VisaController::class, 'create'])->name('visa.create');
            Route::post('/visa-assistance', [\App\Http\Controllers\Front\VisaController::class, 'store'])->name('visa.store');
            Route::get('/visa-assistance/{id}', [\App\Http\Controllers\Front\VisaController::class, 'show'])->name('visa.show');
        });

        Route::get('/shared-itinerary/{token}', [\App\Http\Controllers\Front\ItineraryController::class, 'shared'])->name('itinerary.shared');


    }
);


Route::post('/promo-code/check', [\App\Http\Controllers\Front\PromoCodeController::class, 'check'])->name('promo_code_check');