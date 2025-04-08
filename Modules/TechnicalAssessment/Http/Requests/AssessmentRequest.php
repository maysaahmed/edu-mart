<?php

namespace Modules\TechnicalAssessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class AssessmentRequest extends ApiRequest
{

    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {

        return [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'code' => 'required|string|unique:assessments,code|max:50',
            'assessment_type' => 'required|in:soft,technical',
        ];

    }



    public function messages()
    {

        return [
                'assessment_type.required' => 'The type field is required.',
            'assessment_type.in' => 'The type field must be soft or technical.',


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
