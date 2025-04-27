<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AssessmentRequest;
use Modules\TechnicalAssessment\Http\Requests\CheckAssessmentCodeRequest;
use Modules\TechnicalAssessment\Transformers\TechnicalAssessmentResource;
use Modules\TechnicalAssessment\Transformers\UserTechnicalAssessmentResource;
use Modules\TechnicalAssessment\Transformers\UserAssessmentsListResource;
use Modules\TechnicalAssessment\Transformers\TechnicalAssessmentListResource;
use Modules\TechnicalAssessment\Transformers\AssessmentRecommendedCourseResource;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode;
use Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessments;
use Modules\TechnicalAssessment\Core\Assessment\Queries\GetUserAssessments;
use Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessmentRecommendedCourses;
use Symfony\Component\HttpFoundation\Response;
use App\Enums;

class TechnicalAssessmentController extends ApiController
{

    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::listAssessments->value,   ['only' => ['index', 'show']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::createAssessment->value,   ['only' => ['store']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editAssessment->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteAssessment->value,   ['only' => ['destroy']]);
    }

    /**
     * @param GetAssessments\IGetAssessments $query
     * @return JsonResponse
     */
    public function index(GetAssessments\IGetAssessments $query): JsonResponse
    {
        try {
            $assessments = $query->execute();
            return $this->successResponse(TechnicalAssessmentListResource::collection($assessments));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param GetUserAssessments\IGetUserAssessments $query
     * @return JsonResponse
     */
    public function listAssessments(GetUserAssessments\IGetUserAssessments $query): JsonResponse
    {
        try {
            $assessments = $query->execute();
            return $this->successResponse(UserAssessmentsListResource::collection($assessments));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @param GetAssessment\IGetAssessment $query
     * @return JsonResponse
     */
    public function show(int $id, GetAssessment\IGetAssessment $query): JsonResponse
    {
        try{
            $item = $query->execute($id);
            return $this->successResponse(new TechnicalAssessmentResource($item),'' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param AssessmentRequest $request
     * @param CreateAssessment\ICreateAssessment $command
     * @return JsonResponse
     */
    public function store(AssessmentRequest $request, CreateAssessment\ICreateAssessment $command): JsonResponse
    {
        try {
            $commandModel = CreateAssessment\CreateAssessmentModel::from($request->all());

            $result = $command->execute($commandModel);
            return $this->successResponse(new TechnicalAssessmentResource($result),'Assessment saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param AssessmentRequest $request
     * @param int $id
     * @param EditAssessment\IEditAssessment $command
     * @return JsonResponse
     */
    public function update(AssessmentRequest $request, int $id, EditAssessment\IEditAssessment $command): JsonResponse
    {
        try{
            $commandModel = EditAssessment\EditAssessmentModel::from($request->all() + ['id' => $id]);
            $item = $command->execute($commandModel);
            return $this->successResponse(new TechnicalAssessmentResource($item),'Assessment updated successfully!' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteAssessment\IDeleteAssessment $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteAssessment\IDeleteAssessment $command):JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Assessment removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * check code and get assessment questions
     * @param CheckAssessmentCodeRequest $request
     * @param CheckAssessmentCode\ICheckAssessmentCode $command
     * @return JsonResponse
     */

    public function checkAssessmentCode(CheckAssessmentCodeRequest $request, CheckAssessmentCode\ICheckAssessmentCode $command):JsonResponse
    {
        try{
            $commandModel = CheckAssessmentCode\CheckAssessmentCodeModel::from($request->all());
            $item = $command->execute($commandModel);
            return $this->successResponse(new UserTechnicalAssessmentResource($item),'' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param int $assessment_id
     * @param GetAssessmentRecommendedCourses\IGetAssessmentRecommendedCourses $query
     * @return JsonResponse
     */
    public function getAssessmentRecommendedCourses(int $assessment_id, GetAssessmentRecommendedCourses\IGetAssessmentRecommendedCourses $query): JsonResponse
    {
        try{
            $items = $query->execute($assessment_id);

            return $this->successResponse(AssessmentRecommendedCourseResource::collection($items),'' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
