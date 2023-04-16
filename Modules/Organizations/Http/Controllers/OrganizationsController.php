<?php

namespace Modules\Organizations\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Organizations\Core\Organization\Commands\CreateOrganization;
use Modules\Organizations\Core\Organization\Commands\DeleteOrganization;
use Modules\Organizations\Core\Organization\Commands\EditOrganization;
use Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination;
use Modules\Organizations\Entities\Organization;
use Symfony\Component\HttpFoundation\Response;
use Modules\Organizations\Http\Requests\CreateOrganizationRequest;
use Modules\Organizations\Transformers\OrganizationResource;

class OrganizationsController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index(Request $request, GetOrganizationPagination\IGetOrganizationPagination $query): JsonResponse
    {

        try {
            $queryModel = GetOrganizationPagination\GetOrganizationPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);
            return $this->successResponse(OrganizationResource::collection($pagination));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param CreateOrganizationRequest $request
     * @param ICreateOrganization $command
     * @return JsonResponse
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function store(CreateOrganizationRequest $request, CreateOrganization\ICreateOrganization $command)
    {
        try {
            $commandModel = CreateOrganization\CreateOrganizationModel::from($request->all());
            $result = $command->execute($commandModel);
            return $this->successResponse( new OrganizationResource($result),'Organization saved successfully!' , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CreateOrganizationRequest $request, int $id, EditOrganization\IEditOrganization $command)
    {
        try{

            $commandModel = EditOrganization\EditOrganizationModel::from($request->all() + ["id" => $id]);
            $result = $command->execute($commandModel);

            $this->response['message'] = 'Data updated successfully!';
            return $this->successResponse(new OrganizationResource($result),'Organization updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id, DeleteOrganization\IDeleteOrganization $command)
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Organization removed successfully!');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}
