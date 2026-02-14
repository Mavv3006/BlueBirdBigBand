<?php

use App\Http\Controllers\Api\MusiciansGroupedByInstrumentController;
use App\Http\Controllers\Api\KonzertmeisterUpdateConcertsController;
use App\Http\Controllers\Api\UpcomingConcertsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('concerts/pull', KonzertmeisterUpdateConcertsController::class)
    ->name('api.concerts.pull');

Route::get('concerts/upcoming', UpcomingConcertsController::class)
    ->name('api.concerts.upcoming');

Route::get('musicians/grouped-by-instrument', MusiciansGroupedByInstrumentController::class)
    ->name('api.musicians.grouped-by-instrument');
