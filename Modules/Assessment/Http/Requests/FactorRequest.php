<?php

namespace Modules\Assessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class FactorRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'name_en' => 'required|max:255',
            'name_ar' => 'required|max:255',
            'desc_en' => 'required',
            'desc_ar' => 'required',
            'low_desc_en' => 'required',
            'low_desc_ar' => 'required',
            'moderate_desc_en' => 'required',
            'moderate_desc_ar' => 'required',
            'high_desc_en' => 'required',
            'high_desc_ar' => 'required',
            'formula' => 'required',
        ];

    }

    public function messages()
    {

        return [
            'name_ar.required' => 'The arabic field is required.',
            'name_ar.max' => 'The arabic field must not exceed 255 characters.',

            'desc_en.required' => 'The field is required.',
            'desc_ar.required' => 'The field is required.',

            'low_desc_en.required' => 'The field is required.',
            'low_desc_ar.required' => 'The field is required.',

            'moderate_desc_en.required' => 'The field is required.',
            'moderate_desc_ar.required' => 'The field is required.',

            'high_desc_en.required' => 'The field is required.',
            'high_desc_ar.required' => 'The field is required.',


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
