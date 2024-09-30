<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class RegisterUserRequest extends ApiRequest
{
    public function rules()
    {

        return ['first_name'=> 'required|max:255',
            'last_name'=> 'required|max:255',
            'email'=> 'required|email|unique:users,email,NULL,id,deleted_at,NULL|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'confirmPassword' => 'required_with:password|same:password',
            ];


    }



    public function messages()
    {

        return [
            'email.required' => 'The email is required.',
            'email.unique' => 'The email has already been taken.',
            'password.regex' => 'The password must contain small letters, capital letters and numbers.',

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
