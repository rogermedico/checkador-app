<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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

/** dashboard routes */
Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard.index');

/** event routes */
//Route::get('reservation/create/second', [EventController::class, 'createSecondStep'])->name('reservation.create.second');
//Route::post('reservation/first', [EventController::class, 'processFirstStep'])->name('reservation.store.first');
Route::get('event/all/{user?}/{day?}/{month?}/{year?}', [EventController::class, 'index'])->name('event.index');
Route::resource('event', EventController::class)->middleware('auth')
    ->except('index', 'show');

/** user routes */
Route::get('user/login', [UserController::class, 'loginShow'])->middleware('guest')->name('user.login.show');
Route::post('user/login', [UserController::class, 'login'])->middleware('guest')->name('user.login');
Route::get('user/logout', [UserController::class, 'logout'])->middleware('auth')->name('user.logout');
Route::put('user/{user}/job', [UserController::class, 'updateJob'])->middleware('auth')->name('user.update.job');
Route::put('user/{user}/password', [UserController::class, 'updatePassword'])->middleware('auth')->name('user.update.password');
//Route::get('user/{user}/reservations', [UserController::class, 'showReservations'])->middleware('auth')->name('user.reservations.show');
Route::resource('user', UserController::class)->except('show');

///** session routes */
//Route::resource('session', SessionController::class)->except('create','show',)->middleware('admin');
