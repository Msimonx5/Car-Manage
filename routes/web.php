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

    Route::resource('infractions', InfractionController::class);

    /*
    | Deux formulaires officiels selon le profil de l'agence :
    | DPL1, la declaration prealable de location, pour celles qui gerent des
    | contrats ; DA1, la declaration de l'auteur de l'infraction, pour les
    | autres, qui declarent le conducteur sans piece de location a joindre.
    */
    Route::get('/infractions/{id}/pdf', function ($id) {
        $vue = auth()->user()?->can('view-contracts')
            ? 'infractions.jspdf'
            : 'infractions.jspdf-da1';

        return view($vue, ['id' => $id]);
    })->name('infractions.pdf');

    /*
    |--------------------------------------------------------------------------
    | Donnees JSON de la declaration
    |--------------------------------------------------------------------------
    | Consommees par la page de generation du PDF. Declarees ici (et non dans
    | routes/api.php) pour beneficier de la session : ces donnees client sont
    | nominatives et ne doivent pas etre accessibles sans authentification.
    */

    Route::get('/api/infractionsapi/{infraction}', [ApiInfractionController::class, 'show']);
    Route::get('/api/infractionsapi', [ApiInfractionController::class, 'index']);

});





require __DIR__.'/auth.php';
