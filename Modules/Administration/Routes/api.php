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

Route::middleware('auth:sanctum')->get('/administration', function (Request $request) {
    return $request->user();
});

Route::post('/administration/login', 'Modules\Administration\Http\Controllers\AdministrationController@login')->name('login');
Route::post('/administration/register', 'Modules\Administration\Http\Controllers\AdministrationController@register');

Route::middleware(['auth:sanctum', 'ability:guard-admin-api'])->group( function () {
    Route::get('/administration/user', 'Modules\Administration\Http\Controllers\AdministrationController@details');
    Route::post('/administration/logout', 'Modules\Administration\Http\Controllers\AdministrationController@logout');

});
