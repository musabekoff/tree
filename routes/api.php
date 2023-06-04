<?php

use App\Http\Controllers\API\IndexController;
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

Route::get('/main', [IndexController::class, 'main']);
Route::get('/item/{slug}', [IndexController::class, 'item']);
Route::post('/set', [IndexController::class, 'set']);
Route::post('/update', [IndexController::class, 'update']);
Route::get('/delete-image/{id}', [IndexController::class, 'deleteImage']);
Route::get('/delete/{id}', [IndexController::class, 'delete']);
