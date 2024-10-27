<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Modules\Users\Http\Requests\CreateUserRequest;
use Modules\Users\Core\User\Commands\CreateUser;
use Modules\Users\Core\User\Commands\ImportUser;
use Modules\Users\Core\User\Commands\VerifyUser;
use Modules\Users\Core\User\Commands\VerifyRegisteredUser;
use Modules\Users\Core\User\Commands\ResendVerificationMail;
use Modules\Users\Core\User\Commands\ResendMail;
use Modules\Users\Core\Auth\Commands\UserAuth;
use Modules\Users\Core\User\Commands\CompleteUserData;
use App\Enums;
use Modules\Users\Http\Requests\EditUserRequest;
use Modules\Users\Http\Requests\CompleteUserDataRequest;
use Modules\Users\Http\Requests\VerifyUserRequest;
use Modules\Users\Http\Requests\UserLoginRequest;
use Modules\Users\Http\Requests\ForgetPasswordRequest;
use Modules\Users\Http\Requests\RegisterUserRequest;
use Modules\Users\Http\Requests\ResendMailRequest;
use Modules\Users\Http\Requests\EditProfileRequest;
use App\Http\Requests\ImportCSVRequest;
use Modules\Users\Transformers\UserResource;
use Modules\Users\Transformers\UserProfileResource;
use Modules\Users\Transformers\UserAccountResource;
use Modules\Users\Core\User\Queries\GetUserPagination;
use Modules\Users\Core\User\Commands\DeleteUser;
use Modules\Users\Core\User\Commands\EditUser;
use Modules\Users\Core\User\Commands\ForgetPassword;
use Modules\Users\Core\User\Commands\ResetPassword;
use Modules\Users\Core\User\Commands\RegisterUser;
use Modules\Users\Core\User\Commands\EditProfile;
use Symfony\Component\HttpFoundation\Response;
use Modules\Users\Imports\ImportUsers;
use Str;

class UsersController extends ApiController
{

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
                "organization_id" => $currentUserOrganizationId,
                "type"  => Enums\EnumUserTypes::User->value,
                "password" => Str::random(3)
            ];

            $commandModel = CreateUser\CreateUserModel::from($request->all() + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse( new UserResource($result), 'Users created successfully!');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * @param EditUserRequest $request
     * @param int $id
     * @param EditUser\IEditUser $command
     * @return JsonResponse
     */
    public function update(EditUserRequest $request, int $id, EditUser\IEditUser $command) : JsonResponse
    {
        try{
            $currentUserID = $request->user()->id;

            $additionalModelData = [
                "id" => $id,
                "updatedBy" => $currentUserID,
            ];

            $commandModel = EditUser\EditUserModel::from($request->except(["_method"]) + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse(new UserResource($result),'User updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @param DeleteUser\IDeleteUser $command
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteUser\IDeleteUser $command):JsonResponse
    {
        try {
            $currentUserID = request()->user()->id;
            $command->execute($id, $currentUserID);
            return $this->successResponse([],'User removed successfully!');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    public function verifyUser(VerifyUserRequest $request,$token, VerifyUser\IVerifyUser $command): JsonResponse
    {
        try {
            $command->execute($token, $request->password);
            return $this->successResponse([],'Your e-mail is verified. You can now login.');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function forgetPassword(ForgetPasswordRequest $request, ForgetPassword\IForgetPassword $command): JsonResponse
    {
        try {
            $command->execute($request->email);
            return $this->successResponse([],'You have received an email to reset your password, check your email.');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function resetPassword(VerifyUserRequest $request,$token, ResetPassword\IResetPassword $command): JsonResponse
    {
        try {
            $userType = $command->execute($token, $request->password);
            return $this->successResponse(['user_type' => $userType],'You have reset your password successfully. You can now login.');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function resendMail($id, ResendMail\IResendMail $command): JsonResponse
    {
        try {
            $command->execute($id);
            return $this->successResponse([],'The email sent successfully');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function login(Request $request, UserAuth\IUserAuth $command): JsonResponse
    {
        $validation_rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = $this->getValidationFactory()->make(['email' => $request->email, 'password' => $request->password], $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        try {
            $additionalModelData = [
                "rememberMe" => $request->has('remember_me'),
            ];
            $commandModel = UserAuth\UserAuthModel::from($request->all()+$additionalModelData);
            $result = $command->execute($commandModel);
            return $this->successResponse($result);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    /**
     * @param CompleteUserDataRequest $request
     * @param CompleteUserData\ICompleteUserData $command
     * @return JsonResponse
     */
    public function completeUserData(CompleteUserDataRequest $request, CompleteUserData\ICompleteUserData $command) : JsonResponse
    {
        try{
            $user_id = $request->user()->id;

            $additionalModelData = [
                "user_id" => $user_id,
            ];

            $commandModel = CompleteUserData\CompleteUserDataModel::from($request->except(["_method"]) + $additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse(new UserAccountResource($result),'Your data updated successfully!' , Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }

    /**
     * upload multiple from excel
     * @param ImportCSVRequest $request
     * @param ImportUser\IImportUser $command
     * @return JsonResponse
     */
    public function import(ImportCSVRequest $request, ImportUser\IImportUser $command): JsonResponse
    {
        $file = $request->file('file')->store('import');
        try {
            $rowCount = $command->execute($file);
            return $this->successResponse([],$rowCount.' Users have been uploaded successfully!' , Response::HTTP_CREATED);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            return $this->importFailures($e->failures());
        }

    }


    public function register(RegisterUserRequest $request, RegisterUser\IRegisterUser $command): JsonResponse
    {
        try {
            $commandModel = RegisterUser\RegisterUserModel::from($request->all() );
            $result = $command->execute($commandModel);

                return $this->successResponse( new UserResource($result), 'Thank you for registering on our website, you have received a verification mail please check your email.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param $token
     * @param VerifyRegisteredUser\IVerifyRegisteredUser $command
     * @return JsonResponse
     */
    public function verifyRegisteredUser($token, VerifyRegisteredUser\IVerifyRegisteredUser $command): JsonResponse
    {
        try {
            $verified = $command->execute($token);
            if($verified)
                return $this->successResponse([],'Email Verified Successfully. You can now login.');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * @param ResendMailRequest $request
     * @param $email
     * @param ResendVerificationMail\IResendVerificationMail $command
     * @return JsonResponse
     */
    public function resendVerificationMail(ResendMailRequest $request, ResendVerificationMail\IResendVerificationMail $command): JsonResponse
    {
        try {
            $sent = $command->execute($request->email);
            if($sent)
                return $this->successResponse([],'The email resent successfully');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }



    public function editProfile(EditProfileRequest $request, EditProfile\IEditProfile $command): JsonResponse
    {
        try {
            $user_id = $request->user()->id;

            $additionalModelData = [
                "id" => $user_id,
            ];
            $commandModel = EditProfile\EditProfileModel::from($request->all()+$additionalModelData);
            $result = $command->execute($commandModel);

            return $this->successResponse( new UserProfileResource($result), 'The profile has been updated successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

}
