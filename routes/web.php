<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDestinationController;
use App\Http\Controllers\Admin\AdminDestinationDetailController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\LandingPageController;
use App\Http\Controllers\Front\SearchResultController;
use App\Http\Controllers\User\UserAuthController;

//LandingPage
Route::get('/', [LandingPageController::class, 'home'])->name('home');

Route::get('/destination/{slug}', [LandingPageController::class, 'destination_detail'])->name('destination_detail');

//SearchPage
Route::post('/search-result', [SearchResultController::class, 'searchResult'])->name('search_result');
Route::get('/search-result', [SearchResultController::class, 'filterSearch'])->name('filter_search');

//BookingPage
Route::post('/destination/{slug}/information', [BookingController::class, 'saveInformation'])->name('booking_form');
Route::get('/destination/{slug}/booking', [BookingController::class, 'booking'])->name('booking_details');
Route::get('/booking-success', [BookingController::class, 'success'])->name('booking_success');

Route::middleware('auth')->group(function () {
    Route::post('/destination/{slug}/booking', [BookingController::class, 'storeBooking'])->name('booking_store');
    Route::get('/destination/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking_checkout');
    Route::post('/destination/{slug}/payment', [BookingController::class, 'payment'])->name('booking_payment');
});

//User Auth
Route::get('/login-register', [UserAuthController::class, 'login_register'])->name('login_register');
Route::post('/login', [UserAuthController::class, 'login_submit'])->name('login_submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
Route::post('/register', [UserAuthController::class, 'register_submit'])->name('register_submit');
Route::get('/register-verify', [UserAuthController::class, 'register_verify'])->name('register_verify');
Route::get('/forget-password', [UserAuthController::class, 'forget_password'])->name('forget_password');
Route::post('/forget-password', [UserAuthController::class, 'forget_password_submit'])->name('forget_password_submit');
Route::get('/reset-password', [UserAuthController::class, 'reset_password'])->name('reset_password');
Route::post('/reset-password', [UserAuthController::class, 'reset_password_submit'])->name('reset_password_submit');

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
