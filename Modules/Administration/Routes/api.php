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
//    dd(\Spatie\Permission\Models\Role::findById(1), \Spatie\Permission\Models\Role::find(1));
//    return $request->user();
//});

Route::post('/administration/login', 'Modules\Administration\Http\Controllers\AdministrationController@login')->name('login');
Route::post('/administration/register', 'Modules\Administration\Http\Controllers\AdministrationController@register');

Route::middleware(['auth:admin-api', 'ability:guard-admin-api'])->prefix('administration')->group( function () {

    Route::put('/updateStatus/{admin}', 'Modules\Administration\Http\Controllers\AdministrationController@updateStatus');
    Route::put('/updateProfile', 'Modules\Administration\Http\Controllers\AdministrationController@updateProfile');
    Route::put('/changePassword', 'Modules\Administration\Http\Controllers\AdministrationController@changePassword');

    Route::get('/user', 'Modules\Administration\Http\Controllers\AdministrationController@details');
    Route::post('/logout', 'Modules\Administration\Http\Controllers\AdministrationController@logout');

    Route::get('/roles/permissions/{role_id?}', 'RolesPermissionsController@getAllPermissions');
    Route::get('/roles', 'RolesPermissionsController@getAllRoles');
    Route::resource('/roles', 'RolesPermissionsController',['only'=>['store', 'update']]);

    // resource should be at the end to not override the single routes
    Route::resource('/', 'Modules\Administration\Http\Controllers\AdministrationController',['only'=>['index', 'store', 'update', 'destroy']])->parameters([
        '' => 'admin' // this to fix resource parameter name, as it come without name because the resource name no follow the convention naming.
    ]);
});
