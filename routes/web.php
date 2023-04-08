<?php

use App\Http\Controllers\ActivateUsersController;
use App\Http\Controllers\ActiveMusicianController;
use App\Http\Controllers\ConcertsController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Index');
})->name('home');
Route::get('/about-us', function () {
    return Inertia::render('Band/AboutPage');
});
Route::get('/anfahrt', function () {
    return Inertia::render('Band/ArrivalPage');
});
Route::get('/auftritte', [ConcertsController::class, 'index']);
Route::get('/buchung', function () {
    return Inertia::render('LatestInfos/BookingPage');
});
Route::get('/impressum', function () {
    return Inertia::render('Contact/ImprintPage');
});
Route::get('/kontakt', function () {
    return Inertia::render('Contact/ContactPage');
});
Route::get('/musiker', [ActiveMusicianController::class, 'show']);
Route::get('/presse', function () {
    return Inertia::render('LatestInfos/PressInfoPage');
});

Route::prefix('intern')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [InternController::class, 'index']);
        Route::get('/emails', [InternController::class, 'emails']);
    });

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('activate-users', [ActivateUsersController::class, 'show']);
        Route::patch('activate-users/{user}', [ActivateUsersController::class, 'update']);

        Route::resource('roles', RolesController::class);
    });

require __DIR__ . '/auth.php';
