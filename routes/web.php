<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingReportController;
use Illuminate\Support\Facades\Auth;

// Root redirect to login
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes([]);

// Only allow access to dashboard if logged in
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/booking-chart-data', [DashboardController::class, 'booking_chart_data']);

    // Groups Routes
    Route::resource('groups', GroupController::class);
    Route::get('groups-getdata', [GroupController::class, 'getGroupData'])->name('group.getdata');

    // School Routes
    Route::resource('schools', SchoolController::class);
    Route::get('school-getdata', [SchoolController::class, 'getSchoolData'])->name('school.getdata');

    // Team Routes
    Route::resource('teams', TeamController::class);
    Route::get('team-getdata', [TeamController::class, 'getTeamData'])->name('team.getdata');

    // Therapist Routes
    Route::resource('therapists', TherapistController::class);
    Route::get('therapist-getdata', [TherapistController::class, 'getTherapistData'])->name('therapist.getdata');


    // Room Routes
    Route::resource('rooms', RoomController::class);
    Route::get('room-getdata', [RoomController::class, 'getRoomData'])->name('room.getdata');

    // Booking Routes
    Route::resource('bookings', BookingController::class);
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/school-form', [BookingController::class, 'storeSchoolForm'])->name('bookings.school.form');
    Route::post('/bookings/fsp-form', [BookingController::class, 'storeFspForm'])->name('bookings.fsp.form');
    Route::get('booking-getdata', [BookingController::class, 'getBookingData'])->name('booking.getdata');

    Route::post('/bookings/update', [BookingController::class, 'updateCentreHome'])->name('bookings.update');
    Route::post('/bookings/update-school-form', [BookingController::class, 'updateSchoolForm'])->name('bookings.update.school.form');
    Route::post('/bookings/update-fsp-form', [BookingController::class, 'updateFspForm'])->name('bookings.update.fsp.form');
    Route::post('/change-status/{id}', [BookingController::class, 'changeStatus'])->name('bookings.change.status');

    Route::post('/group-booking', [BookingController::class, 'groupBookings'])->name('group.bookings');
    Route::delete('/group-booking/{group_id}/remove-booking/{booking_id}', [BookingController::class, 'removeBooking'])->name('group-booking.remove-booking');


    // Contact Routes
    Route::resource('contacts', ContactController::class);
    Route::get('contacts-data', [ContactController::class, 'getContactData'])->name('contact.getdata');

    //Profile Routes
    Route::get('update-profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /**
     * Booking Reports
     */
    Route::get('booking-reports', [BookingReportController::class, 'booking_reports'])->name('booking.reports');
    Route::get('get-booking-reports', [BookingReportController::class, 'get_booking_reports'])->name('reports.data');
    Route::get('/reports/download', [BookingReportController::class, 'downloadReport'])->name('reports.download');

});
