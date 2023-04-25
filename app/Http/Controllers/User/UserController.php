<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Core\User\Commands\CreateUser;
use App\Core\User\Queries\GetUserPagination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\UserResource;

class UserController extends ApiController
{
    public function index(GetUserPaginationRequest $request, GetUserPagination\IGetUserPagination $query): JsonResponse
    {
        try {
            $queryModel = GetUserPagination\GetUserPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            return $this->successResponse(UserResource::collection($pagination));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(CreateUserRequest $request, CreateUser\ICreateUser $command): RedirectResponse
    {
        $commandModel = CreateUser\CreateUserModel::from($request->all());
        $command->execute($commandModel);

        return redirect()->route('home');
    }
}
