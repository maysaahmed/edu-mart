<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Core\User\Commands\CreateUser\ICreateUser;
use App\Core\User\Queries\GetUserPagination\IGetUserPagination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\UserResource;

class UserController extends ApiController
{
    public function index(GetUserPaginationRequest $request, IGetUserPagination $query): JsonResponse
    {
        try {
            $pagination = $query->execute($request->data());
            return $this->successResponse(UserResource::collection($pagination));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(CreateUserRequest $request, ICreateUser $command): RedirectResponse
    {
        $command->execute($request->data());
        return redirect()->route('home');
    }
}
