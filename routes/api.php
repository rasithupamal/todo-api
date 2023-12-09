<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/todos', [TodoController::class, 'store']);
Route::put('/todos/{uuid}', [TodoController::class, 'update']);
Route::delete('/todos/{uuid}', [TodoController::class, 'destroy']);
Route::put('/todos/{uuid}/archive', [TodoController::class, 'archive']);
Route::put('/todos/{uuid}/unarchive', [TodoController::class, 'unarchive']);
Route::get('/todos', [TodoController::class, 'index']);
Route::get('/todos/archived', [TodoController::class, 'archived']);
