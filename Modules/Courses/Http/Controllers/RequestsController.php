<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Courses\Http\Requests\BookCourseRequest;
use Modules\Courses\Transformers\RequestResource;
use Modules\Courses\Transformers\ApprovedRequestResource;
use Modules\Courses\Core\Request\Commands\CreateRequest;
use Modules\Courses\Core\Request\Commands\EditRequestStatus;
use Modules\Courses\Core\Request\Commands\ManageRequest;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination;
use Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsCount;
use Modules\Courses\Core\Request\Queries\GetApprovedRequestsCount;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Enums;

class RequestsController extends ApiController
{

    /**
     * Instantiate a new RequestsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::listRequests->value,   ['only' => ['getApprovedRequests', 'getApprovedRequestsCount']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editRequests->value,   ['only' => ['manageRequests']]);
    }

    /**
     * Display a list of organization requests
     * @param Request $request
     * @param GetOrganizationRequestsPagination\IGetOrganizationRequestsPagination $query
     * @return JsonResponse
     */
    public function getOrganizationRequests(Request $request,GetOrganizationRequestsPagination\IGetOrganizationRequestsPagination $query): JsonResponse
    {
        try {
            $queryModel = GetOrganizationRequestsPagination\GetOrganizationRequestsPaginationModel::from($request->all()+['org_id' => $request->user()->organization_id]);

            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(RequestResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getApprovedRequests(Request $request,GetApprovedRequestsPagination\IGetApprovedRequestsPagination $query): JsonResponse
    {
        try {
            $queryModel = GetApprovedRequestsPagination\GetApprovedRequestsPaginationModel::from($request->all());

            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(ApprovedRequestResource::class,$pagination);;
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getApprovedRequestsCount(GetApprovedRequestsCount\IGetApprovedRequestsCount $query): JsonResponse
    {
        try {
            $count = $query->execute();
            return $this->successResponse(['count' => $count]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    public function getOrganizationRequestsCount(Request $request,GetOrganizationRequestsCount\IGetOrganizationRequestsCount $query): JsonResponse
    {
        try {
            $org_id = $request->user()->organization_id;

            $count = $query->execute($org_id);

            return $this->successResponse(['count' => $count]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param BookCourseRequest $request
     * @param CreateRequest\ICreateRequest $command
     * @return JsonResponse
     */
    public function store(BookCourseRequest $request, CreateRequest\ICreateRequest $command): JsonResponse
    {
        try {
            $commandModel = CreateRequest\CreateRequestModel::from($request->all()+['user_id' => $request->user()->id]);
            $result = $command->execute($commandModel);
            return $this->successResponse(new RequestResource($result),'Course booked successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function updateRequestStatus(Request $request, $id, EditRequestStatus\IEditRequestStatus $command): JsonResponse
    {
        $validation_rules = [
            'id' => 'required|integer|exists:course_requests,id',
            'status' => 'required|integer|in:1,2'

        ];
        $validator = $this->getValidationFactory()->make(['id' => $id, 'status' => $request->status], $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try{

            $command->execute($id, $request->status);
            return $this->successResponse([],'Course request status updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * change course request to be canceled or booked
     * @param Request $request
     * @param $id
     * @param ManageRequest\IManageRequest $command
     * @return JsonResponse
     * @throws ValidationException
     */
    public function manageRequests(Request $request, $id, ManageRequest\IManageRequest $command): JsonResponse
    {
        $validation_rules = [
            'id' => 'required|integer|exists:course_requests,id',
            'status' => 'required|integer|in:3,4',
            'note' => 'nullable'

        ];
        $validator = $this->getValidationFactory()->make(['id' => $id, 'status' => $request->status, 'note' => $request->note], $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try{

            $commandModel = ManageRequest\ManageRequestModel::from($request->all()+['id' => $id]);

            $command->execute($commandModel);
            return $this->successResponse([],'Course request status updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}
