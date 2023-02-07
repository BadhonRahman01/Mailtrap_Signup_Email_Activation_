<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers;
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
// Route::group(['middleware' => ['auth']], function() {
//     Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
//     Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify')->middleware(['signed']);
//     Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');
// });
Route::controller(VerificationController::class)->group(function () {
    Route::get('/email/verify', 'show')->name('verification.notice')->middleware('auth');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify')->middleware(['auth:web,signed']);;
    Route::post('/email/resend', 'resend')->name('verification.resend')->middleware('auth');
});
Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => ['verified']], function() {
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
