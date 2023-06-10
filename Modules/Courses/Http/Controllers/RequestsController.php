<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Http\Requests\BookCourseRequest;
use Modules\Courses\Transformers\RequestResource;
use Modules\Courses\Core\Request\Commands\CreateRequest;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination;
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

    /**
     * Store a newly created resource in storage.
     * @param BookCourseRequest $request
     * @param CreateRequest\ICreateRequest $command
     * @return JsonResponse
     */
    public function store(BookCourseRequest $request, CreateRequest\ICreateRequest $command): JsonResponse
    {
        try {
            $commandModel = CreateRequest\CreateRequestModel::from($request->all()+['user_id' => 7]);
            $result = $command->execute($commandModel);
            return $this->successResponse(new RequestResource($result),'Course booked successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function updateRequestStatus($id, EditRequestStatus\IEditRequestStatus $command): JsonResponse
    {
        $validation_rules = [
            'id' => 'required|integer|exists:courses,id,deleted_at,null'
        ];
//        $validator = $this->getValidationFactory()->make(['id' => $id], $validation_rules);
//
//        if ($validator->fails()) {
//            $this->failedValidation($validator);
//        }
//
//        try{
//            $organization_id = request()->user()->organization_id;
//            $command->execute($id, $organization_id);
//            return $this->successResponse([],'Course visibility updated successfully!' , Response::HTTP_ACCEPTED);
//
//        } catch (\Throwable $th) {
//            return $this->errorResponse($th->getMessage());
//        }

    }
}
