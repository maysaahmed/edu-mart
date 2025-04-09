<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AssessmentRequest;
use Modules\TechnicalAssessment\Transformers\TechnicalAssessmentResource;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment;
use Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment;
use Symfony\Component\HttpFoundation\Response;

class TechnicalAssessmentController extends ApiController
{

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
