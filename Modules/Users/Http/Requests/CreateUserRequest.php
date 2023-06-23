<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class CreateUserRequest extends ApiRequest
{
    public function rules()
    {

        return ['name'=> 'required|unique:users|max:255',
            'email'=> 'required|email|unique:users|max:255'];


    }



    public function messages()
    {

        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name length must not be greater than 255 characters.',
            'email.required' => 'The email is required.',
            'email.unique' => 'The email has already been taken.',
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
