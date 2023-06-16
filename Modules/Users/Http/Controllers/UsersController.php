<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Http\Requests\CreateUserRequest;
use Modules\Users\Transformers\UserResource;
use Modules\Users\Core\User\Queries\GetUserPagination;
use Modules\Users\Core\User\Commands\CreateUser;
use App\Enums;

class UsersController extends ApiController
{

    /**
     * Instantiate a new UseristrationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createUser->value, ['only' => ['store']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editUser->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::listUsers->value,   ['only' => ['index']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteUser->value,   ['only' => ['destroy']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::blockUser->value,   ['only' => ['updateStatus']]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetUserPagination\IGetUserPagination $query
     * @return JsonResponse
     */
    public function index(Request $request,GetUserPagination\IGetUserPagination $query): JsonResponse
    {
        try {
            $organization_id = request()->user()->organization_id;
            $queryModel = GetUserPagination\GetUserPaginationModel::from($request->all()+['org_id' => $organization_id]);
            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(UserResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/administration",
     *     tags={"Users"},
     *     summary="Add User",
     *     description="Add new admin",
     *     operationId="UseristrationAddUser",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateUserModel")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *      )
     * )
     * @param CreateUserRequest $request
     * @param CreateUser\ICreateUser $command
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request, CreateUser\ICreateUser $command): JsonResponse
    {
        try {

            $currentUserID = $request->user()->id;
            $currentUserOrganizationId = $request->user()->organization_id;

            $additionalModelData = [
                "createdBy" => $currentUserID,
                "organizationId" => $currentUserOrganizationId,
                "type"  => Enums\EnumUserTypes::User->value
            ];

            $commandModel = CreateUser\CreateUserModel::from($request->all() + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse( new UserResource($result));
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
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('users::edit');
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
