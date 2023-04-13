<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Entities\Category;
use Modules\Courses\Transformers\CategoryResource;
use Modules\Courses\Http\Requests\CategoryRequest;
use Modules\Courses\Imports\ImportCategories;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $categories = QueryBuilder::for(Category::class)
                ->allowedFilters('name')
                ->paginate();

            return $this->successResponse(CategoryResource::collection($categories));
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
            $category = Category::create($request->all());
            return $this->successResponse(new CategoryResource($category),'Category saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    public function import(ImportCSVRequest $request): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $import = new ImportCategories;
            $import->import($file);

            return $this->successResponse([],'Categories saved successfully!' , Response::HTTP_CREATED);

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
            $item = Category::find($id);
            if(!$item){
                return $this->errorResponse('Category cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->update($request->all())) {
                return $this->successResponse(new CategoryResource($item),'Category updated successfully!' , Response::HTTP_ACCEPTED);

            } else {
                return $this->errorResponse('Category failed to update!');
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
            $item = Category::find($id);
            if(!$item){
                return $this->errorResponse('Category cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->delete()) {
                return $this->successResponse([],'Category removed successfully!');
            } else {
                return $this->errorResponse('Category failed to remove!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
