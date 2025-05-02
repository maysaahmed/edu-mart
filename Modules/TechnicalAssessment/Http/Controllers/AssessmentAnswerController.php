<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\TechnicalAssessment\Http\Requests\AnswersRequest;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetAssessmentResults;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetOrganizationReports;

use Modules\TechnicalAssessment\Transformers\AssessmentResultResource;
use Modules\TechnicalAssessment\Transformers\OrganizationAssessmentReportResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

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

    public function getReports(int $organization_id,GetOrganizationReports\IGetOrganizationReports $query): JsonResponse
    {
        try {
            $results = $query->execute($organization_id);
            return $this->successResponse(OrganizationAssessmentReportResource::collection($results));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function downloadReport($filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {

        $path = storage_path('app/reports/' . $filename);

        if (!file_exists($path)) {
            return $this->errorResponse('File not found', Response::HTTP_NOT_FOUND);
            abort(404);
        }
        $this->fileResponse($path);

    }


}
