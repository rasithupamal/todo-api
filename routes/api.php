<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::post('/todos', [TodoController::class, 'store']);
Route::put('/todos/{uuid}', [TodoController::class, 'update']);
Route::delete('/todos/{uuid}', [TodoController::class, 'destroy']);
Route::put('/todos/{uuid}/archive', [TodoController::class, 'archive']);
Route::put('/todos/{uuid}/unarchive', [TodoController::class, 'unarchive']);
Route::get('/todos', [TodoController::class, 'index']);
Route::get('/todos/archived', [TodoController::class, 'archived']);
