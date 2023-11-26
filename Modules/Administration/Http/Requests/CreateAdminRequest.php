<?php

namespace Modules\Administration\Http\Requests;
use App\Http\Requests\ApiRequest;

class CreateAdminRequest extends ApiRequest
{
    public function rules()
    {
        $rules = [
            'isActive' => 'required|in:1,0',
            'roleId' => 'required|integer'
        ];

        $id = $this->route('admin');

        $passRule =  (!isset($id) ? 'required' : 'nullable'). '|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/';
        $rules["password"] = $passRule;

        if (!isset($id))
        {
            $rules += ['name'=> 'required|unique:users|max:255'];
            $rules += ['email'=> 'required|email|unique:users|max:255'];
        }else{
            $rules += ['name'=> 'required|max:255|unique:users,name,'.$id,];
            $rules += ['email'=> 'required|email|max:255|unique:users,email,'.$id,];
        }

        return $rules;

    }



    public function messages()
    {

        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name length must not be greater than 255 characters.',
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
