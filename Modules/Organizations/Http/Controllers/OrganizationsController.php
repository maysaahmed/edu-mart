<?php

namespace Modules\Organizations\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Organizations\Core\Organization\Commands\CreateOrganization;
use Modules\Organizations\Core\Organization\Commands\DeleteOrganization;
use Modules\Organizations\Core\Organization\Commands\EditOrganization;
use Modules\Organizations\Core\Organization\Commands\EditOrganizationStatus;
use Modules\Organizations\Core\Organization\Commands\ImportOrganization;
use Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination;
use Modules\Organizations\Core\Organization\Queries\GetOrganizationList;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Validation\ValidationException;

use Modules\Organizations\Entities\Organization;
use Symfony\Component\HttpFoundation\Response;
use Modules\Organizations\Http\Requests\CreateOrganizationRequest;
use Modules\Organizations\Transformers\OrganizationResource;
use Modules\Organizations\Transformers\OrganizationListResource;



class OrganizationsController extends ApiController
{
    /**
     * Instantiate a new OrganizationsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:create_organization', ['only' => ['store', 'import']]);
        $this->middleware('ability:edit_organization',   ['only' => ['update']]);
        $this->middleware('ability:list_organizations',   ['only' => ['show', 'index']]);
        $this->middleware('ability:block_organization',   ['only' => ['updateStatus']]);
        $this->middleware('ability:delete_organization',   ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetOrganizationPagination\IGetOrganizationPagination $query
     * @return JsonResponse
     */

    public function index(Request $request, GetOrganizationPagination\IGetOrganizationPagination $query): JsonResponse
    {

        try {
            $queryModel = GetOrganizationPagination\GetOrganizationPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);
            return $this->paginationResponse(OrganizationResource::class,$pagination);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getOrganizations(GetOrganizationList\IGetOrganizationList $query): JsonResponse
    {
        try {
            $list = $query->execute();
            return $this->successResponse(OrganizationListResource::collection($list));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateOrganizationRequest $request
     * @param CreateOrganization\ICreateOrganization $command
     * @return JsonResponse
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
     * @param ImportCSVRequest $request
     * @param ImportOrganization\IImportOrganization $command
     * @return JsonResponse
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function import(ImportCSVRequest $request, ImportOrganization\IImportOrganization $command): JsonResponse
    {
        $file = $request->file('file')->store('import');

        try {
            $rowCount = $command->execute($file);
            return $this->successResponse([],$rowCount.' Organizations have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            return $this->importFailures($e->failures());
        }


    }

    /**
     * Update the specified resource in storage.
     * @param CreateOrganizationRequest $request
     * @param int $id
     * @param EditOrganization\IEditOrganization $command
     * @return JsonResponse
     */
    public function update(CreateOrganizationRequest $request, int $id, EditOrganization\IEditOrganization $command): JsonResponse
    {
        try{
            $commandModel = EditOrganization\EditOrganizationModel::from($request->all() + ["id" => $id]);
            $result = $command->execute($commandModel);

            return $this->successResponse(new OrganizationResource($result),'Organization updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * update status -> active or blocked
     * @param Request $request
     * @param $id
     * @param EditOrganizationStatus\IEditOrganizationStatus $command
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateStatus(Request $request, $id, EditOrganizationStatus\IEditOrganizationStatus $command): JsonResponse
    {
        $validation_rules = [
            'status' => 'required|in:0,1'
        ];
        $validator = $this->getValidationFactory()->make($request->all(), $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try{
            $commandModel = EditOrganizationStatus\EditOrganizationStatusModel::from($request->all() + ["id" => $id]);
            $result = $command->execute($commandModel);

            return $this->successResponse(new OrganizationResource($result),'Organization updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @param DeleteOrganization\IDeleteOrganization $command
     * @return JsonResponse
     */
    public function destroy($id, DeleteOrganization\IDeleteOrganization $command): JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Organization removed successfully!');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}
