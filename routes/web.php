<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Contract\ContractPdfController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class,'create'])->name('login');
    Route::post('/login', [LoginController::class,'store']);

    Route::get('/register', [RegisterController::class,'create'])->name('register');
    Route::post('/register', [RegisterController::class,'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class,'create'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class,'store'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'store'])
        ->name('password.update');



});

Route::post('/logout',[LoginController::class,'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

Route::middleware('auth')->group(function () {

    Route::resource('clients', ClientController::class);

});

Route::middleware('auth')->group(function () {

    Route::resource(
        'vehicles',
        VehicleController::class
    );

});

Route::middleware('auth')->group(function () {

    Route::resource('contracts', ContractController::class);

});

Route::get(
    'contracts/{contract}/pdf',
    [ContractController::class,'pdf']
)->name('contracts.pdf');

Route::resource('contracts', ContractController::class);

Route::prefix('contracts/{contract}')
    ->name('contracts.')
    ->group(function () {

        Route::get(
            '/preview',
            [ContractPdfController::class, 'preview']
        )->name('preview');

        Route::get(
            '/pdf',
            [ContractPdfController::class, 'stream']
        )->name('pdf');

        Route::get(
            '/download',
            [ContractPdfController::class, 'download']
        )->name('download');

    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');


    Route::patch('/vehicles/{vehicle}/oil-change', [VehicleController::class, 'addOilChange'])
    ->name('vehicles.oil-change');