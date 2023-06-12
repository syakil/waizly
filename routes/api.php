<?php

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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/task',[\App\Http\Controllers\Api\TaskController::class,'getTask']);
    Route::get('/task/{id}',[\App\Http\Controllers\Api\TaskController::class,'getTaskById']);
    Route::post('/task',[\App\Http\Controllers\Api\TaskController::class,'store']);
    Route::patch('/task/selesai/{id}',[\App\Http\Controllers\Api\TaskController::class,'update_selesai']);
    Route::patch('/task/belum_selesai/{id}',[\App\Http\Controllers\Api\TaskController::class,'update_belumselesai']);
    Route::put('/task/{id}',[\App\Http\Controllers\Api\TaskController::class,'update']);
    Route::delete('/task/{id}',[\App\Http\Controllers\Api\TaskController::class,'delete']);

    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});
