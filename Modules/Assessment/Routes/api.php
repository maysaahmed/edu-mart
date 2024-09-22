<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/assessment', function (Request $request) {
    return $request->user();
});

Route::get('/assessment/getOptions', 'AssessmentController@getOptions');
Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->prefix('administration')->group( function () {

    Route::get('/questions', 'AssessmentController@getQuestionsPaginated');
    Route::get('/listQuestions', 'AssessmentController@getQuestions');
    Route::put('/questions/{id}',  'AssessmentController@updateQuestion');
});
