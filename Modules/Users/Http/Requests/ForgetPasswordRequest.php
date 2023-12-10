<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class ForgetPasswordRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'email'=>'required|email|exists:users,email'
        ];
    }

    public function messages()
    {

        return [
            'email.exists' => 'The email you have entered is not registered before.',
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
