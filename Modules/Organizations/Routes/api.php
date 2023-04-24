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

Route::middleware('auth:admin-api')->get('/organizations', function (Request $request) {
    return $request->user();
});

//role:admin-api|super-admin
Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->group(function () {

    Route::post('/organizations/updateStatus/{organization}', 'OrganizationsController@updateStatus');
    Route::post('/organizations/import', 'OrganizationsController@import');
    Route::resource('organizations', 'Modules\Organizations\Http\Controllers\OrganizationsController',['only'=>['index', 'store', 'update', 'destroy']]);

});
