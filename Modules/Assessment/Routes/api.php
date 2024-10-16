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

Route::get('/assessment', 'AssessmentController@getAssessment');

Route::middleware(['token-name:user-token'])->group(function () {
    Route::post('/postAssessment', 'AssessmentController@postAnswers');
    Route::get('/result', 'AssessmentController@getResult');
    Route::get('/takeAssessment', 'AssessmentController@checkResult');
});


Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->prefix('administration')->group( function () {

    Route::get('/questions', 'AssessmentController@getQuestionsPaginated');
    Route::get('/listQuestions', 'AssessmentController@getQuestions');
    Route::put('/questions/{id}',  'AssessmentController@updateQuestion');
    Route::post('/questions/reorder',  'AssessmentController@reorderQuestions');
    Route::get('/factors',  'AssessmentController@getFactors');
    Route::put('/factors/{id}',  'AssessmentController@updateFactor');
    Route::put('/editFormula/{id}',  'AssessmentController@updateFormula');
});
