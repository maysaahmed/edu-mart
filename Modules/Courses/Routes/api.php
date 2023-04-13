<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/courses', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:admin-api')->prefix('courses')->group(function () {
    Route::resource('/', 'CoursesController',['only'=>['index', 'store', 'update', 'destroy']]);
    Route::get('/getLists', 'CoursesController@getLists');
    Route::resource('/categories', 'CategoriesController',['only'=>['index', 'store', 'update', 'destroy']]);
    Route::post('/categories/import', 'CategoriesController@import');
    Route::resource('/providers', 'ProvidersController',['only'=>['index', 'store', 'update', 'destroy']]);
    Route::post('/providers/import', 'ProvidersController@import');


});
