<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LogExportTextfileController;
use App\Http\Controllers\LogTextfileResultController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TextfileResultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\vrys_autodebetfuture_syariahController;
use App\Http\Controllers\vrys_autodebetkonsumenbermasalah_syariahController;
use App\Http\Controllers\vrys_autodebetnormal_syariahController;
use App\Models\LogTextfileResult;
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

Route::group(['prefix' => 'user','middleware' => ['auth:sanctum','permission:/user']], function () {
    Route::get('',[UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'detail']);
    Route::post('/{id}', [UserController::class, 'update']);
    Route::post('/{id}/status', [UserController::class, 'toggleStatus']);
    Route::post('/{id}/updateGroups', [UserController::class, 'updateGroups']);
    Route::post('', [UserController::class, 'create']);
    Route::get('/{id}/group',[UserController::class, 'getGroup']);
});

Route::group(['prefix' => 'textfile' ,'middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'create' ,'middleware' => 'permission:/textfile/create'], function () {
        Route::group(['prefix' => 'autodebetnormal'],function () {
            Route::get('/',[vrys_autodebetnormal_syariahController::class,'getTodayDueDate']);
            Route::post('/generate',[vrys_autodebetnormal_syariahController::class,'generateTodayDueDate']);
        });
        Route::group(['prefix' => 'autodebetkonsumenbermasalah'],function () {
            Route::get('/',[vrys_autodebetkonsumenbermasalah_syariahController::class,'getTodayDueDate']);
            Route::post('/generate',[vrys_autodebetkonsumenbermasalah_syariahController::class,'generateTodayDueDate']);
        });
        Route::group(['prefix' => 'autodebetfuture'],function () {
            Route::get('/',[vrys_autodebetfuture_syariahController::class,'getByDueDate']);
            Route::post('/generate',[vrys_autodebetfuture_syariahController::class,'generateByDueDate']);
        });
        Route::get('/downloadTextfile',[LogExportTextfileController::class,'downloadTextfile']);
    });


    Route::group(['prefix' => 'upload','middleware' => 'permission:/textfile/upload'], function() {
        Route::get('/',[TextfileResultController::class,'index']);
        Route::get('/browse',[LogTextfileResultController::class,'browse']);
        Route::post('/import',[TextfileResultController::class,'import']);
        Route::get('/downloadTextfile',[LogTextfileResultController::class,'downloadTextfile']);
        Route::get('/downloadExcel',[LogTextfileResultController::class,'downloadExcel']);
    });
});

Route::group(['prefix' => 'group','middleware' => ['auth:sanctum','permission:/group']], function () {
    Route::get('',[GroupController::class, 'index']);
    Route::get('/{id}', [GroupController::class, 'detail']);
    Route::post('/{id}', [GroupController::class, 'update']);
    Route::post('', [GroupController::class, 'create']);
    Route::post('/{id}/status', [GroupController::class, 'toggleStatus']);
    Route::post('/{id}/updateMenu', [GroupController::class, 'updateMenu']);
    Route::get('/{id}/menu',[GroupController::class, 'getMenu']);
});

Route::group(['prefix' => 'menu','middleware' => 'auth:sanctum'], function () {
    Route::get('',[MenuController::class, 'index']);
    Route::get('/{id}', [MenuController::class, 'detail']);
    Route::post('/{id}', [MenuController::class, 'update']);
    Route::post('', [MenuController::class, 'create']);
});


