<?php

namespace Modules\Assessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assessment\Core\Option\Queries\GetOptions;
use Modules\Assessment\Core\Question\Queries\GetQuestionPagination;
use Modules\Assessment\Transformers\QuestionResource;

class AssessmentController extends ApiController
{

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

}
