<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Courses\Core\Category\Commands\CreateCategory;
use Modules\Courses\Core\Category\Commands\DeleteCategory;
use Modules\Courses\Core\Category\Commands\EditCategory;
use Modules\Courses\Core\Category\Commands\ImportCategory;
use Modules\Courses\Core\Category\Queries\GetCategoryPagination;
use App\Http\Requests\ImportCSVRequest;

use Symfony\Component\HttpFoundation\Response;
use Modules\Courses\Http\Requests\CategoryRequest;
use Modules\Courses\Transformers\CategoryResource;

class CategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetCategoryPagination\IGetCategoryPagination $query
     * @return JsonResponse
     */
    public function index(Request $request, GetCategoryPagination\IGetCategoryPagination $query): JsonResponse
    {
        try {
            $queryModel = GetCategoryPagination\GetCategoryPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            return $this->successResponse(CategoryResource::collection($pagination));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @param CreateCategory\ICreateCategory $command
     * @return JsonResponse
     */
    public function store(CategoryRequest $request, CreateCategory\ICreateCategory $command): JsonResponse
    {
        try {
            $category = $command->execute($request->name);
            return $this->successResponse(new CategoryResource($category),'Category saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * import from csv
     * @param ImportCSVRequest $request
     * @param ImportCategory\IImportCategory $command
     * @return JsonResponse
     */
    public function import(ImportCSVRequest $request, ImportCategory\IImportCategory $command): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $rowCount = $command->execute($file);
            return $this->successResponse([],$rowCount . ' Categories have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $e) {

            return $this->importFailures($e->failures());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param CategoryRequest $request
     * @param int $id
     * @param EditCategory\IEditCategory $command
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $id, EditCategory\IEditCategory $command): JsonResponse
    {
        try{
            $commandModel = EditCategory\EditCategoryModel::from($request->all() + ["id" => $id]);
            $category = $command->execute($commandModel);
            return $this->successResponse(new CategoryResource($category),'Category updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteCategory\IDeleteCategory $command
     * @return JsonResponse
     */
    public function destroy($id,  DeleteCategory\IDeleteCategory $command): JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Category removed successfully!');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage());
        }
    }

}
