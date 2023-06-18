<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class VerifyUserRequest extends ApiRequest
{
    public function rules()
    {

        return [
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'confirmPassword' => 'required_with:password|same:password',

        ];


    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
