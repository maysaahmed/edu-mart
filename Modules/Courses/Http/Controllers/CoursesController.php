<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Entities\Category;
use Modules\Courses\Entities\Course;
use Modules\Courses\Entities\Level;
use Modules\Courses\Entities\Provider;
use Modules\Courses\Http\Requests\CourseRequest;
use Modules\Courses\Transformers\CategoryResource;
use Modules\Courses\Transformers\CourseResource;
use Modules\Courses\Imports\ImportCourses;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $providers = QueryBuilder::for(Course::class)
                ->allowedFilters('name')
                ->paginate();

            return $this->successResponse(CourseResource::collection($providers));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * get levels, categories, providers lists
     * @return JsonResponse
     */
    public function getLists(): JsonResponse
    {
        try {
            $levels = Level::get(['id','name']);
            $categories = Category::get(['id','name']);
            $providers = Provider::get(['id','name']);

            return $this->successResponse([
                'levels' => CategoryResource::collection($levels),
                'categories' => CategoryResource::collection($categories),
                'providers' => CategoryResource::collection($providers),
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }



    /**
     * Store a newly created resource in storage.
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request): JsonResponse
    {
        try {
            $course = Course::create($request->all());
            return $this->successResponse(new CourseResource($course),'Course saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * upload multiple from excel
     * @param ImportCSVRequest $request
     * @return JsonResponse
     */
    public function import(ImportCSVRequest $request): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $import = new ImportCourses;
            $import->import($file);
            $rowCount = $import->getRowCount();
            return $this->successResponse([],$rowCount.' Courses have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            return $this->importFailures($e->failures());
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try{
            $item = Course::find($id);
            if(!$item){
                return $this->errorResponse('Course cannot be found!', Response::HTTP_NOT_FOUND);
            }

            return $this->successResponse(new CourseResource($item),'' , Response::HTTP_ACCEPTED);


        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param CourseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CourseRequest $request, $id): JsonResponse
    {
        try{
            $item = Course::find($id);
            if(!$item){
                return $this->errorResponse('Course cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->update($request->all())) {
                return $this->successResponse(new CourseResource($item),'Course updated successfully!' , Response::HTTP_ACCEPTED);

            } else {
                return $this->errorResponse('Course failed to update!');
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
            $item = Course::find($id);
            if(!$item){
                return $this->errorResponse('Course cannot be found!', Response::HTTP_NOT_FOUND);
            }
            if ($item->delete()) {
                return $this->successResponse([],'Course removed successfully!');
            } else {
                return $this->errorResponse('Course failed to remove!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
