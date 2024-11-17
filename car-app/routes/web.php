<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cars', [CarController::class, 'index']);

Route::get('/cars/create', [CarController::class, 'create']);

Route::get('/cars/about', [CarController::class, 'about']);

Route::post('/cars', [CarController::class, 'store']);

Route::get('/cars/{id}', [CarController::class, 'show']);

Route::get('/cars/{id}/edit', [CarController::class, 'edit']);

Route::patch('/cars', [CarController::class, 'update']);

Route::delete('/cars', [CarController::class, 'destroy']);

