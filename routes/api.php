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

Route::group(['middleware'=> ['role:admin-api|admin']], function() {
//    Route::get('/products/{id}', [CategoryController::class, 'edit']);
});


Route::get('levels', ['uses' => 'App\Http\Controllers\LevelController@index']);
Route::resource('categories', 'App\Http\Controllers\CategoryController',['only'=>['index', 'store', 'update', 'destroy']]);
//Route::group(['prefix' => 'categories'], function()  {
//    Route::get('/', 'App\Http\Controllers\CategoryController@index');
//    Route::post('/', 'App\Http\Controllers\CategoryController@store');
//    Route::put('/{id}',  'App\Http\Controllers\CategoryController@update');
//    Route::delete('/{id}', 'App\Http\Controllers\CategoryController@destroy');
//    });

