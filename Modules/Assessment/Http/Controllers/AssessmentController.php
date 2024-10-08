<?php

namespace Modules\Assessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assessment\Core\Option\Queries\GetOptions;
use Modules\Assessment\Core\Question\Commands\EditQuestion;
use Modules\Assessment\Core\Question\Commands\ReorderQuestions;
use Modules\Assessment\Core\Factor\Commands\EditFactor;
use Modules\Assessment\Core\Question\Queries\GetQuestionPagination;
use Modules\Assessment\Core\Question\Queries\GetQuestions;
use Modules\Assessment\Core\Factor\Queries\GetFactors;
use Modules\Assessment\Transformers\QuestionResource;
use Modules\Assessment\Transformers\FactorResource;
use App\Enums;
use Modules\Assessment\Http\Requests\QuestionRequest;
use Modules\Assessment\Http\Requests\FactorRequest;
use Modules\Assessment\Http\Requests\ReorderQuestionsRequest;
use Symfony\Component\HttpFoundation\Response;

class AssessmentController extends ApiController
{
    /**
     * Instantiate a new AssessmentController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::listQuestions->value,   ['only' => ['getQuestionsPaginated', 'getQuestions', 'getFactors']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editQuestions->value,   ['only' => ['updateQuestion', 'reorderQuestions']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editFactors->value,   ['only' => ['updateFactor']]);
    }

    /**
     * @param GetOptions\IGetOptions $query
     * @return JsonResponse
     */
    public function getOptions(GetOptions\IGetOptions $query): JsonResponse
    {
        try {
            $options = $query->execute();

            return $this->successResponse([
                'options' => $options
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetQuestionPagination\IGetQuestionPagination $query
     * @return JsonResponse
     */
    public function getQuestionsPaginated(Request $request,GetQuestionPagination\IGetQuestionPagination $query): JsonResponse
    {
        try {
            $queryModel = GetQuestionPagination\GetQuestionPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(QuestionResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param QuestionRequest $request
     * @param int $id
     * @param EditQuestion\IEditQuestion $command
     * @return JsonResponse
     */
    public function updateQuestion(QuestionRequest $request, int $id, EditQuestion\IEditQuestion $command): JsonResponse
    {
        try{
            $commandModel = EditQuestion\EditQuestionModel::from($request->all() + ['id' => $id]);
            $item = $command->execute($commandModel);
            return $this->successResponse([],'Question updated successfully!' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param ReorderQuestionsRequest $request
     * @param ReorderQuestions\IReorderQuestions $command
     * @return JsonResponse
     */
    public function reorderQuestions(ReorderQuestionsRequest $request, ReorderQuestions\IReorderQuestions $command): JsonResponse
    {
        try{
            $questions =$request->questions ;
            $command->execute($questions);
            return $this->successResponse([],'Question reordered successfully!' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * @param GetQuestions\IGetQuestions $query
     * @return JsonResponse
     */
    public function getQuestions(GetQuestions\IGetQuestions $query): JsonResponse
    {
        try {
            $questions = $query->execute();

            return $this->successResponse(QuestionResource::collection($questions));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * @param GetFactors\IGetFactors $query
     * @return JsonResponse
     */
    public function getFactors(GetFactors\IGetFactors $query): JsonResponse
    {
        try {
            $factors = $query->execute();

            return $this->successResponse(FactorResource::collection($factors));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param FactorRequest $request
     * @param int $id
     * @param EditFactor\IEditFactor $command
     * @return JsonResponse
     */
    public function updateFactor(FactorRequest $request, int $id, EditFactor\IEditFactor $command): JsonResponse
    {
        try{
            $commandModel = EditFactor\EditFactorModel::from($request->all() + ['id' => $id]);
            $item = $command->execute($commandModel);
            return $this->successResponse([],'Data updated successfully!' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

}
