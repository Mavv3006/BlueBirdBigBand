<?php

use App\Http\Controllers\ActivateUsersController;
use App\Http\Controllers\AssignRolesToUserController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\MusiciansController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SongsController;
use Illuminate\Support\Facades\Gate;
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

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about-us', [PublicController::class, 'aboutUs']);
Route::get('/anfahrt', [PublicController::class, 'arrival']);
Route::get('/auftritte', [PublicController::class, 'concerts']);
Route::get('/buchung', [PublicController::class, 'booking']);
Route::get('/impressum', [PublicController::class, 'imprint']);
Route::get('/kontakt', [PublicController::class, 'contact']);
Route::get('/musiker', [PublicController::class, 'musicians']);
Route::get('/presse', [PublicController::class, 'pressInfo']);

Route::prefix('intern')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [InternController::class, 'index']);
        Route::get('/emails', [InternController::class, 'emails']);
        Route::get('/songs', [InternController::class, 'songs']);
    });

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('activate-users', [ActivateUsersController::class, 'show']);
        Route::patch('activate-users/{user}', [ActivateUsersController::class, 'update']);

        Route::resource('roles', RolesController::class);
        Route::resource('musicians', MusiciansController::class);
        Route::resource('songs', SongsController::class)
            ->except('show');

        Route::prefix('assign-roles')->group(function () {
            Route::get('/', [AssignRolesToUserController::class, 'showSearchForm']);
            Route::put('user/{user}', [AssignRolesToUserController::class, 'syncRoles']);
        });
    });

require __DIR__ . '/auth.php';
