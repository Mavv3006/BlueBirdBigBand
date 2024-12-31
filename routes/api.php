<?php

use App\Http\Controllers\Api\KonzertmeisterUpdateConcertsController;
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

//Route::middleware('auth:sanctum')
//    ->get('download/song/{song}', DownloadSongController::class)
//    ->name('download-song');

Route::get('concerts/pull', KonzertmeisterUpdateConcertsController::class)->name('api.concerts.pull');
