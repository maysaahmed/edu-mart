<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Http\Requests\EditManagerRequest;
use Modules\Users\Transformers\ManagerListResource;
use Modules\Users\Transformers\ManagerResource;
use Modules\Users\Core\Manager\Queries\GetManagerPagination;
use Modules\Users\Core\Manager\Commands\EditManager;
use Modules\Users\Core\Manager\Commands\DeleteManager;
use Modules\Users\Core\Manager\Commands\EditManagerStatus;
use Symfony\Component\HttpFoundation\Response;


class ManagersController extends ApiController
{

    /**
     * Instantiate a new ManagersController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:create_manager', ['only' => ['store']]);
        $this->middleware('ability:edit_manager',   ['only' => ['update']]);
        $this->middleware('ability:list_managers',   ['only' => ['show', 'index']]);
        $this->middleware('ability:block_manager',   ['only' => ['updateStatus']]);
        $this->middleware('ability:delete_manager',   ['only' => ['destroy']]);
    }

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
            $organization_id = request()->Manager()->organization_id;
            $list = $query->execute($organization_id);

            return $this->successResponse(ManagerListResource::collection($list));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * @param EditManagerRequest $request
     * @param int $id
     * @param EditManager\IEditManager $command
     * @return JsonResponse
     */
    public function update(EditManagerRequest $request, int $id, EditManager\IEditManager $command) : JsonResponse
    {
        try{
            $currentManagerID = $request->user()->id;

            $additionalModelData = [
                "id" => $id,
                "updatedBy" => $currentManagerID,
            ];

            $commandModel = EditManager\EditManagerModel::from($request->except(["_method"]) + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse(new ManagerResource($result),'Manager updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteManager\IDeleteManager $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteManager\IDeleteManager $command):JsonResponse
    {
        try {
            $currentManagerID = request()->user()->id;
            $command->execute($id, $currentManagerID);
            return $this->successResponse([],'Manager removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * update status -> active or blocked
     * @param Request $request
     * @param $id
     * @param EditManagerStatus\IEditManagerStatus $command
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateStatus(Request $request, $id, EditManagerStatus\IEditManagerStatus $command): JsonResponse
    {
        $validation_rules = [
            'isActive' => 'required|in:0,1'
        ];
        $validator = $this->getValidationFactory()->make($request->all(), $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try{
            $commandModel = EditManagerStatus\EditManagerStatusModel::from($request->all() + ["id" => $id]);
        $result = $command->execute($commandModel);

            return $this->successResponse(new ManagerResource($result),'Manager updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }



}