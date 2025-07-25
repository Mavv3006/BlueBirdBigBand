<?php

use App\Enums\FeatureFlagName;
use App\Http\Controllers\Internal\DownloadSongController;
use App\Http\Controllers\Internal\InternController;
use App\Http\Controllers\NewsletterRequestController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\v2\BandController;
use App\Http\Controllers\v2\ConcertDetailsPageController;
use App\Http\Controllers\v2\ConcertsPageController;
use App\Http\Controllers\v2\ContactPageController;
use App\Http\Controllers\v2\ImprintController;
use App\Http\Controllers\v2\IndexController;
use App\Http\Middleware\HasPermissionToAccessInternalRoutes;
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

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about-us', 'aboutUs');
    Route::get('/anfahrt', 'arrival');
    Route::get('/auftritte', 'concerts')->name('concerts');
    Route::get('/buchung', 'booking');
    Route::get('/impressum', 'imprint');
    Route::get('/kontakt', 'contact');
    Route::get('/musiker', 'musicians');
    Route::get('/presse', 'pressInfo');
    Route::get('/datenschutz', 'dataPrivacy');
});

Route::prefix('newsletter')
    ->middleware(['feature:'.FeatureFlagName::Newsletter->value])
    ->group(function () {
        Route::get('/', [PublicController::class, 'newsletter'])->name('newsletter');
        Route::controller(NewsletterRequestController::class)
            ->name('newsletter.')
            ->group(function () {
                Route::get('/subscribe', 'subscribe')->name('subscribe');
                Route::post('/request', 'request')->name('request');
                Route::get('/confirm/success', 'confirmSuccess')->name('confirm.success');
                Route::get('/confirm/{newsletterRequest}', 'confirm')
                    ->middleware('signed')
                    ->name('confirm');
            });
    });

Route::middleware('auth')
    ->get('download/song/{song}', DownloadSongController::class)
    ->name('download-song');

Route::prefix('intern')
    ->controller(InternController::class)
    ->middleware(['auth', HasPermissionToAccessInternalRoutes::class])
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/emails', 'emails');
        Route::get('/songs', 'songs')->name('intern.songs');
    });

require __DIR__.'/auth.php';
