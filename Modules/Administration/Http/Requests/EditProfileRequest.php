<?php

namespace Modules\Administration\Http\Requests;
use App\Http\Requests\ApiRequest;

class EditProfileRequest extends ApiRequest
{
    public function rules()
    {
        $id = request()->user()->id;
        $rules = [
            'password' => 'nullable|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
        ];

        $rules += ['name'=> 'required|max:255|unique:users,name,'.$id,];
        $rules += ['email'=> 'required|email|max:255|unique:users,email,'.$id,];

        return $rules;

    }

    public function messages()
    {

        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name has already been taken.',
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
