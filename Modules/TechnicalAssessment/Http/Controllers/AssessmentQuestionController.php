<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AssessmentQuestionRequest;
use Modules\TechnicalAssessment\Transformers\AssessmentQuestionResource;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\DeleteAssessmentQuestion;
use Symfony\Component\HttpFoundation\Response;
use App\Enums;

class AssessmentQuestionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createAssessmentQuestion->value,   ['only' => ['store']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editAssessmentQuestion->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteAssessmentQuestion->value,   ['only' => ['destroy']]);
    }

    /**
     * Store a newly created resource in storage.
     * @param AssessmentQuestionRequest $request
     * @param CreateAssessmentQuestion\ICreateAssessmentQuestion $command
     * @return JsonResponse
     */
    public function store(AssessmentQuestionRequest $request, CreateAssessmentQuestion\ICreateAssessmentQuestion $command): JsonResponse
    {
        try {
            $commandModel = CreateAssessmentQuestion\CreateAssessmentQuestionModel::from($request->all());

            $result = $command->execute($commandModel);
            return $this->successResponse(new AssessmentQuestionResource($result),'Question saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param AssessmentQuestionRequest $request
     * @param int $id
     * @param EditAssessmentQuestion\IEditAssessmentQuestion $command
     * @return JsonResponse
     */
    public function update(AssessmentQuestionRequest $request, int $id, EditAssessmentQuestion\IEditAssessmentQuestion $command): JsonResponse
    {
        try{
            $commandModel = EditAssessmentQuestion\EditAssessmentQuestionModel::from($request->all() + ['id' => $id]);
            $item = $command->execute($commandModel);
            return $this->successResponse(new AssessmentQuestionResource($item),'Question updated successfully!' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteAssessmentQuestion\IDeleteAssessmentQuestion $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteAssessmentQuestion\IDeleteAssessmentQuestion $command):JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Question removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
