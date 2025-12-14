<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDestinationController;
use App\Http\Controllers\Admin\AdminDestinationDetailController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminHotelBookingController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminPromoCodeController;
use App\Http\Controllers\Admin\AdminVisaController;
use App\Http\Controllers\Admin\AdminInsuranceController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminPriceSettingController;
use App\Http\Controllers\Admin\AdminSeasonalPricingController;



Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
Route::post('/profile', [AdminAuthController::class, 'profile_submit'])->name('admin.profile.submit');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::get('/visas', [AdminVisaController::class, 'index'])->name('admin.visas.index');
Route::get('/visas/{id}', [AdminVisaController::class, 'show'])->name('admin.visas.show');
Route::put('/visas/{id}', [AdminVisaController::class, 'update'])->name('admin.visas.update');


Route::get('/insurance', [AdminInsuranceController::class, 'index'])->name('admin.insurance.index');
Route::get('/insurance/create', [AdminInsuranceController::class, 'create'])->name('admin.insurance.create');
Route::post('/insurance', [AdminInsuranceController::class, 'store'])->name('admin.insurance.store');
Route::get('/insurance/{id}/edit', [AdminInsuranceController::class, 'edit'])->name('admin.insurance.edit');
Route::put('/insurance/{id}', [AdminInsuranceController::class, 'update'])->name('admin.insurance.update');
Route::delete('/insurance/{id}', [AdminInsuranceController::class, 'destroy'])->name('admin.insurance.destroy');


Route::get('/destination', [AdminDestinationController::class, 'index'])->name('admin.destinations.index');
Route::get('/destination/create', [AdminDestinationController::class, 'create'])->name('admin.destinations.create');
Route::post('/destination', [AdminDestinationController::class, 'store'])->name('admin.destinations.store');
Route::get('/destination/edit/{slug}', [AdminDestinationController::class, 'edit'])->name('admin.destinations.edit');
Route::put('/destination/{id}', [AdminDestinationController::class, 'update'])->name('admin.destinations.update');
Route::delete('/destination/{id}', [AdminDestinationController::class, 'delete'])->name('admin.destinations.destroy');
Route::get('/destination/{slug}/photos', [AdminDestinationController::class, 'photos'])->name('admin.destinations.photos');
Route::post('/destination/{slug}/photos', [AdminDestinationController::class, 'photos_store'])->name('admin.destinations.photos.store');


Route::get('/destination/{slug}/details', [AdminDestinationDetailController::class, 'details'])->name('admin.destinations.details');
Route::post('/destination/{slug}/details', [AdminDestinationDetailController::class, 'details_store'])->name('admin.destinations.details.store');
Route::get('/destination/{slug}/details/edit', [AdminDestinationDetailController::class, 'edit'])->name('admin.destinations.details.edit');
Route::put('/destination/{slug}/details', [AdminDestinationDetailController::class, 'update'])->name('admin.destinations.details.update');


