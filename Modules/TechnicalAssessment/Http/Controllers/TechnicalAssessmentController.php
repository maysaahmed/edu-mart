<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\TechnicalAssessment\Http\Requests\AssessmentRequest;
use Modules\TechnicalAssessment\Transformers\TechnicalAssessmentResource;
use Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;
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
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
