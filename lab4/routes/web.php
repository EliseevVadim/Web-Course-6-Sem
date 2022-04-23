<?php

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
    return view('welcome');
});

Route::get('/social-auth/{provider}', [SocialController::class, "redirectToProvider"])->name('auth.social');

Route::get('/social-auth/{provider}/callback', [SocialController::class, "handleProviderCallback"])->name('auth.social.callback');
