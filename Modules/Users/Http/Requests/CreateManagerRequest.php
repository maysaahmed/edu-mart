<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class CreateManagerRequest extends ApiRequest
{
    public function rules()
    {

        return ['name'=> 'required|unique:users,name,NULL,id,deleted_at,NULL|max:255',
            'email'=> 'required|email|unique:users,email,NULL,id,deleted_at,NULL|max:255',
            'organization_id'=>'required|exists:organizations,id'];
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
