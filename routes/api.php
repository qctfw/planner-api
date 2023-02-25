<?php

use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('/', [UserController::class, 'show'])->middleware('auth:sanctum');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('plans', PlanController::class);
    Route::get('plans/status/{status}', [PlanController::class, 'getByStatus']);
});
