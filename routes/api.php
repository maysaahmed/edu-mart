<?php

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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/user', 'App\Http\Controllers\UserAuthController@details');
});





//Route::group(['middleware'=> ['auth:sanctum', 'ability:guard-admin-api']], function() {
////    Route::get('/products/{id}', [CategoryController::class, 'edit']);
//    Route::resource('categories', 'App\Http\Controllers\CategoryController',['only'=>['index', 'store', 'update', 'destroy']]);
//
//});


Route::get('levels', ['uses' => 'App\Http\Controllers\LevelController@index']);
//Route::resource('categories', 'App\Http\Controllers\CategoryController',['only'=>['index', 'store', 'update', 'destroy']]);


