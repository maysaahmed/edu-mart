<?php

namespace Modules\TechnicalAssessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class AssessmentQuestionRequest extends ApiRequest
{

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Decode the 'data' JSON field into an array
        if ($this->has('answers')) {
            // If 'data' is JSON, decode it
            $this->merge([
                'answers' => json_decode($this->input('answers'), true), // Decode JSON to array
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
            'question' => 'required|string|max:255',
            'question_type' => 'required|in:mcq,t/f,sb',
            'assessment_id' => 'required|integer|exists:assessments,id',
            'weight' => 'required|integer',
            'answers' => 'required|array',
            'answers.*.is_correct' => 'required|bool',
            'answers.*.answer_text' => 'required|string',
        ];

    }



    public function messages()
    {

        return [
            'question_type.required' => 'The question type is required.',
            'question_type.in' => 'The question type must be in mcq,t/f,sb.',
            'assessment_id.required' => 'The assessment id is required.',
            'assessment_id.integer' => 'The assessment id must be an integer.',
            'assessment_id.exists' => 'The assessment id is invalid.',
            'answers.*.is_correct.required' => 'Each answer must have a correctness flag (true or false).',
            'answers.*.is_correct.boolean'  => 'The correctness flag must be true or false.',
            'answers.*.answer_text.required' => 'Each answer must have text.',
            'answers.*.answer_text.string'   => 'The answer text must be a valid string.',


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
