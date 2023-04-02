<?php

namespace Modules\Organizations\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
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
    public function index()
    {
        try {
            $orgs = QueryBuilder::for(Organization::class)
                ->allowedFilters('name', 'phone', 'address')
                ->paginate();

            return $this->successResponse(OrganizationResource::collection($orgs));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateOrganizationRequest $request)
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
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CreateOrganizationRequest $request, $id)
    {
        try{
            $item = Organization::findOrFail($id);

            if ($item->update($request->all())) {
                $this->response['message'] = 'Data updated successfully!';
                return $this->successResponse(new OrganizationResource($item),'Organization updated successfully!' , Response::HTTP_ACCEPTED);

            } else {
                return $this->errorResponse('Data failed to update!');
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
    public function destroy($id)
    {
        try {
            $item = Organization::findOrFail($id);
            if ($item->delete()) {
                return $this->successResponse([],'Organization removed successfully!');
            } else {
                return $this->errorResponse('Data failed to remove!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}
