<?php

namespace Modules\TechnicalAssessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class AnswersRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'assessment_id' => 'required|exists:assessments,id',
            'started_at' => 'nullable|date_format:Y-m-d H:i:s',
            'submitted_at' => 'nullable|date_format:Y-m-d H:i:s',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:assessment_questions,id',
            'answers.*.answer_id' => 'required|exists:assessment_answers,id',
        ];

    }

    public function messages()
    {

        return [
            'assessment_id.required' => 'The assessment id is required.',
            'assessment_id.exists' => 'The assessment id is invalid.',
            'answers.*.question_id.required' => 'The question id is required.',
            'answers.*.question_id.exists' => 'The question id is invalid.',
            'answers.*.answer_id.required'  => 'The answer id is required.',
            'answers.*.answer_id.exists'  => 'The answer id is invalid.',
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
