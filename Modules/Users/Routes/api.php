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
Route::post('/forgetPassword', 'UsersController@forgetPassword');
Route::post('/resetPassword/{token}', 'UsersController@ResetPassword');


Route::post('/user/login', 'UsersController@login');
Route::post('/user/register', 'UsersController@register');
Route::get('/user/verify-registered/{token}', 'UsersController@verifyRegisteredUser');
Route::post('/user/resend-mail', 'UsersController@resendVerificationMail');


Route::middleware(['token-name:manager-token'])->group(function () {
    Route::resource('/users', 'UsersController',['only'=>['index' ,'store', 'update', 'destroy']])->parameters([
        '' => 'user'
    ]);
    Route::post('users/import', 'UsersController@import');
    Route::get('/organization/managers', 'ManagersController@getOrganizationManagers');
    Route::get('/users/resendMail/{id}', 'UsersController@resendMail');

});

Route::middleware(['token-name:user-token,manager-token'])->group(function () {
    Route::post('/user/completeData', 'UsersController@completeUserData');

});

Route::middleware(['token-name:user-token'])->group(function () {
    Route::post('/user/editProfile', 'UsersController@editProfile');
    Route::post('/user/uploadImage', 'UsersController@uploadProfileImage');
    Route::get('/user/removeImage', 'UsersController@removeProfileImage');
    Route::post('/user/changePassword', 'UsersController@changePassword');
    Route::get('/user/profile', 'UsersController@getUserProfile');
});

Route::middleware(['token-name:admin-token'])->group(function () {
    Route::post('/managers/updateStatus/{manager}', 'ManagersController@updateStatus');
    Route::get('/managers/resendMail/{id}', 'ManagersController@resendMail');
    Route::post('managers/import', 'ManagersController@import');
    Route::resource('/managers', 'ManagersController',['only'=>['index', 'store', 'update', 'destroy']])->parameters([
        '' => 'manager'
    ]);
    Route::get('/endUsers', 'UsersController@getUsers');
    Route::get('/users/{id}', 'UsersController@getUserData');

    Route::resource('/', 'Modules\Users\Http\Controllers\UsersController');

});



