<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class EditUserRequest extends ApiRequest
{
    public function rules()
    {

        $id = $this->route('user');

        $passRule =  (!isset($id) ? 'required' : 'nullable'). '|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/';

        return [
            'name'=> 'required|max:255|unique:users,name,'.$id,
            'email'=> 'required|email|max:255|unique:users,email,'.$id,
            'password' => $passRule,
            'isActive' => 'nullable|in:1,0',

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
