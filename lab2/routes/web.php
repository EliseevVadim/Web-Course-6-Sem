<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\UserController;
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

Route::any('/telegram/handler', [TelegramController::class, "handler"]);

Route::get('/openServiceAdding', [ModerationController::class, "openServiceAdding"])->name("openServiceAdding");

Route::post('/addService', [ModerationController::class, "addService"]);

Route::get('/addServiceType', [ModerationController::class, "openServiceTypeAdding"])->name("typeAdding");

Route::post('/addServiceType', [ModerationController::class, "addServiceType"]);

Route::get('/tinkerTest', [HomeController::class, "openTinkerPage"]);

Route::post('/setUserId', [UserController::class, "setUserId"]);

Route::get('/getUserId', [UserController::class, "getUserId"]);

Route::delete('/unauthUser', [UserController::class, "unauthUser"]);
