<?php

use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController as ForgotPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController as ControllersCollectionController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLicenceController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\WebpageController;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/order_email1', function () {
    return redirect()->route('order_mail');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('login')
            ->with('msg_error', 'Invalid verification link.');
    }

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return redirect()->route('login')
            ->with('msg_error', 'Invalid verification link.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')
            ->with('msg_success', 'Email already verified. You can login.');
    }

    $user->markEmailAsVerified();

    return redirect()->route('login')
        ->with('msg_success', 'Email verified successfully! You can now login.');
})->middleware(['signed'])->name('verification.verify');

Route::post('/resend-verification', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $user = User::where('email', $validated['email'])->first();

    if ($user && !$user->hasVerifiedEmail()) {
        $user->sendEmailVerificationNotification();
        return back()->with('msg_success', 'Verification email sent! Please check your inbox.');
    }

    if ($user && $user->hasVerifiedEmail()) {
        return back()->with('msg_error', 'This email is already verified. You can login.');
    }

    return back()->with('msg_error', 'Unable to send verification email. Please check email address.');
})->name('verification.resend');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Route::get('/test-vision', function () {
//     $apiKey   = 'AIzaSyB69Z85Exygj04LYp9l5cc4RkEjDEmk-jk';
//     $endpoint = "https://vision.googleapis.com/v1/images:annotate?key={$apiKey}";

//     // Test with a public image URL
//     $response = Http::post($endpoint, [
//         'requests' => [[
//             'image'    => ['source' => ['imageUri' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/PNG_transparency_demonstration_1.png/280px-PNG_transparency_demonstration_1.png']],
//             'features' => [
//                 ['type' => 'LABEL_DETECTION', 'maxResults' => 5],
//             ],
//         ]],
//     ]);

//     return $response->json();
// });
Route::post('/photos/search-by-image', [HomeController::class, 'searchByImage'])->name('photos.searchByImage');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/print', [HomeController::class, 'printStore'])->name('print_store');
Route::get('/videos', [HomeController::class, 'videos'])->name('videos');
Route::get('/allPhotos', [HomeController::class, 'allPhotos'])->name('all_photos');
Route::get('/enterprise', [HomeController::class, 'enterprise'])->name('enterprise');
Route::get('/product_list', [HomeController::class, 'productList'])->name('product.list');
Route::get('/product_detail/{id}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/home_search', [HomeController::class, 'homeSearch'])->name('home.search');

Route::get('/download-bucket', [HomeController::class, 'downloadAllFiles']);

Route::get('/pricing', [PricingController::class, 'pricing'])->name('pricing');

Route::get('/collection', [CollectionsController::class, 'index'])->name('collection');

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('check.login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/check_user_is_exist', [AuthController::class, 'checkUserIsExist'])->name('user_check_exist');
Route::post('/check_user_is_valid', [AuthController::class, 'checkUserValid'])->name('user_check_valid');

Route::post('/contact_us_store', [ContactController::class, 'store'])->name('contact.add');
Route::get('/contact_us', [ContactController::class, 'index'])->name('contact');
Route::get('/quote', [ContactController::class, 'quote'])->name('quote');
Route::post('/quote', [ContactController::class, 'quoteStore'])->name('quote.store');

Route::get('/user_profile', [ProfileController::class, 'index'])->name('user.profile');


Route::get('/term', [WebpageController::class, 'term'])->name('term');
Route::get('/privacy', [WebpageController::class, 'privacy'])->name('privacy');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog_detail/{id}', [BlogController::class, 'blog_detail'])->name('blog_detail');


Route::post('/add_favorite', [FavoritesController::class, 'addToFavorite'])->name('add_favorite');
Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');
Route::post('/remove_favorites', [FavoritesController::class, 'removeFavorite'])->name('favorites.remove');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/forgot-password-store', [NewPasswordController::class, 'store'])->name('password.store');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::post('/checkout/process', [PaymentController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [PaymentController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');
Route::post('/stripe/handleWebhook', [PaymentController::class, 'handleWebhook']);

Route::get('/download/file', [CheckoutController::class, 'downloadFile'])->name('download.file')->middleware('auth');


Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.cart');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove.cart');
Route::get('/cart', [CartController::class, 'index'])->name('cart.list');

Route::middleware('auth')->group(function () {

    Route::get('/view_profile', [ProfileController::class, 'edit'])->name('view_profile');
    Route::post('update_profile', [ProfileController::class, 'update_profile'])->name('front.update_profile');
    Route::post('update_password', [ProfileController::class, 'update_password'])->name('front.update_password');
    Route::post('check_password', [ProfileController::class, 'check_password'])->name('front.check_password');
});

Route::middleware('auth')->group(function () {

    // Route::get('/subscription/checkout/{id}',[UserSubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/stripe-session', [UserSubscriptionController::class, 'stripeSession'])->name('subscription.stripe');
    Route::get('/subscription/success', [UserSubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscription/cancel', [UserSubscriptionController::class, 'cancel'])->name('subscription.cancel');

    Route::post('/license/checkout', [UserLicenceController::class, 'checkout'])->name('license.checkout');
    Route::get('/license/success', [UserLicenceController::class, 'success'])->name('license.success');
    Route::get('/license/cancel', [UserLicenceController::class, 'cancel'])->name('license.cancel');
});

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
