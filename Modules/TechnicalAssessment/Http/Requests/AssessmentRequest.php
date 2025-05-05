<?php

namespace Modules\TechnicalAssessment\Http\Requests;
use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rule;
use Modules\TechnicalAssessment\Domain\Entities\UserAssessmentResult;

class AssessmentRequest extends ApiRequest
{


    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        $id = $this->route('assessment');
        $hasResults = UserAssessmentResult::where('assessment_id', $id)
            ->whereNotNull('submitted_at')
            ->exists();
        if(!$hasResults)
        {
            $rules = [
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'assessment_type' => 'required|in:soft,technical',
                'retake_days' => 'required|integer|min:0'
            ];



            if (!isset($id))
            {
                $rules += ['code'=> [
                    'required',
                    'max:50',
                    Rule::unique('assessments')->whereNull('deleted_at'),
                ]];

            }else{

                $rules += [ 'code' => [
                    'required',
                    'max:50',
                    Rule::unique('assessments')->ignore($id)->whereNull('deleted_at')
                ]];

            }
        }else{
            $rules = [
                'retake_days' => 'required|integer|min:0'
            ];
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
