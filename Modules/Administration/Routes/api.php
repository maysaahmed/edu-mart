<?php

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

//Route::get('/administration/getRole', function (Request $request) {
//    dd(\Spatie\Permission\Models\Role::findById(1));
//    return $request->user();
//});

Route::post('/administration/login', 'Modules\Administration\Http\Controllers\AdministrationController@login')->name('login');
Route::post('/administration/register', 'Modules\Administration\Http\Controllers\AdministrationController@register');

Route::middleware(['auth:sanctum', 'ability:guard-admin-api'])->prefix('administration')->group( function () {
    Route::resource('/', 'Modules\Administration\Http\Controllers\AdministrationController',['only'=>['index', 'store', 'update', 'destroy']]);

    Route::put('/updateStatus/{admin}', 'Modules\Administration\Http\Controllers\AdministrationController@updateAdminStatus');
    Route::put('/updateProfile', 'Modules\Administration\Http\Controllers\AdministrationController@UpdateProfile');
    Route::put('/changePassword', 'Modules\Administration\Http\Controllers\AdministrationController@ChangePassword');

    Route::get('/user', 'Modules\Administration\Http\Controllers\AdministrationController@details');
    Route::post('/logout', 'Modules\Administration\Http\Controllers\AdministrationController@logout');

    Route::resource('/roles', 'RolesController',['only'=>['store']]);


});
