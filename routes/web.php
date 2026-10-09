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
use App\Http\Controllers\Api\ApiInfractionController;

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
        return auth()->user()->can('dashboard.view')
            ? view('home')
            : redirect()->route('infractions.index');
    })->name('home');

    Route::get('/dashboard', function (DashboardController $controller) {
        return auth()->user()->can('dashboard.view')
            ? $controller->index()
            : redirect()->route('infractions.index');
    })
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    */

    Route::middleware('can:clients.create')->group(function () {
        Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    });
    Route::middleware('can:clients.view')->group(function () {
        Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    });
    Route::middleware('can:clients.edit')->group(function () {
        Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::match(['put', 'patch'], '/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    });
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->middleware('can:clients.delete')->name('clients.destroy');

    /*
    |--------------------------------------------------------------------------
    | Véhicules
    |--------------------------------------------------------------------------
    */

    Route::middleware('can:vehicles.create')->group(function () {
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    });
    Route::middleware('can:vehicles.view')->group(function () {
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
    });
    Route::middleware('can:vehicles.edit')->group(function () {
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::match(['put', 'patch'], '/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::patch('/vehicles/{vehicle}/oil-change', [VehicleController::class, 'addOilChange'])->name('vehicles.oil-change');
        Route::patch('/vehicles/{vehicle}/maintenance', [VehicleController::class, 'updateMaintenance'])->name('vehicles.maintenance');
    });
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->middleware('can:vehicles.delete')->name('vehicles.destroy');

    /*
    |--------------------------------------------------------------------------
    | Contrats
    |--------------------------------------------------------------------------
    */

    /*
    | Acces aux contrats soumis aux permissions : un compte sans
    | view-contracts n'a ni la page ni le lien dans le menu.
    */

    Route::middleware('can:create-contract')->group(function () {
        Route::resource('contracts', ContractController::class)->only(['create', 'store']);
    });

    Route::middleware('can:edit-contract')->group(function () {
        Route::resource('contracts', ContractController::class)->only(['edit', 'update', 'destroy']);
    });

    Route::middleware('can:view-contracts')->group(function () {

        Route::resource('contracts', ContractController::class)->only(['index', 'show']);

        Route::prefix('contracts/{contract}')
            ->name('contracts.')
            ->group(function () {

                Route::get('/preview', [ContractPdfController::class, 'preview'])->name('preview');
                Route::get('/pdf', [ContractPdfController::class, 'stream'])->name('pdf');
                Route::get('/download', [ContractPdfController::class, 'download'])->name('download');

            });

    });

    Route::middleware('can:manage-infractions')->get('/infractions/create', [InfractionController::class, 'create'])->name('infractions.create');

    Route::middleware('can:view-infractions')->group(function () {
        Route::get('/infractions', [InfractionController::class, 'index'])->name('infractions.index');
        Route::get('/infractions/{infraction}', [InfractionController::class, 'show'])->name('infractions.show');
        Route::get('/infractions/{infraction}/pdf', [InfractionController::class, 'pdf'])->name('infractions.pdf');
    });

    Route::middleware('can:manage-infractions')->group(function () {
        Route::post('/infractions', [InfractionController::class, 'store'])->name('infractions.store');
        Route::get('/infractions/{infraction}/edit', [InfractionController::class, 'edit'])->name('infractions.edit');
        Route::put('/infractions/{infraction}', [InfractionController::class, 'update'])->name('infractions.update');
        Route::patch('/infractions/{infraction}', [InfractionController::class, 'update']);
        Route::delete('/infractions/{infraction}', [InfractionController::class, 'destroy'])->name('infractions.destroy');
    });

    /*
    | Deux formulaires officiels selon le profil de l'agence :
    | DPL1, la declaration prealable de location, pour celles qui gerent des
    | contrats ; DA1, la declaration de l'auteur de l'infraction, pour les
    | autres, qui declarent le conducteur sans piece de location a joindre.
    */
    Route::get('/infractions/{infraction}/pdf', [InfractionController::class, 'pdf'])
        ->name('infractions.pdf');

    /*
    |--------------------------------------------------------------------------
    | Donnees JSON de la declaration
    |--------------------------------------------------------------------------
    | Consommees par la page de generation du PDF. Declarees ici (et non dans
    | routes/api.php) pour beneficier de la session : ces donnees client sont
    | nominatives et ne doivent pas etre accessibles sans authentification.
    */

    Route::middleware('can:view-infractions')->group(function () {
        Route::get('/api/infractionsapi/{infraction}', [ApiInfractionController::class, 'show']);
        Route::get('/api/infractionsapi', [ApiInfractionController::class, 'index']);
    });

});





require __DIR__.'/auth.php';
