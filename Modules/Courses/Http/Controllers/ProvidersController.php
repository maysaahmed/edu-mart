<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ImportCSVRequest;
use Illuminate\Http\JsonResponse;
use Modules\Courses\Transformers\CategoryResource;
use Modules\Courses\Http\Requests\CategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Modules\Courses\Core\Provider\Commands\CreateProvider;
use Modules\Courses\Core\Provider\Commands\DeleteProvider;
use Modules\Courses\Core\Provider\Commands\EditProvider;
use Modules\Courses\Core\Provider\Commands\ImportProvider;
use Modules\Courses\Core\Provider\Queries\GetProviderPagination;


class ProvidersController extends ApiController
{

    /**
     * Instantiate a new ProvidersController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:create_provider', ['only' => ['store', 'import']]);
        $this->middleware('ability:edit_provider',   ['only' => ['update']]);
        $this->middleware('ability:list_providers',   ['only' => ['index']]);
        $this->middleware('ability:delete_provider',   ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetProviderPagination\IGetProviderPagination $query
     * @return JsonResponse
     */
    public function index(Request $request, GetProviderPagination\IGetProviderPagination $query): JsonResponse
    {
        try {
            $queryModel = GetProviderPagination\GetProviderPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            return $this->successResponse(CategoryResource::collection($pagination));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @param CreateProvider\ICreateProvider $command
     * @return JsonResponse
     */
    public function store(CategoryRequest $request, CreateProvider\ICreateProvider $command): JsonResponse
    {
        try {
            $provider = $command->execute($request->name);
            return $this->successResponse(new CategoryResource($provider),'Provider saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param ImportCSVRequest $request
     * @param ImportProvider\IImportProvider $command
     * @return JsonResponse
     */
    public function import(ImportCSVRequest $request, ImportProvider\IImportProvider $command): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $rowCount = $command->execute($file);
            return $this->successResponse([],$rowCount . ' Providers have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            return $this->importFailures($e->failures());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param CategoryRequest $request
     * @param int $id
     * @param EditProvider\IEditProvider $command
     * @return JsonResponse
     */
    public function update(CategoryRequest $request,int $id, EditProvider\IEditProvider $command): JsonResponse
    {
        try{
            $commandModel = EditProvider\EditProviderModel::from($request->all() + ['id' => $id]);
            $item = $command->execute($commandModel);
            return $this->successResponse(new CategoryResource($item),'Provider updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteProvider\IDeleteProvider $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteProvider\IDeleteProvider $command): JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Provider removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
