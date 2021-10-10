<?php

use App\Http\Controllers\AuthController;
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



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout']);
});

Route::group(['prefix' => 'user','middleware' => 'auth:sanctum'], function () {
    Route::get('',[UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'detail']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::put('/{id}/status', [UserController::class, 'toggleStatus']);
    Route::post('', [UserController::class, 'create']);

    Route::group(['prefix' => 'group'], function () {
        Route::get('',[UserController::class, 'index']);
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('',[UserController::class, 'index']);
    });
});



