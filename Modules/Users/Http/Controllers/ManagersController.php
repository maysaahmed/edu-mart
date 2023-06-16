<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Transformers\ManagerListResource;
use Modules\Users\Transformers\ManagerResource;
use Modules\Users\Core\Manager\Queries\GetManagerPagination;
use Symfony\Component\HttpFoundation\Response;


class ManagersController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetManagerPagination\IGetManagerPagination $query
     * @return JsonResponse
     */
    public function index(Request $request,GetManagerPagination\IGetManagerPagination $query): JsonResponse
    {
        try {
            $queryModel = GetManagerPagination\GetManagerPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(ManagerResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     * @param GetOrganizationManagers\IGetOrganizationManagers $query
     * @return JsonResponse
     */
    public function getOrganizationManagers(GetOrganizationManagers\IGetOrganizationManagers $query): JsonResponse
    {
        try {
            $organization_id = request()->user()->organization_id;
            $list = $query->execute($organization_id);

            return $this->successResponse(ManagerListResource::collection($list));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


}
