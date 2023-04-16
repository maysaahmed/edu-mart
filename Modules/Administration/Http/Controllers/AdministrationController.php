<?php

namespace Modules\Administration\Http\Controllers;

use App\Http\Controllers\ApiController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Administration\Core\Admin\Commands\CreateAdmin;
use Modules\Administration\Core\Admin\Queries\GetAdminPagination;
use Modules\Administration\Domain\Entities\Admin\Admin;
use Modules\Administration\Core\Admin\Commands\AdminAuth;
use Modules\Administration\Http\Requests\AdminLoginRequest;
use Modules\Administration\Transformers\AdminResource;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Hash;

class AdministrationController extends ApiController
{
//    /**
//     * Handles Registration Request
//     *
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function register(Request $request)
//    {
//        $rules = [
//            'name' => 'required|min:3',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|min:6',
//        ];
//        $validator = $this->getValidationFactory()->make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            return $this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
//        }
//
//        try {
//            $user = Admin::Create([
//                'name' => $request->name,
//                'email' => $request->email,
//                'password' => bcrypt($request->password)
//            ]);
//
//            $token = $user->createToken('authToken')->accessToken;
//            return $this->successResponse(['token' => $token],'Admin saved successfully!' , Response::HTTP_CREATED);
//
//        } catch (\Throwable $th) {
//            return $this->errorResponse($th->getMessage());
//        }
//    }

    public function index(Request $request, GetAdminPagination\IGetAdminPagination $query): JsonResponse
    {
        try {
            $queryModel = GetAdminPagination\GetAdminPaginationModel::from($request->all());
            $pagination = $query->execute($queryModel);

            return $this->successResponse( AdminResource::collection($pagination));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(Request $request, CreateAdmin\ICreateAdmin $command): JsonResponse
    {
        try {
            $commandModel = CreateAdmin\CreateAdminModel::from($request->all());
            $result = $command->execute($commandModel);

            return $this->successResponse( new AdminResource($result));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * Handles Login Request
     * @param AdminLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AdminLoginRequest $request, AdminAuth\IAdminAuth $command): JsonResponse
    {

        try {
            // map request to command.
            $commandModel = AdminAuth\AdminAuthModel::from($request->all());
            $result = $command->execute($commandModel);
            return $this->successResponse($result);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
//            return $this->errorResponse('The provided credentials do not match our records.!', Response::HTTP_UNAUTHORIZED);
        }
    }




    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function logout (Request $request) {

        $request->user()->tokens()->delete();

//        $token = $request->user()->token();
//        $token->revoke();
        return $this->successResponse([], 'You have been successfully logged out!');
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request)
    {

        $user = auth("admin-api")->user();
        return response()->json(['user' =>  $user, 'permissions' => $user->getAllPermissions()], 200);

    }
}
