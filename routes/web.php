<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Contract\ContractPdfController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Vehicle\VehicleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserRoleController;
use App\Http\Controllers\InfractionController;
use App\Http\Controllers\InfractionPdfController;

/*
|--------------------------------------------------------------------------
| Accueil
|--------------------------------------------------------------------------
| Redirige vers le tableau de bord si connecté, sinon vers la connexion.
*/

Route::get('/', function () {
    return redirect()->route(
        auth()->check() ? 'dashboard' : 'login'
    );
});

/*
|--------------------------------------------------------------------------
| Authentification (invités uniquement)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Application (utilisateurs authentifiés)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    */

    Route::resource('clients', ClientController::class);

    /*
    |--------------------------------------------------------------------------
    | Véhicules
    |--------------------------------------------------------------------------
    */

    Route::resource('vehicles', VehicleController::class);
    // routes/web.php — vérifier/changer en POST si nécessaire
    // Route::post('vehicles/{vehicle}/oil-change', [VehicleController::class, 'addOilChange'])
    //     ->name('vehicles.oil-change');
    Route::patch('/vehicles/{vehicle}/oil-change', [VehicleController::class, 'addOilChange'])
        ->name('vehicles.oil-change');

    /*
    |--------------------------------------------------------------------------
    | Contrats
    |--------------------------------------------------------------------------
    */

    Route::resource('contracts', ContractController::class);

    Route::prefix('contracts/{contract}')
        ->name('contracts.')
        ->group(function () {

            Route::get('/preview', [ContractPdfController::class, 'preview'])->name('preview');
            Route::get('/pdf', [ContractPdfController::class, 'stream'])->name('pdf');
            Route::get('/download', [ContractPdfController::class, 'download'])->name('download');

        });

    Route::prefix('infractions/{infraction}/pdf')
        ->name('infractions.pdf.')
        ->group(function () {

            Route::get('preview', [InfractionPdfController::class, 'preview'])
                ->name('preview');

            Route::get('download', [InfractionPdfController::class, 'download'])
                ->name('download');

            Route::get('stream', [InfractionPdfController::class, 'streamPdf'])
                ->name('stream');

    });


        Route::resource('infractions', InfractionController::class);

});


    Route::middleware(['auth' ,'role:admin'])->group(function () {
        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.roles.edit');
        Route::put('/users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
    });

        


require __DIR__.'/auth.php';