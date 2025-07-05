<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficeLocationController;
use App\Http\Controllers\StaffInformationController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\MapController;

// Redirect root to map
Route::get('/', function () {
    return redirect()->route('map.index');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Map Routes (accessible by everyone)
Route::prefix('map')->name('map.')->group(function () {
    Route::get('/', [MapController::class, 'index'])->name('index');
    Route::get('/debug', [MapController::class, 'index'])->name('debug');
    Route::get('/osm', [MapController::class, 'indexOSM'])->name('index.osm');
    Route::get('/data', [MapController::class, 'getOfficesData'])->name('data');
    Route::get('/office/{office}', [MapController::class, 'showOffice'])->name('office.show');
    Route::get('/staff', [MapController::class, 'staffDirectory'])->name('staff.directory');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Office Locations
    Route::resource('offices', OfficeLocationController::class);
    
    // Staff Information
    Route::resource('staff', StaffInformationController::class);
    
    // Reminders
    Route::resource('reminders', ReminderController::class);
});
