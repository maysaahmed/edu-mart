<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Http\Requests\BookCourseRequest;
use Modules\Courses\Transformers\RequestResource;
use Modules\Courses\Core\Request\Commands\CreateRequest;
use Modules\Courses\Core\Request\Commands\EditRequestStatus;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsCount;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class RequestsController extends ApiController
{

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

            return $this->paginationResponse(RequestResource::class,$pagination);;
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
}
