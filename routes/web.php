<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', function() {
    return Inertia::render('Index');
});
Route::get('/about-us', function () {
    return Inertia::render('Band/AboutPage');
});
Route::get('/anfahrt', function () {
    return Inertia::render('Band/ArrivalPage');
});
Route::get('/buchung', function () {
    return Inertia::render('LatestInfos/BookingPage');
});
Route::get('/impressum', function () {
    return Inertia::render('Contact/Imprint');
});
Route::get('/kontakt', function () {
    return Inertia::render('Contact/Contact');
});
Route::get('/musiker', function () {
    return Inertia::render('Band/MusiciansPage');
});
Route::get('/presse', function () {
    return Inertia::render('LatestInfos/PressInfoPage');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
