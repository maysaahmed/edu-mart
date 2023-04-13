<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Courses\Entities\Category;
use Modules\Courses\Entities\Course;
use Modules\Courses\Entities\Level;
use Modules\Courses\Entities\Provider;
use Modules\Courses\Http\Requests\CourseRequest;
use Modules\Courses\Transformers\CategoryResource;
use Modules\Courses\Transformers\CourseResource;
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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('courses::show');
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
