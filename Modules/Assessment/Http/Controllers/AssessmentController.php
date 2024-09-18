<?php

namespace Modules\Assessment\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assessment\Core\Option\Queries\GetOptions;


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

}
