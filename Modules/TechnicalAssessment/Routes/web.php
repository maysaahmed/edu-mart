<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Enums;

Route::prefix('technicalassessment')->group(function() {
    Route::get('/', 'TechnicalAssessmentController@index');
});

Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->group( function () {
    Route::get('reports/{filename}', 'AssessmentAnswerController@downloadReport');
});
