<?php

use App\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::post('/', [HomeController::class, 'store'])->name('store');

Route::post('/loadWithDrive', [HomeController::class, 'storeWithGoogleDrive'])->name('storeWithGoogle');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/data-view', [HomeController::class, 'dataView'])->name('data');

Route::get('/activity/{id?}', [ActivitiesController::class, 'getActivityById'])->name('getActivity');

Route::post('/addRecord', [ActivitiesController::class, 'addRecord'])->name('add');

Route::post('/updateRecord', [ActivitiesController::class, 'updateRecord'])->name('update');

Route::delete('/deleteRecord/{id?}', [ActivitiesController::class, 'deleteRecord'])->name('delete');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
