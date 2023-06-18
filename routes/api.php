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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:'.Enums\EnumGuardNames::Admin->value)->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:'.Enums\EnumGuardNames::Admin->value)->group(function () {
    Route::get('user/user', 'App\Http\Controllers\UserAuthController@details');
});

Route::post('user/login', 'App\Http\Controllers\LoginController@authenticate');

