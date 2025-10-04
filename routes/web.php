<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MealController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Client routes
    Route::middleware('client')->group(function () {
        Route::resource('bookings', BookingController::class);
        Route::resource('orders', OrderController::class);
        Route::get('/orders/draft', [OrderController::class, 'draft'])->name('orders.draft');
        Route::post('/orders/add-meal', [OrderController::class, 'addMeal'])->name('orders.add-meal');
        Route::delete('/orders/remove-meal/{orderItem}', [OrderController::class, 'removeMeal'])->name('orders.remove-meal');
    });
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('restaurants', RestaurantController::class);
        Route::resource('tables', TableController::class);
        Route::resource('meals', MealController::class);
        
        // Admin booking and order management
        Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
        Route::patch('/admin/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('admin.bookings.update');
        Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::patch('/admin/orders/{order}', [OrderController::class, 'adminUpdate'])->name('admin.orders.update');
    });
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
