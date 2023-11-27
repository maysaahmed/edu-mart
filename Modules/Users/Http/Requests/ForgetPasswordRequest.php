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
