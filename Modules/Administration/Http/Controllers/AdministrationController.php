<?php

namespace Modules\Administration\Http\Controllers;

use App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use Modules\Administration\Entities\AdminEntity;
use Modules\Administration\Http\Requests\AdminLoginRequest;
use Symfony\Component\HttpFoundation\Response;

use Hash;
class AdministrationController extends ApiController
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];
        $validator = $this->getValidationFactory()->make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = AdminEntity::Create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);


            $token = $user->createToken('authToken')->accessToken;
            return $this->successResponse(['token' => $token],'Admin saved successfully!' , Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AdminLoginRequest $request)
    {
        $admin = AdminEntity::where('email', $request->email)->first();
        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('authToken')->accessToken;
                $data = ['name' => $admin->name,'token' => $token];

                return $this->successResponse($data);

            }
        }
        return $this->errorResponse('The provided credentials do not match our records.!', Response::HTTP_UNAUTHORIZED);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return $this->successResponse([], 'You have been successfully logged out!');

    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth("admin-api")->user()], 200);
    }
}
