<?php

namespace Modules\Administration\Http\Controllers;

use App\Http\Controllers\ApiController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Administration\Core\Admin\Commands\ChangePassword;
use Modules\Administration\Core\Admin\Commands\CreateAdmin;
use Modules\Administration\Core\Admin\Commands\EditAdmin;
use Modules\Administration\Core\Admin\Commands\DeleteAdmin;
use Modules\Administration\Core\Admin\Commands\UpdateAdminStatus;
use Modules\Administration\Core\Admin\Commands\EditProfile;
use Modules\Administration\Core\Admin\Queries\GetAdminPagination;
use Modules\Administration\Core\Admin\Commands\AdminAuth;
use Modules\Administration\Http\Requests\AdminLoginRequest;
use Modules\Administration\Http\Requests\CreateAdminRequest;
use Modules\Administration\Http\Requests\EditProfileRequest;
use Modules\Administration\Transformers\AdminResource;
use Modules\Administration\Transformers\AdminLoginResource;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use App\Enums;

class AdministrationController extends ApiController
{
    /**
     * Instantiate a new AdministrationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:'.Enums\PermissionsEnum::createAdmin->value, ['only' => ['store']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::editAdmin->value,   ['only' => ['update']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::listAdmins->value,   ['only' => ['index']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::deleteAdmin->value,   ['only' => ['destroy']]);
        $this->middleware('ability:'.Enums\PermissionsEnum::blockAdmin->value,   ['only' => ['updateStatus']]);
    }
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

    /**
     * @OA\Get(
     *     path="/api/administration",
     *     tags={"Administration"},
     *     summary="Returns paginated list of admins",
     *     description="Returns paginated list of admins",
     *     operationId="getAdminsList",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="path",
     *         description="page number",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="filter data by admin name",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/AdminResource")
     *          )
     *       ),
     * )
     * @param Request $request
     * @param GetAdminPagination\IGetAdminPagination $query
     * @return JsonResponse
     */
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

    /**
     * @OA\Post(
     *     path="/api/administration",
     *     tags={"Administration"},
     *     summary="Add Admin",
     *     description="Add new admin",
     *     operationId="AdministrationAddAdmin",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateAdminModel")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AdminResource")
     *      )
     * )
     * @param CreateAdminRequest $request
     * @param CreateAdmin\ICreateAdmin $command
     * @return JsonResponse
     */
    public function store(CreateAdminRequest $request, CreateAdmin\ICreateAdmin $command): JsonResponse
    {
        try {

            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "createdBy" => $currentUserID,
                "type"  => Enums\EnumUserTypes::Admin->value
            ];

            $commandModel = CreateAdmin\CreateAdminModel::from($request->all() + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse( new AdminResource($result));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @OA\Post(
     *     path="/api/administration/{id}",
     *     tags={"Administration"},
     *     summary="Update Admin",
     *     description="Returns updated admin data",
     *     operationId="updateAdmin",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="admin id",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EditAdminModel")
     *     ),
     *     @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AdminResource")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      )
     * )
     * @param CreateAdminRequest $request
     * @param int $id
     * @param EditAdmin\IEditAdmin $command
     * @return JsonResponse
     */
    public function update(CreateAdminRequest $request, int $id, EditAdmin\IEditAdmin $command) : JsonResponse
    {
        try{
            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "id" => $id,
                "updatedBy" => $currentUserID,
            ];

            $commandModel = EditAdmin\EditAdminModel::from($request->except(["_method"]) + $additionalModelData);
            $result = $command->execute($commandModel);

            $this->response['message'] = 'Data updated successfully!';
            return $this->successResponse(new AdminResource($result),'Admin updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * update status -> active or blocked
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateStatus(Request $request, $id, UpdateAdminStatus\IUpdateAdminStatus $command): JsonResponse
    {
        $validation_rules = [
            'status' => 'required|in:0,1'
        ];

        $this->validateRequest($request->all(), $validation_rules);

        try{
            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "id" => $id,
                "updatedBy" => $currentUserID,
            ];

            $commandModel = UpdateAdminStatus\UpdateAdminStatusModel::from($request->all() + $additionalModelData);
            $result = $command->execute($commandModel);

            $this->response['message'] = 'Data updated successfully!';
            return $this->successResponse(new AdminResource($result),'Admin updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param integer $id
     * @param DeleteAdmin\IDeleteAdmin $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteAdmin\IDeleteAdmin $command): JsonResponse
    {
        try {
            $currentUserID = request()->user()->id;

            $additionalModelData = [
                "id" => $id,
                "deletedBy" => $currentUserID,
            ];

            $commandModel = DeleteAdmin\DeleteAdminModel::from($additionalModelData);
            $command->execute($commandModel);
            return $this->successResponse([],'Admin removed successfully!');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Update profile the current user.
     * @param EditProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(EditProfileRequest $request, EditProfile\IEditProfile $command) : JsonResponse
    {
        try{
            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "profileId" => $currentUserID,
            ];

            $commandModel = EditProfile\EditProfileModel::from($request->all() + $additionalModelData);
            $result = $command->execute($commandModel);

            $this->response['message'] = 'Profile updated successfully!';
            return $this->successResponse(new AdminResource($result),'Profile updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Update profile the current user.
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request, ChangePassword\IChangePassword $command) : JsonResponse
    {
        $validation_rules = [
            'oldPassword' => 'required',
            'newPassword' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
        ];

        $this->validateRequest($request->all(), $validation_rules);

        try{
            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "profileId" => $currentUserID,
            ];

            $commandModel = ChangePassword\ChangePasswordModel::from($request->all() + $additionalModelData);
            $result = $command->execute($commandModel);

            $this->response['message'] = 'Profile password updated successfully!';
            return $this->successResponse(new AdminResource($result),'Profile password updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * @OA\Post(
     *     path="/api/administration/login",
     *     tags={"Auth"},
     *     summary="Admin Login",
     *     description="Admin Login and generate access token",
     *     operationId="AuthAdminLogin",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AdminAuthModel")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AdminLoginResource")
     *      )
     * )
     * @param AdminLoginRequest $request
     * @param AdminAuth\IAdminAuth $command
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request, AdminAuth\IAdminAuth $command): JsonResponse
    {
        try {
            // map request to command.
            $commandModel = AdminAuth\AdminAuthModel::from($request->all());
            $result = $command->execute($commandModel);
            return $this->successResponse((new AdminLoginResource($result['user']))->token($result['token']));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request)
    {
        $user = auth("sanctum")->user();
        return $this->successResponse(new AdminResource($user));

    }


}
