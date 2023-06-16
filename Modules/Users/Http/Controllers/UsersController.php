<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Http\Requests\EditUserRequest;
use Modules\Users\Transformers\UserResource;
use Modules\Users\Core\User\Queries\GetUserPagination;
use Modules\Users\Core\User\Commands\DeleteUser;
use Modules\Users\Core\User\Commands\EditUser;
use Symfony\Component\HttpFoundation\Response;


class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetUserPagination\IGetUserPagination $query
     * @return JsonResponse
     */
    public function index(Request $request,GetUserPagination\IGetUserPagination $query): JsonResponse
    {
        try {
            $organization_id = request()->user()->organization_id;
            $queryModel = GetUserPagination\GetUserPaginationModel::from($request->all()+['org_id' => $organization_id]);
            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(UserResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * @param EditUserRequest $request
     * @param int $id
     * @param EditUser\IEditUser $command
     * @return JsonResponse
     */
    public function update(EditUserRequest $request, int $id, EditUser\IEditUser $command) : JsonResponse
    {
        try{
            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "id" => $id,
                "updatedBy" => $currentUserID,
            ];

            $commandModel = EditUser\EditUserModel::from($request->except(["_method"]) + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse(new UserResource($result),'User updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteUser\IDeleteUser $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteUser\IDeleteUser $command):JsonResponse
    {
        try {
            $currentUserID = request()->user()->id;
            $command->execute($id, $currentUserID);
            return $this->successResponse([],'User removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