Route::get('/transaction', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
Route::put('/transaction/{id}/status', [AdminTransactionController::class, 'updateStatus'])->name('admin.transactions.update_status');
Route::delete('/transaction/{id}', [AdminTransactionController::class, 'destroy'])->name('admin.transactions.destroy');


Route::get('/hotel', [AdminHotelController::class, 'index'])->name('admin.hotels.index');
Route::get('/hotel/create', [AdminHotelController::class, 'create'])->name('admin.hotels.create');
Route::post('/hotel', [AdminHotelController::class, 'store'])->name('admin.hotels.store');
Route::get('/hotel/edit/{hotel:slug}', [AdminHotelController::class, 'edit'])->name('admin.hotels.edit');
Route::put('/hotel/{hotel:slug}', [AdminHotelController::class, 'update'])->name('admin.hotels.update');
Route::delete('/hotel/{hotel:slug}', [AdminHotelController::class, 'delete'])->name('admin.hotels.destroy');
Route::delete('/hotel/photo/{id}', [AdminHotelController::class, 'deletePhoto'])->name('admin.hotels.photos.destroy');


Route::get('/hotel/{hotel:slug}/rooms', [AdminHotelController::class, 'rooms'])->name('admin.hotels.rooms');
Route::post('/hotel/{hotel:slug}/rooms', [AdminHotelController::class, 'storeRoom'])->name('admin.hotels.rooms.store');
Route::put('/hotel/{hotel:slug}/rooms/{room}', [AdminHotelController::class, 'updateRoom'])->name('admin.hotels.rooms.update');
Route::delete('/hotel/{hotel:slug}/rooms/{room}', [AdminHotelController::class, 'deleteRoom'])->name('admin.hotels.rooms.destroy');


Route::get('/hotel/{hotel:slug}/amenities', [AdminHotelController::class, 'amenities'])->name('admin.hotels.amenities');
Route::post('/hotel/{hotel:slug}/amenities', [AdminHotelController::class, 'storeAmenity'])->name('admin.hotels.amenities.store');
Route::delete('/hotel/{hotel:slug}/amenities/{amenity}', [AdminHotelController::class, 'deleteAmenity'])->name('admin.hotels.amenities.destroy');


Route::get('/hotel-bookings', [AdminHotelBookingController::class, 'index'])->name('admin.hotels.bookings.index');
Route::get('/hotel-bookings/{id}', [AdminHotelBookingController::class, 'show'])->name('admin.hotels.bookings.show');
Route::put('/hotel-bookings/{id}/status', [AdminHotelBookingController::class, 'updateStatus'])->name('admin.hotels.bookings.update_status');
Route::delete('/hotel-bookings/{id}', [AdminHotelBookingController::class, 'delete'])->name('admin.hotels.bookings.destroy');


Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('admin.testimonials.index');
Route::post('/testimonials/{id}/approve', [AdminTestimonialController::class, 'approve'])->name('admin.testimonials.approve');
Route::post('/testimonials/{id}/unapprove', [AdminTestimonialController::class, 'unapprove'])->name('admin.testimonials.unapprove');
Route::delete('/testimonials/{id}', [AdminTestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');


Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
Route::post('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
Route::post('/reviews/{id}/unapprove', [AdminReviewController::class, 'unapprove'])->name('admin.reviews.unapprove');
Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');


Route::get('/promo-codes', [AdminPromoCodeController::class, 'index'])->name('admin.promo_codes.index');
Route::get('/promo-codes/create', [AdminPromoCodeController::class, 'create'])->name('admin.promo_codes.create');
Route::post('/promo-codes', [AdminPromoCodeController::class, 'store'])->name('admin.promo_codes.store');
Route::get('/promo-codes/{id}/edit', [AdminPromoCodeController::class, 'edit'])->name('admin.promo_codes.edit');
Route::put('/promo-codes/{id}', [AdminPromoCodeController::class, 'update'])->name('admin.promo_codes.update');
Route::delete('/promo-codes/{id}', [AdminPromoCodeController::class, 'destroy'])->name('admin.promo_codes.destroy');


Route::get('/newsletters', function () {
  $subscribers = \App\Models\NewsletterSubscriber::latest()->paginate(15);
  return view('admin.newsletters.index', compact('subscribers'));
})->name('admin.newsletters.index');


Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('admin.analytics.index');


Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');


Route::get('/blog', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
Route::post('/blog', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
Route::get('/blog/categories', [AdminBlogController::class, 'categories'])->name('admin.blogs.categories');
Route::post('/blog/categories', [AdminBlogController::class, 'storeCategory'])->name('admin.blogs.categories.store');
Route::delete('/blog/categories/{category}', [AdminBlogController::class, 'deleteCategory'])->name('admin.blogs.categories.destroy');
Route::get('/blog/{post}/edit', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
Route::put('/blog/{post}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
Route::delete('/blog/{post}', [AdminBlogController::class, 'delete'])->name('admin.blogs.destroy');


Route::get('/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');


Route::get('/price-settings', [AdminPriceSettingController::class, 'index'])->name('admin.price_settings.index');
Route::put('/price-settings', [AdminPriceSettingController::class, 'update'])->name('admin.price_settings.update');


Route::get('/seasonal-pricing', [AdminSeasonalPricingController::class, 'index'])->name('admin.seasonal_pricing.index');
Route::post('/seasonal-pricing', [AdminSeasonalPricingController::class, 'store'])->name('admin.seasonal_pricing.store');
Route::delete('/seasonal-pricing/{id}', [AdminSeasonalPricingController::class, 'destroy'])->name('admin.seasonal_pricing.destroy');
