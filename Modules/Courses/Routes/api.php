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
Route::middleware(['token-name:manager-token'])->prefix('organization')->group(function () {

    Route::get('/courses', 'CoursesController@getOrganizationCourses');
    Route::get('/courses/updateVisibility/{id}', 'CoursesController@updateVisibility');
    Route::post('/requests/{id}', 'RequestsController@updateRequestStatus');
    Route::get('/requests/count', 'RequestsController@getOrganizationRequestsCount');
    Route::get('/requests', 'RequestsController@getOrganizationRequests');

});

Route::middleware(['token-name:user-token'])->group(function () {
    Route::post('/requests', 'RequestsController@store');
    Route::get('/users/courses', 'CoursesController@getUserCourses');
    Route::get('/courses/getFilterLists', 'CoursesController@getFilterLists');
});

Route::get('/courses/getLists', 'CoursesController@getLists');

Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->group(function () {

    Route::get('/courses/show/{id}', 'CoursesController@show');
    Route::prefix('courses')->group(function () {
        Route::post('/import', 'CoursesController@import');
        Route::get('/archived', 'CoursesController@archived');
        Route::post('/categories/import', 'CategoriesController@import');
        Route::resource('/categories', 'CategoriesController', ['only' => ['index', 'store', 'update', 'destroy']]);
        Route::post('/providers/import', 'ProvidersController@import');
        Route::resource('/providers', 'ProvidersController', ['only' => ['index', 'store', 'update', 'destroy']]);
        Route::post('/levels/import', 'LevelsController@import');
        Route::resource('/levels', 'LevelsController', ['only' => ['index', 'store', 'update', 'destroy']]);
    });
    Route::get('/approvedRequests', 'RequestsController@getApprovedRequests');
    Route::get('/approvedRequests/count', 'RequestsController@getApprovedRequestsCount');
    Route::resource('/courses', 'CoursesController',['only'=>['index', 'store', 'update', 'destroy']]);
});


