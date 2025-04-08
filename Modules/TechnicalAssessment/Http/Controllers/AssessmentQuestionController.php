<?php

namespace Modules\TechnicalAssessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\TechnicalAssessment\Http\Requests\AssessmentQuestionRequest;
use Modules\TechnicalAssessment\Transformers\AssessmentQuestionResource;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion;
use Symfony\Component\HttpFoundation\Response;

class AssessmentQuestionController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     * @param AssessmentQuestionRequest $request
     * @param CreateAssessmentQuestion\ICreateAssessmentQuestion $command
     * @return JsonResponse
     */
    public function store(AssessmentQuestionRequest $request, CreateAssessmentQuestion\ICreateAssessmentQuestion $command): JsonResponse
    {
//        try {
            $commandModel = CreateAssessmentQuestion\CreateAssessmentQuestionModel::from($request->all());

            $result = $command->execute($commandModel);
            return $this->successResponse(new AssessmentQuestionResource($result),'Question saved successfully!' , Response::HTTP_CREATED);

//        } catch (\Throwable $th) {
//            return $this->errorResponse($th->getMessage());
//        }
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
