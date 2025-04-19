<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AnswersRequest;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetAssessmentResults;

use Modules\TechnicalAssessment\Transformers\AssessmentResultResource;
use Symfony\Component\HttpFoundation\Response;

class AssessmentAnswerController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     * @param AnswersRequest $request
     * @param PostAssessmentAnswer\IPostAssessmentAnswer $command
     * @return JsonResponse
     */
    public function storeAssessmentAnswers(AnswersRequest $request, PostAssessmentAnswer\IPostAssessmentAnswer $command): JsonResponse
    {
        try {
            $commandModel = PostAssessmentAnswer\PostAssessmentAnswerModel::from($request->all());

            $result = $command->execute($commandModel);

            return $this->successResponse([],'Answers saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param int $assessment_id
     * @param GetAssessmentResults\IGetAssessmentResults $query
     * @return JsonResponse
     */
    public function index(int $assessment_id,GetAssessmentResults\IGetAssessmentResults $query): JsonResponse
    {
        try {
            $results = $query->execute($assessment_id);
            return $this->successResponse(AssessmentResultResource::collection($results));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
