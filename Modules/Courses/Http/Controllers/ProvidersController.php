<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Entities\Provider;
use Modules\Courses\Transformers\CategoryResource;
use Modules\Courses\Http\Requests\CategoryRequest;
use Modules\Courses\Imports\ImportProviders;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class ProvidersController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $providers = QueryBuilder::for(Provider::class)
                ->allowedFilters('name')
                ->paginate();

            return $this->successResponse(CategoryResource::collection($providers));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $provider = Provider::create($request->all());
            return $this->successResponse(new CategoryResource($provider),'Provider saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    public function import(ImportCSVRequest $request): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $import = new ImportProviders;
            $import->import($file);
            $rowCount = $import->getRowCount();
            return $this->successResponse([],$rowCount . ' Providers have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            return $this->importFailures($e->failures());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param CategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, $id): JsonResponse
    {
        try{
            $item = Provider::find($id);
            if(!$item){
                return $this->errorResponse('Provider cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->update($request->all())) {
                return $this->successResponse(new CategoryResource($item),'Provider updated successfully!' , Response::HTTP_ACCEPTED);

            } else {
                return $this->errorResponse('Provider failed to update!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $item = Provider::find($id);
            if(!$item){
                return $this->errorResponse('Provider cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->delete()) {
                return $this->successResponse([],'Provider removed successfully!');
            } else {
                return $this->errorResponse('Provider failed to remove!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
