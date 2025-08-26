<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\ReservationForm;
use App\Http\Livewire\MyReservations;
use App\Http\Livewire\AdminDashboard;

Route::get('/', function () {
    return view('homepage');
});

// Auth routes - only accessible by guests
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Logout route - accessible by authenticated users
Route::middleware('auth')->post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Protected routes - only accessible by authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/reservation', ReservationForm::class)->name('reservation');
    Route::get('/reserve', ReservationForm::class)->name('reserve');
    Route::get('/my-reservations', MyReservations::class)->name('my-reservations');
});

// Admin routes - only accessible by admin users
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
});