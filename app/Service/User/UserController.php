<?php

namespace App\Service\User;

use App\Http\User\CreateUserRequest;
use App\Http\User\GetUserPaginationRequest;
use App\Core\User\Commands\CreateUser\ICreateUser;
use App\Core\User\Queries\GetUserPagination\IGetUserPagination;
//use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Service\Common\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->scopes('user.read', ['only' => ['index']]);
        $this->scopes('user.write', ['only' => ['store']]);
    }

    /**
     * @param IGetUserPagination $query
     * @param GetUserPaginationRequest $request
     * @return JsonResponse
     * @OA\Get(
     *     path="/users",
     *     summary="List all users",
     *     operationId="index",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="users pagination",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/userTransformer")
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(GetUserPaginationRequest $request, IGetUserPagination $query): JsonResponse
    {
        $pagination = $query->execute($request->data());
//        return $this->response->paginator($pagination, new UserTransformer(), ['key' => 'User']);
//
        return $this->successResponse(UserTransformer::collection($pagination));
    }

    /**
     * @param CreateUserRequest $request
     * @param ICreateUser $command
     * @return Response
     * @OA\Post(
     *     path="/users",
     *     summary="New User",
     *     operationId="store",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateUserRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A User",
     *         @OA\JsonContent(ref="#/components/schemas/UserTransformer"),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity",
     *         @OA\JsonContent(ref="#/components/schemas/CreateUserRequestValidationError")
     *     )
     * )
     */
    public function store(CreateUserRequest $request, ICreateUser $command): JsonResponse
    {
        $User = $command->execute($request->data());
        return $this->successResponse(new UserTransformer($User),'Data saved successfully!' , Response::HTTP_CREATED);

    }
}
