<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Transformers\OrganizationCourseResourceCollection;
use Modules\Courses\Transformers\UserCourseResourceCollection;
use Modules\Courses\Core\Course\Commands\CreateCourse;
use Modules\Courses\Core\Course\Commands\DeleteCourse;
use Modules\Courses\Core\Course\Commands\EditCourse;
use Modules\Courses\Core\Course\Commands\ImportCourse;
use Modules\Courses\Core\Course\Commands\EditCourseVisibility;
use Modules\Courses\Core\Course\Queries\GetCoursePagination;
use Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination;
use Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination;
use Modules\Courses\Core\Course\Queries\GetUserCoursesPagination;
use Modules\Courses\Core\Course\Queries\GetCourse;
use Modules\Courses\Core\Course\Queries\GetMinMaxCoursePrice;
use Modules\Courses\Core\Category\Queries\GetCategories;
use Modules\Courses\Core\Provider\Queries\GetProviders;
use Modules\Courses\Core\Level\Queries\GetLevels;
use Modules\Courses\Http\Requests\CourseRequest;
use Modules\Courses\Transformers\CategoryResource;
use Modules\Courses\Transformers\CourseResource;
use Modules\Courses\Transformers\UserCourseResource;
use Modules\Courses\Imports\ImportCourses;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Enums;

class CoursesController extends ApiController
{

