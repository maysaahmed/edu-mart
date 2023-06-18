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
Route::post('/user/verify/{token}', 'UsersController@verifyUser');

Route::middleware(['token-name:manager-token'])->group(function () {
    Route::resource('/users', 'UsersController',['only'=>['index', 'store', 'update', 'destroy']])->parameters([
        '' => 'user'
    ]);
    Route::get('/organization/managers', 'ManagersController@getOrganizationManagers');

});

Route::middleware(['token-name:admin-token'])->group(function () {
    Route::post('/managers/updateStatus/{manager}', 'ManagersController@updateStatus');
    Route::resource('/managers', 'ManagersController',['only'=>['index', 'store', 'update', 'destroy']])->parameters([
        '' => 'manager'
    ]);

    Route::resource('/', 'Modules\Users\Http\Controllers\UsersController');

});



