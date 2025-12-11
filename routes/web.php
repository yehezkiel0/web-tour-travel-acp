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
use App\Http\Controllers\front\AboutController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\HotelController;
use App\Http\Controllers\Front\LandingPageController;
use App\Http\Controllers\Front\SearchResultController;
use App\Http\Controllers\User\UserAuthController;

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
Route::post('/search', [SearchResultController::class, 'searchResult'])->name('search_result');
Route::get('/search', [SearchResultController::class, 'searchAll'])->name('search_all');
Route::get('/search-result', [SearchResultController::class, 'filterSearch'])->name('filter_search');

//HotelPages
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
Route::get('/hotel/filter', [HotelController::class, 'filter'])->name('hotel.filter');
Route::get('/hotel/{slug}', [HotelController::class, 'show'])->name('hotel.show');
Route::get('/hotel-booking-success', [HotelController::class, 'success'])->name('hotel.success');

//BookingPage
Route::post('/destination/{slug}/information', [BookingController::class, 'saveInformation'])->name('booking_form');
Route::get('/destination/{slug}/booking', [BookingController::class, 'booking'])->name('booking_details');
Route::get('/booking-success', [BookingController::class, 'success'])->name('booking_success');

//InformationsPage
Route::get('/about-us', [LandingPageController::class, 'about'])->name('about');
Route::get('/contact-us', [LandingPageController::class, 'contact'])->name('contact');
Route::post('/contact-us', [AboutController::class, 'store'])->name('contact_submit');

Route::middleware('user')->group(function () {
    Route::post('/destination/{slug}/booking', [BookingController::class, 'storeBooking'])->name('booking_store');
    Route::get('/destination/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking_checkout');
    Route::post('/destination/{slug}/payment', [BookingController::class, 'payment'])->name('booking_payment');

    // Hotel booking routes (requires authentication)
    Route::post('/hotel/{slug}/booking', [HotelController::class, 'booking'])->name('hotel.booking');
    Route::get('/hotel/{slug}/checkout', [HotelController::class, 'checkout'])->name('hotel.checkout');
    Route::post('/hotel/{slug}/payment', [HotelController::class, 'payment'])->name('hotel.payment');
});

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
    Route::get('/hotel/edit/{id}', [AdminHotelController::class, 'edit'])->name('admin_hotel_edit');
    Route::put('/hotel/{id}', [AdminHotelController::class, 'update'])->name('admin_hotel_update');
    Route::delete('/hotel/{id}', [AdminHotelController::class, 'delete'])->name('admin_hotel_delete');
    Route::delete('/hotel/photo/{id}', [AdminHotelController::class, 'deletePhoto'])->name('admin_hotel_delete_photo');

    // Hotel Rooms
    Route::get('/hotel/{id}/rooms', [AdminHotelController::class, 'rooms'])->name('admin_hotel_rooms');
    Route::post('/hotel/{id}/rooms', [AdminHotelController::class, 'storeRoom'])->name('admin_hotel_store_room');
    Route::delete('/hotel/{hotelId}/rooms/{roomId}', [AdminHotelController::class, 'deleteRoom'])->name('admin_hotel_delete_room');

    // Hotel Amenities
    Route::get('/hotel/{id}/amenities', [AdminHotelController::class, 'amenities'])->name('admin_hotel_amenities');
    Route::post('/hotel/{id}/amenities', [AdminHotelController::class, 'storeAmenity'])->name('admin_hotel_store_amenity');
    Route::delete('/hotel/{hotelId}/amenities/{amenityId}', [AdminHotelController::class, 'deleteAmenity'])->name('admin_hotel_delete_amenity');

    // Hotel Bookings
    Route::get('/hotel-bookings', [AdminHotelBookingController::class, 'index'])->name('admin_hotel_bookings');
    Route::get('/hotel-bookings/{id}', [AdminHotelBookingController::class, 'show'])->name('admin_hotel_booking_show');
    Route::put('/hotel-bookings/{id}/status', [AdminHotelBookingController::class, 'updateStatus'])->name('admin_hotel_booking_update_status');
    Route::delete('/hotel-bookings/{id}', [AdminHotelBookingController::class, 'delete'])->name('admin_hotel_booking_delete');
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
