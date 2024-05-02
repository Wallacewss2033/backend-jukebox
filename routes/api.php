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

Route::middleware('auth:api')->controller(TaskController::class)->group(function() {
    Route::get('/tasks', 'index')->name('tasks.index');
    Route::post('/tasks', 'store')->name('tasks.store');
    Route::get('/tasks/{id}', 'show')->name('tasks.show');
    Route::put('/tasks/{id}', 'update')->name('tasks.update');
    Route::delete('/tasks/{id}', 'delete')->name('tasks.delete');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/login-firebase', 'loginFirebase')->name('tasks.loginFirebase')->middleware('auth:api');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:api');
    Route::get('/check', 'check')->name('check')->middleware('auth:api');
});

