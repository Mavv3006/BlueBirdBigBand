<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ConcertManagement\ConcertsController;
use App\Http\Controllers\Admin\MusicianManagement\MusiciansController;
use App\Http\Controllers\Admin\MusicianManagement\MusicianSeatingPositionController;
use App\Http\Controllers\Admin\RolesManagement\RolesController;
use App\Http\Controllers\Admin\SongManagement\SongsController;
use App\Http\Controllers\Admin\UserManagement\ActivateUsersController;
use App\Http\Controllers\Admin\UserManagement\AssignRolesToUserController;
use App\Http\Controllers\Internal\InternController;
use App\Http\Controllers\PublicController;
use App\Http\Middleware\HasPermissionToAccessAdminRoutes;
use App\Http\Middleware\HasPermissionToAccessInternalRoutes;
use App\Http\Middleware\UseDesignVersion2;
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
    ->middleware(['auth', HasPermissionToAccessInternalRoutes::class])
    ->group(function () {
        Route::get('/', [InternController::class, 'index']);
        Route::get('/emails', [InternController::class, 'emails']);
        Route::get('/songs', [InternController::class, 'songs']);
    });

Route::prefix('admin')
    ->middleware(['auth', HasPermissionToAccessAdminRoutes::class])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index']);

        Route::get('activate-users', [ActivateUsersController::class, 'show']);
        Route::patch('activate-users/{user}', [ActivateUsersController::class, 'update']);

        Route::get('musicians/seating-position', [MusicianSeatingPositionController::class, 'show'])
            ->name('musicians.seating-position');
        Route::match(
            ['put', 'patch'],
            'musicians/seating-position',
            [MusicianSeatingPositionController::class, 'update']
        );
        Route::delete('musicians/{musician}/picture', [MusiciansController::class, 'deletePicture']);
        Route::resources([
            'roles' => RolesController::class,
            'musicians' => MusiciansController::class,
        ]);

        Route::resource('concerts', ConcertsController::class)->except('show');

        Route::resource('songs', SongsController::class)
            ->except('show');

        Route::prefix('assign-roles')->group(function () {
            Route::get('/', [AssignRolesToUserController::class, 'showSearchForm']);
            Route::put('user/{user}', [AssignRolesToUserController::class, 'syncRoles']);
        });
    });

Route::prefix('v2')
    ->middleware([UseDesignVersion2::class])
    ->group(function () {
    Route::get('/', function () {
        return Inertia::render('v2/Index');
    });
});

require __DIR__ . '/auth.php';
