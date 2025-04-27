<?php

namespace Modules\TechnicalAssessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class AssessmentTierRequest extends ApiRequest
{


    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {

        return [
            'evaluation' => 'required|string|max:255',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'assessment_id' => 'required|integer|exists:assessments,id',
            'courses' => 'nullable|array',
            'courses.*' => 'nullable|integer|exists:courses,id',
            'desc' => 'nullable|string',
        ];

    }



    public function messages()
    {

        return [
            'assessment_id.required' => 'The assessment id is required.',
            'assessment_id.integer' => 'The assessment id must be an integer.',
            'assessment_id.exists' => 'The assessment id is invalid.',
            'courses.*.integer'  => 'The course id must be an integer.',
            'courses.*.exists'  => 'The course id is invalid.',

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
