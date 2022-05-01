<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/social-auth/{provider}', [SocialController::class, "redirectToProvider"])->name('auth.social');

Route::get('/social-auth/{provider}/callback', [SocialController::class, "handleProviderCallback"])->name('auth.social.callback');

Route::get('/register', [HomeController::class, "openRegistrationPage"])->name('register');

Route::get('/auth', [HomeController::class, "openAuthorizationPage"])->name('auth');

Route::get('/home', [HomeController::class, "openHomePage"])->name('home');

Route::get('/settings', [HomeController::class, "openSettingsPage"])->name('settings');

Route::get('/menu', [HomeController::class, "openMenuPage"])->name('menu');

Route::get('/product/{id}', [HomeController::class, "openProductPage"])->name('product');

Route::get('/cart', [HomeController::class, "openCartPage"])->name('cart');

Route::get('/news', [HomeController::class, "openNewsPage"])->name('news');

Route::get('/post/{id}', [HomeController::class, "openPostPage"])->name('post');

Route::get('/checkout', [HomeController::class, "openCheckoutPage"])->name('checkout');

Route::get('/home-after-social', [HomeController::class, "processToHomePageAfterSocialAuth"])->name('home-social');
