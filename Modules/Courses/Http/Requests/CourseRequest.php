<?php

namespace Modules\Courses\Http\Requests;
use App\Http\Requests\ApiRequest;

class CourseRequest extends ApiRequest
{

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Decode the 'data' JSON field into an array
        if ($this->has('factors')) {
            // If 'data' is JSON, decode it
            $this->merge([
                'factors' => json_decode($this->input('factors'), true), // Decode JSON to array
            ]);
        }
    }


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
            'provider_id' => 'nullable|integer|exists:providers,id',
            'location'  => 'max:255',
            'factors' => 'required|array',
            'factors.*.factor' => 'required|exists:factors,id',
            'factors.*.result' => 'required',
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
