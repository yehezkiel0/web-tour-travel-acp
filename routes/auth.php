<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Admin\AdminAuthController;




Route::prefix('user')->group(function () {
  Route::get('/login-register', [UserAuthController::class, 'login_register'])->name('user.login_register');
  Route::get('/login', [UserAuthController::class, 'login'])->name('user.login');
  Route::get('/register', [UserAuthController::class, 'register'])->name('user.register');
  Route::post('/login', [UserAuthController::class, 'login_submit'])->name('user.login.submit');
  Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
  Route::post('/register', [UserAuthController::class, 'register_submit'])->name('user.register.submit');
  Route::get('/register-verify', [UserAuthController::class, 'register_verify'])->name('user.register_verify');
  Route::get('/forget-password', [UserAuthController::class, 'forget_password'])->name('user.forget_password');
  Route::post('/forget-password', [UserAuthController::class, 'forget_password_submit'])->name('user.forget_password_submit');
  Route::get('/reset-password', [UserAuthController::class, 'reset_password'])->name('user.reset_password');
  Route::post('/reset-password', [UserAuthController::class, 'reset_password_submit'])->name('user.reset_password_submit');
});


Route::prefix('admin')->group(function () {
  Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
  Route::post('/login', [AdminAuthController::class, 'login_submit'])->name('admin.login.submit');
  Route::get('/forget-password', [AdminAuthController::class, 'forget_password'])->name('admin.forget_password');
  Route::post('/forget-password', [AdminAuthController::class, 'forget_password_submit'])->name('admin.forget_password.submit');
  Route::get('/reset-password', [AdminAuthController::class, 'reset_password'])->name('admin.reset_password');
  Route::post('/reset-password', [AdminAuthController::class, 'reset_password_submit'])->name('admin.reset_password.submit');
});
