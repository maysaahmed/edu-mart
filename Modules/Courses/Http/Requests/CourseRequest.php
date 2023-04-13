<?php

namespace Modules\Courses\Http\Requests;
use App\Http\Requests\ApiRequest;

class CourseRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'duration' => 'required|numeric',
            'price' => 'required|numeric|between:0,9999999999.99',
            'level_id' => 'nullable|integer|exists:levels,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'provider_id' => 'nullable|integer|exists:providers,id'
        ];

    }



    public function messages()
    {

        return [
            'level_id.integer' => 'The level field must be an integer.',
            'level_id.exists' => 'The selected level is invalid.',
            'category_id.integer' => 'The category field must be an integer.',
            'category_id.exists' => 'The selected category is invalid.',
            'provider_id.integer' => 'The provider field must be an integer.',
            'provider_id.exists' => 'The selected provider is invalid.',


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
