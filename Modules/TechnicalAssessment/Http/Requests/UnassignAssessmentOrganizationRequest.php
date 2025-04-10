<?php

namespace Modules\TechnicalAssessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class UnassignAssessmentOrganizationRequest extends ApiRequest
{




    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {

        return [
            'assessment_id' => 'required|integer|exists:assessments,id',
            'organization_id' => 'required|integer|exists:organizations,id',
        ];

    }



    public function messages()
    {

        return [
            'assessment_id.required' => 'The assessment id is required.',
            'assessment_id.integer' => 'The assessment id must be an integer.',
            'assessment_id.exists' => 'The assessment id is invalid.',
            'organization_id.required' => 'The organization id is required.',
            'organization_id.integer' => 'The organization id must be an integer.',
            'organization_id.exists' => 'The organization id is invalid.',

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
