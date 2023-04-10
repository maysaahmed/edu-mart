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

Route::middleware('auth:api')->get('/organizations', function (Request $request) {
    return $request->user();
});

//role:admin-api|super-admin
Route::middleware('auth:admin-api')->prefix('organizations')->group(function () {
    Route::resource('/', 'OrganizationsController',['only'=>['index', 'store', 'update', 'destroy']]);
    Route::post('/updateStatus/{organization}', 'OrganizationsController@updateStatus');
});
