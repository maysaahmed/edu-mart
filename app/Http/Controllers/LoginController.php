<?php

namespace App\Http\Controllers;

use App\Domain\Entities\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\EnumUserTypes;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class LoginController extends ApiController
{
    /**
     * Handle an authentication attempt.
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email',$request->email)->whereIn('type', [EnumUserTypes::Manager,EnumUserTypes::User])->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                //check user organization is blocked or user is blocked
                $organization = Organization::find($user->organization_id);
                if(!$user->is_active || !$organization->status)
                {
                    return $this->errorResponse('The user account is blocked!');
                }

                if($user->type == EnumUserTypes::Manager->value){
                    $token = 'manager-token';
                }else{
                    $token = 'user-token';
                }
                $user_token = $user->createToken($token,[])->plainTextToken;
                $data = ['user' => $user,'token' => $user_token];


                return $this->successResponse($data);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
