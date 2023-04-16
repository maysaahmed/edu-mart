<?php

namespace Modules\Administration\Http\Requests;

use App\Http\Requests\ApiRequest;

class AdminLoginRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {

        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name length must not be greater than 255 characters.',
            'phone.regex' => 'The phone format is invalid.',
            'phone.min' => 'The phone must not be less than 10 digits.',
            'address.regex' => 'The address format is invalid.',
            'address.min' => 'The address must not be less than 8 characters.',
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
