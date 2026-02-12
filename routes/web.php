<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController as ForgotPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('password.request');
});


Route::get('/home', [HomeController::class, 'getImageList'])->name('home');
Route::post('/contact_us_store', [ContactController::class, 'store'])->name('contact.add');
Route::get('/contact_us', [ContactController::class, 'index'])->name('contact');
Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
