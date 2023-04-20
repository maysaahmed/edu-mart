<?php

namespace Modules\Administration\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Administration\Core\Role\Commands\CreateRole;

use Symfony\Component\HttpFoundation\Response;
use Modules\Administration\Http\Requests\RoleRequest;
use Modules\Administration\Transformers\RoleResource;

class RolesController extends ApiController
{


    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @param CreateRole\ICreateRole $command
     * @return JsonResponse
     */
    public function store(RoleRequest $request, CreateRole\ICreateRole $command): JsonResponse
    {
        try {
            $category = $command->execute($request->name);
            return $this->successResponse(new RoleResource($category),'Role saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }





}
