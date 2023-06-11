<?php

namespace App\Http\Controllers;

use App\Domain\Entities\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email',$request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                if(!$user->is_active)
                {
                    throw new \Exception('The user account is blocked!');
                }
                $user_type = 2;
                if($user->type == $user_type){
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
