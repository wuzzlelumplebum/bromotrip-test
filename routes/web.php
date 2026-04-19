<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\Admin\TourPackageManagementController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $packages = \App\Models\TourPackage::where('is_active', true)->latest()->take(3)->get();
    return view('welcome', compact('packages'));
})->name('home');

// Tour Routes
Route::get('/tours', [TourPackageController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourPackageController::class, 'show'])->name('tours.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('packages', TourPackageManagementController::class)->names('packages');
    Route::get('/packages/{package}/schedules', [TourPackageManagementController::class, 'schedules'])->name('packages.schedules');
    Route::post('/packages/{package}/schedules', [TourPackageManagementController::class, 'storeSchedule'])->name('packages.schedules.store');
    Route::delete('/schedules/{schedule}', [TourPackageManagementController::class, 'destroySchedule'])->name('schedules.destroy');
    Route::resource('bookings', BookingManagementController::class)->names('bookings');
    Route::post('/bookings/{booking}/confirm', [BookingManagementController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/complete', [BookingManagementController::class, 'complete'])->name('bookings.complete');
    Route::post('/bookings/{booking}/cancel', [BookingManagementController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}', [BookingManagementController::class, 'show'])->name('bookings.show');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{schedule}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store/{schedule}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Profile Routes
    Route::get('/profile', [ProfilePageController::class, 'index'])->name('profile.index');
    Route::patch('/profile/update', [ProfilePageController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfilePageController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';
