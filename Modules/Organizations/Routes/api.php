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
Route::middleware('auth:admin-api')->group(function () {
    Route::resource('organizations', 'Modules\Organizations\Http\Controllers\OrganizationsController',['only'=>['index', 'store', 'update', 'destroy']]);

});
