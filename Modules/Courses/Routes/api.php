<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Enums;

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

Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->group(function () {

    Route::get('/courses/show/{id}', 'CoursesController@show');
    Route::prefix('courses')->group(function () {
        Route::get('/getLists', 'CoursesController@getLists');
        Route::post('/import', 'CoursesController@import');
        Route::post('/categories/import', 'CategoriesController@import');
        Route::resource('/categories', 'CategoriesController', ['only' => ['index', 'store', 'update', 'destroy']]);
        Route::post('/providers/import', 'ProvidersController@import');
        Route::resource('/providers', 'ProvidersController', ['only' => ['index', 'store', 'update', 'destroy']]);
        Route::post('/levels/import', 'LevelsController@import');
        Route::resource('/levels', 'LevelsController', ['only' => ['index', 'store', 'update', 'destroy']]);
    });

    Route::resource('/courses', 'CoursesController',['only'=>['index', 'store', 'update', 'destroy']]);
});
