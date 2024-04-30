<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TaskController::class)->group(function() {
    Route::get('/tasks', 'index')->middleware('auth:sanctum');
    Route::post('/tasks', 'store')->middleware('auth:sanctum');
    Route::get('/tasks/{id}', 'show')->middleware('auth:sanctum');
    Route::put('/tasks/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/tasks/{id}', 'update')->middleware('auth:sanctum');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

