<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Transformers\CourseResource;
use Modules\TechnicalAssessment\Http\Requests\AssessmentRequest;
use Modules\TechnicalAssessment\Transformers\TechnicalAssessmentResource;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessments;
use Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessment;
use Symfony\Component\HttpFoundation\Response;

class TechnicalAssessmentController extends ApiController
{

    /**
     * @param GetAssessments\IGetAssessments $query
     * @return JsonResponse
     */
    public function index(GetAssessments\IGetAssessments $query): JsonResponse
    {
        try {
            $assessments = $query->execute();
            return $this->successResponse(TechnicalAssessmentResource::collection($assessments));
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
}
