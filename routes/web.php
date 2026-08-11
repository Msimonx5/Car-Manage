<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Contract\ContractPdfController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Vehicle\VehicleController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])
        ->name('password.update');

});

/*
|--------------------------------------------------------------------------
| Application (utilisateurs authentifiés)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

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

});
