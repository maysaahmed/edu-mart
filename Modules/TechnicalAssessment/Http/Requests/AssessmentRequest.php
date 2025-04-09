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
        $rules = [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'assessment_type' => 'required|in:soft,technical',
        ];

        $id = $this->route('assessment');

        if (!isset($id))
        {
            $rules += ['code'=> 'required|unique:assessments,code,NULL,id,deleted_at,NULL|max:50'];
        }else{
            $rules += ['code'=> 'required|max:50|unique:assessments,code,'.$id.',id,deleted_at,NULL'];
        }

        return $rules;


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
