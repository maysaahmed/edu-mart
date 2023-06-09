<?php

namespace Modules\Administration\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Administration\Core\Role\Commands\CreateRole;
use Modules\Administration\Core\Role\Commands\EditRole;
use Modules\Administration\Core\Permission\Queries\GetPermissions;
use Modules\Administration\Core\Role\Queries\getRoles;

use Symfony\Component\HttpFoundation\Response;
use Modules\Administration\Http\Requests\RoleRequest;
use Modules\Administration\Http\Requests\UpdateRoleRequest;
use Modules\Administration\Transformers\RoleResource;
use Modules\Administration\Transformers\PermissionResource;
use Modules\Administration\Transformers\RolePermissionResourceCollection;
use App\Enums;
class RolesPermissionsController extends ApiController
{

    /**
     * Instantiate a new RolesPermissionsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createRole->value, ['only' => ['store']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editRole->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::listRoles->value,   ['only' => ['getAllRoles']]);
    }
    /**
     * Store a newly created resource in storage.
     * @param RoleRequest $request
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

    public function update(UpdateRoleRequest $request, int $id, EditRole\IEditRole $command) : JsonResponse
    {
        try{
            $commandModel = EditRole\EditRoleModel::from($request->except(["_method"]) + ['id' => $id]);
            $result = $command->execute($commandModel);

            return $this->successResponse(new RoleResource($result),'Role updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * @param GetPermissions\IGetPermissions $query
     * @param int|null $role_id
     * @return JsonResponse
     */
    public function getAllPermissions( GetPermissions\IGetPermissions $query, ?int $role_id = null): JsonResponse
    {
        try {
            $permissions = $query->execute();
            if(isset($role_id))
                return $this->successResponse(RolePermissionResourceCollection::make($permissions)->role($role_id));
            else
                return $this->successResponse(PermissionResource::collection($permissions));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param GetRoles\IGetRoles $query
     * @return JsonResponse
     */
    public function getAllRoles(GetRoles\IGetRoles $query): JsonResponse
    {
        try {
            $roles = $query->execute();

            return $this->successResponse( RoleResource::collection($roles));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }








}