    /**
     * Instantiate a new CoursesController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createCourse->value, ['only' => ['store', 'import']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editCourse->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::listCourses->value,   ['only' => ['index', 'show', 'archived']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteCourse->value,   ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetCoursePagination\IGetCoursePagination $query
     * @return JsonResponse
     */
    public function index(Request $request,GetCoursePagination\IGetCoursePagination $query): JsonResponse
    {
        try {
            $queryModel = GetCoursePagination\GetCoursePaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);
            return $this->paginationResponse(CourseResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display a list of archived courses
     * @param Request $request
     * @param GetArchivedCoursePagination\IGetArchivedCoursePagination $query
     * @return JsonResponse
     */
    public function archived(Request $request,GetArchivedCoursePagination\IGetArchivedCoursePagination $query): JsonResponse
    {
        try {
            $queryModel = GetArchivedCoursePagination\GetArchivedCoursePaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);
            return $this->paginationResponse(CourseResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * get levels, categories, providers lists
     * @param GetCategories\IGetCategories $query
     * @param GetProviders\IGetProviders $providerQuery
     * @param GetLevels\IGetLevels $levelQuery
     * @param GetMinMaxCoursePrice\IGetMinMaxCoursePrice $priceQuery
     * @return JsonResponse
     */
    public function getLists(GetCategories\IGetCategories $query, GetProviders\IGetProviders $providerQuery,
    GetLevels\IGetLevels $levelQuery): JsonResponse
    {
        try {
            $categories = $query->execute();

            $providers = $providerQuery->execute();
            $levels = $levelQuery->execute();
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
     * @param GetCategories\IGetCategories $query
     * @param GetProviders\IGetProviders $providerQuery
     * @param GetLevels\IGetLevels $levelQuery
     * @param GetMinMaxCoursePrice\IGetMinMaxCoursePrice $priceQuery
     * @return JsonResponse
     */
    public function getFilterLists(GetCategories\IGetCategories $query, GetProviders\IGetProviders $providerQuery,
                             GetLevels\IGetLevels $levelQuery, GetMinMaxCoursePrice\IGetMinMaxCoursePrice $priceQuery): JsonResponse
    {
        try {
            $categories = $query->execute();
            $providers = $providerQuery->execute();
            $levels = $levelQuery->execute();
            $prices = (request()->user()->organization_id) ? $priceQuery->execute(request()->user()->organization_id) : [];

            $categories = $categories->toArray();
            $providers = $providers->toArray();
            $levels = $levels->toArray();
            array_unshift($categories,(object)['id' => "", 'name' => 'All Categories']);
            array_unshift($providers,(object)['id' => "", 'name' => 'All Providers']);
            array_unshift($levels,(object)['id' => "", 'name' => 'All Levels']);
            return $this->successResponse([
                'levels' => $levels,
                'categories' => $categories,
                'providers' => $providers,
                'prices' => $prices
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param CourseRequest $request
     * @param CreateCourse\ICreateCourse $command
     * @return JsonResponse
     */
    public function store(CourseRequest $request, CreateCourse\ICreateCourse $command): JsonResponse
    {
        try {
            $commandModel = CreateCourse\CreateCourseModel::from($request->all());
            $result = $command->execute($commandModel);
            return $this->successResponse(new CourseResource($result),'Course saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * upload multiple from excel
     * @param ImportCSVRequest $request
     * @param ImportCourse\IImportCourse $command
     * @return JsonResponse
     */
    public function import(ImportCSVRequest $request, ImportCourse\IImportCourse $command): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $rowCount = $command->execute($file);
            return $this->successResponse([],$rowCount.' Courses have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            return $this->importFailures($e->failures());
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @param GetCourse\IGetCourse $query
     * @return JsonResponse
     */
    public function show(int $id, GetCourse\IGetCourse $query): JsonResponse
    {
        try{
            $item = $query->execute($id);
            return $this->successResponse(new CourseResource($item),'' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param CourseRequest $request
     * @param int $id
     * @param EditCourse\IEditCourse $command
     * @return JsonResponse
     */
    public function update(CourseRequest $request, int $id, EditCourse\IEditCourse $command): JsonResponse
    {
        try{
            $commandModel = EditCourse\EditCourseModel::from($request->all() + ['id' => $id]);
            $item = $command->execute($commandModel);
            return $this->successResponse(new CourseResource($item),'Course updated successfully!' , Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteCourse\IDeleteCourse $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteCourse\IDeleteCourse $command):JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Course removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display a list of organization courses
     * @param Request $request
     * @param GetOrganizationCoursesPagination\IGetOrganizationCoursesPagination $query
     * @return JsonResponse
     */
    public function getOrganizationCourses(Request $request,GetOrganizationCoursesPagination\IGetOrganizationCoursesPagination $query): JsonResponse
    {
        try {
            $queryModel = GetOrganizationCoursesPagination\GetOrganizationCoursesPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            $organization_id = request()->user()->organization_id;

            $data = [
                'paginatedData' =>  OrganizationCourseResourceCollection::make($pagination)->organization($organization_id),
                'currentPage' => $pagination->currentPage(),
                'lastPage' => $pagination->lastPage(),
                'total' => $pagination->total()
            ];
            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function updateVisibility($id, EditCourseVisibility\IEditCourseVisibility $command): JsonResponse
    {
        $validation_rules = [
            'id' => 'required|integer|exists:courses'
        ];
        $validator = $this->getValidationFactory()->make(['id' => $id], $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try{
            $organization_id = request()->user()->organization_id;
            $command->execute($id, $organization_id);
            return $this->successResponse([],'Course visibility updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }


    /**
     * Display a list of organization courses
     * @param Request $request
     * @param GetUserCoursesPagination\IGetUserCoursesPagination $query
     * @return JsonResponse
     */
    public function getUserCourses(Request $request,GetUserCoursesPagination\IGetUserCoursesPagination $query): JsonResponse
    {
        try {
            $queryModel = GetUserCoursesPagination\GetUserCoursesPaginationModel::from( $request->all() + ['organization_id' => request()->user()->organization_id] );

            $pagination = $query->execute($queryModel);
            $data = [
                'paginatedData' =>  UserCourseResourceCollection::make($pagination)->status($request->status ?? 'all'),
                'currentPage' => $pagination->currentPage(),
                'lastPage' => $pagination->lastPage(),
                'total' => $pagination->total()
            ];
            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
