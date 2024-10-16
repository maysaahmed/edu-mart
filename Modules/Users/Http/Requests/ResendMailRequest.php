<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;

class ResendMailRequest extends ApiRequest
{
    public function rules()
    {

        return [
            'email'=> 'required|email|exists:users,email',
        ];


    }



    public function messages()
    {

        return [

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
