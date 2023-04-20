<?php

namespace Modules\Administration\Http\Requests;

use App\Http\Requests\ApiRequest;

class RoleRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {

        return [
            'name.required' => 'The name is required.',
            'name.max' => 'The name length must not be greater than 255 characters.',
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
