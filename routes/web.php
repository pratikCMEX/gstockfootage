<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController as ForgotPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect()->route('home');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('check.login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/contact_us_store', [ContactController::class, 'store'])->name('contact.add');
Route::get('/contact_us', [ContactController::class, 'index'])->name('contact');

Route::get('/product_list', [HomeController::class, 'productList'])->name('product.list');
Route::get('/product_detail/{id}', [HomeController::class, 'productDetail'])->name('product.detail');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/forgot-password-store', [NewPasswordController::class, 'store'])->name('password.store');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');

Route::get('/quote', [ContactController::class, 'quote'])->name('quote');
Route::post('/quote', [ContactController::class, 'quoteStore'])->name('quote.store');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');

Route::middleware('auth')->group(function () {});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/logout', function () {
    $user = Auth::guard('web')->user();

    if ($user) {
        Auth::logout();
    } else {
        return redirect()->route('home');
    }
    Session::flush();
    return redirect()->route('home');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
