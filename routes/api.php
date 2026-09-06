<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiInfractionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/infractionsapi/{infraction}', [ApiInfractionController::class, 'show']);
Route::get('/infractionsapi', [ApiInfractionController::class, 'index']);
