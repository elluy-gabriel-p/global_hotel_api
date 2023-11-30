<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KamarController;


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

Route::post('/register', [App\Http\Controllers\Api\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\UserController::class, 'login']);

Route::get('/user', [App\Http\Controllers\Api\UserController::class, 'index']);
Route::get('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'show']);
Route::put('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'update']);
Route::delete('/user/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy']);
Route::post('/updatePass', [App\Http\Controllers\Api\UserController::class, 'updatePassword']);

Route::apiResource('kamar', KamarController::class);