<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class ChangePasswordRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'newPass' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'oldPass' => 'required|string|min:8',
            'confirmPass' => 'required_with:newPass|same:newPass',
        ];
    }



    public function messages()
    {
        return [
            'newPass.regex' => 'The password must contain small letters, capital letters and numbers.',
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
