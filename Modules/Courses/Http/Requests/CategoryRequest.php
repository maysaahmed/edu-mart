<?php

namespace Modules\Courses\Http\Requests;
use App\Http\Requests\ApiRequest;

class CategoryRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255'
        ];

    }



    public function messages()
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
