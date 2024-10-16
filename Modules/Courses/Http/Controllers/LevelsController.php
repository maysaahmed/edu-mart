<?php

namespace Modules\Courses\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Courses\Core\Level\Commands\CreateLevel;
use Modules\Courses\Core\Level\Commands\DeleteLevel;
use Modules\Courses\Core\Level\Commands\EditLevel;
use Modules\Courses\Core\Level\Commands\ImportLevel;
use Modules\Courses\Core\Level\Queries\GetLevels;
use App\Http\Requests\ImportCSVRequest;

use Symfony\Component\HttpFoundation\Response;
use Modules\Courses\Http\Requests\CategoryRequest;
use Modules\Courses\Transformers\CategoryResource;
use App\Enums;

class LevelsController extends ApiController
{
    /**
     * Instantiate a new LevelsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createLevel->value, ['only' => ['store', 'import']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editLevel->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::listLevels->value,   ['only' => ['index']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteLevel->value,   ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @param GetLevels\IGetLevels $query
     * @return JsonResponse
     */
    public function index(GetLevels\IGetLevels $query): JsonResponse
    {
        try {
            $levels = $query->execute();
            return $this->successResponse(CategoryResource::collection($levels));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }



    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @param CreateLevel\ICreateLevel $command
     * @return JsonResponse
     */
    public function store(CategoryRequest $request, CreateLevel\ICreateLevel $command): JsonResponse
    {
        try {
            $Level = $command->execute($request->name);
            return $this->successResponse(new CategoryResource($Level),'Level saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * import from csv
     * @param ImportCSVRequest $request
     * @param ImportLevel\IImportLevel $command
     * @return JsonResponse
     */
    public function import(ImportCSVRequest $request, ImportLevel\IImportLevel $command): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $rowCount = $command->execute($file);
            return $this->successResponse([],$rowCount . ' Levels have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $e) {

            return $this->importFailures($e->failures());
        }
    }


    /**
     * Update the specified resource in storage.
     * @param categoryRequest $request
     * @param int $id
     * @param EditLevel\IEditLevel $command
     * @return JsonResponse
     */
    public function update(categoryRequest $request, int $id, EditLevel\IEditLevel $command): JsonResponse
    {
        try{
            $commandModel = EditLevel\EditLevelModel::from($request->all() + ["id" => $id]);
            $Level = $command->execute($commandModel);
            return $this->successResponse(new CategoryResource($Level),'Level updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteLevel\IDeleteLevel $command
     * @return JsonResponse
     */
    public function destroy($id,  DeleteLevel\IDeleteLevel $command): JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'Level removed successfully!');

        } catch (\Throwable $th) {

            return $this->errorResponse($th->getMessage());
        }
    }

}
