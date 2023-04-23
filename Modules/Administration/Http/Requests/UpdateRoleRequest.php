<?php

namespace Modules\Administration\Http\Requests;

use App\Http\Requests\ApiRequest;

class UpdateRoleRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {

        return [
            'permissions.*.exists' => 'The selected permission is invalid',
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
