<?php

use App\Enums\FeatureFlagName;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ConcertManagement\ConcertsController;
use App\Http\Controllers\Admin\MusicianManagement\MusiciansController;
use App\Http\Controllers\Admin\MusicianManagement\MusicianSeatingPositionController;
use App\Http\Controllers\Admin\RolesManagement\RolesController;
use App\Http\Controllers\Admin\SongManagement\DownloadSongController;
use App\Http\Controllers\Admin\SongManagement\SongsController;
use App\Http\Controllers\Admin\UserManagement\ActivateUsersController;
use App\Http\Controllers\Admin\UserManagement\AssignRolesToUserController;
use App\Http\Controllers\Inertia\AboutUsController;
use App\Http\Controllers\Inertia\ArrivalController;
use App\Http\Controllers\Inertia\BookingController;
use App\Http\Controllers\Inertia\ConcertController;
use App\Http\Controllers\Inertia\ContactController;
use App\Http\Controllers\Inertia\HomeController;
use App\Http\Controllers\Inertia\InternalEmailController;
use App\Http\Controllers\Inertia\InternalSongsController;
use App\Http\Controllers\Inertia\NewsletterController;
use App\Http\Controllers\Inertia\PressInfoController;
use App\Http\Controllers\Internal\InternalIndexController;
use App\Http\Controllers\NewsletterRequestController;
use App\Http\Controllers\v2\BandController;
use App\Http\Controllers\v2\ConcertDetailsPageController;
use App\Http\Controllers\v2\ConcertsPageController;
use App\Http\Controllers\v2\ContactPageController;
use App\Http\Controllers\v2\ImprintController;
use App\Http\Controllers\v2\IndexController;
use App\Http\Middleware\HasPermissionToAccessAdminRoutes;
use App\Http\Middleware\HasPermissionToAccessInternalRoutes;
use App\Mail\NewsletterMail;
use App\Models\Concert;
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

Route::get('/', HomeController::class)->name('home');
Route::get('/about-us', AboutUsController::class);
Route::get('/anfahrt', ArrivalController::class);
Route::get('/auftritte', ConcertController::class);
Route::get('/buchung', BookingController::class);
Route::get('/impressum', \App\Http\Controllers\Inertia\ImprintController::class);
Route::get('/kontakt', ContactController::class);
Route::get('/musiker', \App\Http\Controllers\Inertia\MusiciansController::class);
Route::get('/presse', PressInfoController::class);

Route::get('/test', function () {
    \Illuminate\Support\Facades\Mail::to('test@example.com')
        ->send(new NewsletterMail(Concert::first()));
});

Route::middleware([
    'feature:'.FeatureFlagName::Newsletter->value,
])->group(function () {
    Route::get('/newsletter', NewsletterController::class)
        ->name('newsletter');
    Route::post('newsletter/request', [NewsletterRequestController::class, 'request'])
        ->name('newsletter.request');
    Route::get('newsletter/confirm/{newsletterRequest}', [NewsletterRequestController::class, 'confirm'])
        ->name('newsletter.confirm');
});

Route::middleware('auth')
    ->get('download/song/{song}', DownloadSongController::class)
    ->name('download-song');

Route::prefix('intern')
    ->middleware(['auth', HasPermissionToAccessInternalRoutes::class])
    ->group(function () {
        Route::get('/', InternalIndexController::class);
        Route::get('/emails', InternalEmailController::class);
        Route::get('/songs', InternalSongsController::class)->name('intern.songs');
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
    ->middleware(['feature:'.FeatureFlagName::DesignV2->value, 'auth'])
    ->group(function () {
        Route::get('/', IndexController::class);
        Route::get('/auftritt/{concert}', ConcertDetailsPageController::class)
            ->name('concert-details-page');
        Route::get('/auftritte', ConcertsPageController::class)
            ->name('concerts-page');
        Route::get('/kontakt', ContactPageController::class)
            ->name('contact-page');
        Route::get('/impressum', ImprintController::class)
            ->name('imprint');
        Route::get('band', BandController::class)
            ->name('band');
    });

require __DIR__.'/auth.php';
