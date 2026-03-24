<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminItemController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root
Route::get('/', function () {
    return redirect('/items');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::post('/items/{item}/book', [BookingController::class, 'store'])->name('items.book');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/items', [AdminItemController::class, 'index'])->name('items.index');
        Route::get('/items/create', [AdminItemController::class, 'create'])->name('items.create');
        Route::post('/items', [AdminItemController::class, 'store'])->name('items.store');
        Route::get('/items/{item}/edit', [AdminItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/{item}', [AdminItemController::class, 'update'])->name('items.update');
        Route::get('/items/{item}', [AdminItemController::class, 'show'])->name('items.show');
        Route::post('/items/{item}/close', [AdminItemController::class, 'close'])->name('items.close');

        Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/reveal-phone', [AdminUserController::class, 'revealPhone'])->name('users.reveal-phone');
    });
});
