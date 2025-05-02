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



Route::middleware(['auth:'.Enums\EnumGuardNames::Admin->value, 'token-name:admin-token'])->prefix('administration')->group( function () {

    Route::resource('technical-assessments', TechnicalAssessmentController::class)->except(['create', 'edit', 'update']);
    Route::put('technical-assessments/{assessment}', 'TechnicalAssessmentController@update');
    Route::get('technical-assessments/result/{assessment}', 'AssessmentAnswerController@index');
    Route::resource('assessment-questions', AssessmentQuestionController::class)->except(['create', 'edit']);
    Route::get('technical-assessments/questions/{assessment}', 'AssessmentQuestionController@getAssessmentQuestions');
    Route::post('assessment-organization', 'AssessmentOrganizationController@assignAssessmentToOrganization');
    Route::post('unassign-assessment-organization', 'AssessmentOrganizationController@unassignAssessmentFromOrganization');
    Route::resource('assessment-tiers', AssessmentTierController::class)->except(['create', 'edit', 'show']);

    Route::get('assessment-organization/result/{organization}', 'AssessmentAnswerController@getReports');
    Route::get('assessment-organization/download-report/{filename}', 'AssessmentAnswerController@downloadReport');

});


Route::middleware(['token-name:user-token'])->group(function () {
    Route::post('/assessments/check-code', 'TechnicalAssessmentController@checkAssessmentCode');
    Route::post('/assessments/post-answers', 'AssessmentAnswerController@storeAssessmentAnswers');
    Route::get('/assessments', 'TechnicalAssessmentController@listAssessments');
    Route::get('/assessments/recommended-courses/{assessment}', 'TechnicalAssessmentController@getAssessmentRecommendedCourses');
});



