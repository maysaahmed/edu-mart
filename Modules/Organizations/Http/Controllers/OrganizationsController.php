<?php

namespace Modules\Organizations\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Organizations\Entities\Organization;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Organizations\Http\Requests\CreateOrganizationRequest;
use Modules\Organizations\Transformers\OrganizationResource;

class OrganizationsController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        try {
            $organizations = QueryBuilder::for(Organization::class)
                ->allowedFilters('name', 'phone', 'address', 'status')
                ->paginate();

            return $this->successResponse(OrganizationResource::collection($organizations));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param CreateOrganizationRequest $request
     * @return Renderable
     */
    public function store(CreateOrganizationRequest $request): Renderable
    {

        try {
            $org = Organization::create($request->all());
            return $this->successResponse(new OrganizationResource($org),'Organization saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }


    /**
     * Update the specified resource in storage.
     * @param CreateOrganizationRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(CreateOrganizationRequest $request, $id): Renderable
    {
        try{
            $item = Organization::find($id);
            if(!$item){
                return $this->errorResponse('Organization cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->update($request->all())) {
                return $this->successResponse(new OrganizationResource($item),'Organization updated successfully!' , Response::HTTP_ACCEPTED);

            } else {
                return $this->errorResponse('Organization failed to update!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * update status -> active or blocked
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validation_rules = [
            'status' => 'required|in:0,1'
        ];
        $validator = $this->getValidationFactory()->make($request->all(), $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try{
            $item = Organization::find($id);
            if (!$item) {
                return $this->errorResponse('Organization cannot be found!', Response::HTTP_NOT_FOUND);
            }

            if ($item->update(['status' => $request->status])) {
                return $this->successResponse(new OrganizationResource($item), 'Organization status updated successfully!', Response::HTTP_ACCEPTED);

            } else {
                return $this->errorResponse('Organization failed to update!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id): Renderable
    {
        try {
            $item = Organization::find($id);
            if(!$item){
                return $this->errorResponse('Organization cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->delete()) {
                return $this->successResponse([],'Organization removed successfully!');
            } else {
                return $this->errorResponse('Organization failed to remove!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}
